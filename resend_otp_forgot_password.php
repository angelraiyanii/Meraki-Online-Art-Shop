<?php
include_once("header.php");
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>


<?php

include_once "footer.php";

if (isset($_SESSION['forgot_email'])) {
    $email = $_SESSION['forgot_email'];

    // Check if the email is registered in the registration table
    $check_query = "SELECT * FROM user_tbl WHERE U_Email = '$email'";
    $check_result = mysqli_query($con, $check_query);

    if ($check_result && mysqli_num_rows($check_result) == 0) {
        // Email is not registered, display error message
        setcookie('error', "This email is not registered.", time() + 5, "/");
        ?>
        <script>
            window.location.href = "Forgot_password.php";
        </script>
        <?php
        exit; // Stop further execution
    }

    // Check if the email already exists in the password_token table
    $query = "SELECT * FROM password_token_tbl WHERE Email = '$email'";
    $result = mysqli_query($con, $query);


    if ($result && mysqli_num_rows(result: $result) > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $email_time = date("Y-m-d H:i:s");
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 minutes')); 

        $update_query = "UPDATE password_token_tbl SET Otp = '$otp', Created_at = '$email_time', Expires_at = '$expiry_time' WHERE Email = '$email'";
        mysqli_query($con, $update_query);

        // Use PHPMailer to send the OTP
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'veloraa1920@gmail.com'; // SMTP username
            $mail->Password = 'rtep efdy gepi yrqj'; // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('veloraa1920@gmail.com', 'Veloraa');
            $mail->addAddress($email, 'Password reset');


            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; }
                h1 { color: black; }
                .otp { font-size: 24px; font-weight: bold; color: #007bff; }
                .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Forgot Your Password?</h1>
                <p>We received a request to reset your password. Here is your One-Time Password (OTP):</p>
                <p class='otp'>$otp</p>
                <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                <p>If you did not request a password reset, please ignore this email.</p>
                <div class='footer'>
                    <p>This is an automated message, please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";

            $mail->send();

            // Set success message and redirect to OTP form
            setcookie('success', "OTP for resetting your password is sent to the registered mail address", time() + 2, "/");
            ?>
            <script>
                window.location.href = "otp_form.php";
            </script>
            <?php
            exit;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email does not exist, display error message and redirect to Forgot password form
        setcookie('error', "An OTP has already been sent to this email. New OTP will be generated once current OTP expires.", time() + 5, "/");
        ?>
        <script>
            window.location.href = "Forgot_password.php";
        </script>
        <?php
        exit;
    }
}
?>