<!-- here is the registration page, it is the page where the students can choose between advised course
and view the sections and add them. it is also to show the registered courses with the option to 
drop any course student wants. it has the design of this page -->
<?php

// it is to include the SIS project project
require_once("../connection.php");

// this will include the design of the page such as: background, head, footer, and side menu
include("../template/t1.php");

$query="select * from courses";
$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);

// here is to get all courses from courses table and join enrolled table and create relation between 
// course ID in courses table and course id in enrolled table
$get_all_courses = "SELECT courses.* 
                    FROM courses 
                    JOIN enrolled 
                    ON courses.id = enrolled.course_id 
                    WHERE enrolled.student_id = '" . $student_id['id'] . "' ";



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

<!-- here is the start the CSS design of the tables in registration page -->
<html>
<head>
<title>SIS | Registration</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        margin-left:13.5em;
        margin-top:37em;
        background: white;
        border-radius: 10px;
        opacity: .85;
        transform: scale(0.75);
    }
    .registered-courses::after{
       content: "";
       padding: 5em;
    }
    .foot{
        position: fixed;
    }
    table, th, td{
        border: 1px solid #000;
        border-collapse: collapse;
        padding: 1em 2em;
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
<!-- here is the END the CSS design of the tables in registration page -->


<body>
<form>
    <div id="status">
    </div>
    <?php


// here is the courses advised design and code if the courses data
// has no data
if($courses_data <= 0){
    echo <<< _END
            <div class="student_data" style="
                position: absolute;
                margin-left:17em;
                margin-top:10em;
                background: white;
                border-radius: 10px;
                opacity: .85;  
                transform: scale(0.85);
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

// here is the courses advised design and code if the courses data
// has data
}else{
  
    echo <<< _END
            <div class="student_data" style="
                position: absolute;
                margin-left:17.5em;
                margin-top:10em;
                background: white;
                border-radius: 10px;
                opacity: .85;  
                transform: scale(0.85);
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
                        $price = $row['course_price'];
                        
                        $get_all_teachers_by_course = "SELECT teachers.* FROM teachers JOIN teachers_courses ON teachers.id = teachers_courses.tutor_id WHERE teachers_courses.course_id = '" . $row['id'] . "' ";
                        $teachers_result = mysqli_query($con,$get_all_teachers_by_course);
                        $teacher_name = mysqli_fetch_assoc($teachers_result);

                        echo <<< _END
                            <tr>
                                <td> {$row['course_id']} </td> 
                                <td> {$row['course_name']} </td>
                                <td> {$row['credits']} </td>
                                <td> {$price} SAR </td>
                                <td> <span onclick="showViewSections({$row['id']})" style="color:blue;
                                 text-decoration: none;
                                 background: #2691d9; 
                                border-radius: 25px;
                                font-size: 14px; 
                                color: white;
                                padding: 5px;
                                cursor: pointer;
                                font-weight: 500">View Sections</span> </td>
                            </tr>
                        _END;
                    }
            ?>

        </table>
        </div>
</div>

        </div>

</form>

<!-- here is the design of view sections  -->
<!-- here is the code of adding section, onclick=addsection -->
<div class="view-sections"> 
            <?php
                $result=mysqli_query($con,$query);
                while($row= mysqli_fetch_assoc($result) ){
                    $price = ($row['course_price']);
                   
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
                                margin-top:16em;
                                background: white;
                                border-radius: 10px;
                                opacity: 1;
                                border: 1px solid black;
                                transform: scale(0.85);
                            ">
                            <p class="super-box-title">Section for Course {$row['course_id']} <span class="close_section_btn" style='float:right;transform: scale(1.25);cursor:pointer;' onclick="this.parentNode.parentNode.style.display='none'">&times;</span></p>
                            <div class="row">
                            <table>
                            <tr>
                                <th>Sections</th>
                                <th>Tutor</th>
                                <th colspan="2">Time</th>
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
                            margin-top:16em;
                            background: white;
                            border-radius: 10px;
                            opacity: 1;
                            border: 1px solid black;
                            transform: scale(0.85);
                            ">
                            <p class="super-box-title">Section for Course {$row['course_id']} <span class="close_section_btn" style='float:right;transform: scale(1.25);cursor:pointer;' onclick="this.parentNode.parentNode.style.display='none'">&times;</span> </p>
                            <div class="row">
                            <table>
                            <tr>
                                <th>Sections</th>
                                <th>Tutor</th>
                                <th colspan="2">
                                    Time
                                </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                         _END;
                    }
                 
                    $only_once = true;
                    while($sections_row = mysqli_fetch_assoc($sections_result)){

                        $available = $sections_row['status'] ? '<span style="color:green">Open</span>' : '<span style="color:red">Closed</span>';
                        $action = $sections_row['status'] ? '<span onclick="AddSection(' . $sections_row['id'] . ')" style="color:blue;
                         text-decoration: none;
                                 background: #2691d9; 
                                border-radius: 25px;
                                font-size: 14px; 
                                color: #e9f4fb;
                                padding: 5px;
                                cursor: pointer;
                                font-weight: 500
                         ">Add Section</span>' : '';
                        $day_and_times = explode(' ', $sections_row['time']);
                        $days = array();
                        $times = array();

                        // split time and day from string
                        foreach ($day_and_times as $day_and_time) {
                            if (DateTime::createFromFormat('H:i', $day_and_time) !== false) {
                                array_push($times, $day_and_time);
                            } else {
                                array_push($days, $day_and_time);
                            }
                        }

                        $time_class = strtotime($times[0]);
                        $time_virtual = strtotime($times[1]);

                        $time_class_format = date('H:i', strtotime($time_class));
                        $time_virtual_format = date('H:i', strtotime($time_virtual));

                        $time_class_format = $times[0] . " - " . date('H:i', strtotime('+50 minutes', $time_class));
                        $time_virtual_format = $times[1] . " - " . date('H:i', strtotime('+50 minutes', $time_virtual));
                        echo <<< _END
                            <tr>
                                <td> {$sections_row['id']} </td>
                                <td> {$sections_row['teacher_name']} </td>
                                    <td>
                            _END;
                            if($only_once){
                                echo " <label style='position:absolute;margin-top: -3em;margin-left: 3em;font-weight:bold;'>Class</label>";
                            }
                            echo <<< _END
                                        {$days[0]} {$time_class_format}
                                    </td>
                                    <td> 
                            _END;
                            if($only_once){
                                echo "<label style='position:absolute;margin-top: -3em;margin-left: 3em;font-weight:bold;'>Virtual</label>";
                            }
                            echo <<< _END
                                {$days[1]} {$time_virtual_format}
                                </td>
                                    <td> {$available} </td>
                                    <td> {$action} </td>
                                </tr>
                            _END;
                            $only_once = false;
                    }
                
                    echo <<< _END
                        </table>
                        </div>
                        </div>
                    _END;

                   
                }

            ?>

           


</div>



<!-- this part is to show the registered courses and design the table  -->
<!-- it has the ability to drop course and it is here in this part -->
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
                <th colspan='2'>Time</th>
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
    $print_time_header_once_flag = true;

    while( $courses_data= mysqli_fetch_assoc($student_courses_result) ){
        $price = $courses_data['course_price'];
        $day_and_times = explode(' ', $courses_data['time']);
        $days = array();
        $times = array();

        // split time and day from string
        foreach ($day_and_times as $day_and_time) {
            if (DateTime::createFromFormat('H:i', $day_and_time) !== false) {
                array_push($times, $day_and_time);
            } else {
                array_push($days, $day_and_time);
            }
        }

        $time_class = strtotime($times[0]);
        $time_virtual = strtotime($times[1]);

        $time_class_format = date('H:i', strtotime($time_class));
        $time_virtual_format = date('H:i', strtotime($time_virtual));

        $time_class_format = $times[0] . " - " . date('H:i', strtotime('+50 minutes', $time_class));
        $time_virtual_format = $times[1] . " - " . date('H:i', strtotime('+50 minutes', $time_virtual));

        echo <<< _END
            <tr>
                <td> {$courses_data['course_id']} </td>
                <td> {$courses_data['section_id']} </td>
                <td> {$courses_data['credits']} </td>
                <td> {$courses_data['teacher_name']} </td>
                <td> {$price} SAR </td>
                 <td>
        _END;
        if($print_time_header_once_flag){
            echo "<label style='position:absolute;margin-top: -4em;margin-left: 2.5em;font-weight:bold;'>Class</label>";
        }
        echo <<< _END
                    <span style='white-space: nowrap;'>{$days[0]} {$time_class_format}</span>
                </td>
                <td>
        _END;
        if($print_time_header_once_flag){
            echo "<label style='position:absolute;margin-top: -4em;margin-left: 2.5em;font-weight:bold;'>Virtual</label>";

        }
        echo <<< _END
                    <span style='white-space: nowrap;'>{$days[1]} {$time_virtual_format}</span>
                </td>
                <td> <span style="color:green">Enrolled</span> </td>
                <td> <span style="
               
                text-decoration: none;
                                 background: red; 
                                border-radius: 25px;
                                font-size: 18px; 
                                color: #e9f4fb;
                                padding: 5px;
                                font-weight: 500;
                                cursor: pointer;"
                                 onclick="ConfirmDelete({$courses_data['section_id']})">Drop</span> </td>
            </tr>
        _END;
        $print_time_header_once_flag = false;
    }
                
    echo <<< _END
            </table>
        </div>
        </div>
        &nbsp;
    </div>
    _END;
}

?>




<!-- these are the funnctions that we used to have the ability to add section and remove -->
<!-- these function will redirect to other files like remove sections and add sections -->


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




// these are the messages of the error and success alerts
// also the ime of the alert is here as 3000ms (setTimeout)
// success = flag1, error = flag2


if (location.href.indexOf("#") != -1) {
    // alert();
    // document.window(decodeURI(location.href.substr(location.href.indexOf("#")+1)));
    let message = decodeURI(location.href.substr(location.href.indexOf("#")+1));
    if(message.includes('flag1')){
        message = message.replace('flag1','');
        document.getElementById('status').innerHTML = `
        <div id="alert" class="alert success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <p>${message}</p>
        </div>
        `;
    }else{
        message = message.replace('flag2','');
        document.getElementById('status').innerHTML = `
        <div id="alert" class="alert error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <p>${message}</p>
        </div>
        `;
    }
    setTimeout(function(){
        // window.location.replace('#','');
        history.replaceState("", document.title, window.location.pathname);
        document.getElementById('alert').style.display = 'none';
    }, 3000);
}



</script>
</body>
</html>