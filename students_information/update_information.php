<?php

// session_start()
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
   
    
    <title>SIS | Update Information</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />

</head>


<body>


    <div class="update">
    <form method="post">
    <table>
      <tr>
        <td> Student ID: </td>
        <td><input type="text" value="<?php echo $data['student_id']; ?>" title="Cannot modified" disabled /></td>
        </tr>
        <tr>
        <td>National ID: </td>
        <td><input type="text" value="<?php echo $data['national_id']; ?>" title="Cannot modified" disabled /></td>
        </tr>
        <tr>
        <td> Student Name: </td>
        <td><input required type="text" name="s_name" value="<?php echo $data['s_name']; ?>" /></td>
        </tr>
        <tr>
        <td> Personal Email: </td>
        <td><input required type="email" name="email" value="<?php echo $data['email']; ?>" /></td> 
        </tr>
        <tr>
        <td> Mobile number:</td>
        <td><input required type="mobile" name="mobile" value="<?php echo $data['mobile']; ?>" /></td> 
        </tr>
        <tr>
        <td> Alternative mobile number: </td>
        <td><input required type="mobile2" name="mobile2" value="<?php echo $data['mobile2']; ?>" /></td>
        </tr>
        <tr>
        <td> blood type: </td>
        <td><input required type="blood" name="blood" value="<?php echo $data['blood']; ?>" /></td>
        </tr>        
    </table>
    <br>
    <input style="width: 30%;
                  height:40px;
                  margin-left:37%;
                  border: 1px solid;
                    background: #2691d9;
                    border-radius: 25px;
                    font-size: 18px;
                    color: #e9f4fb;
                    font-weight: 700;
                    cursor: pointer;
                    outline: none;
                    margin-bottom: 15px" 
     type="submit" name="submit" value="Save" />
    </form>
    </div>

    <style>
        table, td{
        
        border-top: 1px solid #fff;
        padding: 1em 2.5em;
    }
    tr:nth-child(odd) {
        background: #eee;
      }
      form td input{
          width: 114%;
          text-align: center;
      }
     
        .update{
            position: absolute;
        margin-left:525px;
        margin-top:200px;
        background: white;
        border-radius: 10px;
        opacity: .85;
        padding: 20px; 
        }
    </style>





</body>


</html>
<?php 


// require_once '../connection.php';
$success ;

if(isset($_POST['submit'])){


    $query="update `students` set 
        s_name = '" . $_POST['s_name'] . 
        "', email = '". $_POST['email'] .
        "', mobile = '" . $_POST['mobile'] . 
        "', mobile2 = '". $_POST['mobile2'] . 
        "', blood = '". $_POST['blood'] .
        "' where student_id = '" . $_SESSION['student_id'] . "' ";
        
    $result=mysqli_query($con,$query);
    // var_dump($query);

    if(mysqli_affected_rows($con))
    {
        echo <<< _END
            <div class="alert success">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>Information updated successfully</p>
            </div>
        _END;
        // after 2 second refresh the page (to view the new changes)
        header("Refresh:2");
    }
    else{
        echo <<< _END
            <div class="alert error">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>Sorry! We couldn't udpate the information, Try later!</p>
            </div>
        _END;
        die;
    }


}






?>