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
            <h2 style="text-align:center">Change Password</h2>
            <div class="col-md-4"></div>
            <div class="col-md-4 mt-3">
                <!-- new pwd form -->
                <form id="changePwd" method="post" onsubmit="return newPwdForm()" enctype="multipart/form-data">
                    <label for="name" class="form-label">New Password :</label>
                    <input type="text" class="form-control" id="newPwd" name="newPwd" placeholder="Enter New password">
                    <span id="NPwdError"></span>
                    <br>
                    <label for="name" class="form-label">Confirm Password :</label>
                    <input type="text" class="form-control" id="coPwd" name="coPwd" placeholder="Re-enter new password">
                    <span id="CPwdError"></span><br>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <button class="col-md-6 btn btn-dark" type="submit" name="changepwdbtn" class="btn btn-dark">Change</button>
                        <div class="col-md-3"></div>
                    </div>
                </form>
                <!-- new pwd form -->
            </div>
        </div>
    </div>

    <script>
        function newPwdForm(){
            validate=true;
            PwdValidate(document.getElementById('newPwd'), document.getElementById('NPwdError'));
            CommanValidate(document.getElementById('coPwd'),document.getElementById('CPwdError'));

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

    if (isset($_POST['changepwdbtn'])) 
    {
        if (isset($_SESSION['forgot_email']))
         {
            $email = $_SESSION['forgot_email'];
            $newPwd = $_POST['newPwd'];
    
    
            // Update the user's password in the users table (assuming the table is named 'users')
            $update_query = "UPDATE user_tbl SET U_Pwd = '$newPwd' WHERE U_Email = '$email'";
            if (mysqli_query($con, $update_query)) {
                // Delete the token from the password_token table
                $delete_query = "DELETE FROM password_token_tbl WHERE email = '$email'";
                mysqli_query($con, $delete_query);
                unset($_SESSION['forgot_email']);
    
                setcookie('success', 'Password has been reset successfully.', time() + 5, '/');
    ?>
    
                <script>
                    window.location.href = 'Login.php';
                </script>
            <?php
    
            } else {
                setcookie('error', 'Error in resetting Password.', time() + 5, '/');
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