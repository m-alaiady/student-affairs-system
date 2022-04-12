<?php
require_once('../connection.php');
require_once('connection.php');
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
    <title>SIS | Exam In Other Branch/Center</title>
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
            margin-top:33em !important;
            background: white;
            border-radius: 10px;
            opacity: .85;
        }
    </style>
</head>


<body>

<div class="student_data">
    <p class="super-box-title">Exam In Other Branch/Center</p>

    <div class="row">

        <div class="box">
                <table>
                    <tr>
                        <th>Course</th>
                        <th>Branch</th>
                        <th>Center</th>
                        <th>Submit</th>
                    </tr>
                    <?php
                        $courses_result = mysqli_query($con, $get_all_student_courses);
                        $counter = 1;
                        while( $courses= mysqli_fetch_assoc($courses_result)){
                            echo <<<_END
                                    <tr>
                                        <form method="post">
                                            <td>{$courses['course_name']}</td>
                                            <input type="hidden" name="course_name" value="{$courses['course_name']}">
                                            <td>
                                                <select name="country" id="branchList" onchange="get_centers(this, {$counter});" required>
                                                    <option value="" selected disabled hidden >-- Select branch --</option>
                                                    <option value="saudi_arabia">Saudi Arabia</option>
                                                    <option value="kuwait">Kuwait</option>
                                                    <option value="egypt">Egypt</option>
                                                    <option value="sudan">Sudan</option>
                                                    <option value="palestine">Palestine</option>
                                                    <option value="oman">Oman</option>
                                                    <option value="bahrain">Bahrain</option>
                                                    <option value="jordan">Jordan</option>
                                                    <option value="lebanon">Lebanon</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="city" id="facultiesResult{$counter}" required>
                                                    <option selected disabled hidden >-- Select Branch First --</option>
                                                </select>
                                            </td>
                                            <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                            <input type="hidden" name="service_type" value="center_transfer">
                                        </form>
                                    </tr>
                            _END;
                            $counter++;
                        }
                                
                        ?>
                  
                </table>
        </div>
    </div>
</div>






    <div id="service"></div>



</body>

</html>

<script>
     function get_centers(select, counter) {
        let options = "";

        switch (select.options[select.selectedIndex].value) {
            case 'saudi_arabia':
                options = `
                    <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="riyadh">Riyadh</option>
                    <option value="jeddah">Jeddah</option>
                    <option value="dammam">Dammam</option>
                    <option value="hail">Hail</option>    
                    <option value="hassa">Hassa</option>   
                    <option value="madina">Madina</option>   
                `;
                break;
            case 'kuwait':
                options = `
                    <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="kuwait">Kuwait</option>    
                `;
                break;
            case 'egypt':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="egypt">Egypt</option>  
                `;
                break;
            case 'sudan':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="sudan">Sudan</option>  
                `;
                break;
            case 'palestine':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="palestine">Palestine</option>  
                `;
                break;
            case 'oman':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="oman">Oman</option>  
                `;
                break;
            case 'bahrain':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="bahrain">Bahrain</option>  
                `;
                break;
            case 'jordan':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="jordan">Jordan</option>  
                `;
                break;
            case 'lebanon':
                options = `
                <option value="" selected disabled hidden >-- Select Center --</option>
                    <option value="lebanon">Lebanon</option>  
                `;
                break;
        }
        // document.write(options)
        document.getElementById('facultiesResult'+counter).innerHTML = options;

    }
</script>

<?php
if (isset($_POST['submit'])) {
    $stid = $student_id["id"];
    $course = $_POST['course_name'];
    $branch = $_POST['country'];
    $center = $_POST['city'];

    echo $center;

    $insert = "INSERT INTO `change_exam_location` (student_id, course, branch, center) VALUES ('$stid', '$course', '$branch', '$center')";
    $result = mysqli_query($exam_con, $insert);
    if (mysqli_affected_rows($exam_con) > -1) {
        echo <<< _END
            <div class="alert success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>Data submitted Successfully!</p>
            </div>
        _END;
    } else {
        $err =  mysqli_error($exam_con);
        echo <<< _END
            <div class="alert error">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>We could not save the data<br />Error message: {$err}</p>
            </div>
        _END;
    }
  
}

// show requedted file
$get_requested = "SELECT * FROM `change_exam_location` WHERE student_id = {$student_id['id']}";
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