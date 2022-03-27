<?php 
require_once('connection.php');
session_start();
    if(isset($_POST['Login']))
    {
       if(empty($_POST['student_id']) || empty($_POST['password']))
       {
            header("location:index.php?Empty= Please Fill in the Blanks");
       }
       else
       {
            $query="select * from students where student_id='".$_POST['student_id']."' and password='".hash('sha256',$_POST['password'])."'";

            $result=mysqli_query($con,$query);

            if(mysqli_fetch_assoc($result))
            {
                $_SESSION['student_id']=$_POST['student_id'];
                header("location:home.php");
                
            }
            else
            {
                header("location:index.php?Invalid= Please enter correct username and password ");
            }
       }
    }
    else
    {
        echo 'Not Working Now Guys';
    }

?>