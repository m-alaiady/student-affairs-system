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

?>

<html>

<head>
    <title>SIS | Tuition Fees Exemption</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />
    <style>
        .student_data{
            margin-top:10em !important;
        }
        .student_data form{
            padding: 2em;
        }
        .upload-btn{

            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.5em 2em;
            border: none;
            cursor: pointer;
            color: white;
        }
        .request_data{
            position: absolute;
            margin-left:525px;
            margin-top:33em !important;
            background: white;
            border-radius: 10px;
            opacity: .85;
        }
    </style>
</head>


<body>
    <div class="student_data">
     <p class="super-box-title">Tuition Fees Exemption</p>
    
            <form method="post" enctype="multipart/form-data">
                <label for="social_security">Social Security: </label>
                <input name="social_security_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <label for="salary_certifiacte">Salary Certifiacte: </label>
                <input name="salary_certifiacte_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <label for="electricity_bill">Electricity Bill: </label>
                <input name="electricity_bill_file" type="file" accept='image/*, .doc, .pdf' required /><br /><br />

                <label for="account_statement">Account Statement: </label>
                <input name="account_statement_file" type="file" accept='image/*, .doc, .pdf'  required/><br /><br />

                <input name="submit" type="submit" class="upload-btn" value="upload" />
                
            </form>

    </div>

</body>

</html>
<?php

// show requedted file
$get_requested = "SELECT * FROM `tuition_fees_exemption` WHERE student_id = {$student_id['id']} LIMIT 1";
$requested_result = mysqli_query($con, $get_requested);
if(mysqli_num_rows($requested_result) > 0){
    echo '<div class="request_data">
        <p  class="super-box-title">Submitted request summary</p>';
    while( $requested= mysqli_fetch_assoc($requested_result)){
        echo <<<_END
            <div class="row">
                <div class="student box">
                    <p class="box-title">Semester</p>
                    <p>{$requested['semester']}</p>
                </div>
                <div class="student_id box">
                    <p class="box-title">Date</p>
                    <p>{$requested['request_date']}</p>
                </div>
                <div class="SSN box">
                    <p class="box-title">Status</p>
                    <p>{$requested['status']}</p>
                </div>
                <div class="SSN box">
                    <p class="box-title">feedback</p>
                    <p>{$requested['feedback']}</p>
                </div>
            </div>
        _END;
    }
    echo "</div>";
}


?>
<?php
if(isset($_POST['submit'])){
    $social_security_file = $_FILES['social_security_file'];
    $salary_certifiacte_file = $_FILES['salary_certifiacte_file'];
    $electricity_bill_file = $_FILES['electricity_bill_file'];
    $account_statement_file = $_FILES['account_statement_file'];

    function get_season(\DateTime $dateTime){
        $dayOfTheYear = $dateTime->format('z');
        if($dayOfTheYear < 80 || $dayOfTheYear > 356){
            return 'Winter';
        }
        if($dayOfTheYear < 173){
            return 'Spring';
        }
        if($dayOfTheYear < 266){
            return 'Summer';
        }
        return 'Fall';
    }

    function store_file($file){
        global $con, $student_id;
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        $allowed = array('jpg', 'pdf', 'png', 'jpeg', 'doc');
        $std_id = $student_id['id'];

        if(in_array($file_ext, $allowed)){
            if($file_error === 0){
                if($file_size <= FIVE_MIGA_BYTES){
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $upload_dir = '../uploads/' . $student_id['id'] ;
                    $file_destination = $upload_dir. '/' . $file_name_new;

                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    if(move_uploaded_file($file_tmp, $file_destination)){
                        $today = new DateTime();
                        $semester = get_season($today) . ' term ' . (date("y")-1) . '-' . date("y");
                        $insert_file = "INSERT INTO `tuition_fees_exemption` (semester, file_name, student_id) VALUES ('$semester', '$file_name_new', '$std_id')";
                        if(mysqli_query($con,$insert_file)){
                            echo <<< _END
                                <div class="alert success">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p>Files Uploaded Successfully!</p>
                                </div>
                            _END;
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
            }
        }


    }
    store_file($social_security_file);
    store_file($salary_certifiacte_file);
    store_file($electricity_bill_file);
    store_file($account_statement_file);


}
?>

