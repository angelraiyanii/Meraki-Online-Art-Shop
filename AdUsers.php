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
            <div class="col-md-3"></div>
            <div class="col-md-1" style="text-align:right"><button class="btn btn-dark" onclick="addForm(1)"><i
                        class="fa fa-plus"></i></button></div>
        </div>

        <!-- add users -->
        <div class="container-fluid bgcolor mt-5 mb-5" id="register" style="display:none">
            <div class="row">
                <h2 style="text-align:center">Register</h2>
                <!-- <div class="col-md-3"></div> -->
                <div class="col-md-12 mt-3">
                    <form id="register" name="register" onsubmit="return reg()" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">First Name :</label>
                                <input type="text" class="form-control" id="fnm" name="Fnm"
                                    placeholder="Enter First Name">
                                <span id="fnm_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Last Name :</label>
                                <input type="text" class="form-control" id="lnm" name="Lnm"
                                    placeholder="Enter Last Name">
                                <span id="lnm_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Email :</label>
                                <input type="text" class="form-control" id="email" name="Email"
                                    placeholder="Enter Email">
                                <span id="email_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Phone No. :</label>
                                <input type="text" class="form-control" id="phn" name="Phn"
                                    placeholder="Enter Mobile No.">
                                <span id="phn_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Address :</label>
                                <textarea class="form-control" id="add" name="Add"
                                    placeholder="Enter your full address"></textarea>
                                <span id="add_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">City :</label>
                                <input type="text" class="form-control" id="city" name="City" placeholder="Enter City">
                                <span id="city_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">State :</label>
                                <input type="text" class="form-control" id="state" name="State"
                                    placeholder="Enter State">
                                <span id="state_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Zip Code :</label>
                                <input type="text" class="form-control" id="zip" name="Zip"
                                    placeholder="Enter Zip code">
                                <span id="zip_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Password :</label>
                                <input type="text" class="form-control" id="pwd" name="Pwd"
                                    placeholder="Enter Password">
                                <span id="pwd_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Profile Image :</label>
                                <input type="file" class="form-control" id="img" name="Img">
                                <span id="img_er"></span>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-10 mb-3">
                            </div>
                            <div class="col-md-2 mb-3" style="align-content: end;">
                                <input type="submit" name="register" class="btn btn-dark" value="Register">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="col-md-3"></div> -->
            </div>
        </div>

        <div class="row w-100">
            <div class="col-12">
                <table>
                    <tr>
                        <th style="width:50px">Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>City State</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>View</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    // SQL query to include the search condition
                    $search_query = '';
                    if (!empty($search)) {
                        $search_query = "WHERE U_Fnm LIKE '%$search%' OR U_Lnm LIKE '%$search%' OR U_Email LIKE '%$search%' OR U_Phn LIKE '%$search%' OR U_Add LIKE '%$search%' OR U_City LIKE '%$search%'OR U_State LIKE '%$search%' OR U_Zip LIKE '%$search%' OR U_Pwd LIKE '%$search%' OR U_Role LIKE '%$search%' OR U_Status LIKE '%$search%'";
                    }

                    // Determine the total number of records
                    $q = "SELECT * FROM user_tbl $search_query";
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

                    $q = "Select * from user_tbl $search_query LIMIT $start_from, $records_per_page";
                    $result = mysqli_query($con, $q);

                    while ($r = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $r['U_Id']; ?></td>
                            <td><?php echo $r['U_Fnm'] . " " . $r['U_Lnm']; ?></td>
                            <td><?php echo $r['U_Email']; ?></td>
                            <td><?php echo $r['U_Pwd']; ?></td>
                            <td><?php echo $r['U_City'] . ", " . $r['U_State']; ?></td>
                            <td><?php echo $r['U_Status']; ?></td>
                            <td><?php echo $r['U_Role']; ?></td>
                            <td>
                                <form method="post" action="AdUsers.php#user_profile"><a href="#user_profile"><button
                                            type="submit" class="btn btn-dark" value="<?php echo $r['U_Id'] ?>"
                                            name="showUsr" onclick="showUser(1)"><i class="fa fa-eye"></i></button></a>
                                </form>
                            </td>
                            <td>
                                <form method="post" action="AdUsers.php">
                                    <input type="hidden" name="userId" value="<?php echo $r['U_Id']; ?>">
                                    <input type="hidden" name="currentStatus" value="<?php echo $r['U_Status']; ?>">
                                    <button type="submit" name="changeStatus" class="btn btn-dark">
                                        <?php echo $r['U_Status'] == 'Active' ? 'Hide' : 'Show'; ?>
                                    </button>
                                </form>
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
    if (isset($_POST['showUsr'])) {
        //echo $_POST['showUsr'];
        $id = $_POST['showUsr'];

        $query = "select * from user_tbl where U_Id=$id";
        $result = mysqli_query($con, $query);
        $r = mysqli_fetch_assoc($result);
        $p_status = $r['U_Status'];
        ?>
        <div class="container-fluid bgcolor mt-5" id="user_profile">
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
                        <a href="wishlist.php?Id=<?php echo $r['U_Email']; ?>"><button class="btn btn-dark w-100 mb-2">See
                                Wishlist</button></a>
                        <a href="cart.php?Id=<?php echo $r['U_Email']; ?>"><button class="btn btn-dark w-100 mb-2">See
                                Cart</button></a>
                        <a href="orderhistory.php?Id=<?php echo $r['U_Email']; ?>"><button class="btn btn-dark w-100">Order
                                History</button></a>
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
                        <form id="update" method="post" enctype="multipart/form-data" style="display:none !important;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">First Name :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_Fnm'] ?>" id="fnm"
                                        name="fnm" placeholder="Enter First Name">
                                    <span id="FnmError"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Last Name :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_Lnm'] ?>" id="lnm"
                                        name="lnm" placeholder="Enter Last Name">
                                    <span id="LnmError"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Email :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_Email'] ?>" id="email"
                                        name="email" placeholder="Enter Email">
                                    <span id="EmailError"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Phone No. :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_Phn'] ?>" id="phn"
                                        name="phn" placeholder="Enter Mobile No.">
                                    <span id="PhnError"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Address :</label>
                                    <textarea class="form-control" id="add" name="add"
                                        placeholder="Enter your full address"><?php echo $r['U_Add'] ?></textarea>
                                    <span id="AddError"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">City :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_City'] ?>" id="city"
                                        name="city" placeholder="Enter City">
                                    <span id="CityError"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">State :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_State'] ?>" id="state"
                                        name="state" placeholder="Enter State">
                                    <span id="StateError"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Zip Code :</label>
                                    <input type="text" class="form-control" value="<?php echo $r['U_Zip'] ?>" id="zip"
                                        name="zip" placeholder="Enter Zip code">
                                    <span id="ZipError"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Status :</label>
                                    <select class="form-control" name="status">
                                        <option <?php if ($p_status == 'Active')
                                            echo 'selected'; ?> value="Active">Active
                                        </option>
                                        <option <?php if ($p_status == 'Inactive')
                                            echo 'selected'; ?> value="Inactive">
                                            Inactive</option>
                                    </select>
                                    <span id="StatusError"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Profile Image :</label>
                                    <input type="file" class="form-control" id="img" name="img">
                                    <span id="ImgError"></span>
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
                        <form id="changePwd" method="post" enctype="multipart/form-data" style="display:none !important;">
                            <div class="row">
                                <input type="hidden" name="cpemail" value="<?php echo $r['U_Email'] ?>">
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
                                <div class="col-md-12">
                                    <br><a href="Forgot_password.php">Forgot Password..?</a>
                                </div>
                        </form>
                    </div>
                </div>
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
        function addForm(a) {
            if (a == 1)
                $('#register').show();
            else
                $('#register').hide();
        }
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
        }
    </script>
    <script>
        function reg() {
            validate = true;
            NameValidate(document.getElementById('fnm'), document.getElementById('fnm_er'));
            NameValidate(document.getElementById('lnm'), document.getElementById('lnm_er'));
            EmailValidate(document.getElementById('email'), document.getElementById('email_er'));
            PhnValidate(document.getElementById('phn'), document.getElementById('phn_er'));
            BigTextValidate(document.getElementById('add'), document.getElementById('add_er'));
            NameValidate(document.getElementById('city'), document.getElementById('city_er'));
            NameValidate(document.getElementById('state'), document.getElementById('state_er'));
            ZipValidate(document.getElementById('zip'), document.getElementById('zip_er'));
            PwdValidate(document.getElementById('pwd'), document.getElementById('pwd_er'));
            ImgValidate(document.getElementById('img'), document.getElementById('img_er'));

            if (validate) {
                return true;
            }
            return false;
        }
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
    </script>

    <?php
    include 'Footer.php';

    // Add user
    if (isset($_POST['register'])) {
        $fnm = $_POST['Fnm'];
        $lnm = $_POST['Lnm'];
        $email = $_POST['Email'];
        $phn = $_POST['Phn'];
        $add = $_POST['Add'];
        $city = $_POST['City'];
        $state = $_POST['State'];
        $zip = $_POST['Zip'];
        $pwd = $_POST['Pwd'];
        $img = uniqid() . $_FILES['Img']['name'];

        $query = "INSERT INTO `user_tbl`(`U_Fnm`, `U_Lnm`, `U_Email`, `U_Phn`, `U_Add`, `U_City`, `U_State`, `U_Zip`, `U_Pwd`, `U_Profile`) VALUES ('$fnm','$lnm','$email','$phn','$add','$city','$state','$zip','$pwd','$img')";
        echo $query;
        if (mysqli_query($con, $query)) {
            if (!is_dir("db_img/user_img")) {
                mkdir("db_img/user_img");
            }
            move_uploaded_file($_FILES['Img']['tmp_name'], "db_img/user_img/" . $img);

            // $mail = new PHPMailer(true);
            // try {
            //     $mail->isSMTP();
            //     $mail->Host = 'smtp.gmail.com';
            //     $mail->SMTPAuth = true;
            //     $mail->Username = 'veloraa1920@gmail.com';
            //     $mail->Password = 'rtep efdy gepi yrqj ';
            //     $mail->SMTPSecure = 'tls';
            //     $mail->Port = 587;
    
            //     $mail->setFrom('veloraa1920@gmail.com', 'Veloraa');
            //     $mail->addAddress($email, $fnm);
    
            //     $mail->isHTML(true);
            //     $mail->Subject = 'Email Verification';
            //     $activation_link = "http://localhost/demo/verify_email.php?em=" . $email;
            //     $mail->Body = "<html>
            //     <head>
            //         <style>
            //             body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            //             .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; }
            //             h1 { color: black; }
            //             .button { display: inline-block; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px; }
            //             .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
            //             a { text-decoration: none; color: white; }
            //         </style>
            //     </head>
            //     <body>
            //         <div class='container'>
            //             <h1>Welcome, $fn!</h1>
            //             <p>Thank you for registering. Please click the button below to activate your account:</p>
            //             <p><a href='$activation_link' class='button'>Activate Your Account</a></p>
            //             <p>If you didn't register on our website, please ignore this email.</p>
            //             <div class='footer'>
            //                 <p>This is an automated message, please do not reply to this email.</p>
            //             </div>
            //         </div>
            //     </body>
            //     </html>";
    
            //     $mail->send();
            // } catch (Exception $e) {
            //     // $_SESSION['error'] = "Error in sending email: ". $mail->ErrorInfo;
            //     setcookie('error', "Error in sending email: " . $mail->ErrorInfo, time() + 5);
            // }
    
            // $_SESSION['success'] = "Registration Successfull. VErify your Email using verification link sent to registered Email Address";
            setcookie('success', 'Registration Successfull. Verify your Email using verification link sent to registered Email Address', time() + 5, "/");
            ?>

            <script>
                window.location.href = "AdUsers.php";
            </script>
            <?php
        } else {
            // $_SESSION['error'] = "Error in Registration. Try again."
            setcookie('error', 'Error in Registration. Try again.', time() + 5, "/");
            ?>

            <script>
                window.location.href = "AdUsers.php";
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
    // status update from table
    if (isset($_POST['changeStatus'])) {
        $id = $_POST['userId'];
        $currentStatus = $_POST['currentStatus'];

        // Determine the new status
        $newStatus = ($currentStatus == 'Active') ? 'Deactivate' : 'Active';

        // Update the status in the database
        $query = "UPDATE `user_tbl` SET `U_Status`='$newStatus' WHERE `U_Id`=$id";

        if (mysqli_query($con, $query)) {
            setcookie('success', "Status updated successfully", time() + 5, "/");
        } else {
            setcookie('error', "Error in updating status", time() + 5, "/");
        }
        ?>
        <script>
            window.location.href = 'AdUsers.php';
        </script>
        <?php
    }
    ?>
</body>

</html>