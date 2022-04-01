<?php
require_once('connection.php');
include('template/t1.php');



?>
<!DOCTYPE html>
<html>
<head>
    
    <title>SIS | Home</title> 



<!-- Start of info -->

<div class="hom">
  <h2 style="text-align: center; padding-bottom: 5px;">Student Information</h2>
    <table>
      <tr>
     <td>Student Name</td>
     <td><?php echo $data['s_name']; ?> </td>
     </tr>
     <tr>
    <td> Student ID </td>
    <td><?php echo $data['student_id']; ?></td> 
    </tr>
    <tr>
    <td> National ID </td>
    <td><?php echo $data['national_id']; ?></td>
    </tr>
    <tr>
    <td> Personal Email</td>
    <td><?php echo $data['email']; ?> </td>
    </tr>
    <tr>
    <td> Mobile number</td>
    <td><?php echo $data['mobile']; ?> </td>
    </tr>
    <tr>
    <td> Alternative Mobile number</td>
    <td><?php echo $data['mobile2']; ?> </td>
    </tr>
    <tr>
    <td> Blood type</td>
    <td><?php echo $data['blood']; ?> </td>
    </tr>
    </table>
    </div>
   
     
    <style>
      table, th, td{
        border-right: 1px solid #fff;
        border-top: 1px solid #fff;
        padding: 1em 2em;
    }
      tr:nth-child(odd) {
        background: #eee;
      }
      .hom{
        position: absolute;
        margin-left:525px;
        margin-top:200px;
        background: white;
        border-radius: 10px;
        opacity: .85;
        padding: 20px; 
        /* text-align: center; */
      }
    </style>


<!-- End of info -->





   
</body>








</html>