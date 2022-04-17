<?php

require_once('../connection.php');
include("../template/t1.php");

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);

$get_all_grades_data = "SELECT  enrolled.notes, enrolled.grade,enrolled.absences, courses.*, sections.id as section_id, courses_time.time, teachers.teacher_name
        FROM enrolled
        JOIN sections
            ON enrolled.section_id = sections.id
        JOIN courses
            ON sections.course_id = courses.id
        JOIN courses_time
            ON courses_time.id = sections.time_id
        JOIN teachers
            ON teachers.id = sections.tutor_id
        WHERE enrolled.student_id = " . $student_id['id'] . "";

?>

<html>
<head>
    <title>SIS | Grades & Transcripts</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <style>
        .box{
            min-width: 10em !important;
        }
        .student-data{
            all:unset;
            position: absolute;
            margin-left:0em;
            margin-top:25em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(0.85);
        }
    </style>
</head>
<body>
<div class="student_data">
     <p class="super-box-title">Grades</p>
    
            <?php

                function grade_details($grade)
                {
                    switch ($grade) {
                        case 0:
                            return '';
                            break;
                        case $grade >= 0 && $grade < 50:
                            return 'F';
                            break;
                        case $grade >= 50 && $grade < 58:
                            return 'D';
                            break;
                        case $grade >= 58 && $grade < 66:
                            return 'C';
                            break;
                        case $grade >= 66 && $grade < 74:
                            return 'C+';
                            break;
                        case $grade >= 74 && $grade < 82:
                            return 'B';
                            break;
                        case $grade >= 82 && $grade < 90:
                            return 'B+';
                            break;
                        case $grade >= 90 && $grade <= 100:
                            return 'A';
                            break;
                       
                    }
                }
                $grade_result = mysqli_query($con, $get_all_grades_data);
                if(mysqli_num_rows($grade_result) > 0){
                    while( $grade_data= mysqli_fetch_assoc($grade_result)){
                        $grade_mark = grade_details($grade_data['grade']);
                        $notes = $grade_data['notes'] != null ? $grade_data['notes']: 'No notes available';
                            echo <<< _END
                                <div class="row">
                                    <div class="box">
                                        <p class="box-title">Course Code</p>
                                        <p>{$grade_data['course_id']}</p>
                                    </div>
                                    <div class="box">
                                        <p class="box-title">Credits</p>
                                        <p>{$grade_data['credits']}</p>
                                    </div>
                                    <div class="box">
                                        <p class="box-title">Grade</p>
                                        <p>{$grade_data['grade']}</p>
                                    </div>
                                    <div class="box">
                                        <p class="box-title">Grade Details</p>
                                        <p>{$grade_mark}</p>
                                    </div>
                                    <div class="box">
                                        <p class="box-title">Notes</p>
                                        <p>{$notes}</p>
                                    </div>
                                </div>
                            
                            _END;
                    }
                }
                else{
                    echo <<< _END
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