<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    include 'Header.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    if (!isset($_SESSION['U_Admin'])) {
        header("Location: index.php");
        exit();
    }
    ?>
    <style>
        tr {
            border: 1px black solid;
            text-align: center;
        }

        table {
            width: 100%;
        }

        th,
        td {
            width: 100%;
            border: 1px black solid;
            padding: 10px;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 25%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 30%;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5">
        <div class="row mt-3 mb-3">
            <h2 class="col-md-4" style="color:white">Users</h2>
            <div class="col-md-3" style="text-align:right">
                <!-- form for search -->
                <form method="get"><input type="text" name="search" class="form-control"
                        placeholder="Search here...">&nbsp;
            </div>
            <div class="col-md-1"><button class="btn btn-dark"><i class="fa fa-search "></i></button></div>
            </form>
        </div>

        <div class="row w-100">
            <div class="col-12">
                <table>
                    <tr>
                        <th style="width:50px">Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Reply</th>
                    </tr>
                    <?php
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    // SQL query to include the search condition
                    $search_query = '';
                    if (!empty($search)) {
                        $search_query = "WHERE Co_Name LIKE '%$search%' OR Co_Email LIKE '%$search%'";
                    }

                    // Determine the total number of records
                    $q = "SELECT * FROM contact_tbl $search_query";
                    $result = mysqli_query($con, $q);
                    $total_records = mysqli_num_rows($result);

                    // Set the number of records per page
                    $records_per_page = 2;

                    // Calculate the total number of pages
                    $total_pages = ceil($total_records / $records_per_page);

                    // Get the current page number
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Calculate the start record for the current page
                    $start_from = ($page - 1) * $records_per_page;

                    $q = "Select * from contact_tbl $search_query ORDER BY (Co_Reply ='') DESC, Co_Id ASC LIMIT $start_from, $records_per_page";
                    $result = mysqli_query($con, $q);

                    while ($r = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $r['Co_Id']; ?></td>
                            <td><?php echo $r['Co_Name']; ?></td>
                            <td><?php echo $r['Co_Email']; ?></td>
                            <td><?php echo $r['Co_Msg']; ?></td>
                            <td>
                                <?php if (empty($r['Co_Reply'])): // Check if reply is null ?>
                                    <form method="post" action="AdContactUs.php#user_profile">
                                        <a href="#user_profile">
                                            <button type="submit" class="btn btn-dark" value="<?php echo $r['Co_Id'] ?>"
                                                name="showContact" onclick="showUser (1)">
                                                <i class="fa fa-arrow-right"></i>
                                            </button>
                                        </a>
                                    </form>
                                <?php else: ?>
                                    <span>
                                        <form method="post" action="AdContactUs.php#user_profile">
                                            <a href="#user_profile">
                                                <button type="submit" class="btn btn-dark" value="<?php echo $r['Co_Id'] ?>"
                                                    name="showContact" onclick="showUser (1)">
                                                    Done
                                                </button>
                                            </a>
                                        </form>
                                    </span> <!-- Display "Done" if reply is not null -->
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <nav>
            <ul class="pagination">
                <?php
                if ($page > 1) {
                    echo "<li class='page-item'><a class='page-link btn-dark' href='?page=" . ($page - 1) . "&search=" . $search . "'><i class='fa fa-chevron-left'></i></a></li>";
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='?page=" . $i . "&search=" . $search . "'>" . $i . "</a></li>";
                }
                if ($page < $total_pages) {
                    echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "&search=" . $search . "'><i class='fa fa-chevron-right'></i></a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <!-- single user profile -->
    <?php
    if (isset($_POST['showContact'])) {
        $id = $_POST['showContact'];

        $query = "select * from contact_tbl where Co_Id=$id";
        $result = mysqli_query($con, $query);
        $r = mysqli_fetch_assoc($result);
        ?>
        <div class="container-fluid bgcolor mt-5" id="user_profile">
            <div class="row">
                <h2 class="mb-3">Name : <?php echo $r['Co_Name']; ?></h2>
                <div class="col-md-12">
                    <form method="post" onsubmit="return replyForm()">
                        <input type="hidden" name="Coid" id="Coid" value="<?php echo $r['Co_Id'] ?>">
                        <input type="hidden" name="email" value="<?php echo $r['Co_Email'] ?>">
                        <input type="hidden" name="nm" value="<?php echo $r['Co_Name']; ?>">
                        <div class="row mb-3">
                            <label for="name" class="form-label" class="mb-3">Email : <?php echo $r['Co_Email']; ?></label>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="form-label" class="mb-3">Message : <?php echo $r['Co_Msg']; ?></label>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="form-label">Reply :</label>
                            <textarea name="reply" id="reply" placeholder="Write a reply..."
                                class="form-control"><?php echo $r['Co_Reply']?></textarea>
                                <span id="reply_er"></span>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-dark" name="replybtn"
                                style="align-content: end;">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- single user profile -->

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function showUser(a) {
            if (a == 1) {
                $('#user_profile').show();
            }
        }
    </script>
    <script>
        function replyForm(){
            validate=true;
            BigTextValidate(document.getElementById('reply'), document.getElementById('reply_er'));
            if(validate){
                return true;
            }
            return false;
        }
    </script>

    <?php
    include 'Footer.php';

    // Add user
    if (isset($_POST['replybtn'])) {
        $reply = $_POST['reply'];
        $id = $_POST['Coid'];
        $email = $_POST['email'];
        $nm = $_POST['nm'];

        $query = "update contact_tbl set Co_Reply='$reply' where Co_Id=$id";
        echo $query;
        if (mysqli_query($con, $query)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'veloraa1920@gmail.com';
                $mail->Password = 'rtep efdy gepi yrqj ';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('veloraa1920@gmail.com', 'Veloraa');
                $mail->addAddress($email, $nm);

                $mail->isHTML(true);
                $mail->Subject = 'Contact Us';
                $mail->Body = "Hello, $name</br>
                    Thank you for reaching us...</br>
                    $reply";

                $mail->send();
            } catch (Exception $e) {
                setcookie('error', "Error in sending email: " . $mail->ErrorInfo, time() + 5);
            }
            setcookie('success', 'Reply sended.', time() + 5, "/");
            ?>

            <script>
                window.location.href = "AdContactUs.php";
            </script>
            <?php
        } else {
            // $_SESSION['error'] = "Error in Registration. Try again."
            setcookie('error', 'Error in sending reply. Try again.', time() + 5, "/");
            ?>

            <script>
                window.location.href = "AdContactUs.php";
            </script>
            <?php
        }
    }

    // Update user info
    if (isset($_POST['updatebtn'])) {
        $fnm = $_POST['fnm'];
        $lnm = $_POST['lnm'];
        $uemail = $_POST['email'];
        $phn = $_POST['phn'];
        $add = $_POST['add'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $status = $_POST['status'];

        if ($_FILES['img']['name'] != "") {
            $img = $_FILES['img']['name'];

            $temp = $_FILES['img']['tmp_name'];
            $img = uniqid() . $img;
            move_uploaded_file($temp, "db_img/user_img/" . $img);
        } else {
            $img = $r['U_Profile'];
        }

        $update_query = "UPDATE `user_tbl` SET `U_Fnm`='$fnm',`U_Lnm`='$lnm',`U_Email`='$uemail',`U_Phn`='$phn',`U_Add`='$add',`U_City`='$city',`U_State`='$state',`U_Zip`='$zip',`U_Profile`='$img',`U_Status`='$status' WHERE U_Email='$uemail' ";
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
                window.location.href = 'AdUsers.php';
            </script>";
            <?php
        } else {
            setcookie('error', "Error in updating profie", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdUsers.php';
            </script>
            <?php
        }
    }
    // Change password
    if (isset($_POST['changepwdbtn'])) {
        $oldPwd = $_POST['oldPwd'];
        $newPwd = $_POST['newPwd'];
        $email = $_POST['cpemail'];

        $query = "select * from user_tbl where `U_Email`='$email'";
        $result = mysqli_query($con, $query);
        while ($r = mysqli_fetch_assoc($result)) {
            if ($r['U_Pwd'] == $oldPwd) {
                $q = "UPDATE user_tbl SET U_Pwd='$newPwd' WHERE U_Email='$email'";
                if (mysqli_query($con, $q)) {
                    setcookie('success', "Password changed successfully", time() + 5, "/");
                    ?>
                    <script>
                        window.location.href = "AdUsers.php";
                    </script>
                    <?php
                } else {
                    setcookie('error', "Failed to change password", time() + 5, "/");
                    ?>
                    <script>
                        window.location.href = "AdUsers.php";
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
    <!-- <script>
        function updateForm() {
            event.preventDefault();
            let validate = true;

            // var id = document.getElementById('id');
            // var id_er = document.getElementById('idError');
            var fn = document.getElementById('fnm');
            var fn_er = document.getElementById('FnmError');
            var ln = document.getElementById('lnm');
            var ln_er = document.getElementById('LnmError');
            var email = document.getElementById('email');
            var em_er = document.getElementById('EmailError');
            var phn = document.getElementById('phn');
            var phn_er = document.getElementById('PhnError');
            var add = document.getElementById('add');
            var add_er = document.getElementById('AddError');
            var city = document.getElementById('city');
            var city_er = document.getElementById('CityError');
            var state = document.getElementById('state');
            var state_er = document.getElementById('StateError');
            var zip = document.getElementById('zip');
            var zip_er = document.getElementById('ZipError');
            var img = document.getElementById('img');
            var img_er = document.getElementById('ImgError');
            var pwd = document.getElementById('pwd');
            var pwd_er = document.getElementById('pwdError');

            // CommonValidate(id,id_er);
            NameValidate(fn, fn_er);
            NameValidate(ln, ln_er);
            EmailValidate(email, em_er);
            PhnValidate(phn, phn_er);
            BigTextValidate(add, add_er);
            NameValidate(city, city_er);
            NameValidate(state, state_er);
            ZipValidate(zip, zip_er);
            ImgValidate(img, img_er);
            PwdValidate(pwd, pwd_er);

            return validate;
        }


    </script> -->
</body>

</html>