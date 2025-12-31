<?php

include('./dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function sendemail_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
         $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'user@example.com';                     //SMTP username
        $mail->Password   = 'secret';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('from@example.com', $name);
        $mail->addAddress('joe@example.net', $email);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'email verification from oursite ';
       $email_template ="
       <h2>Great you have registerd with us</h2>
       <h5> using the link below to verify </h5>
        <br/><br/>
        <a href='http://localhost/Regestration_system/verify-email.php?token=$verify_token'>Click Me </a>
       ";
       
        $mail->Body    = $email_template;

        $mail->send();
        echo 'Message has been sent';
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    
}


if(isset($_POST['register_btn'])){
    $name = $_POST['name']; 
    $name = $_POST['phone']; 
    $name = $_POST['email']; 
    $name = $_POST['password'];
    $verify_token = md5(rand()); 

    sendemail_verify("$name","$email","$verify_token");
echo "Sent or not ";


    //Emails checking
    // $check_email_query = "SELECT email FROM users where email = '$email' LIMIT 1  ";
    // $check_email_query_run = mysqli_query($con,$check_email_query);
    // if (mysqli_num_rows($check_email_query_run)> 0) {
    //     $_SESSION['status']= "Email id already exist";
    //     header("Location:register.php");
    // }
    // else{
        
    //     $query = "INSERT INTO users (name,phone,email,password,verify_token) VALUES ('$name','$phone','$email','$password','$verify_token')";
    //     $query_run = mysqli_query($con,$query);

    //     if ($query_run) {
    //         sendemail_verify("$name","$email","$verify_token");

    //         $_SESSION['status']= "Registration Succsess please Verify your Email address";
    //         header("Location:register.php");
    //     }
    //     else{
    //          $_SESSION['status']= "Registration Failed";
    //          header("Location:register.php");

    //     }
    // }
}
