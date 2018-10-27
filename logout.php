<?php 
    ini_set('display', 1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);

    session_start();

    include('config.php');
    include('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
   
    <title>Login With Users</title>
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    <?php
        if(strcmp($_SESSION['uid'], "") == 0){
            echo "<center> You have to be logged in to use this feature</center>";
        }else{
            mysqli_query($link, "UPDATE `users` SET `online` = '".date('U')."' WHERE `id` = '".$_SESSION['uid']."'");

            session_destroy();
        }

        session_unset();
        header("Location: login.php");
    ?>
</body>
</html>