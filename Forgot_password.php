<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="validation.js"></script>
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/jquery.validate.js"></script>
  <script src="js/additional-methods.js"></script>

  <?php
  include 'Header.php';

  require 'PHPMailer/Exception.php';
  require 'PHPMailer/PHPMailer.php';
  require 'PHPMailer/SMTP.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  ?>
</head>

<body class="bg-dark">
  <div class="container-fluid bgcolor mt-5 mb-5">
    <div class="row">
      <h2 style="text-align:center">Forgot Password</h2>
      <div class="col-md-4"></div>
      <div class="col-md-4 mt-3">
        <!-- forgot password -->
        <form id="forgot" method="post" onsubmit="return forgotEmail()" style="align-contect:center">
          <label for="name" class="form-label">Email :</label>
          <input type="text" class="form-control" id="femail" name="femail" placeholder="Enter Email">
          <span id="femail_er"></span><br>
          <button type="submit" name="frgt_pwd_btn" class="btn btn-dark">Send OTP</button>
        </form>
        <!-- forgot password -->
        <div class="col-md-12">
          <br><a href="register.php">Don't have an account?Register here!</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    function forgotEmail() {
      validate = true;
      EmailValidate(document.getElementById('femail'), document.getElementById('femail_er'));
      if (validate) {
        return true;
      }
      return false;
    }
  </script>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

  <?php
  include 'Footer.php';
  // when user enters email in forgot password form
  if (isset($_POST['frgt_pwd_btn'])) {
    $email = $_POST['femail'];
    $check_query = "SELECT * FROM user_tbl WHERE U_Email = '$email'";
    echo $check_query;
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
      $query = "SELECT * FROM password_token_tbl WHERE Email = '$email'";
      $result = mysqli_query($con, $query);
      if (mysqli_num_rows($result) > 0) {
        setcookie('error', "OTP is already sent to email address. new otp will be generated after old OTP expires.", time() + 5, "/");
        ?>
        <script>
          window.location.href = "otp_form.php";
        </script>
        <?php
        exit;
      } else {
        $otp = rand(100000, 999999);

        // Use PHPMailer to send the OTP
        $mail = new PHPMailer(true);
        try {
          //Server settings
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
          $mail->Subject = 'OTP for Password Reset';
          $mail->Body = "<p>Your OTP for password reset is: $otp</p>";

          $mail->send();

          // Store the email, OTP, and timestamps in the database
          $email_time = date("Y-m-d H:i:s");
          $expiry_time = date("Y-m-d H:i:s", strtotime('+1 minutes')); // OTP valid for 10 minutes
          $query = "INSERT INTO  password_token_tbl  (Email, Otp, Created_at, Expires_at) VALUES ('$email', '$otp', '$email_time', '$expiry_time')";
          mysqli_query($con, $query);

          $_SESSION['forgot_email'] = $email;
          setcookie('success', "OTP for resetting your password is sent to the registered mail address", time() + 2, "/")
            ?>
          <script>
            window.location.href = "otp_form.php";
          </script>
          <?php
          exit;
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          setcookie('error', $mail->ErrorInfo, time() + 2, "/");
          ?>
          <script>
            window.location.href = "Forgot_password.php ";
          </script>
          <?php
        }
      }
    } else {
      setcookie('error', "Email is not registered", time() + 5, "/");
      ?>
      <script>
        window.location.href = "Forgot_password.php";
      </script>
      <?php
    }
  }
  ?>
</body>

</html>