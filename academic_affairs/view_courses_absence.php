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
    <title>SIS | Student Absences</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <style>
         .student_data{
                position: absolute;
                margin-left:13vw;
                margin-top:100px;
                background: white;
                border-radius: 10px;
                opacity: .85;
                /* transform: translate(35%, 50%); */
                /* padding: 20px;  */
                transform: scale(0.80);
            }
            .row{
                all: unset;
                display: flex;
                padding: 0 2em;
                /* justify-content: ; */
                flex-direction: row;      
                align-items: stretch; 
            }
            .box{
                background: #fff;
                margin: 10px;;
                border-radius: 5px;
                min-width: 5em;
                border: 1px solid #eee;
                box-shadow: 2px 2px #eee;
                padding: 0 3em 0 1em;
            }
            .student_id{
                background: #fff;
                margin: 10px;;
                border-radius: 5px;
                min-width: 40em;
                border: 1px solid #eee;
                box-shadow: 2px 2px #eee;
                padding: 0 3em 0 1em;
            }
    </style>
</head>


<body>

            <?php
                $student_courses_result = mysqli_query($con, $get_all_student_courses);
                $count_absences = 0;
                if(mysqli_num_rows($student_courses_result) > 0){
                    echo <<< _END
                        <div class="student_data">
                        <p class="super-box-title">Student Absences</p>
                    _END;
                    while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
                        // if($courses_data['absences'] > 0){
                            $count_absences++;
                            echo <<< _END
                                <div class="row">
                                    <div class="student box">
                                        <p class="box-title">Course Code</p>
                                        <p>{$courses_data['course_id']}</p>
                                    </div>
                                    <div class="student_id box">
                                        <p class="box-title">Course Name</p>
                                        <p>{$courses_data['course_name']}</p>
                                    </div>
                                    <div class="SSN box">
                                        <p class="box-title">Allowed Absences</p>
                                        <p>{$courses_data['allowed_absences']} hrs </p>
                                    </div>
                                    <div class="SSN box">
                                        <p class="box-title">Student's Absences</p>
                                        <p>{$courses_data['absences']} hrs</p>
                                    </div>
                                </div>
                            
                            _END;
                        // }
                    }
                    // no absences
                    if($count_absences == 0){
                        echo <<< _END
                            <div class="row">
                                <div class="student box">
                                <p style="color: crimson">No absences</p>
                                </div>
                            </div>
                         _END;
                    }
                } 
                else{ // no courses 
                    echo <<< _END
                        <div class="student_data" style="
                            all: unset;
                            position: absolute;
                            margin-left:20vw;
                            margin-top:100px;
                            background: white;
                            border-radius: 10px;
                            opacity: .85;
                            /* transform: translate(35%, 50%); */
                            /* padding: 20px;  */
                            transform: scale(0.80);        
                        " >
                            <p class="super-box-title">Student Absences</p>
                            <div class="row">
                                <div class="student box">
                                <p style="color: crimson">No courses registered</p>
                                </div>
                            </div>
                     _END;
                }

               

            ?>

    </div>

</body>

</html>

