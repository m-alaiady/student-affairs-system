<?php

require_once("../connection.php");

include("../template/t1.php");

$query="select * from courses";
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
    }
    .logo, .foot{
        z-index: 1;
    }
    .student_data div,.view-section div, .registered-courses div{
        padding: 2em;
    }
    

    .registered-courses{
        position: absolute;
        margin-left:25em;
        margin-top:10em;
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
</style>
</head>
<body>
<form>
    <?php

if($courses_data <= 0){
    echo <<< _END
            <div class="student_data" style="
                position: absolute;
                margin-left:25em;
                margin-top:10em;
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
                margin-top:30em;
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
                ?>
                <?php
                    $result=mysqli_query($con,$query);
                    while($row= mysqli_fetch_assoc($result) ){
                        $price = number_format($row['course_price']);
                        
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
                    

            ?>

        </table>
        </div>
    </div>
</form>
<div class="view-sections"> 
            <?php
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
                                margin-left:25em;
                                margin-top:33em;
                                background: white;
                                border-radius: 10px;
                                opacity: .85;
                            ">
                            <p class="super-box-title">Section for Course {$row['course_id']}</p>
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
                                margin-left:25em;
                                margin-top:53em;
                                background: white;
                                border-radius: 10px;
                                opacity: .85;
                            ">
                            <p class="super-box-title">Section for Course {$row['course_id']}</p>
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
        $price = number_format($courses_data['course_price']);

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

<div class="invoice">
    
    <?php
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
                <p>Total price: {$price['total_price']} SAR </p>
                <a href="../financial/index.php">Go to step 2 (Financial)</a><br />
                <a href="../home.php">Cancel my requests and take me to dashboard</a>
            _END;
        }
        else{
            echo <<< _END
                <a href="../home.php">Go back to dashboard</a>
            _END;
        }
        

    ?>

</div>

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