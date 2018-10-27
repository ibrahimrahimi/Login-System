<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $link = mysqli_connect("localhost","root", "imihar 2020", "loginTut");
    if($link->connect_error){
        die("Connection failed:".$link->connect_error);
    }     
?>