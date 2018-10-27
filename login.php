<?php 
    ini_set('display_errors', 1);
    ini_set('dislplay_startup_errors', 1);
    error_reporting(E_ALL);
  
    //allow sessions to be passed so we can see if the user is logged in
    session_start();
    ob_start();
    //connect to the database so we can check,edit or insert data to our user table.
    include('config.php');
    //Include out functions file giving us access to the protect() function made earlier
    include('functions.php');

?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login With Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="style.css" />
    <script src="main.js"></script>
</head>
<body>
 <?php 
        // If the user submitted the form
        if(isset($_POST['submit'])){
           //Protect the posted values then assign them to variables 
           $username = protect($_POST['username']);
           $password = protect($_POST['password']);
           //Check if the username or password boxes were not filled in
           if(!$username || !$password){
               //If not display an error message.
               echo "<center> You need to fil in a <b> Username</b> and <b> Password</b>!</center>";
           }else{
               // If there was a match continue checking

               //select all rows where the username and password match the ones submitted by user.
               $res = mysqli_query($link,"SELECT * FROM `users` WHERE `username` = '".$username."'");
               $num = mysqli_num_rows($res);
               // Check if there was not any match
               if($num == 0){
                    //If not display en error message
                    echo "<center> The <b> Username</b> you suplied does not exist!</center>";
               }else{
                   //If there was continue checking
                   //select all rows where the username and password match the ones submitted by the user
                   $res = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '".$username."' AND `password` = '".md5($password)."'");
                   
                   $num = mysqli_num_rows($res);

                   //check if there was not a match
                   if($num == 0){
                       //if not display error
                       echo "<center>The <b>Password</b> you suplied does not match the one for that username!</center>";
                   }else{
                       //If there was continue 
                       //split all fields from the correct row into an associative array.
                       $row = mysqli_fetch_assoc($res);
                       //check to see if the user has not activated their account yet.
                       if($row['active'] != 1){
                           //If not display error message
                           echo "<center> You have not yet <b> activated</b> your account</center>";
                        }else{

                            //If they have log them in
                            //set the login session sorting id - we use this to see if theya are logged in or not.
                            $_SESSION['uid'] = $row['id'];

                            //show message
                            echo "<center> You have successfully logged in!</center>";

                            //update the online field up to 50 seconds into the future

                            $time = date('U') + 50;
                            mysqli_query($link, "UPDATE `users` SET `online` = '".$time."'WHERE `id` = '".$_SESSION['uid']."'");
                            //redirect them to useronline page
                            header('Location:userOnline.php');
                        }
                    }
                }
            }            
        }
    ?> 
    <form method="post" action="login.php">
        <div class="login" id="login">
            <table>
                <tr>
                    <td align="center">
                        <h1> Login </h1>
                    </td>
                </tr>
                <tr>
                    <td><input placeholder="Username" type="text" name="username"/></td>
                </tr>
                <tr>
                    <td><input placeholder="Password" type="password" name="password"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" 
                    name="submit" value="login"/></td>
                </tr>
                <tr>
                <td colspan="2" align="center"><a href="register.php">Resigter</a> |
                 <a href="forgot.php">Forget Pass</a></td>
                </tr>
            </table>
        </div>
    </form>      
</body>
</html>
<?php 
    ob_end_flush();
?>