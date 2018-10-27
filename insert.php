<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include('config.php');

    $res = "INSERT INTO users(username, email, active) VALUES('Ahmad','ahmad@netlinks.af',1)";
    if($link->query($res) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $res . "<br>" . $link->error;
    }
?>