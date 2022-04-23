<!-- here in this php file, it is to drop registered section -->
<?php

session_start();
// it is to make sure that the current url is courses.php.
if( basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH))  == "courses.php"){
    // include connection.php if the current url is courses.php.
    require_once("connection.php");

    // it is to get the ID from students table and make sure that student id equels the id with this session.
    $get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";
    
    // this function is to perform a query against database.
    $get_id_result=mysqli_query($con,$get_id);
    // this function is to accept the result object.
    $student_id= mysqli_fetch_assoc($get_id_result);
    
    // in this function, it is to delete the course from enrolled table
    $drop_section = "		
        DELETE 
            FROM `enrolled`
            WHERE 
                student_id = " . $student_id['id'] . " 
                AND
                section_id = " . $_GET['id'] . ";
    ;";
    
    $drop_section_result = mysqli_query($con,$drop_section);
    $student_id= mysqli_fetch_assoc($get_id_result);
    
    // it is to return to the same page with green notification saying
    // section removed.
    header('location: ' . $_SERVER['HTTP_REFERER'] . "#section removed flag1");

    
}
else{
    header("location:registration/courses.php");
}
