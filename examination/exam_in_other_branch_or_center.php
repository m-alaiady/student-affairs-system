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
        .student_data{
            all: unset;
            position: absolute;
            margin-left:22vw;
            margin-top:10em;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            transform: scale(0.85);
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

        .request_data {
            all: unset;
            position: absolute;
            margin-left:22vw;
            margin-top:45em;
            background: white;
            border-radius: 10px;
            padding-bottom: 2em;
            opacity: .85;
            transform: scale(0.85);
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

    <div class="student_data">
        <p class="super-box-title">Exam In Other Branch/Center</p>

                    <?php
                    $courses_result = mysqli_query($con, $get_all_student_courses);
                    $counter = 1;
                    if (mysqli_num_rows($courses_result) > 0) {
                        echo <<< _END
                        <div class="row">
                        <div class="box">
                            <table>
                                <tr>
                                    <th>Course</th>
                                    <th>Branch</th>
                                    <th>Center</th>
                                    <th>Submit</th>
                                </tr>
                        _END;
                        while ($courses = mysqli_fetch_assoc($courses_result)) {
                            echo <<<_END
                                    <tr>
                                        <form method="post">
                                            <td>{$courses['course_name']}</td>
                                            <input type="hidden" name="course_name" value="{$courses['course_name']}">
                                            <td style="padding-bottom: 2em">
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
                                            <td style="padding-bottom: 2em">
                                                <select name="city" id="facultiesResult{$counter}" required>
                                                    <option selected disabled hidden >-- Select Branch First --</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                                            </td>
                                            <input type="hidden" name="service_type" value="center_transfer">
                                        </form>
                                    </tr>
                            _END;
                            $counter++;
                        }
                    }else{
                        echo <<< _END
                            <div class="row">
                                <div class="student box">
                                <p style="color: crimson">No courses registered</p>
                                </div>
                                    </div>
                                    </tr>
                                    </table>             
                                </div>
                            </div>
                         _END;
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>






    <div id="service"></div>





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
    echo '<meta http-equiv="refresh" content="2">';
}

// show requedted file
$get_requested = "SELECT * FROM `change_exam_location` WHERE student_id = {$student_id['id']}";
$requested_result = mysqli_query($exam_con, $get_requested);
if (mysqli_num_rows($requested_result) > 0) {
    echo <<< _END
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
    while ($requested = mysqli_fetch_assoc($requested_result)) {
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


if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $query = "DELETE FROM `change_exam_location` WHERE id = $id";
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
        document.getElementById('facultiesResult' + counter).innerHTML = options;

    }
</script>