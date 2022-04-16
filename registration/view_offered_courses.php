<?php

require_once("../connection.php");

include("../template/t1.php");

const ROW_PER_PAGE = 9;
const DEFAULT_PAGE = 1;

$get_courses_number="select COUNT(*) AS courses_number from offered_courses";
$corses_numbers_result = mysqli_query($con, $get_courses_number);
$courses_number = mysqli_fetch_assoc($corses_numbers_result);
// echo  die;

$row_per_page = constant('ROW_PER_PAGE');
$default = constant('DEFAULT_PAGE');
$pageNum = 1;


if(isset($_GET['page'])){
    if(!is_numeric($_GET['page'])){
        echo "<script>alert('Invalid page number')</script>";
        die;
    }
    $pageNum = $_GET['page'];
}


$offset = ($pageNum - 1) * $row_per_page;

function is_valid_pagination(){
    global $row_per_page, $courses_number;
    if(isset($_GET['page'])){
        if($_GET['page'] > ceil(($courses_number['courses_number']/$row_per_page)) || $_GET['page'] <= 0){
            return false;
        }
        else{
            return true;
        }
    }
}



$next_page = $pageNum + 1;
$back_page = $pageNum - 1;

$query="select * from offered_courses LIMIT {$offset},{$row_per_page}";
$get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";

$get_id_result=mysqli_query($con,$get_id);
$student_id= mysqli_fetch_assoc($get_id_result);


$get_all_courses = "SELECT courses.* FROM courses JOIN enrolled ON courses.id = enrolled.course_id WHERE enrolled.student_id = '" . $student_id['id'] . "' ";
$get_all_teachers = "SELECT teachers.* FROM teachers JOIN courses ON teachesr.id = courses.tutor_id WHERE courses.tutor_id = '" . $student_id['id'] . "' ";

$courses=mysqli_query($con,$get_all_courses);

// if user did not signed in
if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}
// if user did not pay 
if( !isset($_SESSION['paid']) ){
    header("location:register.php");
}





?>

<html>
<head>
    <title>SIS | Offered Courses</title>
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/box.css" />
    <link rel="stylesheet" href="<?php echo $path  ?>/assets/css/alert-box.css" />
<style>
    body{
        overflow: auto;
        z-index: 20;
    }
    .logo, .foot{
        z-index: 1;
    }
    .student_data div,.view-section div, .registered-courses div{
        padding: 2em;
    }
    .pagination a{
        color: #fff;
        background-color: #2691d9;
        text-decoration: none;
        border: none;
        border-radius: 25px;
        padding: 5px 2em;
        cursor: pointer;
        font-size: 1em;
        text-decoration: none;
        margin-left: 35%;
    }
    .foot{
        position: fixed;
    }
    table, th, td{
        border: 1px solid #000;
        border-collapse: collapse;
        padding: 1em 2em;
    }
    table tr{
        cursor: pointer;
    }
    table tr:nth-child(2n+1){
        background-color: #eee;
    }
    tr:hover td{
        background-color: #ccc;
    }
</style>
</head>
<body>
<form>
    <?php

    if(is_valid_pagination()){
        echo <<< _END
                <div class="student_data" style="
                    position: absolute;
                    margin-left:15em;
                    margin-top:0em;
                    background: white;
                    border-radius: 10px;
                    opacity: .85;  
                    transform: scale(0.70);
                ">
                <p class="super-box-title">Offered Courses</p>
                    <div class="row">
                        <table>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credits</th>
                                <th>Course Price</th>
                            </tr>
            _END;

            $result=mysqli_query($con,$query);
            while($row= mysqli_fetch_assoc($result) ){
                $price = number_format($row['course_price'], 2);
                $course_name = ucwords($row['course_name']);
                echo <<< _END
                    <tr>
                        <td> {$row['course_id']} </td>
                        <td> {$course_name} </td>
                        <td> {$row['credits']} </td>
                        <td> {$price} SAR </td>
                    </tr>
                _END;
            }
    }else{
        echo <<< _END
            <div class="student_data" style="
            position: absolute;
            margin-left:20em;
            margin-top:5em;
            background: white;
            border-radius: 10px;
            opacity: .85;  
            transform: scale(0.70);
            ">
            <p class="super-box-title">Offered Courses</p>
                <div class="row" style="
                    padding: 2em 10em;
                ">
                 <p style='color: crimson'>No data available</p>
        _END;

    }
                    

        ?>

        </table>

        </div>
   
        <div class="pagination" style="margin-top: -2em;">

            <?php
                if($pageNum <= 0){
                    echo <<< _END
                        <a href="view_offered_courses.php?page={$next_page}">
                            <i class="fa fa-arrow-left"></i>
                            Next
                        </a>
                    _END;
                } else if($pageNum > $courses_number['courses_number']/$row_per_page) {
                    echo <<< _END
                            <a href="view_offered_courses.php?page={$back_page}">
                                Back
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        _END;
                    
                } else if ($pageNum == 1){
                    echo <<< _END
                    <a href="view_offered_courses.php?page={$next_page}">
                        <i class="fa fa-arrow-left"></i>
                        Next
                    </a>
                _END;
                }
                else if ($pageNum == $courses_number['courses_number']/$row_per_page){
                    echo <<< _END
                            <a href="view_offered_courses.php?page={$back_page}">
                                Back
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        _END;
                }
                else {
                    echo <<< _END
                            <a href="view_offered_courses.php?page={$next_page}">
                                <i class="fa fa-arrow-left"></i>
                                Next
                            </a>
                            <a href="view_offered_courses.php?page={$back_page}" style='margin-left: 2em'>
                                Back
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        _END;
                }


            ?>
            

        </div>

        </div>

</form>
</body>
</html>