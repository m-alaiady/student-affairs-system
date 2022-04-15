<?php

require_once('../connection.php');
include("../template/t1.php");
$query="select * from courses";
$get_id = "select * from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student= mysqli_fetch_assoc($get_id_result);


$get_all_courses = "SELECT courses.* FROM courses JOIN enrolled ON courses.id = enrolled.course_id WHERE enrolled.student_id = '" . $student['id'] . "' ";
$get_all_teachers = "SELECT teachers.* FROM teachers JOIN courses ON teachesr.id = courses.tutor_id WHERE courses.tutor_id = '" . $student['id'] . "' ";

$courses=mysqli_query($con,$get_all_courses);

// if user did not signed in
if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}
// if user did not pay 
// if( basename($_SERVER['HTTP_REFERER']) != "courses.php"){
//     header("location:../registration/courses.php");
// }

?>

<html>
<head>
<title>SIS | Grades & Transcripts</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <style>
        body{
            overflow-y: scroll !important;
        }
        .box{
            min-width: 10em !important;
        }
        .student_data{
            margin-top: 100px;
            margin-left:400px;
            z-index: 1;
            transform: scale(0.85);
        }
        .student_data:last-child{
            padding-bottom: 5em;
        }
        .foot{
            position: fixed;
            opacity: 1;
            z-index: 999;
        }
        .header{
            margin: 0 2em;
        }
        
    </style>
<style>

</style>
</head>
<body>
<?php 

$reg_id = rand(1000000000,9999999999);



$get_all_student_courses = "
    SELECT  courses.*, sections.id as section_id, courses_time.time
    FROM enrolled
    JOIN sections
        ON enrolled.section_id = sections.id
    JOIN courses
        ON sections.course_id = courses.id
    JOIN courses_time
        ON courses_time.id = sections.time_id
    WHERE enrolled.student_id = '" . $student['id'] . "'";
$student_courses_result = mysqli_query($con, $get_all_student_courses);
$courses_data= mysqli_fetch_assoc($student_courses_result);
/*
    // <fieldset>
    //     <legend>Courses Registered</legend>
    //     <table>
    //         <tr>
    //             <th>Course Code</th>
    //             <th>Section </th>
    //             <th>Credits</th>
    //             <th>Tutor</th>
    //             <th>Price</th>
    //             <th>Schedule</th>
    //             <th>Status</th>
    //         </tr>
                <tr>
                <td> {$courses_data['course_id']} </td>
                <td> {$courses_data['section_id']} </td>
                <td> {$courses_data['credits']} </td>
                <td> {$courses_data['teacher_name']} </td>
                <td> {$price} SAR </td>
                <td> {$courses_data['time']} </td>
                <td> <span style="color:green">Enrolled</span> </td>
            </tr>

*/
?>
<div class="student_data">
    <p class="super-box-title">Registered courses</p>
<?php
if($courses_data > 0){
    echo <<< _END
        <div class="header">
            <strong>Registeration ID: </strong> 
            <span>{$reg_id}</span>
            <strong style='margin-left: 10rem'>Student info:</strong>
            <span> {$student['s_name']} -  {$student['student_id']} - {$student['email']} </span><br />
            <div class="registered-courses">
        </div>
       
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
        WHERE enrolled.student_id = '" . $student['id'] . "'";

    $student_courses_result = mysqli_query($con, $get_all_student_courses);

    while( $courses_data= mysqli_fetch_assoc($student_courses_result) ){
        $price = number_format($courses_data['course_price']);

        echo <<< _END
            <div class="row">
                <div class="box">
                    <p class="box-title">Course Code</p>
                    <p>{$courses_data['course_id']}</p>
                </div>
                <div class="box">
                    <p class="box-title">Section ID</p>
                    <p>{$courses_data['section_id']}</p>
                </div>
                <div class="box">
                    <p class="box-title">Credits</p>
                    <p>{$courses_data['credits']}</p>
                </div>
                <div class="box">
                    <p class="box-title">Teacher</p>
                    <p>{$courses_data['teacher_name']}</p>
                </div>
                <div class="box">
                    <p class="box-title">Price</p>
                    <p>{$price} SAR </p>
                </div>
                <div class="box">
                    <p class="box-title">Time</p>
                    <p>{$courses_data['time']}</p>
                </div>
            </div>

        _END;
    }
                
    echo <<< _END
            </table>
        </fieldset>
    </div>
    _END;
}
// no courses registered
else{
    echo <<< _END
        <div class="row">
            <div class="student box">
            <p style="color: crimson">No courses registered</p>
            </div>
        </div>
     _END;
}


$get_all_price_query = "
    SELECT  SUM(courses.course_price) as total_price
    FROM `enrolled`
    JOIN `sections`
        ON enrolled.section_id = sections.id 
    JOIN `courses`
        ON sections.course_id = courses.id
    WHERE enrolled.student_id = '" . $student['id'] . "'"; 
$get_all_price_result = mysqli_query($con, $get_all_price_query); 

$price = mysqli_fetch_assoc($get_all_price_result);

$overall_price = 90 + $price['total_price'] + 469 + 23 + 848;

?>


<div>
    <p class="super-box-title">Listed below is a view of your tuition summary for this semester</p>
    <!-- <p>Listed below is a view of your tuition summary for this semester</p> -->
    <table>
        <tr>
            <th>Category</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Administrative Fees</td>
            <td>90 SAR</td>
        </tr>
        <tr>
            <td>Course Fees</td>
            <td><?php echo $price['total_price'] > 0 ? $price['total_price'] : 0 ?> SAR</td>
        </tr>
        <tr>
            <td>Registeration Fees</td>
            <td>469 SAR</td>
        </tr>
        <tr>
            <td>Student Aid Support</td>
            <td>23 SAR</td>
        </tr>
        <tr>
            <td>Technical Services and Electronic Resources</td>
            <td>848 SAR</td>
        </tr>
        <tr>
            <td><strong style="color:green">Balance settled</strong></td>
            <td>0 SAR</td>
        </tr>
        <tr>
            <td><strong style="color:red">Total to be paid</strong></td>
            <td><?php echo $overall_price ?> SAR</td>
        </tr>
       



    </table>
    </div>
</div>
<!-- <a href="../registration/courses.php">Go back to courses registration</a> -->
<script>

function PrintPage(){
    document.getElementById('print_btn').style.display = 'none';
    window.print();
    document.getElementById('print_btn').style.display = 'block';


}

</script>

</body>
</html>