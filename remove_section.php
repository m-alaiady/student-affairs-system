<?php

session_start();

if( basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH))  == "courses.php"){
    require_once("connection.php");

    $get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";
    
    $get_id_result=mysqli_query($con,$get_id);
    $student_id= mysqli_fetch_assoc($get_id_result);
    
    
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

    header('location: ' . $_SERVER['HTTP_REFERER'] . "#section removed");

    
}
else{
    header("location:registration/courses.php");
}
