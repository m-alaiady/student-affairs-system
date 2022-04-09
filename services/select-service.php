<?php
define("FIVE_MIGA_BYTES" , 5242880);
ob_start();
require_once('../connection.php');
include("../template/t1.php");

if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

?>

<html>

<head>
    <title>SIS | Services</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data_print_btn{
            all: unset;
            background-color: dodgerblue;
            border-radius: 10px;
            padding: 0.25em 1em;
            border: none;
            cursor: pointer;
            color: white;
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
                    <select id="servicesList" onchange="change_track();">
                        <option selected disabled hidden >-- Select Service --</option>
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
    function change_track(){
        let select = document.getElementById('servicesList');
        let table = "";

        switch(select.options[select.selectedIndex].value){
            case 'change_track':
                table = `
                    <table>
                        <tr>
                            <th>Faculty</th>
                            <th>Track</th>
                            <th>Submit</th>
                        </tr>
                        <tr>
                            <td>
                                <select id="facultiesList" onchange="get_tracks(this);">
                                    <option selected disabled hidden >-- Select Faculty --</option>
                                    <option value="business_studies">Business studies</option>
                                    <option value="computer_studies">Computer studies</option>
                                    <option value="language_studies">Language studies</option>
                                </select>
                            </td>
                            <td>
                                <select id="facultiesResult">
                                    <option selected disabled hidden >-- Choose faculty first --</option>
                                </select>
                            </td>
                            <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                        </tr>
                    </table>
                `;
                break;
            case 'center_transfer':
                table = `
                    <table>
                        <tr>
                            <th>Branch</th>
                            <th>Center</th>
                            <th>Submit</th>
                        </tr>
                        <tr>
                            <td>
                                <select id="branchList" onchange="get_centers();">
                                    <option selected disabled hidden >-- Select branch --</option>
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
                                <select id="facultiesResult">
                                    <option selected disabled hidden >-- Select Branch First --</option>
                                </select>
                            </td>
                            <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                        </tr>
                    </table>
                `;
                break;
            case 'semester_postponing':
                table = `
                    <table>
                        <tr>
                            <th>Semester</th>
                            <th>Confirmation</th>
                            <th>Submit</th>
                        </tr>
                        <tr>
                            <td>2022-02-25</td>
                            <td>
                                <input type='checkbox' />
                            </td>
                            <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                        </tr>
                    </table>
                `;
                break;
            case 'semester_excuse':
                table = `
                    <table>
                        <tr>
                            <th>Semester</th>
                            <th>Confirmation</th>
                            <th>Submit</th>
                        </tr>
                        <tr>
                            <td>2022-02-25</td>
                            <td>
                                <input type='checkbox' />
                            </td>
                            <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                        </tr>
                    </table>
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
                                        <input type="file"  accept='image/*, .doc, .pdf' required />
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
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
                                        <input type="file"  accept='image/*, .doc, .pdf' required />
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                                    </td>
                                </tr>
                        </table>
                    </form>

                `;
                break;

                case 'withdraw_from_university':
                    table = `
                        <table>
                            <tr>
                                <th>Semester</th>
                                <th>Confirmation</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>2022-02-25</td>
                                <td>
                                    <input type='checkbox' />
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                            </tr>
                        </table>
                `;
                break;

                case 'social_reward':
                    table = `
                        <table>
                            <tr>
                                <th>Semester</th>
                                <th>Details</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>2022-02-25</td>
                                <td>
                                    <textarea style="resize: none;" placeholder="Explain .. "></textarea>
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                            </tr>
                        </table>
                `;
                break;

                case 'aid_request':
                    table = `
                        <table>
                            <tr>
                                <th>Semester</th>
                                <th>Details</th>
                                <th>Submit</th>
                            </tr>
                            <tr>
                                <td>2022-02-25</td>
                                <td>
                                    <textarea style="resize: none;" placeholder="Explain .. "></textarea>
                                </td>
                                <td><input type="submit" name="submit" class="student_data_print_btn" value="Submit"></td>
                            </tr>
                        </table>
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
                                        <select>
                                            <option>Lost</option>
                                            <option>Defective</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="file"  accept='image/*' required />
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" class="student_data_print_btn" value="Submit">
                                    </td>
                                </tr>
                            </table>
                        </form>
                `;
                break;
        }
        document.getElementById('service').innerHTML = `
            <div class="student_data" style='margin-top: 25em !important'>
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
    function get_tracks(){
        let select = document.getElementById('facultiesList');
        let options = "";

        switch(select.options[select.selectedIndex].value){
            case 'business_studies':
                options = `
                    <option selected disabled hidden >-- Select Track --</option>
                    <option value="change_track">Accounting</option>
                    <option value="center_transfer">Accounting in Arabic</option>
                    <option value="semester_postponing">Marketing</option>
                    <option value="semester_excuse">Systems</option>    
                `;
            break;
            case 'computer_studies':
                options = `
                    <option selected disabled hidden >-- Select Track --</option>
                    <option value="change_track">Computer Science</option>
                    <option value="center_transfer">Computing with Business</option>
                    <option value="semester_postponing">Network and Security</option>
                    <option value="semester_excuse">Web Development</option>    
                `;
            break;
            case 'language_studies':
                options = `
                    <option selected disabled hidden >-- Select Track --</option>
                    <option value="change_track">English Language and Literature</option>  
                `;
            break;
        }
        // document.write(options)
        document.getElementById('facultiesResult').innerHTML = options;

    }

    function get_centers(){
        let select = document.getElementById('branchList');
        let options = "";

        switch(select.options[select.selectedIndex].value){
            case 'saudi_arabia':
                options = `
                    <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Riyadh</option>
                    <option value="center_transfer">Jeddah</option>
                    <option value="semester_postponing">Dammam</option>
                    <option value="semester_excuse">Hail</option>    
                    <option value="semester_excuse">Hassa</option>   
                    <option value="semester_excuse">Madina</option>   
                `;
            break;
            case 'kuwait':
                options = `
                    <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Kuwait</option>    
                `;
            break;
            case 'egypt':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Egypt</option>  
                `;
            break;
            case 'sudan':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Sudan</option>  
                `;
            break;
            case 'palestine':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Palestine</option>  
                `;
            break;
            case 'oman':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Oman</option>  
                `;
            break;
            case 'bahrain':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Bahrain</option>  
                `;
            break;
            case 'jordan':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Jordan</option>  
                `;
            break;
            case 'lebanon':
                options = `
                <option selected disabled hidden >-- Select Center --</option>
                    <option value="change_track">Lebanon</option>  
                `;
            break;
        }
        // document.write(options)
        document.getElementById('facultiesResult').innerHTML = options;

    }
</script>