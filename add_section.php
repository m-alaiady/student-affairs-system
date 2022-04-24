<!-- this file from its name, it is to add section where the user can add section.
Relations between tables done here, sections, enrolled, and courses tables. when the user in register
page. It has the conditions that checks the user or student credit hours if it is 
less than or equal 20. It has the condition also when the student register course and 
it has prequestions. It has the condition when the user already registered the course. -->
<?php

session_start();
// it is to make sure that the current url is courses.php.
if( basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)) == "courses.php"){
    // include connection.php if the current url is courses.php.
    require_once("connection.php");


    // it is to get the ID from students table and make sure that student id equels the id with this session.
    $get_id = "select id from students where student_id = '" . $_SESSION['student_id'] . "' ";
    // this function is to perform a query against database.
    $get_id_result=mysqli_query($con,$get_id);
    // this function is to accept the result object.
    $student_id= mysqli_fetch_assoc($get_id_result);

    // this is to assign section id value from enrolled table and make sure student id is equal to $student id
    $get_sections_id = "SELECT  section_id FROM `enrolled` WHERE enrolled.student_id = '" . $student_id['id'] . "'";
    $get_sections_id_result = mysqli_query($con,$get_sections_id);

    // here is to get the credit value or registered from sections table and to join course id from courses table
    //  and create relation between courses IDs in courses and sections 
    $get_course_credit = "
        SELECT  time, credits
        FROM sections
        JOIN courses
            ON sections.course_id = courses.id
        JOIN courses_time
            ON sections.id = courses_time.section_id
        WHERE sections.id =  '" . $_GET['id'] . "'
        LIMIT 1
    ";

    $get_course_credit_result = mysqli_query($con,$get_course_credit);
    $course_credit= mysqli_fetch_assoc($get_course_credit_result);
    
    
    function intersectCheck($from, $from_compare, $to, $to_compare){
        $from = strtotime($from);
        $from_compare = strtotime($from_compare);
        $to = strtotime($to);
        $to_compare = strtotime($to_compare);

        $intersect = min($to, $to_compare) - max($from, $from_compare);
            if ( $intersect < 0 ) $intersect = 0;
            $overlap = $intersect / 3600;
            if ( $overlap <= 0 ):
                // There are no time conflicts
                return FALSE;
            else:
                // There is a time conflict
                // echo '<p>There is a time conflict where the times overlap by ' , $overlap , ' hours.</p>';
                return TRUE;
            endif;
    }

// here to insert the regstered course to enrolled table
    $add_section = "		
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

    // here is to sum the credits of the registered courses
    $credits_query = "
        SELECT  SUM(courses.credits) as credits
            FROM enrolled
            JOIN sections
                ON enrolled.section_id = sections.id
            JOIN courses
                ON sections.course_id = courses.id
            WHERE enrolled.student_id = '" . $student_id['id'] . "'
    ";

    $get_all_student_courses = "
        SELECT  enrolled.absences, courses.*, sections.id as section_id, courses_time.time, teachers.teacher_name
        FROM enrolled
        JOIN sections
            ON enrolled.section_id = sections.id
        JOIN courses
            ON sections.course_id = courses.id
        JOIN courses_time
            ON courses_time.id = sections.time_id
        JOIN teachers
            ON teachers.id = sections.tutor_id
        WHERE enrolled.student_id = '" . $student_id['id']  . "'";    

    $student_courses_result = mysqli_query($con,$get_all_student_courses);

    $credits_result = mysqli_query($con,$credits_query);

    $credits = mysqli_fetch_assoc($credits_result);

// here to check the credits and add it to the sum of the credit and check if they are less than or equels to 20 
    if($credits['credits'] + $course_credit['credits'] <= 20){
        while($section_id = mysqli_fetch_assoc($get_sections_id_result)){
            if($section_id['section_id'] == $_GET['id']){
                $already_enrolled = true;
            }

        }
        while($row = mysqli_fetch_assoc($student_courses_result)){
            $day_and_times = explode(' ', $row['time']);
            $given_dates = explode(' ',$course_credit['time']);

            $days = array();
            $times = array();

            $given_days = array();
            $given_times = array();

    
            // split time and day from string in the student's courses
            foreach ($day_and_times as $day_and_time) {
                if (DateTime::createFromFormat('H:i', $day_and_time) !== false) {
                    array_push($times, $day_and_time);
                } else {
                    array_push($days, $day_and_time);
                }
            }
            
            // split time and day from string in the given time
            foreach ($given_dates as $given_date) {
                if (DateTime::createFromFormat('H:i', $given_date) !== false) {
                    array_push($given_times, $given_date);
                } else {
                    array_push($given_days, $given_date);
                }
            }
            

            for($i = 0; $i < count($times); $i++){
                $end_time = date('H:i', strtotime('+50 minutes', strtotime($times[$i])) );
                $end_given_time = date('H:i', strtotime('+50 minutes', strtotime($given_times[0])) );
                $end_given_time_2 = date('H:i', strtotime('+50 minutes', strtotime($given_times[1])) );

                if(
                    $days[$i] == $given_days[0] && intersectCheck($times[$i], $given_times[0], $end_time, $end_given_time) ||
                    $days[$i] == $given_days[1] && intersectCheck($times[$i], $given_times[1], $end_time, $end_given_time_2) 
                ){
                    header('location: ' . $_SERVER['HTTP_REFERER'] . "#You have a time conflict flag2");
                    die;
                }
            }



        }        
        if($already_enrolled){
            // here if the course is enrolled already it will return to the same page 
            // with red notification saying section is already enrolled.
            header('location: ' . $_SERVER['HTTP_REFERER'] . "#section already enrolled flag2");
        }
        else if($_GET['id'] == 2){
            // if the course is has prequestions it will return to the same page with 
            // red notificaton saying you must register the prequestion.
            header('location: ' . $_SERVER['HTTP_REFERER'] . "#You must complete TM111 first flag2");
        }
        else{
            // if everything is good to register it will return to the same page
            // with green notification saying new section added.
            $add_section_result = mysqli_query($con,$add_section);
            $student_id= mysqli_fetch_assoc($get_id_result);
            header('location: ' . $_SERVER['HTTP_REFERER'] . "#New section added flag1");
        }
    }
    else{
        // if the student add course and the total of credits is more than 20
        // it will return to the same page with red notification saying 
        // you can not register more than 20CH
        header('location: ' . $_SERVER['HTTP_REFERER'] . "#You cannot register more than 20 CH flag2");
    }



    
}
else{
    header("location:registration/courses.php");
}
