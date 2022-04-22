<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once('../connection.php');

if (!isset($_SESSION['student_id'])) {
    header("location:../index.php");
}



$query = "select * from students where student_id='" . $_SESSION['student_id'] . "' ";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);

$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";

$faculty_data = mysqli_query($con, $sql);
$faculty = mysqli_fetch_assoc($faculty_data);

$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result = mysqli_query($con, $get_id);
$student_id = mysqli_fetch_assoc($get_id_result);


$std_id = $student_id['id'];

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
$registered_hours['SUM(credits)'] = $registered_hours['SUM(credits)'] > 0 ? $registered_hours['SUM(credits)'] : 0;

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

$head = "
    <style>
        table,tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
            border-width: 2px;
        }
        th, td{
            padding: 1.6em;
        }
        .logo{
            margin-top: -60x;
            margin-left: 39%;
            width: 50%;
        }
        .text p{
            font-size: 1.6em;
            font-weight: bold;
            text-align: center;
            margin-bottom: -50px;
            z-index: -5;
        }
    </style>
";

$html = $head;

$html .= "
    <div class='header'>
       
        <div class='logo'>
            <img src='aou-logo.png' alt='logo' width='150'/>
        </div>
        <div class='text'>
        <p>Schedule Statement</p>
    </div>
    <br><br><br><br>
    </div>
    ";
$html .= "<table>";
$html .= "
        <tr>
            <th>Name</th> <td colspan='5'>" . $data['s_name'] . "</td>
        </tr>
        <tr>
            <th>National ID</th> <td colspan='3'>" . $data['national_id'] . "</td>
            <th>Student ID</th> <td colspan='1'>" . $data['student_id'] . "</td>
        </tr>
        <tr>
            <th>College</th> <td colspan='3'>" . ucwords($faculty['name']) . "</td>
            <th>Major</th> <td colspan='1'>" . $data['major'] . "</td>
        </tr>
        
        <tr>
            <th>Academic Status</th> <td colspan='3'>" . ($data['status'] == '1' ? 'Active' : 'Not active') . "</td>
            <th>Branch</th> <td colspan='1'>" . ucwords($faculty['branch']) . "</td>
        </tr>
        <tr>
            <th>Registered Hours</th> <td colspan='5'>" . $registered_hours['SUM(credits)'] . " hrs </td>
        </tr>
";


$html .= "
  </table><br />
  <h4>Course Schedule</h4>
  ";

$student_courses_result = mysqli_query($con, $get_all_student_courses);
if (mysqli_num_rows($student_courses_result) > 0) {
    $html .= "
    <br />
    <table>
        <tr>
        
            <th>Course Code</th>
            
            <th>Time</th>
            <th>Room</th>
            <th>Day</th>
            <th>Lecture Type</th>
        </tr>";

    $counter = 0;
    while ($courses_data = mysqli_fetch_assoc($student_courses_result)) {
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
            $counter++;
            $time_oo = strtotime($time);
            $time_format = date('H:i', strtotime($time));
            $time_format = $time_format . " - " . date('H:i', strtotime('+50 minutes', $time_oo));

            $html .= "
            <tr>
               
                <td>{$courses_data['course_id']}</td>
                
                <td style='width: 22%'>{$time_format}</td>
                <td>{$room}</td>
                <td>$days[$index]</td>
                <td>{$courses_data[$lecture_or_lab]}</td>
            </tr>
        ";
            if ($lecture_or_lab == "lecture_type") {
                $lecture_or_lab = "lab_type";
            } else {
                $lecture_or_lab = "lecture_type";
            }
        }

        // print_r($times);

    }
    $html .= "
    </table> 
";
}
else{
    $html .= "<p style='color: crimson'>No courses registered</p>";
}

// echo $html;

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
