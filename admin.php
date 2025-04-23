<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
        /* large divice */
        @media (min-width: 992px) {
            .banner-image {
                height: 100px;
                width: auto;
                /* Remove height restriction for large devices */
            }

            .banner-row {
                display: flex;
                justify-content: space-between;
            }

            .banner-row>div {
                flex: 1;
                margin: 0 5px;
            }
        }


        /* medium device */
        @media (max-width: 991.98px) {
            .banner-image {
                margin-bottom: 15px;
                height: 190px;
            }
        }

        /* small device */
        @media (max-width: 480px) {
            .banner-image {
                height: 80px;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body class="bg-dark">
    <!-- change Main banners -->
    <div class="container-fluid bgcolor mt-5 mb-5">
        <div class="row">
            <h2>Change Main Banners</h2>
            <p>Image size should be :1600x500</p>
            <div class="col">
                <div class="banner-row">
                    <?php
                    $query = "select * from slider_tbl where Id=1";
                    $result = mysqli_query($con, $query);
                    $r = mysqli_fetch_assoc($result);
                    ?>
                    <!-- Responsive image layout -->
                    <div><img src="db_img/slider_img/<?php echo $r['Img_1']; ?>" class="banner-image" alt="Banner 1">
                    </div>
                    <div><img src="db_img/slider_img/<?php echo $r['Img_2']; ?>" class="banner-image" alt="Banner 2">
                    </div>
                    <div><img src="db_img/slider_img/<?php echo $r['Img_3']; ?>" class="banner-image" alt="Banner 3">
                    </div>
                </div>
            </div></br></br>
            <div class="row mt-3" id="btn">
                <div class="col-md-4"><button onclick="img(1)" class="button-28">Change</button></div>
            </div>
            <form id="mainbanners" method="post" enctype="multipart/form-data" style="display: none !important;">
                <div class="row">
                    <div class="col-md-3">Banner 1:<input type="file" id="b1" name="b1" class="form-control">
                        <span id="b1_er"></span>
                    </div>
                    <div class="col-md-3">Banner 2:<input type="file" id="b2" name="b2" class="form-control">
                        <span id="b2_er"></span>
                    </div>
                    <div class="col-md-3">Banner 3:<input type="file" id="b3" name="b3" class="form-control"><span
                            id="b3_er"></span></div></br>
                    <div class="col-md-3"><button type="submit" name="mainBannerImg" class="button-28">Change</button>
                    </div>
                </div>
            </form></br></br>
        </div>
    </div>
    </div>

    <!-- change offer banners -->
    <div class="container-fluid bgcolor mt-5 mb-5" id="discount">
        <div class="row">
            <h2>Offers/Discount</h2>
            <div class="col">
                <div class="row">
                    <div class="col-md-4"><img src="img/slide1.png" height="100px" /></div>
                </div></br>
                <form id="offer" method="post" onsubmit="return discount()" style="display: none !important;">
                    <div class="row">
                        <div class="col-md-4">Name:<input type="text" name="onm" id="onm" class="form-control"
                                placeholder="Enter Offer Title"><span id="onm_er"></span></div></br>
                        <div class="col-md-4">Description:<textarea id="odes" name="odes" class="form-control"
                                placeholder="Enter Offer Description"></textarea><span id="odes_er"></span></div></br>
                        <div class="col-md-4">Rate:<input type="text" id="rate" name="rate" class="form-control"
                                placeholder="Enter Rate"><span id="rate_er"></span></div>

                    </div></br>
                    <div class="row">
                        <div class="col-md-4">Maximum Discount Amount:<input type="text" id="mda" name="mda" class="form-control"
                                placeholder="Enter Maximum Discount Amount"><span id="mda_er"></span></div></br>
                        <div class="col-md-4">Order Total:<input type="text" name="odt" id="odt" class="form-control"
                                placeholder="Enter total"><span id="odt_er"></span></div></br>
                        <div class="col-md-4">Start Date:<input type="date" name="sdt" id="sdt" class="form-control"><span
                                id="sdt_er"></span></div></br>

                    </div></br>
                    <div class="row">
                        <div class="col-md-4">End Date:<input type="date" name="edt" id="edt" class="form-control"><span
                                id="edt_er"></span></div></br>
                        <div class="col-md-4">Banner:<input type="file" name="bnr" id="bnr" class="form-control"><span
                                id="bnr_er"></span></div>
                        <div class="col-md-4"><button type="submit" name="offer_add" class="button-28">Add</button>
                        </div>
                    </div></br>
                </form>
                <div class="row" id="btn2">
                    <div class="col-md-4"><button onclick="img(2)" class="button-28">Add</button></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category -->
    <div class="container-fluid bgcolor mt-5 mb-5" id="category">
        <div class="row">
            <div class="col col-md-6">
                <h2>Add New Category</h2>
                <!-- <form onsubmit="return addCat()" > -->
                <form method="post" enctype="multipart/form-data" onsubmit="return mainCat()">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name :</label>
                            <input type="text" class="form-control" name="cnm" id="catNm"
                                placeholder="Enter Category Name">
                            <span id="catNm_er"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Image :</label>
                            <input type="file" class="form-control" name="cimg" id="catImg">
                            Upload Images with Dimentions of 1024*1024
                            <span id="catImg_er"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 mb-3"></div>
                        <div class="col-md-2 mb-3" style="align-content: end;">
                            <button type="submit" name="csubmit" class="btn btn-dark"><i
                                    class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- sub category -->
            <div class="col col-md-6">
                <h2>Add New Sub Category</h2>
                <!-- <form onsubmit="return addSubCat()"> -->
                <form method="post" enctype="multipart/form-data" onsubmit="return subCat()">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name :</label>
                            <input type="text" class="form-control" name="snm" id="scatnm"
                                placeholder="Enter Category Name">
                            <span id="scatnm_er"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Image :</label>
                            <input type="file" class="form-control" name="simg" id="scatimg">
                            Upload Images with Dimentions of 1024*1024
                            <span id="scatimg_er"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Choose Main Category :</label>
                            <select class="form-control" name="scat">
                                <?php
                                $q = "Select * from category_tbl";
                                $result = mysqli_query($con, $q);
                                while ($r = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $r['C_Id']; ?>"><?php echo $r['C_Name']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 mb-3"></div>
                        <div class="col-md-2 mb-3" style="align-content: end;">
                            <button type="submit" name="subCategory" class="btn btn-dark"><i
                                    class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function img(a) {
            if (a == 1) {
                $('#mainbanners').show();
                $('#btn').hide();
            }
            if (a == 2) {
                $('#offer').show();
                $('#btn2').hide();
            }
        }
    </script>
    <script>
        function discount() {
            validate = true;

            NameValidate(document.getElementById('onm'), document.getElementById('onm_er'));
            BigTextValidate(document.getElementById('odes'), document.getElementById('odes_er'));
            RateValidate(document.getElementById('rate'), document.getElementById('rate_er'));
            RateValidate(document.getElementById('mda'), document.getElementById('mda_er'));
            RateValidate(document.getElementById('odt'), document.getElementById('odt_er'));
            CommanValidate(document.getElementById('sdt'), document.getElementById('sdt_er'));
            CommanValidate(document.getElementById('edt'), document.getElementById('edt_er'));
            ImgValidate(document.getElementById('bnr'), document.getElementById('bnr_er'));

            if (validate) {
                return true;
            }
            return false;
        }
        function mainCat() {
            validate = true;

            NameValidate(document.getElementById('catNm'), document.getElementById('catNm_er'));
            ImgValidate(document.getElementById('catImg'), document.getElementById('catImg_er'));
            if (validate) {
                return true;
            }
            return false;
        }
        function subCat() {
            validate = true;
            NameValidate(document.getElementById('scatnm'), document.getElementById('scatnm_er'));
            ImgValidate(document.getElementById('scatimg'), document.getElementById('scatimg_er'));
            if (validate) {
                return true;
            }
            return false;
        }
    </script>
    <?php
    include 'Footer.php';
    if (isset($_POST['csubmit'])) {
        $cnm = $_POST['cnm'];
        $cimg = uniqid() . $_FILES['cimg']['name'];

        $query = "INSERT INTO `category_tbl`(`C_Name`, `C_Img`,`C_Status`) VALUES ('$cnm','$cimg','Active')";
        if (mysqli_query($con, $query)) {
            if (!is_dir('db_img/cat_img')) {
                mkdir('db_img/cat_img');
            }
            if (move_uploaded_file($_FILES['cimg']['tmp_name'], 'db_img/cat_img/' . $cimg)) {
                setcookie('success', 'Category Added', time() + 5, "/");
                ?>
                <script>
                    window.location.href = "admin.php";
                </script>
                <?php
            } else {
                echo "File upload error: " . $_FILES['cimg']['error'];
            }
        } else {
            setcookie('error', 'Error in adding Category', time() + 5, "/");
            ?>
            <script>
                window.location.href = "admin.php";
            </script>
            <?php
        }
    }
    if (isset($_POST['subCategory'])) {
        $snm = $_POST['snm'];
        $simg = uniqid() . $_FILES['simg']['name'];
        $scid = $_POST['scat'];

        $query = "INSERT INTO `subcategory_tbl`(`SC_Name`, `C_Id`, `SC_Img`,`SC_Status`) VALUES ('$snm','$scid','$simg','Active')";
        if (mysqli_query($con, $query)) {
            if (!is_dir('db_img/subCat_img')) {
                mkdir('db_img/subCat_img');
            }
            move_uploaded_file($_FILES['simg']['tmp_name'], 'db_img/subCat_img/' . $simg);
            setcookie('success', 'Sub Category Added', time() + 5, "/");
        } else {
            setcookie('error', 'Error in adding Sub Category', time() + 5, "/");
        }
    }
    if (isset($_POST['mainBannerImg'])) {
        $img1 = isset($_FILES['b1']['name']) ? $_FILES['b1']['name'] : '';
        $img2 = isset($_FILES['b2']['name']) ? $_FILES['b2']['name'] : '';
        $img3 = isset($_FILES['b3']['name']) ? $_FILES['b3']['name'] : '';

        // Get the current images from the database
        $query = "SELECT `Img_1`, `Img_2`, `Img_3` FROM `slider_tbl` WHERE Id=1";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $old_img1 = $row['Img_1'];
        $old_img2 = $row['Img_2'];
        $old_img3 = $row['Img_3'];

        // Set the new image names
        $new_img1 = $img1 ? $img1 : $old_img1;
        $new_img2 = $img2 ? $img2 : $old_img2;
        $new_img3 = $img3 ? $img3 : $old_img3;

        // Delete old images if new images are uploaded
        $dir = 'db_img/slider_img/';
        if ($img1 && file_exists($dir . $old_img1)) {
            unlink($dir . $old_img1);
        }
        if ($img2 && file_exists($dir . $old_img2)) {
            unlink($dir . $old_img2);
        }
        if ($img3 && file_exists($dir . $old_img3)) {
            unlink($dir . $old_img3);
        }

        // Update the database with new images
        $query = "UPDATE `slider_tbl` SET `Img_1`='$new_img1', `Img_2`='$new_img2', `Img_3`='$new_img3' WHERE Id=1";
        if (mysqli_query($con, $query)) {
            if (!is_dir('db_img/slider_img')) {
                mkdir('db_img/slider_img');
            }
            if ($img1) {
                move_uploaded_file($_FILES['b1']['tmp_name'], 'db_img/slider_img/' . $img1);
            }
            if ($img2) {
                move_uploaded_file($_FILES['b2']['tmp_name'], 'db_img/slider_img/' . $img2);
            }
            if ($img3) {
                move_uploaded_file($_FILES['b3']['tmp_name'], 'db_img/slider_img/' . $img3);
            }
            setcookie('success', 'Image Uploaded', time() + 5, "/");
            ?>
            <script>
                window.location.href = "admin.php";
            </script>
            <?php
        } else {
            setcookie('error', 'Error in uploading image', time() + 5, "/");
            ?>
            <script>
                window.location.href = "admin.php";
            </script>
            <?php
        }
    }
    if (isset($_POST['offer_add'])) {
        $offer_title = $_POST['onm'];
        $offer_description = $_POST['odes'];
        $discount_percentage = $_POST['rate'];
        $max_discount_amount = $_POST['mda'];
        $start_date = $_POST['sdt'];
        $end_date = $_POST['edt'];
        $status = 'Active';
        $order_total = $_POST['odt'];

        $query = "INSERT INTO `offers_tbl`(`Of_Name`,`Of_Description`, `Of_Discount_Percentage`, `Of_Cart_Total`, `Of_Max_Discount`, `Of_Start_Date`, `Of_End_Date`, `Of_Status`) 
        VALUES ('$offer_title','$offer_description','$discount_percentage','$order_total','$max_discount_amount','$start_date','$end_date','$status')";

        if (mysqli_query($con, $q)) {
            setcookie('success', "Offer added successfully", time() + 5, "/");
            echo "<script>window.location.href = 'manage_offers.php';</script>";
        } else {
            setcookie('error', 'Error in adding offer', time() + 5, "/");
            echo "<script>window.location.href = 'admin.php';</script>";
        }
    }
    ?>
</body>

</html>