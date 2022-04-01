<?php
session_start();

$query="select * from students where student_id='".$_SESSION['student_id']."' ";
$result=mysqli_query($con,$query);
$data = mysqli_fetch_assoc($result);

$pathInPieces = explode('\\', __DIR__);
$proj_name = $pathInPieces[3];
$path = "http://" . $_SERVER['HTTP_HOST'] . "/" . $proj_name;


?>


<!DOCTYPE html>
<html>



     <!-- Start of the logo coding -->
<head>
    

     <div class="logo">
      
      <?php
  
  
  
  if(isset($_SESSION['student_id']))
  {
     echo ' <span style="float: left; 
                      margin-top: 30px;
                        margin-left: 20px;
     ">' . $data['s_name']. '</span>' ;
      
      echo '<a  style=" float: right;
                margin-top: 30px;
                margin-right: 20px;
                border: 1px solid;
                width: 80px;
                background: red;
                border-radius: 5px;
                font-size: 18px;
                color: #e9f4fb;
                text-decoration: none;    
       "
       href="logout.php?logout">Logout</a>' ;
  }
  
  else
  {
      header("location:index.php");
  }
  
  ?>


    
        <!-- <img src="image/Vision-2030-logo.jpg" height="80" width="200" style="float: right"> -->
        <img src="<?php echo $path ?>/image/aou-logo.png" height="80"  style="float:center; margin-right: 100px">
        <!-- <img src="image/ministry.jpg" height="80" width="200" style="float: left"> -->
      </div>
      </head>
      
  
      <body>
  
  
  
  
     
  
  
  
  
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://kit.fontawesome.com/b3914c431d.js" crossorigin="anonymous"></script>
      
      <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      
  
  <style>
  
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');
  *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
  }
  .logo{
    position: fixed;
    width: 100%;
    text-align: center;
    padding: 5px;
    background: white;
    opacity: .7;
  }
  
  body{
    margin: 0;
    padding: 0;
    background-image: url("pexels-johannes-plenio-1103970.jpg"); 
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    overflow: hidden;
  }
  
  </style>
  
  <!-- End of the logo coding -->




  

<!-- Start of side menu code -->
<nav class="spider">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#" class="st-btn">Student Information 
            <span class="fas fa-caret-down first"></span></a>
        <ul class="st-show">
            <li><a href="<?php echo $path ?>/students_information/update_information.php">Update information</a></li>
            <li><a href="<?php echo $path ?>/students_information/change_password.php">Change password</a></li>
        </ul>
    </li>
    <li><a href="#" class="af-btn">Academic affairs 
            <span class="fas fa-caret-down eight"></span></a>
        <ul class="af-show">
            <li><a href="#">Academic status</a></li>
            <li><a href="#">Certificate ID</a></li>
            <li><a href="#">View courses absence</a></li>
            <li><a href="#">Upload absence execuse</a></li>
        </ul>
    </li>
    <li><a href="#" class="rh-btn">Registration 
        <span class="fas fa-caret-down sixth"></span></a>
        <ul class="rh-show">
            <li><a href="<?php echo $path ?>/registration/register.php">Register</a></li>
            <li><a href="#">View offered courses</a></li>
        </ul>
    </li>
    <li><a href="#" class="re-btn">Grades & Transcripts 
        <span class="fas fa-caret-down second"></span></a>
        <ul class="re-show">
            <li><a href="#">Grades</a></li>
            <li><a href="#">Transcripts</a></li>
            <li><a href="#">Acadmemic plan</a></li>
        </ul>
    </li>
    <li><a href="#" class="fi-btn">Finanical 
        <span class="fas fa-caret-down seventh"></span></a>
        <ul class="fi-show">
            <li><a href="#">Fees payment</a></li>
            <li><a href="#">Tuuition fees exemption</a></li>
            <li><a href="#">View balance</a></li>
        </ul>
    </li>
        
            <li><a href="#" class="se-btn">Services 
        <span class="fas fa-caret-down third"></span></a>
        <ul class="se-show">
            <li><a href="#">Change major</a></li>
            <li><a href="#">Change branch</a></li>
            <li><a href="#">Term postoone</a></li>
            <li><a href="#">Term excuse</a></li>
            <li><a href="#">English equalize</a></li>
            <li><a href="#">Course equalize</a></li>
            <li><a href="#">Cancel course</a></li>
            <li><a href="#">Withdraw from university</a></li>
            <li><a href="#">Re enroll</a></li>
            <li><a href="#">Social Reward</a></li>
            <li><a href="#">Aid Request</a></li>
            <li><a href="#">ID reissuing</a></li>
        </ul>
    </li>
            <li><a href="#" class="ex-btn">Examination 
        <span class="fas fa-caret-down fourth"></span></a>
        <ul class="ex-show">
        <li><a href="#">Exam schedule</a></li>
        <li><a href="#">Exam certificate</a></li>
        <li><a href="#">Exam postpone</a></li>
            <li><a href="#">Upload exam excuse</a></li>
            <li><a href="#">Exam objection</a></li>
            <li><a href="#">Register for makeup exam</a></li>
            <li><a href="#">Exam-different branch</a></li>
            <li><a href="#">Exam-different centre</a></li>
        </ul>
    </li>
    <li><a href="#" class="su-btn">Support 
        <span class="fas fa-caret-down nineth"></span></a>
        <ul class="su-show">
            <li><a href="#">Registration assistant</a></li>
            <li><a href="#">Payment support</a></li>
            <li><a href="#"></a></li>
        </ul>
    </li>
            <li><a href="#">LMS</a></li>
            <li><a href="#">Graduation ceremony</a> </li>
            <li><a href="#">Complaints</a></li>
            
    </ul>
    
</nav>

<script>
    let st_opened = false;
    let re_opened = false;
    let af_opened = false;
    let ex_opened = false;
    let rh_opened = false;
    let fi_opened = false;
    let se_opened = false;
    let su_opened = false;

    function hideOtherMenu(){
      let classNames = ['first', 'second', 'third', 'fourth', 'sixth', 'seventh', 'eight', 'nineth'];
      $("[class*='-show']").each(function(){
          $(this).removeClass('show');
          for(let i=1; i < 9; i++){ 
              $(this).removeClass('show'+i) 
          } 
          $('nav ul').removeClass('rotate'); 
      });
      classNames.forEach(item => {
        $('ul li .' +item).removeClass('rotate');
      });
      st_opened = false;
      re_opened = false;
      af_opened = false;
      ex_opened = false;
      rh_opened = false;
      fi_opened = false;
      se_opened = false;
      su_opened = false;
    }

    $('.st-btn').click(function(){
      hideOtherMenu();
      if(st_opened){
        $('nav ul .st-show').removeClass("show");
        st_opened = false;
      }
      else{
        $('nav ul .st-show').addClass("show");
        $('nav ul .first').addClass("rotate");
        st_opened = true;
      }
    });

    $('.re-btn').click(function(){
      hideOtherMenu();
      if(re_opened){
        $('nav ul .re-show').removeClass("show1");
        re_opened = false;
      }
      else{
        $('nav ul .re-show').addClass("show1");
        $('nav ul .second').addClass("rotate");
        re_opened = true;
      }

    });

    $('.af-btn').click(function(){
      hideOtherMenu();
      if(af_opened){
        $('nav ul .af-show').removeClass("show7");
        af_opened = false;
      }
      else{
        $('nav ul .af-show').addClass("show7");
        $('nav ul .eight').addClass("rotate");
        af_opened = true;
      }

    });
    $('.ex-btn').click(function(){
      hideOtherMenu();
      if(ex_opened){
        $('nav ul .ex-show').removeClass("show3");
        ex_opened = false;
      }
      else{
        $('nav ul .ex-show').toggleClass("show3");
        $('nav ul .fourth').toggleClass("rotate");
        ex_opened = true;
      }

    });
    
    $('.rh-btn').click(function(){
      hideOtherMenu();
      if(rh_opened){
        $('nav ul .rh-show').removeClass("show5");
        rh_opened = false;
      }
      else{
        $('nav ul .rh-show').toggleClass("show5");
        $('nav ul .sixth').toggleClass("rotate");
        rh_opened = true;
      }

    });

    $('.fi-btn').click(function(){
      hideOtherMenu();
      if(fi_opened){
        $('nav ul .fi-show').removeClass("show6");
        fi_opened = false;
      }
      else{
        $('nav ul .fi-show').toggleClass("show6");
        $('nav ul .seventh').toggleClass("rotate");
        fi_opened = true;
      }


    });

    $('.se-btn').click(function(){
      hideOtherMenu();
      if(se_opened){
        $('nav ul .se-show').removeClass("show2");
        se_opened = false;
      }
      else{
        $('nav ul .se-show').toggleClass("show2");
        $('nav ul .third').toggleClass("rotate");
        se_opened = true;
      }


    });
    $('.su-btn').click(function(){
      hideOtherMenu();

      if(su_opened){
        $('nav ul .su-show').removeClass("show8");
        su_opened = false;
      }
      else{
        $('nav ul .su-show').toggleClass("show8");
        $('nav ul .nineth').toggleClass("rotate");
        su_opened = true;
      }


    });
</script>






<style>

@keyframes slide_Down{  
  0%
  {
      
    transform: translateY(-400px);
    opacity: 0;
  }
  100%
  {
      
    transform: translateY(0);
    opacity: .9;
  }
}
.spider{
  position: fixed;
  top: 96.4px;
  bottom: 0;
  width: 320px;
  height: 86.45%;
  background: white;
  opacity: .7;
}
nav ul{
height: 100%;
width: 100%;
list-style: none;
overflow-y: auto;
}
nav ul li{
 line-height: 60px; 
 
}
nav ul li a{
  position: relative;
  text-decoration: none;
  font-size: 18px;
  padding-left: 40px;
  font-weight: 500;
  display: block;
  width: 100%;
  transition: .3s ease;
}
nav ul li a:hover{
  background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);
  color: white; 
}
nav ul ul{
  position: static;
  display: none;
}
nav ul .st-show.show{
  display: block;
}
nav ul .re-show.show1{
  display: block;
}
nav ul .se-show.show2{
  display: block;
}
nav ul .ex-show.show3{
  display: block;
}

nav ul .rh-show.show5{
  display: block;
}
nav ul .fi-show.show6{
  display: block;
}
nav ul .af-show.show7{
  display: block;
}
nav ul .su-show.show8{
  display: block;
}
nav ul ul li{
  line-height: 42px;
}
nav ul ul li a{
  font-size: 17px;
  padding-left: 80px;
}
nav ul li a span{
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
  font-size: 22px;
  transition: transform 0.4s;
}
nav ul li a span.rotate{
  transform: translateY(-50%) rotate(-180deg);
}


</style>









</body>
<!-- End of side menu code -->

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