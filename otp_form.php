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
    <script>
    $(document).ready(function() {
        $("#form1").validate({
            rules: {
                otp: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6
                }
            },
            messages: {
                otp: {
                    required: "Please enter the OTP",
                    digits: "Please enter a valid OTP",
                    minlength: "OTP must be 6 digits",
                    maxlength: "OTP must be 6 digits"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            }
        });
    });
</script>
</head>

<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5 mb-5">
        <div class="row">
            <h2 style="text-align:center">OTP Form</h2>
            <div class="col-md-4"></div>
            <div class="col-md-4 mt-3">
                <!-- otp form -->
                <form id="otp" method="post" onsubmit="return otpForm();" id="form1" style="align-contect:center">
                    <label for="name" class="form-label">Enter OTP :</label>
                    <input type="text" class="form-control" id="otptxt" name="otptxt"
                        placeholder="Enter OTP sent to your email">
                    <span id="otp_er"></span><br>
                    <div id="timer" class="text-danger"></div><br>
                    <button type="button" id="resend_otp" name="resend_otp" class="btn btn-dark"
                        style="display:none;">Resent OTP</button>
                    <script>
                        let timeLeft = 60; // 1 minute timer
                        const timerDisplay = document.getElementById('timer');
                        const resendButton = document.getElementById('resend_otp');

                        // Function to start the countdown
                        function startCountdown() {
                            const countdown = setInterval(() => {
                                if (timeLeft <= 0) {
                                    clearInterval(countdown);
                                    timerDisplay.innerHTML = "You can now resend the OTP.";
                                    resendButton.style.display = "inline";
                                    timeLeft = 60;
                                } else {
                                    timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                                }
                                timeLeft -= 1;
                            }, 1000);
                        }

                        // Check if there's a remaining time in sessionStorage
                        if (sessionStorage.getItem('otpTimer')) {
                            timeLeft = parseInt(sessionStorage.getItem('otpTimer'));
                            startCountdown();
                        } else {
                            startCountdown();
                        }

                        // Update sessionStorage every second
                        setInterval(() => {
                            sessionStorage.setItem('otpTimer', timeLeft);
                        }, 1000);

                        resendButton.onclick = function (event) {
                            event.preventDefault(); // Prevent the default form submission
                            window.location.href = 'resend_otp_forgot_password.php';
                        };
                    </script>
                    <button type="submit" name="otp_btn" id="otp_btn" class="btn btn-dark">Submit</button>
                </form>
                <!-- otp form -->
                <div class="col-md-12">
                    <br><a href="register.php">Don't have an account?Register here!</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function otpForm(){
            validate =true;
            ZipValidate(document.getElementById('otptxt'), document.getElementById('otp_er'));
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

    // to chek if otp is valid or not
    if (isset($_POST['otp_btn'])) {
        if (isset($_SESSION['forgot_email'])) {
            $email = $_SESSION['forgot_email'];
            $otp = $_POST['otptxt'];
            // echo $otp;
            // Fetch the OTP from the database for the given email
            $query = "SELECT Otp FROM password_token_tbl WHERE Email = '$email' ";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $db_otp = $row['Otp'];
                echo $row['Otp'];

                // Compare the OTPs
                if ($otp == $db_otp) {
                    // Redirect to new password page
                    ?>
                    <script>
                        window.location.href = 'new_password_form.php';
                    </script>
                    <?php

                } else {
                    setcookie('error', 'Incorrect OTP', time() + 5, '/');
                    ?>
                    <script>
                        window.location.href = 'otp_form.php';
                    </script>
                    <?php
                }
            } else {
                setcookie('error', 'OTP has expired. Regenerate New OTP', time() + 2, '/');
                ?>
                <script>
                    window.location.href = 'Forgot_password.php';
                </script>
                <?php
            }
        }
    }
    ?>
</body>

</html>