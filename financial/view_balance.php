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


?>

<html>
<head>
<title>SIS | View Balance</title>
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

$price['total_price'] = $price['total_price'] ? 0 - $price['total_price'] : 0;


?>
<div class="student_data">
<div>
    <p class="super-box-title">View Balance</p>
    <!-- <p>Listed below is a view of your tuition summary for this semester</p> -->
    <table>
        <tr>
            <td>Your balance</td>
            <td>
            <?php 
            
            if($price['total_price'] >= 0){
                echo "<strong style='color:green'>{$price['total_price']}</strong> ";
            } else {
                echo "<strong style='color:red'>{$price['total_price']}</strong> ";
            }
            
            ?> SAR</td>
        </tr>

    </table>
    <a href="<?php echo $path ?>/financial/financial.php" style="margin-left: 2em;">For more details</a>

    </div>
</div>
<script>


</script>

</body>
</html>