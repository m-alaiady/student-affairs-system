<?php

ob_start();
require_once('../connection.php');
include("../template/t1.php");

if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

// get the faculty, major and branch name
$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";
        

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);

$get_all_student_courses = "
        SELECT  enrolled.absences, courses.*, sections.id as section_id, courses_time.time, teachers.teacher_name
        FROM enrolled
        JOIN sections
            ON enrolled.section_id = sections.id
        JOIN courses
            ON sections.course_id = courses.id
        JOIN courses_time
            ON courses_time.id = sections.time_id
        JOIN teachers
            ON teachers.id = sections.tutor_id
        WHERE enrolled.student_id = '" . $student_id['id']  . "'";    


$faculty_data=mysqli_query($con,$sql);
$faculty= mysqli_fetch_assoc($faculty_data);

?>

<html>

<head>
    <title>SIS | Tuition Fees Exemption</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <style>
        .student_data form{
            padding: 2em;
        }
        .upload-btn{

            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.5em 2em;
            border: none;
            cursor: pointer;
            color: white;
        }
    </style>
</head>


<body>
    <div class="student_data">
     <p class="super-box-title">Tuition Fees Exemption</p>
    
            <form method="post" enctype="multipart/form-data">
                <label for="social_security">Social Security: </label>
                <input name="social_security_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <label for="salary_certifiacte">Salary Certifiacte: </label>
                <input name="salary_certifiacte_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <label for="electricity_bill">Electricity Bill: </label>
                <input name="electricity_bill_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <label for="account_statement">Account Statement: </label>
                <input name="account_statement_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <input name="submit" type="submit" class="upload-btn" value="upload" />
                
            </form>

    </div>

</body>

</html>

