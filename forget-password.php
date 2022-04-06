<?php
  session_start();
  $pathInPieces = explode('\\', __DIR__);
  $proj_name = $pathInPieces[3];
  $path = "http://" . $_SERVER['HTTP_HOST'] . "/" . $proj_name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS | Password Reset</title>



     <!-- Start of the logo coding -->

     <div class="logo">
      <img src="image/Vision-2030-logo.jpg" height="90" width="200" style="float: right">
      <img src="image/aou-logo.png" height="120" style="float: center">
      <img src="image/ministry.jpg" height="90" width="200" style="float: left">
    </div>
    </head>
    

    <body>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/b3914c431d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    

<style>

      @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
.logo{
  text-align: center;
  padding: 5px;
  background: white;
  opacity: .7;  
}

body{
    margin: 0;
  padding: 0;
  background-image: url("<?php echo $path; ?>/image/pexels-johannes-plenio-1103970.jpg"); 
  background-repeat: no-repeat;
  background-size: cover;
  height: 100vh;
  overflow: hidden;
}

</style>

<!-- End of the logo coding -->



<footer>
    <div class="foot">
      <center>
    Copyright © 2022 Arab Open University. All Rights Reserved.
  </center>
  </div>
  </footer>

  <style>

      .foot{
  position: absolute;
  width: 100%;
  bottom: 0px;
  text-align: center;
  background: white;
  opacity: .7;
}
.succs{
                list-style: none;
             }
              

  </style>


  <!-- End of footer coding -->
  

</head>
<body>
    <!-- <nav>
    <link rel="stylesheet" href="forget.css"> -->


            <div class="forget">


        <form id="form" action="" method="post">

            <div class="txt_field">
            <input name="student_id" type="text"  required/>
            <span></span>
            <label>Student ID:  </label>
            
            
            </div>

            <div class="txt_field">
            <input name="national_id" type="text"  required />
            <span></span>
            <label>National ID: </label>
            
            
            </div>




            <input style="
                position: relative;
                top: 25px;
                bottom: 60px;
                padding: 5px 30px; 
                text-decoration: none; 
                background: #2691d9; 
                border-radius: 25px;
                font-size: 18px; 
                color: #e9f4fb; 
                font-weight: 500; 
                height: 40px;
                cursor: pointer;
                border-style: none;
                "
                
                type="submit" name="submit" value="Reset password" />
            <br>
            <a style="
                position: relative;
                top: 90px;
                padding: 5px 50px; 
                text-decoration: none; 
                background: #2691d9; 
                border-radius: 25px;
                font-size: 18px; 
                color: #e9f4fb; 
                font-weight: 500; 
                height: 40px;"
                
                href="index.php">Back to login page</a>
        </form>
    </div>

<style>
    
.forget{
    background: whitesmoke; 
    width: 500px; 
    height: 450px;
    opacity: .95; 
    border-radius: 10px; 
    top: 30%;
    left:32%; 
    position: absolute; 
    text-align: center; 
    padding: 25px;
}
      form .txt_field{
  position: relative;
  border-bottom: 2px solid #adadad;
  margin: 30px 0;
}
.txt_field input{
  width: 100%;
  padding: 0 5px;
  height: 40px;
  font-size: 16px;
  border: none;
  background: none;
  outline: none;
}
.txt_field label{
  position: absolute;
  top: 50%;
  left: 5px;
  color: black;
  transform: translateY(-50%);
  font-size: 16px;
  pointer-events: none;
  transition: .5s;
}
.txt_field span::before{
  content: '';
  position: absolute;
  top: 40px;
  left: 0;
  width: 0%;
  height: 2px;
  background: #2691d9;
  transition: .5s;
}
.txt_field input:focus ~ label,
.txt_field input:valid ~ label{
  top: -5px;
  color: #2691d9;
}
.txt_field input:focus ~ span::before,
.txt_field input:valid ~ span::before{
  width: 100%;
}
</style>
    <!-- </nav> -->

    
</body>
</html>








<?php
// save student ID for later use

if(isset($_POST['submit'])){
    global $student_id;
    
    require_once 'connection.php';

    $_SESSION['s_id'] = $_POST['student_id'];
    $query="select * from students where student_id='".$_POST['student_id']."' and national_id='".$_POST['national_id']."'";
    $result=mysqli_query($con,$query);
    if(mysqli_fetch_assoc($result))
    {
        echo <<< __END
            <script>
                document.getElementById('form').innerHTML = `
                <div>
                    <form action="" method="post">
                         <div class="txt_field">
                         <link rel="stylesheet" href="forget.css">
                        <input name="password" type="password" required />
                        <span></span>
                        <label >New password </label>
                        </div>
                        <div class="txt_field">
                        <link rel="stylesheet" href="forget.css">
                       
                        <input name="re_password" type="password" required />
                        <span></span>
                        <label>Confirm new password </label>
                       
                        </div>
                        <input style="
                        position: relative;
                        top: 25px;
                        bottom: 60px;
                        padding: 5px 30px; 
                        text-decoration: none; 
                        background: #2691d9; 
                        border-radius: 25px;
                        font-size: 18px; 
                        color: #e9f4fb; 
                        font-weight: 500; 
                        height: 40px;
                        cursor: pointer;
                        border-style: none;
                        "type="submit" name="reset_submit" value="Reset password" />
                        
                    </form>
                    </div>
                `;
            </script>
        __END;


    }
    else
    {
        echo "Invalid entry data";
    }
}

if(isset($_POST['reset_submit'])){
    if($_POST['password'] == $_POST['re_password']){
        require_once 'connection.php';
        $query="update `students` set password = '" .hash('sha256',$_POST['password']) . "' where student_id = '" . $_SESSION['s_id'] . "' ";
        $result=mysqli_query($con,$query);
        if($result){


            // Start of Design single page Application

            
            echo <<< __END
            <script>
            
                document.getElementById('form').innerHTML = `
                <div style="
                    background: whitesmoke; 
                    width: 705px; 
                    height: 250px;
                    opacity: .95; 
                    border-radius: 10px; 
                    top: 20%;
                    right: -25%; 
                    position: absolute; 
                    text-align: center; 
                    padding: 80px;">
               <span style="padding: 10px;  font-size: 25px;"> Password has been successfully changed</span>
               <br>
               <a style="
                position: relative;
                top: 25px;
                padding: 5px 50px; 
                text-decoration: none; 
                background: #2691d9; 
                border-radius: 25px;
                font-size: 25px; 
                color: #e9f4fb; 
                font-weight: 700; 
                height: 50px;
               " href="index.php">Back to login page</a>
                </div>
               `;
            // this code is to remove unwanted css design
               document.getElementsByClassName('forget')[0].style.background='none';
            </script>
            
           
        __END;
       
            // remove student id session not need for it anymore
            unset($_SESSION['s_id']);
            
           // End of Design single page Application



           
        } else {
            echo "Sorry we could not update the password";
        }
    }
    
    else{
        
        
        echo "Passwords Do Not Match!";
        
        
    }
   
}

?>
