<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function protect($string){
        $string = trim(htmlspecialchars(strip_tags($string)));
        return $string;
    }
?>