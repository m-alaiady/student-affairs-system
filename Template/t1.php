<?php
$pathInPieces = explode('\\', __DIR__);
$proj_name = $pathInPieces[3];
$path = "http://" . $_SERVER['HTTP_HOST'] . "/" . $proj_name;

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if(!isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

$query="select * from students where student_id='".$_SESSION['student_id']."' ";
$result=mysqli_query($con,$query);
$data = mysqli_fetch_assoc($result);






?>


<!DOCTYPE html>
<html>



     <!-- Start of the logo coding -->
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="pragma" content="no-cache" />
    <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    .student_name{
      float: left;
      margin-top: 2.5em;
      margin-left: 1em;
    }
    </style>
     <div class="logo">
      
      <?php
  
  
  
  if(isset($_SESSION['student_id']))
  {
    $s_name = $data['s_name'];
     echo <<< _END
        <span style="float: left"> 
          <img src="${path}/image/avatar.png" height="60" style="margin-top:15px; margin-left: 20px;">
        </span>
        <span class="student_name">${s_name}</span>
     _END;
      
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
       href="' . $path . '/logout.php?logout">Logout</a>' ;
  }
  
  else
  {
      header("location:index.php");
  }
  
  ?>


    
        <!-- <img src="image/Vision-2030-logo.jpg" height="80" width="200" style="float: right"> -->
        <img src="<?php echo $path ?>/image/aou-logo.png" height="80"  style="float:center; margin-right: 100px">
        <!-- <img src="<?php echo $path ?>/image/avatar.png" height="50" style="margin-left:0.1em;"> -->
      </div>
      </head>
      
  
      <body>
  
  
  
  
     
  
  
  
  
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://kit.fontawesome.com/b3914c431d.js" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />                 
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
      /* background: #D6DEDB;  */
    opacity: .7;
  }
  
  body{
    margin: 0;
    padding: 0;
    background-image: url("<?php echo $path; ?>/image/6.jpg"); 
    background-repeat: repeat-y;
    background-size: cover;
    height: 100vh;
    overflow: hidden;
  }
  
  </style>
  
  <!-- End of the logo coding -->




  

<!-- Start of side menu code -->
<nav class="spider">
    <ul>
        <li><a href="<?php echo $path ?> /home.php">Home</a></li>
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
            <li><a href="<?php echo $path ?>/academic_affairs/academic_status.php">Academic status</a></li>
            <li><a href="<?php echo $path ?>/academic_affairs/certificate_id.php">Certificate ID</a></li>
            <li><a href="<?php echo $path ?>/academic_affairs/view_courses_absence.php">View courses absence</a></li>
            <li><a href="<?php echo $path ?>/academic_affairs/upload_absence_execuse.php">Upload absence execuse</a></li>
        </ul>
    </li>
    <li><a href="#" class="rh-btn">Registration 
        <span class="fas fa-caret-down sixth"></span></a>
        <ul class="rh-show">
            <li><a href="<?php echo $path ?>/registration/register.php">Register</a></li>
            <li><a href="<?php echo $path ?>/registration/view_offered_courses.php?page=1">View offered courses</a></li>
        </ul>
    </li>
    <li><a href="#" class="re-btn">Grades & Transcripts 
        <span class="fas fa-caret-down second"></span></a>
        <ul class="re-show">
            <li><a href="<?php echo $path ?>/grades_and_transcripts/grades.php">Grades</a></li>
            <li><a href="<?php echo $path ?>/grades_and_transcripts/transcripts.php" target="_blank">Transcripts</a></li>
            <li><a href="<?php echo $path ?>/grades_and_transcripts/academic_plan.php" target="_blank">Acadmemic plan</a></li>
        </ul>
    </li>
    <li><a href="#" class="fi-btn">Finanical 
        <span class="fas fa-caret-down seventh"></span></a>
        <ul class="fi-show">
            <li><a href="<?php echo $path ?>/financial/financial.php">Fees payment</a></li>
            <li><a href="<?php echo $path ?>/financial/tuition_fees_exemption.php">Tuition fees exemption</a></li>
            <li><a href="<?php echo $path ?>/financial/view_balance.php">View balance</a></li>
        </ul>
    </li>
        
            <li><a href="<?php echo $path ?>/services/select-service.php" class="se-btn">Services </a></li>
            <li><a href="#" class="ex-btn">Examination 
        <span class="fas fa-caret-down fourth"></span></a>
        <ul class="ex-show">
            <li><a href="<?php echo $path ?>/examination/exam_schedule.php">Exam schedule</a></li>
            <li><a href="<?php echo $path ?>/examination/exam_certificate.php">Exam certificate</a></li>
            <li><a href="<?php echo $path ?>/examination/exam_postpone.php">Exam postpone</a></li>
            <li><a href="<?php echo $path ?>/examination/exam_objection.php">Exam objection</a></li>
            <li><a href="<?php echo $path ?>/examination/register_for_makeup_exam.php">Register for makeup exam</a></li>
            <li><a href="<?php echo $path ?>/examination/exam_in_other_branch_or_center.php">Exam in other branch/center</a></li>
        </ul>
    </li>
    <li><a href="#" class="su-btn">Support 
        <span class="fas fa-caret-down nineth"></span></a>
        <ul class="su-show">
            <li><a href="<?php echo $path ?>/support/registration_assistant.php">Registration assistant</a></li>
            <li><a href="<?php echo $path ?>/support/payment_support.php">Payment support</a></li>
        </ul>
    </li>
            <li><a href="https://mdl.arabou.edu.kw/ksa/" target="_blank">LMS</a></li>
            <li><a href="<?php echo $path ?>/graduation_ceremony.php"">Graduation ceremony</a> </li>
            <li><a href="<?php echo $path ?>/complaints.php">Complaints</a></li>
            
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
      if(this.st_opened){
        $('nav ul .st-show').removeClass("show");
        this.st_opened = false;
      }
      else{
        $('nav ul .st-show').addClass("show");
        $('nav ul .first').addClass("rotate");
        this.st_opened = true;
      }
    });

    $('.re-btn').click(function(){
      hideOtherMenu();
      if(this.re_opened){
        $('nav ul .re-show').removeClass("show1");
        this.re_opened = false;
      }
      else{
        $('nav ul .re-show').addClass("show1");
        $('nav ul .second').addClass("rotate");
        this.re_opened = true;
      }

    });

    $('.af-btn').click(function(){
      hideOtherMenu();
      if(this.af_opened){
        $('nav ul .af-show').removeClass("show7");
        this.af_opened = false;
      }
      else{
        $('nav ul .af-show').addClass("show7");
        $('nav ul .eight').addClass("rotate");
        this.af_opened = true;
      }

    });
    $('.ex-btn').click(function(){
      hideOtherMenu();
      if(this.ex_opened){
        $('nav ul .ex-show').removeClass("show3");
        this.ex_opened = false;
      }
      else{
        $('nav ul .ex-show').toggleClass("show3");
        $('nav ul .fourth').toggleClass("rotate");
        this.ex_opened = true;
      }

    });
    
    $('.rh-btn').click(function(){
      hideOtherMenu();
      if(this.rh_opened){
        $('nav ul .rh-show').removeClass("show5");
        this.rh_opened = false;
      }
      else{
        $('nav ul .rh-show').toggleClass("show5");
        $('nav ul .sixth').toggleClass("rotate");
        this.rh_opened = true;
      }

    });

    $('.fi-btn').click(function(){
      hideOtherMenu();
      if(this.fi_opened){
        $('nav ul .fi-show').removeClass("show6");
        this.fi_opened = false;
      }
      else{
        $('nav ul .fi-show').toggleClass("show6");
        $('nav ul .seventh').toggleClass("rotate");
        this.fi_opened = true;
      }


    });

    $('.se-btn').click(function(){
      hideOtherMenu();
      if(this.se_opened){
        $('nav ul .se-show').removeClass("show2");
        this.se_opened = false;
      }
      else{
        $('nav ul .se-show').toggleClass("show2");
        $('nav ul .third').toggleClass("rotate");
        this.se_opened = true;
      }


    });
    $('.su-btn').click(function(){
      hideOtherMenu();

      if(this.su_opened){
        $('nav ul .su-show').removeClass("show8");
        this.su_opened = false;
      }
      else{
        $('nav ul .su-show').toggleClass("show8");
        $('nav ul .nineth').toggleClass("rotate");
        this.su_opened = true;
      }


    });
</script>






<style>
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #EEEDEA; 
  border-radius: 10px;
  border: 1px solid black;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #EEEDEA; 
}
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
  background: #E7EDEA;
  /* opacity: .7; */
  padding-bottom: 2em;
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
  padding: 1px;
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

<script>
  // stop resubmitting data when refreshing the page
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>