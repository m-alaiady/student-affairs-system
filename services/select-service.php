<?php
define("FIVE_MIGA_BYTES", 5242880);
ob_start();
require_once('connection.php');
require_once('../connection.php');
include("../template/t1.php");

if (!isset($_SESSION['student_id'])) {
    header("location:../index.php");
}


$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result = mysqli_query($con, $get_id);
$student_id = mysqli_fetch_assoc($get_id_result);

function get_season(\DateTime $dateTime)
{
    $dayOfTheYear = $dateTime->format('z');
    if ($dayOfTheYear < 80 || $dayOfTheYear > 356) {
        return 'Winter';
    }
    if ($dayOfTheYear < 173) {
        return 'Spring';
    }
    if ($dayOfTheYear < 266) {
        return 'Summer';
    }
    return 'Fall';
}

function store_file($file, $table_name, $folder, array $extra_columns = null)
{
    global $services_con, $student_id;
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
                $upload_dir = '../uploads/services/' . $folder . '/' . $student_id['id'];
                $file_destination = $upload_dir . '/' . $file_name_new;
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    if($extra_columns){
                        $insert_file = "INSERT INTO `$table_name` (file_name, student_id";
                        foreach ($extra_columns as $key => $value) {
                            $insert_file .= ",{$key}";
                        }
                        $insert_file .= ") VALUES ('$file_name_new', '$std_id'";
                        foreach ($extra_columns as $key => $value) {
                            $insert_file .= ",'{$value}'";
                        }
                        $insert_file .= ")";
                    }
                    else{
                        $insert_file = "INSERT INTO `$table_name` (file_name, student_id) VALUES ('$file_name_new', '$std_id')";
                    }
                    if (mysqli_query($services_con, $insert_file)) {
                        echo <<< _END
                                <div class="alert success">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p>File Uploaded Successfully!</p>
                                </div>
                            _END;
                        // header('Refresh: 2');
                    } else {
                        $err = mysqli_error($services_con);
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

$today = new DateTime();
$semester = get_season($today) . ' term ' . (date("y") - 1) . '-' . date("y");


?>

<html>

<head>
    <title>SIS | Services</title>
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
        select{
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
            margin-left:17em;
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
            left: 17.5em;
            padding: 20px;
            color: white;
            width: 50%;
            transform: scale(0.75);
        }
    </style>
</head>


<body>
    <form method="post" enctype="multipart/form-data">

        <div class="student_data">
            <p class="super-box-title">Services</p>

            <div class="row">

                <div class="box">
                    <p class="box-title">Select a service: </p>
                    <p>
                        <select id="servicesList" onchange="services('<?php echo $semester ?>');">
                            <option selected disabled hidden>-- Select Service --</option>
                            <option value="change_track">Change Track</option>
                            <option value="center_transfer">Branch - center transfer</option>
                            <option value="semester_postponing">Semester Postponing</option>
                            <option value="semester_excuse">Semester Excuse</option>
                            <option value="english_equalize">English Equalize</option>
                            <option value="courses_equalize">Courses Equalize</option>
                            <option value="withdraw_from_university">Withdraw from University</option>
                            <option value="social_reward">Social Reward</option>
                            <option value="aid_request">Aid Request</option>
                            <option value="id_reissuing">ID reussuing</option>
                        </select>
                    </p>
                </div>

            </div>


        </div>
    </form>

    <div id="service"></div>



</body>

</html>
<script>
    function services(semester) {
        let select = document.getElementById('servicesList');
        let table = "";

        switch (select.options[select.selectedIndex].value) {
            case 'change_track':
                table = `
                    <form method="post">
                        <table>
                            <tr>
                                <th>Faculty</th>
                                <th>Track</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="faculty" id="facultiesList" onchange="get_tracks(this);" required>
                                        <option value="" selected disabled hidden >-- Select Faculty --</option>
                                        <option value="business_studies">Business studies</option>
                                        <option value="computer_studies">Computer studies</option>
                                        <option value="language_studies">Language studies</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="major" id="facultiesResult" required>
                                        <option value="" selected disabled hidden >-- Choose faculty first --</option>
                                    </select>
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                <input type="hidden" name="service_type" value="change_track">
                            </tr>
                        </table>
                    </form>
                `;
                break;
            case 'center_transfer':
                table = `
                    <form method="post">
                        <table>
                            <tr>
                                <th>Branch</th>
                                <th>Center</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="country" id="branchList" onchange="get_centers();" required>
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
                                    <select name="city" id="facultiesResult" required>
                                        <option selected disabled hidden >-- Select Branch First --</option>
                                    </select>
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                <input type="hidden" name="service_type" value="center_transfer">
                            </tr>
                        </table>
                    </form>
                    `;
                break;
            case 'semester_postponing':
                table = `
                    <form method="post">
                        <table>
                            <tr>
                                <th>Semester</th>
                                <th>Confirmation</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>${semester}</td>
                                <td>
                                    <input name="semester_postponing_checkbox" type='checkbox' required />
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                <input type="hidden" name="service_type" value="semester_postponing">
                            </tr>
                        </table>
                    </form>
                `;
                break;
            case 'semester_excuse':
                table = `
                    <form method="post">
                        <table>
                            <tr>
                                <th>Semester</th>
                                <th>Confirmation</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>${semester}</td>
                                <td>
                                    <input name="semester_excuse_checkbox" type='checkbox' required />
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                <input type="hidden" name="service_type" value="semester_excuse">
                            </tr>
                        </table>
                    </form>
                `;
                break;

            case 'english_equalize':
                table = `
                    <form method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <th>English Certificate</th>
                                <th>Submit</th>
                            </tr>
                                <tr>
                                    <td>
                                        <input name="file" type="file"  accept='image/*, .doc, .pdf' required />
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                                        <input type="hidden" name="service_type" value="english_equalize">
                                    </td>
                                </tr>
                        </table>
                    </form>

                `;
                break;

            case 'courses_equalize':
                table = `
                    <form method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <th>Courses Certificate</th>
                                <th>Submit</th>
                            </tr>
                                <tr>
                                    <td>
                                        <input name="file" type="file"  accept='image/*, .doc, .pdf' required />
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                                        <input type="hidden" name="service_type" value="courses_equalize">
                                    </td>
                                </tr>
                        </table>
                    </form>

                `;
                break;

            case 'withdraw_from_university':
                table = `
                        <form method="post">
                            <table>
                                <tr>
                                    <th>Semester</th>
                                    <th>Confirmation</th>
                                    <th>Submit</th>
                                </tr>
                                <tr>
                                    <td>2022-02-25</td>
                                    <td>
                                        <input name="withdraw_from_university_checkbox" type='checkbox' required />
                                    </td>
                                    <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                    <input type="hidden" name="service_type" value="withdraw_from_university">
                                </tr>
                            </table>
                        </form>
                `;
                break;

            case 'social_reward':
                table = `
                        <form method="post">
                            <table>
                                <tr>
                                    <th>Semester</th>
                                    <th>Details</th>
                                    <th>Submit</th>
                                </tr>
                                <tr>
                                    <td>2022-02-25</td>
                                    <td>
                                        <textarea name="details" style="resize: none;" placeholder="Explain .. " required ></textarea>
                                    </td>
                                    <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                    <input type="hidden" name="service_type" value="social_reward">
                                </tr>
                            </table>
                        </form>
                `;
                break;

            case 'aid_request':
                table = `
                        <form method="post">
                            <table>
                                <tr>
                                    <th>Semester</th>
                                    <th>Details</th>
                                    <th>Submit</th>
                                </tr>
                                <tr>
                                    <td>2022-02-25</td>
                                    <td>
                                        <textarea name="details" style="resize: none;" placeholder="Explain .. " required></textarea>
                                    </td>
                                    <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                                    <input type="hidden" name="service_type" value="aid_request">
                                </tr>
                            </table>
                        </form>
                `;
                break;

            case 'id_reissuing':
                table = `
                        <form method="post" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <th>Reason</th>
                                    <th>Picture</th>
                                    <th>Submit</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="reason" required>
                                            <option value="" selected hidden disabled>-- Choose a reason --</option>
                                            <option value="lost">Lost</option>
                                            <option value="defective">Defective</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input name="file" type="file"  accept='image/*' required />
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                                        <input type="hidden" name="service_type" value="id_reissuing">
                                    </td>
                                </tr>
                            </table>
                        </form>
                `;
                break;
        }
        document.getElementById('service').innerHTML = `
            <div class="student_data" style='margin-top: 20em !important; margin-left: 18.5em !important'>
                <p class="super-box-title">${select.options[select.selectedIndex].text}</p>
                
                <div class="row">

                    <div class="box">
                        <p>
                            ${table}
                        </p>
                    </div>

                </div>

            </div>
        `;

    }

    function get_tracks() {
        let select = document.getElementById('facultiesList');
        let options = "";

        switch (select.options[select.selectedIndex].value) {
            case 'business_studies':
                options = `
                    <option value="" selected disabled hidden >-- Select Track --</option>
                    <option value="accounting">Accounting</option>
                    <option value="accounting_in_arabic">Accounting in Arabic</option>
                    <option value="marketing">Marketing</option>
                    <option value="systems">Systems</option>    
                `;
                break;
            case 'computer_studies':
                options = `
                    <option value="" selected disabled hidden >-- Select Track --</option>
                    <option value="computer_science">Computer Science</option>
                    <option value="computing_with_business">Computing with Business</option>
                    <option value="network_and_security">Network and Security</option>
                    <option value="web_development">Web Development</option>    
                `;
                break;
            case 'language_studies':
                options = `
                    <option value="" selected disabled hidden >-- Select Track --</option>
                    <option value="english_language_and_literature">English Language and Literature</option>  
                `;
                break;
        }
        // document.write(options)
        document.getElementById('facultiesResult').innerHTML = options;

    }

    function get_centers() {
        let select = document.getElementById('branchList');
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
        document.getElementById('facultiesResult').innerHTML = options;

    }
</script>

<?php

if (isset($_POST['submit'])) {
    $stid = $student_id["id"];
    $form = $_POST['service_type'];
    switch ($form) {
        case 'change_track':
            $faculty = $_POST['faculty'];
            $major = $_POST['major'];
            $insert = "INSERT INTO `change_track` (student_id, faculty, track) VALUES ('$stid', '$faculty', '$major')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;

        case 'center_transfer':
            $country = $_POST['country'];
            $city = $_POST['city'];
            $insert = "INSERT INTO `change_branch` (student_id, branch, center) VALUES ('$stid', '$country', '$city')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;

        case 'semester_postponing':
            $agree_checkbox = $_POST['semester_postponing_checkbox'];
            $insert = "INSERT INTO `semester_postponing` (student_id, semester, confirmation) VALUES ('$stid', '$semester', '$agree_checkbox')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;

        case 'semester_excuse':
            $agree_checkbox = $_POST['semester_excuse_checkbox'];
            $insert = "INSERT INTO `semester_excuse` (student_id, semester, confirmation) VALUES ('$stid', '$semester', '$agree_checkbox')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;

        case 'english_equalize':
            $file = $_FILES['file'];
            store_file($file, 'english_equalize', 'english_equalize');
            break;
        case 'courses_equalize':
            $file = $_FILES['file'];
            store_file($file, 'courses_equalize', 'courses_equalize');
            break;

        case 'withdraw_from_university':
            $agree_checkbox = $_POST['withdraw_from_university_checkbox'];
            $insert = "INSERT INTO `withdraw_from_university` (student_id, semester, confirmation) VALUES ('$stid', '$semester', '$agree_checkbox')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;
        case 'social_reward':
            $details = $_POST['details'];
            $insert = "INSERT INTO `social_reward` (student_id, semester, details) VALUES ('$stid', '$semester', '$details')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;
        
        case 'aid_request':
            $details = $_POST['details'];
            $insert = "INSERT INTO `aid_request` (student_id, semester, details) VALUES ('$stid', '$semester', '$details')";
            $result = mysqli_query($services_con, $insert);
            if (mysqli_affected_rows($services_con) > -1) {
                echo <<< _END
                    <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Data submitted Successfully!</p>
                    </div>
                _END;
            } else {
                $err =  mysqli_error($services_con);
                echo <<< _END
                    <div class="alert error">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>We could not save the data<br />Error message: {$err}</p>
                    </div>
                _END;
            }
            break;
        case 'id_reissuing':
            $reason = $_POST['reason'];
            $file = $_FILES['file'];
            store_file($file, 'id_reissuing', 'id_reissuing', [ 'reason' => $reason ]);
            break;
            
        default:
            # code...
            break;
    }
}

?>