<?php

require_once("../connection.php");

include("../template/t1.php");

const ROW_PER_PAGE = 9;
const DEFAULT_PAGE = 1;

$get_courses_number="select COUNT(*) AS courses_number from courses";
$corses_numbers_result = mysqli_query($con, $get_courses_number);
$courses_number = mysqli_fetch_assoc($corses_numbers_result);
// echo  die;

$row_per_page = constant('ROW_PER_PAGE');
$default = constant('DEFAULT_PAGE');
$pageNum = 1;


if(isset($_GET['page'])){
    if(!is_numeric($_GET['page'])){
        echo "<script>alert('Invalid page number')</script>";
        die;
    }
    $pageNum = $_GET['page'];
}


$offset = ($pageNum - 1) * $row_per_page;

function is_valid_pagination(){
    global $row_per_page, $courses_number;
    if(isset($_GET['page'])){
        if($_GET['page'] > ceil(($courses_number['courses_number']/$row_per_page)) || $_GET['page'] <= 0){
            return false;
        }
        else{
            return true;
        }
    }
}



$next_page = $pageNum + 1;
$back_page = $pageNum - 1;


$query="select * from courses  LIMIT {$offset},{$row_per_page}";
$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);


$get_all_courses = "SELECT courses.* FROM courses JOIN enrolled ON courses.id = enrolled.course_id WHERE enrolled.student_id = '" . $student_id['id'] . "' ";
$get_all_teachers = "SELECT teachers.* FROM teachers JOIN courses ON teachesr.id = courses.tutor_id WHERE courses.tutor_id = '" . $student_id['id'] . "' ";

$courses=mysqli_query($con,$get_all_courses);

// if user did not signed in
if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}
// if user did not pay 
if( !isset($_SESSION['paid']) ){
    header("location:register.php");
}


$get_all_student_courses = "
    SELECT  courses.*, sections.id as section_id, courses_time.time
    FROM enrolled
    JOIN sections
        ON enrolled.section_id = sections.id
    JOIN courses
        ON sections.course_id = courses.id
    JOIN courses_time
        ON courses_time.id = sections.time_id
    WHERE enrolled.student_id = '" . $student_id['id'] . "'";
$student_courses_result = mysqli_query($con, $get_all_student_courses);
$courses_data= mysqli_fetch_assoc($student_courses_result);


?>

<html>
<head>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
<style>
    body{
        overflow: auto;
        z-index: 20;
        background-size: 250vh;

    }
    .logo, .foot{
        z-index: 1;
    }
    .student_data div,.view-section div, .registered-courses div{
        padding: 0.5em 2em;
    }
    
    .pagination a{
        color: rgb(0,0,0);
        text-decoration: none;
    }
    .pagination a:hover{
        color:darkcyan;
        text-decoration: none;
    }
    .registered-courses{
        position: absolute;
        margin-left:25em;
        margin-top:7em;
        background: white;
        border-radius: 10px;
        opacity: .85;
    }
    .foot{
        position: fixed;
    }
    table, th, td{
        border: 1px solid #000;
        border-collapse: collapse;
        padding: 1em 2em;
    }
    table tr{
        cursor: pointer;
    }
    table tr:nth-child(2n+1){
        background-color: #eee;
    }
    tr:hover td{
        background-color: #ccc;
    }
    .close_section_btn:hover{
        color: crimson;
    }
</style>
</head>
<body>
<form>
    <?php

if(Is_valid_pagination()){
if($courses_data <= 0){
    echo <<< _END
            <div class="student_data" style="
                position: absolute;
                margin-left:25em;
                margin-top:7em;
                background: white;
                border-radius: 10px;
                opacity: .85;  
            ">
            <p class="super-box-title">Courses Advised</p>
                <div class="row">
                        <table>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credits</th>
                                <th>Course Price</th>
                                <th>View Sections</th>
                        </tr>
        _END;
}else{
    echo <<< _END
            <div class="student_data" style="
                position: absolute;
                margin-left:25em;
                margin-top:31em;
                background: white;
                border-radius: 10px;
                opacity: .85;  
            ">
            <p class="super-box-title">Courses Advised</p>
                <div class="row">
                        <table>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credits</th>
                                <th>Course Price</th>
                                <th>View Sections</th>
                        </tr>
        _END;
}
             
                    $result=mysqli_query($con,$query);
                    while($row= mysqli_fetch_assoc($result) ){
                        $price = number_format($row['course_price'], 2);
                        
                        // $get_all_teachers = "SELECT teachers.* FROM teachers JOIN courses ON teachers.id = courses.tutor_id WHERE courses.tutor_id = '" . $row['tutor_id'] . "' ";
                        $get_all_teachers_by_course = "SELECT teachers.* FROM teachers JOIN teachers_courses ON teachers.id = teachers_courses.tutor_id WHERE teachers_courses.course_id = '" . $row['id'] . "' ";
                        // var_dump($get_all_teachers);
                        $teachers_result = mysqli_query($con,$get_all_teachers_by_course);
                        $teacher_name = mysqli_fetch_assoc($teachers_result);

                        echo <<< _END
                            <tr>
                                <td> {$row['course_id']} </td>
                                <td> {$row['course_name']} </td>
                                <td> {$row['credits']} </td>
                                <td> {$price} SAR </td>
                                <td> <span onclick="showViewSections({$row['id']})" style="color:blue; text-decoration: underline;">View Sections</span> </td>
                            </tr>
                        _END;
                    }
                    
                }
            ?>

        </table>
        </div>


     <div class="pagination" style="margin-top: -em;">

<?php
    if($pageNum <= 0){
        echo <<< _END
            <a href="courses.php?page={$next_page}">
                <i class="fa fa-arrow-left"></i>
                Next
            </a>
        _END;
    } else if($pageNum > $courses_number['courses_number']/$row_per_page) {
        echo <<< _END
                <a href="courses.php?page={$back_page}">
                    Back
                    <i class="fa fa-arrow-right"></i>
                </a>
            _END;
        
    } else if ($pageNum == 1){
        echo <<< _END
        <a href="courses.php?page={$next_page}">
            <i class="fa fa-arrow-left"></i>
            Next
        </a>
    _END;
    }
    else if ($pageNum == $courses_number['courses_number']/$row_per_page){
        echo <<< _END
                <a href="courses.php?page={$back_page}">
                    Back
                    <i class="fa fa-arrow-right"></i>
                </a>
            _END;
    }
    else {
        echo <<< _END
                <a href="courses.php?page={$next_page}">
                    <i class="fa fa-arrow-left"></i>
                    Next
                </a>
                <a href="courses.php?page={$back_page}" style='margin-left: 2em'>
                    Back
                    <i class="fa fa-arrow-right"></i>
                </a>
            _END;
    }


?>


</div>
<?php
if(is_valid_pagination()){
        $get_all_price_query = "
            SELECT  SUM(courses.course_price) as total_price
            FROM `enrolled`
            JOIN `sections`
                ON enrolled.section_id = sections.id 
            JOIN `courses`
                ON sections.course_id = courses.id
            WHERE enrolled.student_id = '" . $student_id['id'] . "'"; 
        $get_all_price_result = mysqli_query($con, $get_all_price_query); 

        $price = mysqli_fetch_assoc($get_all_price_result);
        if($price['total_price'] > 0){
            echo <<< _END
                <div class="invoice" style="margin 0 0 5em 1em">
                    <p>Total price: {$price['total_price']} SAR </p>
                    <br />
                    <a href="../financial/index.php">Go to step 2 (Financial)</a><br />
                    <a href="../home.php" style='padding-bottom: 5em'>Cancel my requests and take me to dashboard</a>
                </div>
            _END;
        }
        else{
            echo <<< _END
                <a href="../home.php" style="margin-left: 2em">Go back to dashboard</a>
            _END;
        }
        
    }
    ?>
        </div>

</form>
<div class="view-sections"> 
            <?php
            if(Is_valid_pagination()){
                $result=mysqli_query($con,$query);
                while($row= mysqli_fetch_assoc($result) ){
                    $price = number_format($row['course_price']);
                   
                   $sections = "
                        SELECT  sections.id, teachers.teacher_name, courses_time.time, sections.status
                        FROM teachers
                        JOIN sections
                            ON teachers.id = sections.tutor_id
                        JOIN courses_time 
                            ON courses_time.id = sections.time_id
                        WHERE sections.course_id = '" . $row['id'] . "'";
                   
                    $sections_result = mysqli_query($con,$sections);
                    if($courses_data <= 0){
                        echo <<< _END
                            <div class="view-section viewSections" id="{$row['id']}" style="    
                                display: none;
                                position: absolute;
                                margin-left:30em;
                                margin-top:25em;
                                background: white;
                                border-radius: 10px;
                                opacity: 1;
                            ">
                            <p class="super-box-title">Section for Course {$row['course_id']} <span class="close_section_btn" style='float:right;transform: scale(1.25);cursor:pointer;' onclick="this.parentNode.parentNode.style.display='none'">&times;</span></p>
                            <div class="row">
                            <table>
                            <tr>
                                <th>Sections</th>
                                <th>Tutor</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                         _END;
                    }else{
                        echo <<< _END
                            <div class="view-section viewSections" id="{$row['id']}" style="    
                                display: none;
                                position: absolute;
                                margin-left:30em;
                                margin-top:50em;
                                background: white;
                                border-radius: 10px;
                                opacity: 1;
                            ">
                            <p class="super-box-title">Section for Course {$row['course_id']} <span class="close_section_btn" style='float:right;transform: scale(1.25);cursor:pointer;' onclick="this.parentNode.parentNode.style.display='none'">&times;</span> </p>
                            <div class="row">
                            <table>
                            <tr>
                                <th>Sections</th>
                                <th>Tutor</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                         _END;
                    }
                 
                    
                    while($sections_row = mysqli_fetch_assoc($sections_result)){

                        $available = $sections_row['status'] ? '<span style="color:green">Open</span>' : '<span style="color:red">Closed</span>';
                        $action = $sections_row['status'] ? '<span onclick="AddSection(' . $sections_row['id'] . ')" style="color:blue; text-decoration: underline;">Add Section</span>' : '';

                        echo <<< _END
                            <tr>
                                <td> {$sections_row['id']} </td>
                                <td> {$sections_row['teacher_name']} </td>
                                <td> 
                                    {$sections_row['time']}
                                </td>
                                <td> {$available} </td>
                                <td> {$action} </td>
                            </tr>
                    _END;
                    }
                
                    echo <<< _END
                        </table>
                        </div>
                        </div>
                    _END;

                   
                }
            }else{
                echo <<< _END
                <div class="student_data" style="
                    position: absolute;
                    margin-left:25em;
                    margin-top:7em;
                    background: white;
                    border-radius: 10px;
                    opacity: .85;  
                ">
                <p class="super-box-title">Courses Advised</p>
                    <div class="row" style="
                        padding: 2em 10em;
                    ">
                     <p style='color: crimson'>No data available</p>
            _END;
            }

            ?>

           


</div>
<?php
if($courses_data > 0){
    echo <<< _END
    <div class="registered-courses">
    <p class="super-box-title">Registered Courses</p>
    <div class="row">
        <table>
            <tr>
                <th>Course Code</th>
                <th>Section </th>
                <th>Credits</th>
                <th>Tutor</th>
                <th>Price</th>
                <th>Schedule</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
    _END;
    $get_all_student_courses = "
        SELECT  courses.*, sections.id as section_id, courses_time.time, teachers.teacher_name
        FROM enrolled
        JOIN sections
            ON enrolled.section_id = sections.id
        JOIN courses
            ON sections.course_id = courses.id
        JOIN courses_time
            ON courses_time.id = sections.time_id
        JOIN teachers
            ON teachers.id = sections.tutor_id
        WHERE enrolled.student_id = '" . $student_id['id'] . "'";
    $student_courses_result = mysqli_query($con, $get_all_student_courses);

    while( $courses_data= mysqli_fetch_assoc($student_courses_result) ){
        $price = number_format($courses_data['course_price'], 2);

        echo <<< _END
            <tr>
                <td> {$courses_data['course_id']} </td>
                <td> {$courses_data['section_id']} </td>
                <td> {$courses_data['credits']} </td>
                <td> {$courses_data['teacher_name']} </td>
                <td> {$price} SAR </td>
                <td> {$courses_data['time']} </td>
                <td> <span style="color:green">Enrolled</span> </td>
                <td> <span style="color:red; text-decoration: underline;" onclick="ConfirmDelete({$courses_data['section_id']})">Drop</span> </td>
            </tr>
        _END;
    }
                
    echo <<< _END
            </table>
        </div>
        </div>
    </div>
    _END;
}

?>



<script>

function ConfirmDelete(id)
{
    if (confirm("Are you sure? you will be permanently removed from this section"))
        location.href='../remove_section.php?id=' + id;
}
function AddSection(id)
{
    location.href='../add_section.php?id=' + id;
}
function showViewSections(id){
    var ele = document.getElementsByClassName("viewSections");
    for (var i = 0; i < ele.length; i++ ) {
        ele[i].style.display = "none";
    }
    document.getElementById(id).style.display = 'block';
}


if (location.href.indexOf("#") != -1) {
    alert(decodeURI(location.href.substr(location.href.indexOf("#")+1)));
    location.href = '';
}



</script>
</body>
</html>