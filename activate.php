<?php
    session_start();

    include('config.php');

    include('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login With Users</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<?php 
    $code = protect($_GET['code']); 

    if(!$code){
        echo "<center> Unfortunatly there was an error there!";
    }else{
        $res = mysqli_query($link, "SELECT * FROM `users` WHERE `active` = '0'");
        while($row = mysqli_fetch_assoc($res)){
            if($code == md5($row['username']).$row['rtime']){
            $res1 = mysqli_query($link, "UPDATE `users` SET `active` = '1' WHERE `id` = '".$row['id']."'");
            echo "<center> You have successfully activate your acount!";
            }    
        }
    }
?>
    
</body>
</html>