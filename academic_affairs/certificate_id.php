<?php
define("FIVE_MIGA_BYTES", 5242880);
ob_start();
require_once('../connection.php');
include("../template/t1.php");
if (!isset($_SESSION['student_id'])) {
    header("location:../index.php");
}
$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";
$get_id_result = mysqli_query($con, $get_id);
$student_id = mysqli_fetch_assoc($get_id_result);
$std_id = $student_id['id'];

// get the faculty name, major and branch name
$sql = "
        SELECT 
            faculties.* 
        FROM 
            faculties 
            JOIN students ON faculties.id = students.faculty_id 
        WHERE
            students.student_id = " . $_SESSION['student_id'] . "";

$faculty_data = mysqli_query($con, $sql);
$faculty = mysqli_fetch_assoc($faculty_data);
$get_registered_hours = "
        SELECT
            SUM(credits)
        FROM
            enrolled
            JOIN sections ON enrolled.section_id = sections.id
            JOIN courses ON sections.course_id = courses.id
        WHERE
            student_id = '$std_id';";

$get_registered_hours_result = mysqli_query($con, $get_registered_hours);
$registered_hours = mysqli_fetch_assoc($get_registered_hours_result);
$registered_hours['SUM(credits)'] = $registered_hours['SUM(credits)'] > 0 ? $registered_hours['SUM(credits)'] : 0 . ' hrs';
?>
<html>
<head>
    <title>SIS | Statements</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data{
            position: absolute;
            margin-left:20vw;
            margin-top:7em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(1);
            /* transform: translate(35%, 50%); */
            
        }
        .student_data_print_btn{
            all: unset;
            position: relative;
            margin-top: 2vh;
            margin-left: 45%;
            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.5em 2em;
            border: none;
            cursor: pointer;
            color: white;
         }
        .row{
                display: flex;
                padding: 0 2em;
                /* justify-content: ; */
                flex-wrap: wrap;
                flex-direction: row;      
                align-items: stretch; 
            }
        .box{
            all: unset;
            background: #fff;
            margin: 10px;
            border-radius: 5px;
            min-width: 17em;
            border: 1px solid #eee;
            box-shadow: 2px 2px #eee;
            /* padding: 0 3em; */
         }
         #services{
            all:unset;
            position: absolute;
            margin-left:20vw;
            margin-top:5em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(0.85);
         }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div class="student_data">
            <p class="super-box-title">Statements</p>
            <div class="row">
                <div class="box">
                    <p class="box-title">Select a statement: </p>
                    <p>
                        <select id="servicesList" onchange="services();">
                            <option selected disabled hidden>-- Select statement --</option>
                            <option value="change_track">Statement of Credit Hours Completed by Student</option>
                            <option value="center_transfer">Schedule Statement</option>
                            <option value="semester_postponing">Study Duration Statement</option>
                            <option value="semester_excuse">Definition Statement</option>
                        </select>
                    </p>
                </div>
            </div>
        </div>
    </form>
    <div id="service"></div>
</body>
</html>
<script>
    function services() {
        let select = document.getElementById('servicesList');
        let table = "";
        switch (select.options[select.selectedIndex].value) {
            case 'change_track':
                table = `
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">Stundet Name</p>
                            <p><?php echo $data['s_name']; ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Stundet ID</p>
                            <p><?php echo $data['student_id']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">SSN</p>
                            <p><?php echo $data['national_id']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student_id box">
                            <p class="box-title">Academic Status</p>
                            <p><?php echo ($data['status'] == '1' ? 'Active' : 'Not active'); ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Level</p>
                            <p><?php echo $data['level']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Degree</p>
                            <p><?php echo $data['degree']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">College</p>
                            <p><?php echo $faculty['name']; ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Major</p>
                            <p><?php echo $data['major']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Branch</p>
                            <p><?php echo $faculty['branch']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">Registered Hours</p>
                            <p><?php echo $registered_hours['SUM(credits)'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                <a href="print_registered_hours.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
                </div>
                `;
                break;
            case 'center_transfer':
                table = `
                <div class="row">
                        <div class="student box">
                            <p class="box-title">Stundet Name</p>
                            <p><?php echo $data['s_name']; ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Stundet ID</p>
                            <p><?php echo $data['student_id']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">SSN</p>
                            <p><?php echo $data['national_id']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student_id box">
                            <p class="box-title">Academic Status</p>
                            <p><?php echo ($data['status'] == '1' ? 'Active' : 'Not active'); ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Level</p>
                            <p><?php echo $data['level']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Degree</p>
                            <p><?php echo $data['degree']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">College</p>
                            <p><?php echo $faculty['name']; ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Major</p>
                            <p><?php echo $data['major']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Branch</p>
                            <p><?php echo $faculty['branch']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                <a href="print_schedule_statement.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
                </div>
                    `;
                table = `
                    <table class="table">
                         <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Lecture Type</th>
                         </tr>
                    `;
                <?php 
                    $get_all_student_courses = "
                    SELECT  
                        enrolled.absences, courses.*, sections.*, sections.id as section_id, courses.course_id as course_id, courses_time.time, teachers.teacher_name
                    FROM 
                        enrolled
                        JOIN sections ON enrolled.section_id = sections.id
                        JOIN courses ON sections.course_id = courses.id
                        JOIN courses_time ON courses_time.id = sections.time_id
                        JOIN teachers ON teachers.id = sections.tutor_id
                    WHERE 
                        enrolled.student_id = '$std_id'";
                    $student_courses_result = mysqli_query($con, $get_all_student_courses);

                    while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
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
                        $lecture_or_lab = "lecture_type";
                        $room = $courses_data['room'];
                        foreach ($times as $index => $time) {
                            if($lecture_or_lab == "lab_type"){
                                $room = "Virtual";
                            }
                            $time_oo = strtotime($time);
                            $time_format = date('H:i', strtotime($time));
                            $time_format = $time_format . " - " . date('H:i', strtotime('+50 minutes', $time_oo));
                ?>
                               table +=`<tr>
                                    <td>
                                        <?php echo $courses_data['course_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $courses_data['course_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $time_format; ?>
                                    </td>
                                    <td>
                                        <?php echo $room?>
                                    </td>
                                    <td>
                                        <?php echo  $days[$index] ?>
                                    </td>
                                    <td>
                                        <?php echo  $courses_data[$lecture_or_lab]  ?>
                                    </td>
                                </tr>
                                `;
                      <?php  
                      
                            if ($lecture_or_lab == "lecture_type") {
                                $lecture_or_lab = "lab_type";
                            } else {
                                $lecture_or_lab = "lecture_type";
                            }
                        } 
                      }
                    ?>
                    table += `
                        </table>
                        <div class="row">
                            <a href="print_schedule_statement.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
                        </div>
                    `;
                break;
            case 'semester_postponing':
                table = `
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">Stundet Name</p>
                            <p><?php echo $data['s_name']; ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Stundet ID</p>
                            <p><?php echo $data['student_id']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">SSN</p>
                            <p><?php echo $data['national_id']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student_id box">
                            <p class="box-title">Academic Status</p>
                            <p><?php echo ($data['status'] == '1' ? 'Active' : 'Not active'); ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Level</p>
                            <p><?php echo $data['level']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Degree</p>
                            <p><?php echo $data['degree']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">College</p>
                            <p><?php echo ucwords($faculty['name']); ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Major</p>
                            <p><?php echo $data['major']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Branch</p>
                            <p><?php echo $faculty['branch']; ?></p>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                <a href="print_duration_statement.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
                </div>
                `;
                break;
            case 'semester_excuse':
                table = `
                <div class="row">
                        <div class="student box">
                            <p class="box-title">Stundet Name</p>
                            <p><?php echo $data['s_name']; ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Stundet ID</p>
                            <p><?php echo $data['student_id']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">SSN</p>
                            <p><?php echo $data['national_id']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student_id box">
                            <p class="box-title">Academic Status</p>
                            <p><?php echo ($data['status'] == '1' ? 'Active' : 'Not active'); ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Level</p>
                            <p><?php echo $data['level']; ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Degree</p>
                            <p><?php echo $data['degree']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="student box">
                            <p class="box-title">College</p>
                            <p><?php echo ucwords($faculty['name']); ?></p>
                        </div>
                        <div class="student_id box">
                            <p class="box-title">Major</p>
                            <p><?php echo ucwords($data['major']); ?></p>
                        </div>
                        <div class="SSN box">
                            <p class="box-title">Branch</p>
                            <p><?php echo ucwords($faculty['branch']); ?></p>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                <a href="print_definition_statement.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>
                </div>
               `;
                break;
        }
        document.getElementById('service').innerHTML = `
            <div class="student_data" style='margin-top: 17em !important; margin-left: 20vw !important'>
                <p class="super-box-title">${select.options[select.selectedIndex].text}</p>
                <div class="row">
                    <div class="box">
                        <p>
                            ${table}
                        </p>
                    </div>
                </div>
            </div>
        `;
    }
</script>