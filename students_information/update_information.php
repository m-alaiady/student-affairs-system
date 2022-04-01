<?php


include'template/t1.php';


if( !isset($_SESSION['student_id']))
{
    header("location:../index.php");
}

?>

<html>

<head>
   
    
    <title>SIS | Update Information</title>


</head>


<body>

    <div class="update">
    <form method="post">
        <label> Student ID: </label><br />
        <input type="text" value="<?php echo $data['student_id']; ?>" title="Cannot modified" disabled /><br />
        <label> National ID: </label><br />
        <input type="text" value="<?php echo $data['national_id']; ?>" title="Cannot modified" disabled /><br />
        <label> Student Name: </label><br />
        <input required type="text" name="s_name" value="<?php echo $data['s_name']; ?>" /><br />
        <label> Email: </label><br />
        <input required type="email" name="email" value="<?php echo $data['email']; ?>" /><br  /><br />
        <input type="submit" name="submit" value="Save" />
        <a href="../home.php">Go back to dashboard</a>
    </form>
    </div>

    <style>
        .update{
            position: absolute;
        margin-left:525px;
        margin-top:200px;
        background: white;
        border-radius: 10px;
        opacity: .85;
        padding: 20px; 
        }
    </style>





</body>


</html>
<?php 


// require_once '../connection.php';
$success ;

if(isset($_POST['submit'])){
    $query="update `students` set s_name = '" . $_POST['s_name'] . "', email = '". $_POST['email'] ."' where student_id = '" . $_SESSION['student_id'] . "' ";
    $result=mysqli_query($con,$query);
    // var_dump($query);

    if(mysqli_affected_rows($con))
    {
        echo "Information updated successfully";
        // after 2 second refresh the page (to view the new changes)
        header("Refresh:2");
    }


}






?>