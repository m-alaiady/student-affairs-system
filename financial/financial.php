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
<title>SIS | Fees Payment</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <style>
        body{
            overflow-y: scroll !important;
        }
        .box{
            min-width: 5em !important;
        }
        .student_data{
            all: unset;
            position: absolute;
            margin-left:18em;
            margin-top:7em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(0.80);
            padding-bottom: 2em;
        }
        .student_data_2{
            all: unset;
            position: absolute;
            margin-left:19em;
            margin-top:27em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(0.75);           
        }
        .student_data_2::after{
            content: " ";
            white-space: pre;
            padding: 10em;
        }
        .logo, .foot{
            z-index: 999;
        }
        .foot{
            position: fixed;
            opacity: 0.85;
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

?>
<div class="student_data">
    <p class="super-box-title">Registered courses</p>
<?php
if($courses_data > 0){
    echo <<< _END
        <div class="header">    
            <div class="registered-courses">
        </div>
        <table class="table">
        <tr>
           <th>Course Code</th>
           <th>Section ID</th>
           <th>Credits</th>
           <th>Teacher</th>
           <th>Price</th>
           <th>Time</th>
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
        WHERE enrolled.student_id = '" . $student['id'] . "'";

    $student_courses_result = mysqli_query($con, $get_all_student_courses);

    while( $courses_data= mysqli_fetch_assoc($student_courses_result) ){
        $price = number_format($courses_data['course_price']);
        echo <<< _END
        <tr>
            <td>
                {$courses_data['course_id']}
            </td>
            <td>
                {$courses_data['section_id']}
            </td>
            <td>
                {$courses_data['credits']} hrs 
            </td>
            <td>
                {$courses_data['teacher_name']}
            </td>
            <td>
                {$price} SAR
            </td>
            <td>
                {$courses_data['time']}
            </td>
        </tr>
    _END;
    }
                
    echo <<< _END
            </table>
            <a href="../registration/courses.php" 
            style="text-decoration: none; 
            background: #2691d9; 
            border-radius: 25px;
            font-size: 18px; 
            color: #e9f4fb;
            padding: 10px;
            font-weight: 500;
            margin-left:20em;
            margin-top: 2em !important; 
            ">ADD / Drop courses</a>
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
</div>

<div class="student_data_2">
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
            <td>Registration Fees</td>
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