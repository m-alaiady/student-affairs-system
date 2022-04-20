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


?>

<html>

<head>
    <title>SIS | Exam Objection</title>
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
        .student_data{
            all: unset;
            position: absolute;
            margin-left:23vw;
            margin-top:10em;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            max-width: 70%;
        }
        .request_data{
            all: unset;
            position: absolute;
            margin-left:23vw;
            margin-top:27em;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            /* transform: scale(0.85); */
        }
        .delete{
            margin-top: 1.025em;
            
            /* transform: scale(1.25); */
        }
        .delete input[type='submit']{
            border: none;
            background: crimson;
            color: #fff;
            padding: 0.5em 1em;
            cursor: pointer;
        }
        .alert {
            position: absolute;
            top: 6em;
            left: 19em;
            padding: 20px;
            color: white;
            width: 50%;
            transform: scale(0.75);
        }
        .foot{
            position: fixed;
            opacity: 1;
        }
        .request_data::after{
            content: " ";
            white-space: pre;
            padding: 5em;
        }
        .logo, .foot{
            z-index: 999;
        }
    </style>
</head>


<body>

    <div class="student_data">
        <p class="super-box-title">Exam Objection</p>


        <div class="row">

        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Course</th>
                    <th>Details</th>
                    <th>Submit</th>
                </tr>
                <tr>
                    <td>
                        <select name="course" required>
                            <option value="" selected hidden disabled>-- Choose a course --</option>
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
                        <textarea name="details" placeholder="write more details .." rows="3" cols="25" style="resize: none" required style="margin-top: 5em;"></textarea>
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
$get_requested = "SELECT * FROM `exam_objection` WHERE student_id = {$student_id['id']}";
$requested_result = mysqli_query($exam_con, $get_requested);
if(mysqli_num_rows($requested_result) > 0){
    echo <<<  _END
        <div class="request_data">
            <p  class="super-box-title">Submitted request summary</p>
            <table class="table">
            <tr>
                <th>Course</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Action</th>
            </tr>
    _END;    
    while( $requested= mysqli_fetch_assoc($requested_result)){
        $requested['feedback'] = $requested['feedback'] ? $requested['feedback'] : 'No feedback'; 
        echo <<<_END
            <tr>
                <td>
                    {$requested['course']}
                </td>
                <td>
                    {$requested['status']} 
                </td>
                <td>
                    {$requested['feedback']} 
                </td>
                <td>
                    <div class="delete">
                        <form method="post">
                            <input type="hidden" name="id" value="{$requested['id']}" />
                            <input type="submit" name="delete" value="Delete" />
                        </form>
                     </div>
                </td>
            </tr>
        _END;
    }
    echo "</table></div>";
}

if(isset($_POST['submit'])){
    $course = $_POST['course'];
    $details = $_POST['details'];
    $std_id = $student_id['id'];

    $insert = "INSERT INTO `exam_objection` (course, details, student_id) VALUES ('$course', '$details', '$std_id')";  
    if (mysqli_query($exam_con, $insert)) {
        echo <<< _END
                </div>
                <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>File Uploaded Successfully!</p>
                </div>
            _END;
    } else {
        $err = mysqli_error($exam_con);
        echo <<< _END
                <div class="alert error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>Unable to upload the file!</p>
                </div>
            _END;
    }
    echo '<meta http-equiv="refresh" content="2">';

}
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $query = "DELETE FROM `exam_objection` WHERE id = $id";
    $delete_result = mysqli_query($exam_con, $query);
    if(mysqli_affected_rows($exam_con)){
        echo <<< _END
            </div>
            <div class="alert success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>File Deleted Successfully!</p>
            </div>
        _END;
    }else{
        echo <<< _END
            <div class="alert error">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>Unable to delete the file!</p>
            </div>
        _END;
    }
    echo '<meta http-equiv="refresh" content="2">';
}

?>