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
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />
    <style>

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
                    <select id="servicesList" onchange="change_track(this);">
                        <option selected disabled hidden >-- Select Service --</option>
                        <option value="change_track">Change Track</option>
                        <option value="center_transfer">Branch - center transfer</option>
                        <option value="semester_postponing">Semester Postponing</option>
                        <option value="semester_excuse">Semester Excuse</option>    
                        <option value="english_equalize">English Equalize</option>
                        <option value="course_equalize">Course Equalize</option>
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
                                <select>
                                    <option selected disabled hidden >-- Select Faculty --</option>
                                    <option value="change_track">Change Track</option>
                                    <option value="center_transfer">Branch - center transfer</option>
                                    <option value="semester_postponing">Semester Postponing</option>
                                    <option value="semester_excuse">Semester Excuse</option>    
                                    <option value="english_equalize">English Equalize</option>
                                    <option value="course_equalize">Course Equalize</option>
                                    <option value="withdraw_from_university">Withdraw from University</option>
                                    <option value="social_reward">Social Reward</option>
                                    <option value="aid_request">Aid Request</option>
                                    <option value="id_reissuing">ID reussuing</option>
                                </select>
                            </td>
                            <td>
                                <select>
                                    <option selected disabled hidden >-- Select Track --</option>
                                    <option value="change_track">Change Track</option>
                                    <option value="center_transfer">Branch - center transfer</option>
                                    <option value="semester_postponing">Semester Postponing</option>
                                    <option value="semester_excuse">Semester Excuse</option>    
                                    <option value="english_equalize">English Equalize</option>
                                    <option value="course_equalize">Course Equalize</option>
                                    <option value="withdraw_from_university">Withdraw from University</option>
                                    <option value="social_reward">Social Reward</option>
                                    <option value="aid_request">Aid Request</option>
                                    <option value="id_reissuing">ID reussuing</option>
                                </select>
                            </td>
                            <td>Submit</td>
                        </tr>
                    </table>
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
</script>