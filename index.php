




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>AOU | SIS</title>








<!-- Start of the logo coding -->

    <div class="logo">
      <img src="image/Vision-2030-logo.jpg" height="90" width="200" style="float: right">
      <img src="image/aou-logo.png" height="120" style="float: center">
      <img src="image/ministry.jpg" height="90" width="200" style="float: left">
    </div>

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
  animation: slide_Down 2s ease;
}
@keyframes slide_Down{
  0%
  {
    transform: translateY(-400px);
  }
  100%
  {
    transform: translateY(0);
  }
}
body{
  margin: 0;
  padding: 0;
  background-image: url("image/pexels-johannes-plenio-1103970.jpg"); 
  background-repeat: no-repeat;
  background-size: cover;
  height: 100vh;
  overflow: hidden;
  
}

</style>

<!-- End of the logo coding -->


</head>
<body>

<!-- Start of splash screen -->

<div class="splash">
      <div class="fade-in">
        <center> <img src="image/aou-logo.png" ></center>
        </div>
    </div>

    <script src="splash.js"></script>

    <style>

.splash{
 position: fixed;
  top: 50%;
  left: 50%;
  text-align: center;
  transform: translate(-50%, -50%);
  width: 100%;
  height: 100%;
  color: white;
  background: white;
line-height: 100vh;
z-index: 200;

}
.splash.display-none{
  position: fixed;
  opacity: 0;
   top: 50%;
   left: 50%;
   text-align: center;
   transform: translate(-50%, -50%);
   width: 100%;
   height: 100%;
   color: white;
   background: white;
 line-height: 150vh;
 z-index: -10;
 transition: all 0.5s;
 }
@keyframes fadeIn{
  to{
    opacity: 1;
  }
}
.fade-in{
  opacity: 0;
  animation: fadeIn 1s ease-in forwards;
}

    </style>
<!-- End of splash screen -->











<!-- Start of the log in box -->

    <div class="container">
        
            

 
                        <h1>Login</h1>


 <?php 
              // check if user already logged in if yes then directly move to the home page
             session_start();
              if(isset($_SESSION['student_id']))
              {
                  header("location:home.php");
              }

 
                        if(@$_GET['Empty']==true)
                        {
                    ?>
                        <div class="alert"><?php echo $_GET['Empty'] ?></div>                                
                    <?php
                        }
                    ?>


                    <?php 
                        if(@$_GET['Invalid']==true)
                        {
                    ?>
                        <div class="alert"><?php echo $_GET['Invalid'] ?></div>                                
                    <?php
                        }
 ?>



                    <div>
                        <form action="process.php" method="post">
                            <div class="txt_field">
                            <input type="text" name="student_id">
                            <span></span>
                            <label>Student ID</label>
                            </div>

                            <div class="txt_field">
                            <input type="password" name="password">
                            <span></span>
                            <label>Password</label>
                            </div>

                            <div class="pass">
                            <input type="checkbox">
                            <label>Remember password</label> 
                            </div>

                            <div class="log">
                            <button name="Login">Login</button>
                            </div>
                            
                            <div class="forget">
                           Forget password? <a href="forget-password.php">Reset Password</a>
                            </div>
                        </form>
                    </div>
               
        
    </div>


    <style>

.container{
  position: absolute;
  top: 53%;
  right: 0;
  transform: translate(-25%, -50%);
  width: 500px;
  height: 480px;
  background: white;
  border-radius: 10px;
  opacity: .85;
  animation: slide_Right 2s ease; 
}    

@keyframes slide_Right{
  0%
  {
    transform: translate(1000px);
  }
  100%
  {
    transform: translate();
  }
}

.container h1{
    text-align: center;
  padding: 20px 0;
}

.container form{
  padding: 0 40px;
  box-sizing: border-box;
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

.log button{
  width: 100%;
  height: 50px;
  border: 1px solid;
  background: #2691d9;
  border-radius: 25px;
  font-size: 18px;
  color: #e9f4fb;
  font-weight: 700;
  cursor: pointer;
  outline: none;
}
.pass{
  margin: -5px 0 20px 5px;
  color: black;
  cursor: pointer;
}
.forget{
  margin: 30px 0;
  text-align: center;
  font-size: 16px;
  color: #666666;
}
.forget a{
  color: #2691d9;
  text-decoration: none;
}
.forget a:hover{
  text-decoration: underline;
}
.alert {
  width: 80%;
  padding: 5px;
  text-align: center;
  border-radius: 4px;
  border-style: solid;
  border-width: 1px;
  margin-bottom: 12px;
  font-size: 16px;
  background-color: rgba(248, 215, 218, 1);
  border-color: rgba(220, 53, 69, 1);
  color: rgba(114, 28, 36,1);
  margin: 0 0 0 50px;
}


    </style>


    <!-- End of the log in box -->












    <!-- Start of word coding -->

    <div class="word">
      <h1>

        <div>
          
           <ul>
            
            <li> 
              <h3>AOU Vision</h3>
              <h6>Striving to become a leader in teaching methods
              <br>and techniques, a promoter of creative
              <br>initiatives and a power house of leaders and
            <br>professionals.
           </h6>
            </li>
            
            <li>
              <h3>AOU Mission</h3>
               <h6> Disseminating knowledge, promoting scientific<br>
              research and serving the community through
              <br>flexible, high-quality education whose foremost
               <br>goal is sustained development. </h6>
              </li>
             <li> 
              <h3>AOU Shared Value </h3>
               <h6>At AOU, values constitute the guidelines, which
              <br>determine conduct at the University at all
              <br>administrative levels, and also determine the basis
            <br>of dealing with students and with all other stakeholders...</h6>
            </li>
           </ul>
          </div>
     </h1>
    </div>


<style>

@keyframes slide_Left{
  0%
  {
    transform: translate(-2000px);
  }
  100%
  {
    transform: translate();
  }
}
.word{
  position: absolute;
  top: 45%;
  left: 0;
  height: auto;
  transform: translate(10%, -50%);
  color: black;
  border-radius: 10px;
  animation: slide_Left 2s ease;
}
.word h1{
position: relative;

display: flex;
}
.word h1 ul{
  position: relative;
  height: auto;
  width: auto;
  height: 185px;
  letter-spacing: 2.5px;
  
}
.word h1 div{
  margin: 0;
  position: relative;
  height: auto;
  width: auto;
  z-index: -1;
  overflow: hidden;
 
}
.word h1 div ul{
  margin: 0;
  animation: animate 40s linear infinite;

}
.word h1 div ul li{
  list-style-type: none;
}
.word h1 div ul li h3{
  border-bottom: 2px solid black;
  display: inline-block;
  width: auto;
}
@keyframes animate{
  0%{
    transform: translateY(0px);
  }
  30%{
    transform: translateY(0px);
  }
  40%{
    transform: translateY(-190px);
  }
  70%{
    transform: translateY(-190px);
  }
  80%, 100%{
    transform: translateY(-380px);
  }
}

</style>





    <!-- End of word coding -->



</body>









<!-- Start of footer coding -->


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
  animation: slide_Up 2s ease;
}

@keyframes slide_Up{
  0%
  {
    transform: translateY(250px);
  }
  100%
  {
    transform: translateY(0);
  }
}
  </style>


  <!-- End of footer coding -->
</html>