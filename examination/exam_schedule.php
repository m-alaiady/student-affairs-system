<?php
require_once('../connection.php');

include("../template/t1.php");


$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";
        

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);

$get_all_student_courses = "
        SELECT  enrolled.absences, courses.*, sections.id as section_id,sections.*, courses_time.time, teachers.teacher_name
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
?>

<html>

<head>
    <title>SIS | Exam Schedule</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data_print_btn {
            all: unset;
            position: absolute;
            background-color: dodgerblue;
            margin-left:33em;
            margin-top:30em;
            border-radius: 10px;
            padding: 0.25em 1em;
            border: none;
            cursor: pointer;
            color: white;
        }
    </style>
</head>


<body>

    <div class="student_data">
        <p class="super-box-title">Exam Schedule</p>


        <div class="row">

           
                    
                    <?php
                        $courses_result = mysqli_query($con, $get_all_student_courses);

                        if(mysqli_num_rows($courses_result) > 0){
                            echo "<table>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Classroom</th>
                            </tr>
                            <tr>";
                        
                            while( $courses= mysqli_fetch_assoc($courses_result)){
                                $course_time = $courses['exam_time'] > 12 ?  $courses['exam_time'] . ' PM': $courses['exam_time'] . ' AM';
                                echo <<<_END
                                    <tr>
                                        <td>{$courses['course_name']}</td>
                                        <td>{$courses['course_name']}</td>
                                        <td>{$courses['exam_date']}</td>
                                        <td>{$course_time}</td>
                                        <td>{$courses['id']}</td>
                                    </tr>
                                _END;
                            }
                            echo <<< _END
                                    </tr>
                                    </table>             
                                </div>
                            </div>
                            <a href="print_exam_schedule.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
                            _END;
                        }else{
                            echo <<< _END
                                <div class="row">
                                    <div class="student box">
                                    <p style="color: crimson">No courses registered</p>
                                    </div>
                                        </div>
                                        </tr>
                                        </table>             
                                    </div>
                                </div>
                             _END;
                        }
                        ?>




    <div id="service"></div>



</body>

</html>

<?php
// show requedted file


?>