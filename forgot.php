<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    /* Include the Composer generated autoload.php file. */
    require 'vendor/autoload.php';
    $mail = new PHPMailer();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
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
    <link rel="stylesheet" type="text/css"  href="style.css" />
</head>
<body>
    <?php 
        if(isset($_POST['submit'])){
            $email = protect($_POST['email']);
            if(!$email){
                $message = "<center> You need to fill in your <b>E-mail</b> address! </center>";
            }else{
                $checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";

                if(!preg_match($checkemail, $email)){
                    $message = "<center> <br>E-mail</b> is not valid, must be name@server.tld!";
                }else{

                    $res = mysqli_query($link, "SELECT * FROM `users` WHERE `email` = '".$email."'");
                    $num = mysqli_num_rows($res);

                    if($num == 0){
                        $message = "<center> The <b>E-mail</b> you supplied does not exist in database!</center>";
                    }else{
                        $row = mysqli_fetch_assoc($res);
                        if($row){
                            try{
                                //Set mail sender 
                                $mail->setFrom('noreply@google.co.uk', 'System Admin');
                                //Set reciever 
                                $mail->addAddress($email);
                                //Set E-mail subject
                                $mail->Subject = 'Forgetten Password';
                                //Set E-mail body
                                $mail->Body = 'Here is your password: '.$row['password'].' Please try not too lose it agian!';

                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmial.com';
                                $mail->SMTPAuth = TRUE;
                                $mail->SMTPSecure = 'tls';
                                $mail->Username = 'ebrahimrahimilaziri@gmail.com';
                                $mail->Password = 'imihar 2020';
                                $mail->Port = '587';

                                $mail->send();

                                $text = "<center> An e-mail has been sent to your email address containing your password.</center>";

                            }catch(Exception $e){
                                echo $e->errorMessage();
                            }catch(\Exception $e){
                                echo $e->getMessage();
                            }
                        }
                    }
                }
            }
        }
    ?>
    <div class="warring">
        <?php if($message) {?><h3 style="color: red;"><?= $message ?></h3><?php } ?>
        <?php if($text) {?><h3 style="color: green;"><?= $text ?></h3><?php } ?>
    </div>    
    </div>
    <div class="login" id = "forgotForm">
        <form action="forgot.php" method="post">
            <table cellpadding="2" cellspacing="0" border="0">
                <tr>
                    <td align="center">
                        <h1>Forgot Password</h1>
                    </td>
                </tr>
                <tr>
                    <td><input placeholder="E-mail" type="text" name="email"/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Send" id="send"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><a href="register.php" class="link">Register</a> | <a href="login.php" class="link">Login</a></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="shadow"></div>
</body>
</html>