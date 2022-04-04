<?php 
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once('../connection.php');

$query="select * from students where student_id='".$_SESSION['student_id']."' ";
$result=mysqli_query($con,$query);
$data = mysqli_fetch_assoc($result);

$sql = "SELECT faculties.* FROM faculties 
        JOIN students 
        ON faculties.id = students.faculty_id 
        WHERE students.student_id = " . $_SESSION['student_id'] . "";
        
$faculty_data=mysqli_query($con,$sql);
$faculty= mysqli_fetch_assoc($faculty_data);

$head = "
    <style>
        table,tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
            border-width: 2px;
        }
        th, td{
            padding: 2em;
        }
        .footer{
            display:flex;
            justify-content: space-between;
        }
        .logo{
            margin-top: -75px;
            margin-left: 450px;
            width: 50%;
        }
        .text p{
            position:absolute;
            top: 50;
            margin-bottom: -25px;
            z-index: 5;
        }
        .stamp{
            text-align: right;
            margin-top: -72px;
        }
        .deanship{
            margin-left: 50px;
        }
    </style>
";

$html = $head;

$html .= "
    <div class='header'>
        <div class='text'>
            <p>Statement of Credits Hours Completed by Students</p>
        </div>
        <div class='logo'>
            <img src='logo3.png' alt='logo' width='250'/>
        </div>
    </div>
    ";
$html .= "<table>";
$html .= "
        <tr>
            <th>Name</th> <td colspan='5'>" . $data['s_name'] . "</td>
        </tr>
        <tr>
            <th>National ID</th> <td colspan='2'>" . $data['national_id'] . "</td>
            <th>Student ID</th> <td colspan='2'>" . $data['student_id'] . "</td>
        </tr>
        <tr>
            <th>GPA</th> <td>" . $data['GPA'] . "</td>
            <th>Academic Status</th> <td>" . ($data['status'] == '1'? 'Active': 'Not active') . "</td>
            <th>Academic Term</th> <td>" . $data['acceptance_term'] . "</td>
        </tr>
        <tr>
            <th>Faculty</th> <td>" . $faculty['name'] . "</td>
            <th>Major</th> <td>" . $data['major'] . "</td>
            <th>Branch</th> <td>" . $faculty['branch'] . "</td>
         </tr>
        ";


$html .= "</table>";
$html .= "
    <p>
        The Deanship of Admission and Students Affairs certifies that the mentioned above student is one of<br>
        the regular students who is enrolled in the university during " . $data['acceptance_term'] . " where<br>
        the credit hours by the student are (" . $data['term_credits'] . ") hours out of (127) credits hours.
        <br><br>
        This statement was issues upon the student's request without any responsibility upon the university.
    </p>
    <br><br><br><br>
    <div class='footer'>
        <div class='signature'>
            <p>
                Deanship of admission & Students Affairs<br>
                        <p class='deanship'>Dr.Maysoon Khoja</p>
            </p>
        </div>
        <div class='stamp'>
            <p>Stamp</p>
        </div>
    </div>";


// echo $html;

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();