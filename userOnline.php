<?php 
    ini_set('display_errors',1);
    ini_set('display_startup_errors', 1);
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
        if(strcmp($_SESSION['uid'],"") == 0){
            echo "<center> You need to be logged in to use this feature!</center>";
        }else{
            $time = date('U') + 50;
            $udate = mysqli_query($link, "UPDATE `users` SET `online` '".$time."' WHERE `id` = '".$_SESSION['uid']."'");
    ?>
    <div id="border">
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
            <tr>
                <td><b>Users Online:</b>
                    <?php 
                        $res = mysqli_query($link, "SELECT * FROM `users` WHERE `online` > '".date('U')."'");
                            while($row = mysqli_fetch_assoc($res)){
                                echo $row['username']." - ";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><a href="logout.php">Logout</a></td>
            </tr>
        </table>
    </div> 
    <?php
    }
    ?>
</body>
</html>