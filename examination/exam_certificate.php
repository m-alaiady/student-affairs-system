<?php
require_once('../connection.php');

include("../template/t1.php");

?>

<html>

<head>
    <title>SIS | Exam Certificate</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
    <style>
        .student_data_print_btn {
            all: unset;
            position: absolute;
            background-color: dodgerblue;
            margin-left:33em;
            margin-top:25em;
            border-radius: 10px;
            padding: 0.25em 1em;
            border: none;
            cursor: pointer;
            color: white;
        }
    </style>
</head>


<body>

    <div class="student_data">
        <p class="super-box-title">Exam Certificate</p>


        <div class="row">

            <table>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Classroom</th>
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
                        <input name="file" type="file" accept='image/*' required />
                    </td>
                    <td>
                    </td>
                    <td>
                        10-12
                    </td>
                    <td>
                        10-12
                    </td>
                </tr>
            </table>


        </div>




    </div>
    <a href="print_student_data.php" class="student_data_print_btn" style="text-decoration: none;" target="_blank"><span class="fa fa-print"></span> Print </a>


    <div id="service"></div>



</body>

</html>