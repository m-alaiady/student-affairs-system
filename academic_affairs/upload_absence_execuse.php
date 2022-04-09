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

$get_uploaded_file = "SELECT * FROM absence_excuses WHERE student_id = '" . $student_id['id'] ."' LIMIT 1"; 
$uploaded_file_result = mysqli_query($con, $get_uploaded_file);



$faculty_data=mysqli_query($con,$sql);
$faculty= mysqli_fetch_assoc($faculty_data);
$field_name = "";
?>

<html>

<head>
    <title>SIS | Academic Affairs</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />
    <style>
        .alert{
            margin-top: -12em !important;
            margin-left: -25em !important;
        }
        .student_data_print_btn{
            margin-top: 5em !important;
            margin-left: 0em !important;
        }
    </style>
</head>


<body>
<form method="post" enctype="multipart/form-data">

<div class="student_data">
     <p class="super-box-title">Student Absences</p>
            <?php
                $student_courses_result = mysqli_query($con, $get_all_student_courses);

                while( $courses_data= mysqli_fetch_assoc($student_courses_result)){
                    if($courses_data['absences'] > 0){
                        $field_name = $courses_data['course_id'] . "_excuse_file";
                        echo <<< _END
                            <div class="row">
                                <div class="box">
                                    <p class="box-title">Course Code</p>
                                    <p>{$courses_data['course_id']}</p>
                                </div>
                                <div class="box">
                                    <p class="box-title">Student's Absences</p>
                                    <p>{$courses_data['absences']}</p>
                                </div>
                          
                        _END;
                        if(mysqli_num_rows($uploaded_file_result) > 0){
                            echo <<< _END
                                <div class="box">
                                    <p class="box-title">Action</p>
                                    <p>Processing .. </p>
                                </div>
                            _END;
                        }
                        else{
                            echo <<< _END
                                <div class="box">
                                    <p class="box-title">Action</p>
                                    <p><input name="{$field_name}" type='file' accept='image/*, .doc, .pdf' required /></p>
                                </div>
                                </div>
                                <input type="submit" name="submit" class="student_data_print_btn" value="Upload Excuse"> 
                            _END;
                        }
                    }
                }

            ?>



</form>
                               

</body>

</html>
<?php
if(isset($_POST['submit'])){
    $file = $_FILES[$field_name];


    function store_file($file){
        global $con, $student_id, $uploaded_file_result;
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

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
                            $insert_file = "INSERT INTO `absence_excuses` (file_name, student_id) VALUES ('$file_name_new', '$std_id')";
                            if(mysqli_query($con,$insert_file)){
                                echo <<< _END
                                    <div class="alert success">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p>File Uploaded Successfully!</p>
                                    </div>
                                _END;
                                header('Refresh: 2');
                            }
                            else{
                                $err = mysqli_error($con);
                                echo <<< _END
                                    <div class="alert error">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p>Something Went Wrong in the database: {$err}</p>
                                    </div>
                                _END;
                            }
                        }
                    }
                    else{
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
        else{
            echo <<< _END
                <div class="alert error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>File already uploaded!</p>
                </div>
            _END;
        }

    }
    store_file($file);
}

?>
