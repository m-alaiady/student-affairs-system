<?php
require_once('connection.php');
include("template/t1.php");

$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";
$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";
$get_id_result = mysqli_query($con, $get_id);
$student_id = mysqli_fetch_assoc($get_id_result);
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
    <title>SIS | Complaints</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data_print_btn {
            all: unset;
            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.25em 1em;
            border: none;
            cursor: pointer;
            color: white;
        }
        .request_data{
            position: absolute;
            margin-left:525px;
            margin-top:30em !important;
            background: white;
            border-radius: 10px;
            opacity: .85;
        }
    </style>
</head>
<body>
    <form method="post">
        <div class="student_data">
            <p class="super-box-title">Complaints</p>
            <div class="row">
                <table>
                    <tr>
                        <th>Details</th>
                        <th>Submit</th>
                    </tr>
                    <tr>
                        <td>
                            <textarea name="details" cols='50' rows='2' style='resize:none' placeholder="Write more details .. " required></textarea>
                        </td>
                        <td><button name="submit" type="submit" class="student_data_print_btn" style="text-decoration: none;"> Submit </button></td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <div id="service"></div>
</body>
</html>
<?php
// show requedted file
$get_requested = "SELECT * FROM `complaints` WHERE student_id = {$student_id['id']}";
$requested_result = mysqli_query($con, $get_requested);
if(mysqli_num_rows($requested_result) > 0){
    echo '<div class="request_data">
        <p  class="super-box-title">Submitted request summary</p>';
    while( $requested= mysqli_fetch_assoc($requested_result)){
        echo <<<_END
            <div class="row">
                <div class="student box">
                    <p class="box-title">Details</p>
                    <p>{$requested['details']}</p>
                </div>
                <div class="student_id box">
                    <p class="box-title">Status</p>
                    <p>{$requested['status']}</p>
                </div>
                <div class="SSN box">
                    <p class="box-title">Feedback</p>
                    <p>{$requested['feedback']}</p>
                </div>
            </div>
        _END;
    }
    echo "</div>";
}

if(isset($_POST['submit'])){
    $details = $_POST['details'];
    $std_id = $student_id['id'];

    $insert = "INSERT INTO `complaints` (details, student_id) VALUES ('$details', '$std_id')";  
    if (mysqli_query($con, $insert)) {
        echo <<< _END
                <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>File Uploaded Successfully!</p>
                </div>
            _END;
        // header('Refresh: 2');
    } else {
        $err = mysqli_error($con);
        echo <<< _END
                <div class="alert error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>Something Went Wrong in the database: {$err}</p>
                </div>
            _END;
    }
}

?>