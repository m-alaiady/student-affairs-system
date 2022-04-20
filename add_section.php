<?php

session_start();
if( basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) == "courses.php"){
    require_once("connection.php");

    $get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";
    $get_id_result=mysqli_query($con,$get_id);
    $student_id= mysqli_fetch_assoc($get_id_result);

    $get_sections_id = "SELECT  section_id FROM `enrolled` WHERE enrolled.student_id = '" . $student_id['id'] . "'";
    $get_sections_id_result = mysqli_query($con,$get_sections_id);

    $get_course_credit = "
        SELECT  credits
        FROM sections
        JOIN courses
            ON sections.course_id = courses.id
        WHERE sections.id =  '" . $_GET['id'] . "'
        LIMIT 1
    ";

    $get_course_credit_result = mysqli_query($con,$get_course_credit);
    $course_credit= mysqli_fetch_assoc($get_course_credit_result);
    

    $drop_section = "		
        INSERT
            INTO `enrolled`
            (student_id, section_id)
            VALUES(
                " . $student_id['id'] . ",
                " . $_GET['id'] . "
            );
    ;";
    
    // check if student already enrolled to section
    $already_enrolled = false;

    $credits_query = "
        SELECT  SUM(courses.credits) as credits
            FROM enrolled
            JOIN sections
                ON enrolled.section_id = sections.id
            JOIN courses
                ON sections.course_id = courses.id
            WHERE enrolled.student_id = '" . $student_id['id'] . "'
    ";

    $credits_result = mysqli_query($con,$credits_query);

    $credits = mysqli_fetch_assoc($credits_result);


    if($credits['credits'] + $course_credit['credits'] <= 20){
        while($section_id = mysqli_fetch_assoc($get_sections_id_result)){
            if($section_id['section_id'] == $_GET['id']){
                $already_enrolled = true;
            }
        }
    
        if($already_enrolled){
            header('location: ' . $_SERVER['HTTP_REFERER'] . "#section already enrolled flag2");
        }
        else if($_GET['id'] == 2){
            header('location: ' . $_SERVER['HTTP_REFERER'] . "#You must complete TM111 first flag2");
        }
        else{
            $drop_section_result = mysqli_query($con,$drop_section);
            $student_id= mysqli_fetch_assoc($get_id_result);
            header('location: ' . $_SERVER['HTTP_REFERER'] . "#New section added flag1");
        }
    }
    else{
        header('location: ' . $_SERVER['HTTP_REFERER'] . "#You cannot register more than 20 hrs");
    }



    
}
else{
    header("location:registration/courses.php");
}
