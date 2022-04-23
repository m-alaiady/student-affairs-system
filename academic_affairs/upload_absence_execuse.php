<?php
define("FIVE_MIGA_BYTES" , 5242880);
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
$field_name = "";

function store_file($file, $course_id, $uploaded_file_result){
    global $con, $student_id, $uploaded_file_result;
    $file_name = $file['name']['file'];
    $file_tmp = $file['tmp_name']['file'];
    $file_size = $file['size']['file'];
    $file_error = $file['error']['file'];
    // echo $file_name; die;
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    $allowed = array('jpg', 'pdf', 'png', 'jpeg', 'doc');
    $std_id = $student_id['id'];

    if(mysqli_num_rows($uploaded_file_result) == 0){
        if(in_array($file_ext, $allowed)){
            if($file_error === 0){
                if($file_size <= FIVE_MIGA_BYTES){
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $upload_dir = '../uploads/absences/' . $student_id['id'] ;
                    $file_destination = $upload_dir. '/' . $file_name_new;

                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    if(move_uploaded_file($file_tmp, $file_destination)){
                        $insert_file = "INSERT INTO `absence_excuses` (file_name, student_id, course_id) VALUES ('$file_name_new', '$std_id', '$course_id')";
                        if(mysqli_query($con,$insert_file)){
                            // echo <<< _END
                            //     <div class="alert success">
                            //         <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            //         <p>File Uploaded Successfully!</p>
                            //     </div>
                            // _END;
                            // header('Refresh: 2');
                            return 1;
                        }
                        else{
                            $err = mysqli_error($con);
                            // echo <<< _END
                            //     <div class="alert error">
                            //         <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            //         <p>Something Went Wrong in the database: {$err}</p>
                            //     </div>
                            // _END;
                            return 0;
                        }
                    }
                }
                // else{
                //     // if file too large
                //     echo <<< _END
                //         <div class="alert error">
                //             <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                //             <p>File is too large!</p>
                //         </div>
                //     _END;
                // }
            }
        }
    }
    // else{
    //     echo <<< _END
    //         <div class="alert error">
    //             <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
    //             <p>File already uploaded!</p>
    //         </div>
    //     _END;
    // }

}
?>

<html>

<head>
    <title>SIS | Academic Affairs</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />
    <style>
        .alert{
            position: absolute;
            top: 7em;
            left: 19em;
            padding: 20px;
            color: white;
            width: 50%;
            transform: scale(0.75);
        }
        .delete input[type='submit']{
            border: none;
            background: crimson;
            color: #fff;
            padding: 0.5em 1em;
            cursor: pointer;
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
        .student_data{
                position: absolute;
                margin-left:28vw;
                margin-top:170px;
                background: white;
                border-radius: 10px;
                opacity: .85;
                /* transform: translate(35%, 50%); */
                /* padding: 20px;  */
                transform: scale(0.87);
            }
            .row{
                all: unset;
                display: flex;
                padding: 0 2em;
                /* justify-content: ; */
                flex-direction: row;      
                align-items: stretch; 
            }
        .student_data_print_btn{
            all: unset;
            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.025em 1em;
            border: none;
            cursor: pointer;
            color: white;
            margin: 0.25em;
        }
        .request_data{
            all: unset;
            position: absolute;
            margin-left:28vw;
            margin-top:34em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            transform: scale(0.80);
        }
    </style>
</head>


<body>


            <?php
                $courses = array();
                $student_courses_result = mysqli_query($con, $get_all_student_courses);
                if(mysqli_num_rows($student_courses_result) > 0){
                    echo <<< _END
                        <div class="student_data">
                            <p class="super-box-title">Student Absences</p>
                            <table class="table">
                            <tr>
                                <th>Course Code</th>
                                <th>Student's Absences</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                     _END;
                    $count_absences = 0;
                    while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
                        $get_uploaded_file = "SELECT * FROM absence_excuses WHERE student_id = '" . $student_id['id'] ."' AND course_id = '" . $courses_data['course_id'] ."' LIMIT 1"; 
                        $uploaded_file_result = mysqli_query($con, $get_uploaded_file);
                        $uploaded_file = mysqli_fetch_assoc($uploaded_file_result);

                        // if($courses_data['absences'] > 0){
                            array_push($courses, $courses_data['course_id']);
                            $count_absences++;
                            $field_name = $courses_data['course_id'] . "_excuse_file";
                            echo <<< _END
                                    <tr>
                                        <form method="post" enctype="multipart/form-data">
                                            <td>
                                                {$courses_data['course_id']}
                                            </td>
                                            <td>
                                                {$courses_data['absences']} hrs
                                            </td>
                            _END;
                            if(mysqli_num_rows($uploaded_file_result) > 0){
                                echo <<< _END
                                            <td>
                                                {$uploaded_file['file_name']}
                                            </td>
                                            <td>
                                                Processing ..
                                            </td>
                                        </form>
                                    </tr>
                                _END;
                            }
                            else{
                                echo <<< _END
                                            <td>
                                                <input name="{$courses_data['course_id']}[file]" type="file" accept='image/*, .doc, .pdf' required />
                                            </td>
                                            <td>
                                                <input type="submit" name="{$courses_data['course_id']}[submit]" class="student_data_print_btn" value="Upload Excuse">
                                                <input type="hidden" name="{$courses_data['course_id']}[course_id]" value="{$courses_data['course_id']}">
                                            </td>
                                        </form>
                                    </tr>
                            _END;
                            }
                            // echo "</form>";
                        // }
                    }
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
                else{
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
                        ">
                        <p class="super-box-title">Student Absences</p>
                            <div class="row">
                                <div class="student box">
                                <p style="color: crimson">No courses registered</p>
                                </div>
                            </div>
                     _END;
                }
            echo "</div>";

            ?>



</table>
                               
<?php
// show requedted file
$get_requested = "SELECT * FROM `absence_excuses` WHERE student_id = {$student_id['id']}";
$requested_result = mysqli_query($con, $get_requested);
if(mysqli_num_rows($requested_result) > 0){
    echo <<< _END
    </div>
        <div class="request_data">
            <p class="super-box-title">Submitted request summary</p>'
            <table class="table">
            <tr>
                <th>Course Code</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
    _END;
    while( $requested= mysqli_fetch_assoc($requested_result)){
        echo <<<_END
            <tr>
                <td>
                    {$requested['course_id']}
                </td>
                <td>
                    {$requested['request_date']} 
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

?>
</body>

</html>
<?php

foreach ($courses as $course) {
    if(isset($_POST[$course])){
        $form = $_POST[$course];
        $file = $_FILES[$course];

        $course_id = $form['course_id'];

        $get_uploaded_file = "SELECT * FROM absence_excuses WHERE student_id = '" . $student_id['id'] ."' AND course_id = '" . $courses_data['course_id'] ."' LIMIT 1"; 
        $uploaded_file_result = mysqli_query($con, $get_uploaded_file);

        // print_r($file['name']['file']);
        $flag = store_file($file, $course_id, $uploaded_file_result);
        if($flag){
            echo <<< _END
                    </div>
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>File Uploaded Successfully!</p>
                    </div>
                _END;
            header('Refresh: 2');
        }
        else{
            echo <<< _END
                    </div>
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Something Went Wrong in the database: {$err}</p>
                    </div>
                _END;
        }
    }
}

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $query = "DELETE FROM `absence_excuses` WHERE id = $id";
    $delete_result = mysqli_query($con, $query);
    if(mysqli_affected_rows($con)){
        echo <<< _END
            </div>
            <div class="alert success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>File Deleted Successfully!</p>
            </div>
        _END;
    }else{
        echo <<< _END
            </div>
            <div class="alert error">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>Unable to delete file!</p>
            </div>
        _END;
    }
    echo '<meta http-equiv="refresh" content="2">';
}

?>
