<?php
define("FIVE_MIGA_BYTES", 5242880);

require_once('connection.php');
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

function store_file($file, $course)
{
    global $exam_con, $student_id;
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    $allowed = array('jpg', 'pdf', 'png', 'jpeg', 'doc');
    $std_id = $student_id['id'];

    if (in_array($file_ext, $allowed)) {
        if ($file_error === 0) {
            if ($file_size <= FIVE_MIGA_BYTES) {
                $file_name_new = uniqid('', true) . '.' . $file_ext;
                $upload_dir = '../uploads/examination/' . $student_id['id'];
                $file_destination = $upload_dir . '/' . $file_name_new;
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $insert_file = "INSERT INTO `exam_postpone` (course, file_name, student_id) VALUES ('$course', '$file_name_new', '$std_id')";  
                    if (mysqli_query($exam_con, $insert_file)) {
                        echo <<< _END
                                <div class="alert success">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p>File Uploaded Successfully!</p>
                                </div>
                            _END;
                        // header('Refresh: 2');
                    } else {
                        $err = mysqli_error($exam_con);
                        echo <<< _END
                                <div class="alert error">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p>Something Went Wrong in the database: {$err}</p>
                                </div>
                            _END;
                    }
                }
            } else {
                // if file too large
                echo <<< _END
                        <div class="alert error">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <p>File is too large!</p>
                        </div>
                    _END;
            }
        }
    }
}
?>

<html>

<head>
    <title>SIS | Exam Postpone</title>
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

    <div class="student_data">
        <p class="super-box-title">Exam Postpone</p>


        <div class="row">

        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Course</th>
                    <th>Upload excuse</th>
                    <th>Submit</th>
                </tr>
                <tr>
                    <td>
                        <select name="course" required>
                            <option value="" selected hidden disabled>-- Choose a reason --</option>
                            <?php
                                $courses_result = mysqli_query($con, $get_all_student_courses);
                            
                                while( $courses= mysqli_fetch_assoc($courses_result)){
                                    echo <<<_END
                                        <option value="{$courses['course_name']}">{$courses['course_name']}</option>
                                    _END;
                                }
                                
                            ?>
                        </select>
                    </td>
                    <td>
                        <input name="file" type="file"  accept='image/*' required />
                    </td>
                    <td>
                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                    </td>
                </tr>
            </table>
        </form>

        </div>




    </div>


    <div id="service"></div>



</body>

</html>

<?php
// show requedted file
$get_requested = "SELECT * FROM `exam_postpone` WHERE student_id = {$student_id['id']} LIMIT 1";
$requested_result = mysqli_query($exam_con, $get_requested);
if(mysqli_num_rows($requested_result) > 0){
    echo '<div class="request_data">
        <p  class="super-box-title">Submitted request summary</p>';
    while( $requested= mysqli_fetch_assoc($requested_result)){
        echo <<<_END
            <div class="row">
                <div class="student box">
                    <p class="box-title">Course</p>
                    <p>{$requested['course']}</p>
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
    $file = $_FILES['file'];
    $course = $_POST['course'];
    store_file($file, $course);
}

?>