<?php
require_once('../connection.php');
include("../template/t1.php");
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
    <title>SIS | Payment Support</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
 .student_data{
            all: unset;
            position: absolute;
            margin-left:22vw;
            margin-top:10em;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            transform: scale(0.75);
        }
        textarea{
            border: 1px solid black;
        }
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
            margin-left:19em;
            margin-top:25em !important;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(0.75);
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
            top: 7em;
            left: 21em;
            padding: 20px;
            color: white;
            width: 50%;
            transform: scale(0.75);
        }
        .logo, .foot{
            z-index: 999;
        }
        .request_data::after{
            content: "";
            padding: 5em;
        }
        .foot{
            position: fixed;
        }
    </style>
</head>
<body>
    <form method="post">
        <div class="student_data">
            <p class="super-box-title">Payment Support</p>
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
$get_requested = "SELECT * FROM `payment_support` WHERE student_id = {$student_id['id']}";
$requested_result = mysqli_query($con, $get_requested);
if(mysqli_num_rows($requested_result) > 0){
    echo <<< _END
        <div class="request_data">
        <p  class="super-box-title">Submitted request summary</p>
            <table class="table">
            <tr>
                <th style='max-width: 20em; overflow-wrap:break-word'>Course</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Action</th>
            </tr>
    _END;
    while( $requested= mysqli_fetch_assoc($requested_result)){
        $requested['feedback'] = $requested['feedback'] ? $requested['feedback'] : 'No feedback'; 
        echo <<<_END
            <tr>
                <td style="max-width: 20em; overflow-wrap:break-word">
                    {$requested['details']}
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
    $details = $_POST['details'];
    $std_id = $student_id['id'];

    $insert = "INSERT INTO `payment_support` (details, student_id) VALUES ('$details', '$std_id')";  
    if (mysqli_query($con, $insert)) {
        echo <<< _END
                <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>File Uploaded Successfully!</p>
                   <meta http-equiv="refresh" content="2">
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

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $query = "DELETE FROM `payment_support` WHERE id = $id";
    $delete_result = mysqli_query($con, $query);
    if(mysqli_affected_rows($con)){
        echo <<< _END
        </div>
        <div class="alert success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <p>File Deleted Successfully!</p>
            <meta http-equiv="refresh" content="2">
        </div>
    _END;
    }else{
        echo <<< _END
        </div>
        <div class="alert error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <p>Unable to delete the file!</p>
        </div>
        _END;
    }
    echo '<meta http-equiv="refresh" content="2">';
}
?>