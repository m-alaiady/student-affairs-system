<!-- here is the code of the logout button -->
<?php 
    session_start();
    if(isset($_GET['logout']))
    {
        session_destroy();
        header("location:index.php");
    }

?>