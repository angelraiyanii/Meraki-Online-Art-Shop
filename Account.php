<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    include 'Header.php';
    if (!isset($_SESSION['U_Admin']) && !isset($_SESSION['U_User'])) {
        header("Location: index.php");
        exit();
    }
    $email=isset($_SESSION['U_User'])?$_SESSION['U_User']:$_SESSION['U_Admin'];    
    $query = "select * from user_tbl where U_Email='$email'";
    $result = mysqli_query($con, $query);
    $r = mysqli_fetch_assoc($result);
    ?>
</head>

<body class="bg-dark">
    <div class="container-fluid mt-5 bgcolor">
        <div class="row">
            <h2>Hello, <?php echo $r['U_Fnm']; ?></h2>
            <!-- Left Column -->
            <div class="col-md-4">
                <p class="price"></p>
                <div class="product-image">
                    <img src="db_img/user_img/<?php echo $r['U_Profile']; ?>" alt="User Image"
                        class="img-fluid rounded">
                </div>
                <div class="buttons mt-3">
                    <a href="wishlist.php?<?php echo $r['U_Id'] ?>"><button class="btn btn-dark w-100 mb-2">See Wishlist</button></a>
                    <a href="cart.php?<?php echo $r['U_Id'] ?>"><button class="btn btn-dark w-100 mb-2">See Cart</button></a>
                    <a href="orderhistory.php?<?php echo $r['U_Id'] ?>"><button class="btn btn-dark w-100">Order History</button></a>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-8">
                <!-- <h3 class="mb-5">Account Information</h3> -->
                <div class="product-image-large">
                    <!-- user Information -->
                    <div id="info">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">First Name :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_Fnm']; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Last Name :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_Lnm']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Email :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_Email']; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Phone No. :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_Phn']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Address :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_Add']; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">City :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_City']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">State :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_State']; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Zip Code :</label>
                                <p style="font-weight: bold;"><?php echo $r['U_Zip']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button type="submit" onclick="asd(1)" class="cirbutton"
                                    style="font-weight: bold;">Update Info</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="submit" onclick="asd(2)" class="cirbutton"
                                    style="font-weight: bold;">Change Password</button>
                            </div>
                        </div>
                    </div>
                    <!-- update information -->
                    <form id="update" method="post" onsubmit="return upd()" enctype="multipart/form-data" style="display:none !important;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">First Name :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_Fnm'] ?>" id="fnm"
                                    name="fnm" placeholder="Enter First Name">
                                <span id="fnm_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Last Name :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_Lnm'] ?>" id="lnm"
                                    name="lnm" placeholder="Enter Last Name">
                                <span id="lnm_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Email :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_Email'] ?>" id="email"
                                    name="email" placeholder="Enter Email" readonly>
                                <span id="email_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Phone No. :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_Phn'] ?>" id="phn"
                                    name="phn" placeholder="Enter Mobile No.">
                                <span id="phn_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Address :</label>
                                <textarea class="form-control" id="add" name="add"
                                    placeholder="Enter your full address"><?php echo $r['U_Add'] ?></textarea>
                                <span id="add_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">City :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_City'] ?>" id="city"
                                    name="city" placeholder="Enter City">
                                <span id="city_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">State :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_State'] ?>" id="state"
                                    name="state" placeholder="Enter State">
                                <span id="state_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Zip Code :</label>
                                <input type="text" class="form-control" value="<?php echo $r['U_Zip'] ?>" id="zip"
                                    name="zip" placeholder="Enter Zip code">
                                <span id="zip_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Profile Image :</label>
                                <input type="file" class="form-control" id="img" name="img">
                                <span id="img_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                            </div>
                            <div class="col-md-3 mb-3" style="align-content: end;">
                                <a href="Account.php"><button type="submit" onclick="asd(3)" class="btn btn-dark"><i
                                            class="fa fa-times"></i></button></a>
                                <button type="submit" id="updatebtn" name="updatebtn" class="btn btn-dark"><i
                                        class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- change password -->
                    <form id="changePwd" onsubmit="return Pwdch()" method="post" enctype="multipart/form-data" style="display:none !important;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Old Password :</label>
                                <input type="text" class="form-control" id="oldPwd" name="oldPwd"
                                    placeholder="Enter Old password">
                                <span id="OPwdError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">New Password :</label>
                                <input type="text" class="form-control" id="newPwd" name="newPwd"
                                    placeholder="Enter New password">
                                <span id="NPwdError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Confirm Password :</label>
                                <input type="text" class="form-control" id="coPwd" name="coPwd"
                                    placeholder="Re-enter new password">
                                <span id="CPwdError"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <br>
                                <button class="col-md-12 btn btn-dark" type="submit" name="changepwdbtn"
                                    class="btn btn-dark" onclick="asd(3)">Change</button>

                            </div>
                            <!-- <div class="col-md-12">
                                <br><a href="Forgot_password.php">Forgot Password..?</a>
                            </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function asd(a) {
            if (a == 1) {
                $('#update').show();
                $('#info').hide();
                $('#changePwd').hide();
            }
            if (a == 2) {
                $('#changePwd').show();
                $('#info').hide();
                $('#update').hide();
            }
            if (a == 3) {
                $('#info').show();
                $('#changePwd').hide();
                $('#update').hide();
            }

        }
    </script>
    <script>
        function upd() {
            validate = true;
            NameValidate(document.getElementById('fnm'), document.getElementById('fnm_er'));
            NameValidate(document.getElementById('lnm'), document.getElementById('lnm_er'));
            EmailValidate(document.getElementById('email'), document.getElementById('email_er'));
            PhnValidate(document.getElementById('phn'), document.getElementById('phn_er'));
            BigTextValidate(document.getElementById('add'), document.getElementById('add_er'));
            NameValidate(document.getElementById('city'), document.getElementById('city_er'));
            NameValidate(document.getElementById('state'), document.getElementById('state_er'));
            ZipValidate(document.getElementById('zip'), document.getElementById('zip_er'));
            // ImgValidate(document.getElementById('img'), document.getElementById('img_er'));

            if (validate) {
                return true;
            }
            return false;
        }

        function Pwdch() {
            validate = true;

            CommanValidate(document.getElementById('oldPwd'), document.getElementById('OPwdError'))
            PwdValidate(document.getElementById('newPwd'), document.getElementById('NPwdError'));
            CommanValidate(document.getElementById('coPwd'), document.getElementById('CPwdError'));

            if(validate){
                return true;
            }
            return false;
        }
    </script>
    <?php
    include 'Footer.php';

    if (isset($_POST['updatebtn'])) {
        $fnm = $_POST['fnm'];
        $lnm = $_POST['lnm'];
        $uemail = $_POST['email'];
        $phn = $_POST['phn'];
        $add = $_POST['add'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

        if ($_FILES['img']['name'] != "") {
            $img = $_FILES['img']['name'];

            $temp = $_FILES['img']['tmp_name'];
            $img = uniqid() . $img;
            move_uploaded_file($temp, "db_img/user_img/" . $img);
        } else {
            $img = $r['U_Profile'];
        }

        $update_query = "UPDATE `user_tbl` SET `U_Fnm`='$fnm',`U_Lnm`='$lnm',`U_Email`='$uemail',`U_Phn`='$phn',`U_Add`='$add',`U_City`='$city',`U_State`='$state',`U_Zip`='$zip',`U_Profile`='$img' WHERE U_Email='$email' ";
        if (mysqli_query($con, $update_query)) {
            if ($img != $r['U_Profile']) {
                $old_profile_picture = $r['U_Profile'];
                if (file_exists("db_img/user_img/" . $old_profile_picture)) {
                    unlink("db_img/user_img/" . $old_profile_picture);
                }
            }
            setcookie('success', "Profile updated successfully", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'Account.php';
            </script>";
            <?php
        } else {
            setcookie('error', "Error in updating profie", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'Account.php';
            </script>
            <?php
        }
    }

    if (isset($_POST['changepwdbtn'])) {
        $oldPwd = $_POST['oldPwd'];
        $newPwd = $_POST['newPwd'];

        $query = "select * from user_tbl where `U_Email`='$email'";
        $result = mysqli_query($con, $query);
        while ($r = mysqli_fetch_assoc($result)) {
            if ($r['U_Pwd'] == $oldPwd) {
                $q = "UPDATE user_tbl SET U_Pwd='$newPwd' WHERE U_Email='$email'";
                if (mysqli_query($con, $q)) {
                    setcookie('success', "Password changed successfully", time() + 5, "/");
                    ?>
                    <script>
                        window.location.href = "Account.php";
                    </script>
                    <?php
                } else {
                    setcookie('error', "Failed to change password", time() + 5, "/");
                    ?>
                    <script>
                        window.location.href = "Account.php";
                    </script>
                    <?php
                }
            } else {
                setcookie('error', "Incorrect Old Password", time() + 5, "/");
                ?>
                <script>
                    window.location.href = "Account.php";
                </script>
                <?php
            }
        }
    }

    ?>
</body>

</html>