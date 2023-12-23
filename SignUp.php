<?php

session_start();
include('config.php');


// imports three PHP classes from the PHPMailer library
//The PHPMailer class is used to send email messages from a PHP application

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
//we can make use of the classes and functions provided by the packages installed via Composer, without having to manually include the class files.
require 'vendor/autoload.php';

$msg = "";
$Error_Pass = "";

if (isset($_POST['submit'])) {
    // Validating the CAPTCHA
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha = $_POST['g-recaptcha-response'];
        if (!$recaptcha) {
            echo '<script>alert("Please validate the CAPTCHA.")</script>';
            exit;
        } else {
            $secret = "enter your secret key provided by google reCaptcha";
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $recaptcha;
            $response = file_get_contents($url);

            $responseKeys = json_decode($response, true);
            if ($responseKeys['success']) {
                // CAPTCHA validation successful
            } else {
                echo 'You are a Robot!!!';

                exit;
            }
        }
    } else {
        $msg= '<script>alert("Please validate the CAPTCHA.")</script>';
        exit;
    }
    $msg="";

    // Sanitize user input
    $name = mysqli_real_escape_string($conx, $_POST['Username']);
    $email = mysqli_real_escape_string($conx, $_POST['Email']);
    $password = mysqli_real_escape_string($conx, md5($_POST['Password']));
    $confirm_password = mysqli_real_escape_string($conx, md5($_POST['Conf-Password']));
    $code = mysqli_real_escape_string($conx, md5(rand()));

    // Check if email already exists
    $existing_user_query = "SELECT * FROM register WHERE email='{$email}'";
    $existing_user_result = mysqli_query($conx, $existing_user_query);
    if (mysqli_num_rows($existing_user_result) > 0) {
        $msg = "<div class='alert alert-danger'>This email '{$email}' already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            // Insert new user into the database
            $insert_user_query = "INSERT INTO register (`Username`, `email`, `Password`, `CodeV`) VALUES ('$name', '$email', '$password', '$code')";
            $insert_user_result = mysqli_query($conx, $insert_user_query);
            if ($insert_user_result) {
                // Send verification email
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'enter your email';                     //SMTP username
                    $mail->Password   = 'enter your app password';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                //TCP port to connect to; use 587 if you have
                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    //Recipients
                    $mail->setFrom('enter your email','enter your name');
                    $mail->addAddress($email,$name);
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Welcome To My Website';
                    $mail->Body = '<p> This is the Verification Link<b>
                    <a href="http://localhost/Bishok_Paudel/?Verification='. $code . '">http://localhost/Bishok_Paudel/?Verification=' . $code . '</a></b></p>';
                    $mail->send();                    
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $msg = "<div class='alert alert-info'>Please, Check your Mail!! We've send a verification code on Your email Address</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something was Wrong</div>";
                
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password is not match</div>";
            $Error_Pass='style="border:1px Solid red;box-shadow:0px 1px 11px 0px red"';
        }
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Sign_up_Form</title>
    <style>
        .alert {
            padding: 1rem;
            border-radius: 5px;
            color: white;
            margin: 1rem 0;
            font-weight: 500;
            width: 65%;
        }

        .alert-success {
            background-color: #42ba96;
        }

        .alert-danger {
            background-color: #fc5555;
        }

        .alert-info {
            background-color: #2E9AFE;
        }

        .alert-warning {
            background-color: #ff9966;
        }
    </style>
    <script>
        function onLoadCallback(){
        grecaptcha.render('divRecaptcha', {
            sitekey: '6Lce8WUlAAAAAEuTUs-Mdn8XPeyZLge3c_Xy0N5W',
            /callback: successCallback,
        });
    }
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onLoadCallback&renser=explict" async defer></script>
</head>

<body>
    
    <div class="container sign-up-mode">
       
        <div class="forms-container">
            <div class="signin-signup">
                    <script>
                        function onSubmit(token) {
                         document.getElementById("myForm").submit();
                        }
                    </script>   
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i>
                        <span class="input-group-append">      
                        <img src="img/profile.png" style="width: 25px; height: 25px; margin-top: 15px;">                               
                        </span>
                        </i>
                        <input type="text" name="Username" placeholder="Username" value="<?php
                         if (isset($_POST['Username'])) {echo $name;} 
                         ?>" />
                    </div>
                    <div class="input-field">
                        <i>
                        <span class="input-group-append">
                                    <img src="img/mail.png" style="width: 25px; height: 25px; margin-top: 15px;">
                            </span>
                        </i>
                            <input type="email" name="Email" placeholder="Email" value="<?php
                         if (isset($_POST['Email'])) {echo $email;} ?>" />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass?>>
                        <i>
                            <span class="input-group-append">
                            <img src="img/eye-close.png" alt="toggle password visibility" onclick="togglePasswordVisibility()"
                             style="width: 25px; height: 20px; margin-top: 15px; cursor: pointer;">                                     
                            </span>
                        </i>
                        <input id= "password" type="password" name="Password" placeholder="Password" />
                        <div id="password-strength"></div>
                    </div>
                    <div class="input-field" <?php echo $Error_Pass?>>
                    <i>
                        <span class="input-group-append">      
                            <img src="img/eye-close.png" alt="toggle password visibility 1" onclick="togglePasswordVisibility1()"
                             style="width: 25px; height: 20px; margin-top: 15px; cursor: pointer;">  
                            </span>
                    </i>
                        <input class="" id = "cpassword" type="password" name="Conf-Password" placeholder="Confirm Password" />
                    </div>
                    <div id="divRecaptcha"class="g-recaptcha" data-sitekey="enter your sitekey provided by google reCaptha"></div>
                    <input type="submit" name="submit" class="btn"onclick="return validateCaptcha()" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                  
                </form>
                <script src="script.js"></script>
               
            </div>
        </div>

        <div class="panels-container">
            
            <div class="panel left-panel">
                
            </div>
            <div class="panel right-panel">
            <h1 style='margin-right:150px';>Fun Olympics 2023</h1>
            <img src="img/olympic.png" style="margin: -70px 0 -110px 0;" class="image" alt="" />
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>
                        Already a member? Click here to Sign In.
                    </p>
                    <a href="index.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">Sign in</a>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    
   
</body>
</html>
