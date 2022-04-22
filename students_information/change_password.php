<?php

ob_start();
require_once('../connection.php');
include("../template/t1.php");

if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

$query="select * from students where student_id='".$_SESSION['student_id']."' ";
$result=mysqli_query($con,$query);
$data = mysqli_fetch_assoc($result);



?>

<html>

<head>
    <title>Updating information</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css//alert-box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />

    
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
            margin-left: 5em;
            background: white;
            border-radius: 10px;
            opacity: .85;
            padding: 0; 
        }
    </style>
</head>
<body>
    <div class="update">
    <p class="super-box-title">Update Information</p>
  <h2 style="text-align: center; padding-bottom: 5px;"></h2>
    <form method="post">
    <table>
      <tr>
        <td> Current password: </td>
        <td><input type="password" name="old_password" placeholder="current password" required /><br /></td>
        </tr>
        <tr>
        <td>New password:  </td>
        <td><input type="password" name="new_password" placeholder="New password"  required /></td>
        </tr>
        <tr>
        <td>  Retype new password:  </td>
        <td> <input type="password" name="password_confirm" placeholder="Retype new password"  required /><br /><br /></td>
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

</body>
<script src="../centerBox.js"></script>
<script>
$('.update').center();
  </script>
</html>
<?php 


// require_once '../connection.php';
$success ;

if(isset($_POST['submit'])){
    if(empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['password_confirm']) ){
        die("Fields cannot be empty");
    }
    else{
        if($data['password'] == hash('sha256', $_POST['old_password']) ){
            if($_POST['new_password'] == $_POST['password_confirm']){
                $query="update `students` set password = '" . hash('sha256', $_POST['new_password']) . "' where student_id = '" . $_SESSION['student_id'] . "' ";
                $result=mysqli_query($con,$query);
                // var_dump($query);
            
                if(mysqli_affected_rows($con))
                {
                    echo <<< _END
                    <div id="alert" class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p>Password Changed Successfully!</p>
                    </div>
                    <script>
                        setTimeout(function(){
                            history.replaceState("", document.title, window.location.pathname);
                            document.getElementById('alert').style.display = 'none';
                        }, 3000);
                    </script>
                    _END;
                    // after 2 second refresh the page (to view the new changes)
                    // header("Refresh:2");
                }
            }
            else{
                echo <<< _END
                <div id="alert" class="alert error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <p>New password do not match the confirmation!</p>
                </div>
                _END;
                die;
            }
        }
        // old password doesnt match the the input
        else{
            echo <<< _END
            <div id="alert" class="alert error">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <p>Invalid Current Password!</p>
            </div>
            _END;
            die;
        }
    
       
    }
   


}






?>