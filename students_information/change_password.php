<?php

require_once('../connection.php');

session_start();

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
</head>
<body>
    <form method="post">
        <label> Current password: </label><br />
        <input type="text" name="old_password" placeholder="current password" /><br />
        <label> New password: </label><br />
        <input type="text" name="new_password" placeholder="New password" /><br />
        <label> Retype new password: </label><br />
        <input type="text" name="password_confirm" placeholder="Retype new password" /><br /><br />
        <input type="submit" name="submit" value="Save" />
        <a href="../home.php">Go back to dashboard</a>
    </form>
</body>
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
                    echo "password changed successfully";
                    // after 2 second refresh the page (to view the new changes)
                    header("Refresh:2");
                }
            }
            else{
                die("new password do not match the confirmation");
            }
        }
        // old password doesnt match the the input
        else{
            die("invalid current password");
        }
       
       
    }
   


}






?>