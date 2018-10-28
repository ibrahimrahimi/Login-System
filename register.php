<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    /* Include the Composer generated autoload.php file. */
    require 'vendor/autoload.php';

    $mail = new PHPMailer(TRUE);

    error_reporting(E_ALL);

    session_start();

    include('config.php');

    include('functions.php');
    $message = '';
    $text = '';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login With Users</title>
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="script.js"></script>
</head>
<body>
    <?php 
        //Check to see if the form is submitted
        if(isset($_POST['submit'])){
            $username = protect($_POST['username']);
            $password = protect($_POST['password']);
            $passconf = protect($_POST['passconf']);
            $email = protect($_POST['email']);

            //Check if any of the boxes were not empty
            if(!$username || !$password || !$passconf || !$email){
                $message = "<center>You need to fill all the required fields in the form!</center>";
            }else{
                if(strlen($username) > 32 || strlen($username) < 3 ){
                    $message = "<center>Your <b>Username</b> should be between 3 and 32 character long!</center>";
                }else{
                    $res = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '".$username."'");

                    $num = mysqli_num_rows($res);

                    if($num == 1){
                        $message = "<center>The <b>Username</b> you have choien is already taken!</center>";
                    }else{
                        if(strlen($password) < 5 || strlen($password) > 32){
                            $message = "<center> Your <b>Password</b> should be between 5 and 32 characters!</center>";
                        }else{
                            if($password != $passconf){
                                $message = "<center>The <b>Password you supplied did not match the confirmation password!</center>";
                            }else{
                                $checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
                                if(!preg_match($checkemail, $email)){
                                    $message = "<center>The <b>Email</b> is not valid, must be name@server.ltd!</center>";
                                }else{
                                    $res1 = mysqli_query($link, "SELECT * FROM `users` WHERE `email` = '".$email."'");
                                    $num1 = mysqli_num_rows($res1);
                                    if($num1 == 1){
                                        $message = "<center>The <b>Email</b> address you supplied is already taken</center>";
                                    }else{
                                        $registerTime = date('U');
                                        $online = date('U')+60;
                                        $active = 0;
                                        $code = md5($username).$registerTime;
                                        
                                        $res2 = "INSERT INTO users(username,password,online,email,active,rtime) 
                                        VALUES('".$username."','".md5($password)."','".$online."','".$email."','"
                                        .$active."','".$registerTime."')";
                                        if($link->query($res2) === TRUE){

                                            try{
                                                //Set the mail sender
                                                $mail->setFrom('noreply@google.co.uk', 'System Admin');
                                                //Set the mail reciever                                                 
                                                $mail->addAddress($email, $username);
                                                //Set mail subject
                                                $mail->Subject = 'Registration Confirmation';
                                                //Set mail body
                                                $mail->Body = 'Thank you for registration to us '.$username.',Here is your activation link.
                                                if the link does not work copy and paste it into your browser address bar.
                                                 http://localhost/project/login/activate.php?code='.$code.'';

                                                $mail->isSMTP();

                                                $mail->Host = 'smtp.gmail.com';

                                                $mail->SMTPAuth = TRUE;

                                                $mail->SMTPSecure = 'tls';

                                                $mail->Username = 'ebrahimrahimilaziri@gmail.com';

                                                $mail->Password = 'imihar 2020';

                                                $mail->Port = '587';    

                                                //finally send the mail
                                                $mail->send();
                                            }
                                            catch(Exception $e)
                                            {
                                                echo $e->errorMessage();
                                            }
                                            catch(\Exception $e){
                                                echo $e->getMessage();
                                            }
                                            $text = "<center>You have successfully registered, please visit your inbox to activate your acount!</center>";
                                        }else {
                                            echo "Error: " . $res2 . "<br>" . $link->error;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
    ?>

    <div class="warring">
        <?php if ($message) {?><h3 style="color: red;"><?= $message ?></h3><?php } ?>
        <?php if($text) {?><h3 style="color: green;"><?= $text ?></h3><?php } ?>
    </div>    
    <div class="login" id="register">
        <form method="post" action="register.php">
            <table cellpadding="2" cellspacing="0" border="0">
                <tr>
                    <td align="center">
                        <h1>Register Users</h1
                    </td>
                </tr>
                <tr>
                    <td><input placeholder="Username" type="text" name="username" id="register" /></td>
                </tr>
                <tr>
                    <td><input placeholder="Password" type="password" name="password" class="password"></td>
                </tr>
                <tr>
                    <td><input placeholder="Confirm Password" type="password" name="passconf" class="password"></td>
                </tr>
                <tr>
                    <td><input placeholder="E-mail" type="text" name="email"></td>
                </tr>
                <tr>
                    <td id="tdShow"><input type="checkbox" onclick="showPass()"/><lable id="showpass">Show Password</lable></td>
                    <td align="left"><input type="submit" name="submit" value="Rigester" id="submit"/></td> 
                </tr>
                <tr>
                    <td colspan="2" align="center" ><a href="login.php" class="link">Login</a> | <a href="forgot.php" class="link">Forgot Pass</a></a></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="shadow"></div>
</body>
</html>