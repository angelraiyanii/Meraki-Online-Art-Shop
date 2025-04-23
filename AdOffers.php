<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers</title>
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

        th:nth-child(2),
        td:nth-child(2) {
            width: 30%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 20%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 30%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 30%;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5">
        <div class="row mt-3 mb-3">
            <h2 class="col-md-4" style="color:white">Offers/Discounts</h2>
            <div class="col-md-3" style="text-align:right">
                <!-- form for search Start -->
                <form method="get"><input type="text" name="search" class="form-control"
                        placeholder="Search here...">&nbsp;
            </div>
            <div class="col-md-1"><button class="btn btn-dark"><i class="fa fa-search "></i></button></div>
            </form>
            <!-- form for search End -->
            <div class="col-md-3"></div>
            <div class="col-md-1" style="text-align:right"><button class="btn btn-dark" onclick="addForm(1)"><i
                        class="fa fa-plus"></i></button></div>
        </div>

        <!-- add offers -->
        <div class="container-fluid bgcolor mt-5 mb-5" id="discount" style="display: none !important;">
            <div class="row">
                <h2>Discount</h2>
                <div class="col">
                    <div class="row">
                        <div class="col-md-4"><img src="img/slide1.png" height="100px" /></div>
                    </div></br>
                    <form id="offer" method="post" enctype="multipart/form-data" onsubmit="return discount()" >
                        <div class="row">
                            <div class="col-md-4">Name:<input type="text" name="onm" id="onm" class="form-control"
                                    placeholder="Enter Offer Title"><span id="onm_er"></span></div></br>
                            <div class="col-md-4">Description:<textarea id="odes" name="odes" class="form-control"
                                    placeholder="Enter Offer Description"></textarea><span id="odes_er"></span></div>
                            </br>
                            <div class="col-md-4">Rate:<input type="text" id="rate" name="rate" class="form-control"
                                    placeholder="Enter Rate"><span id="rate_er"></span></div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-4">Maximum Discount Amount:<input type="text" id="mda" name="mda"
                                    class="form-control" placeholder="Enter Maximum Discount Amount"><span
                                    id="mda_er"></span></div></br>
                            <div class="col-md-4">Order Total:<input type="text" id="odt" name="odt"
                                    class="form-control" placeholder="Enter total"><span id="odt_er"></span></div></br>
                            <div class="col-md-4">Start Date:<input type="date" name="sdt" id="sdt"
                                    class="form-control"><span id="sdt_er"></span></div></br>
                        </div></br>
                        <div class="row">
                            <div class="col-md-4">End Date:<input type="date" name="edt" id="edt"
                                    class="form-control"><span id="edt_er"></span></div></br>
                            <div class="col-md-4">Banner:<input type="file" id="bnr" name="bnr"
                                    class="form-control">Upload files with dimentions of 1600*500
                                <span id="bnr_er"></span>
                            </div>
                            <div class="col-md-4"><button type="submit" name="offer_add" class="button-28">Add</button>
                            </div>
                        </div></br>
                    </form>
                </div>
            </div>
        </div>

        <!-- table -->
        <div class="row" id="product">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Cart Total</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Image</th>
                    <th>View</th>
                    <th>Status</th>
                </tr>
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $search_query = '';
                if (!empty($search)) {
                    $search_query = "WHERE Of_Id LIKE '%$search%' OR Of_Name LIKE '%$search%' OR Of_Description LIKE '%$search%' OR Of_Discount_Percentage LIKE '%$search%' OR Of_Cart_Total LIKE '%$search%' OR Of_Max_Discount LIKE '%$search%' OR Of_Start_Date LIKE '%$search%' OR Of_End_Date LIKE '%$search%' Of_Status LIKE '$search'";
                }
                $q = "SELECT * FROM offers_tbl $search_query";
                $result = mysqli_query($con, $q);
                $total_records = mysqli_num_rows($result);

                $records_per_page = 2;

                $total_pages = ceil($total_records / $records_per_page);

                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                $start_from = ($page - 1) * $records_per_page;

                $q = "SELECT * FROM offers_tbl $search_query LIMIT $start_from, $records_per_page";
                $result = mysqli_query($con, $q);


                while ($r = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $r['Of_Id'] ?></td>
                        <td><?php echo $r['Of_Name'] ?></td>
                        <td><?php echo $r['Of_Discount_Percentage'] ?></td>
                        <td><?php echo $r['Of_Cart_Total'] ?></td>
                        <td><?php echo $r['Of_Start_Date'] ?></td>
                        <td><?php echo $r['Of_End_Date'] ?></td>
                        <td><img src="db_img/offer_img/<?php echo $r['Of_Banner'] ?>" height="50px" width="160px"></td>
                        <td>
                            <form method="post" action="AdOffers.php#update_form">
                                <a href="#update_form">
                                    <button type="submit" class="btn btn-dark" value="<?php echo $r['Of_Id'] ?>"
                                        name="showOffer" onclick="update(1)"><i class="fa fa-eye"></i></button>
                                </a>
                            </form>
                        </td>

                        <td>
                            <form method="post" action="AdOffers.php">
                                <input type="hidden" name="categoryId" value="<?php echo $r['Of_Id']; ?>">
                                <input type="hidden" name="currentStatus" value="<?php echo $r['Of_Status']; ?>">
                                <button type="submit" name="changeStatus" class="btn btn-dark">
                                    <?php echo $r['Of_Status'] == 'Active' ? 'Hide' : 'Show'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <!--pagination Start  -->
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
        <!--pagination End  -->
    </div>

    <!-- update cat form -->
    <?php
    if (isset($_POST['showOffer'])) {
        //echo $_POST['showUsr'];
        $id = $_POST['showOffer'];

        $query = "select * from offers_tbl where Of_Id=$id";
        $result = mysqli_query($con, $query);
        $r = mysqli_fetch_assoc($result);
        $p_status = $r['Of_Status'];
        ?>
        <div class="container-fluid bgcolor mt-5" id="update_form">
            <div class="row">
                <!-- Images Column -->
                <div class="col-md-4">
                    <div class="product-image">
                        <img src="db_img/offer_img/<?php echo $r['Of_Banner']; ?>" height="50px" width="160px"
                            alt="Offer Image" class="img-fluid rounded">
                        <br><br>
                        <form method="post" enctype="multipart/form-data">
                        <label for="uimg" class="form-label">Change Offer Image:</label>
                        <input type="file" class="form-control" name="ubnr" id="ubnr">
                        Upload files with dimentions of 1600*500
                        <span id="uimg_er" class="text-danger"></span>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-8">
                    <div class="product-image-large">
                        <!-- update information -->
                            <div class="row">
                                <input type="hidden" name="ofid" value="<?php echo $r['Of_Id'] ?>">
                                <!-- <input type="hidden" name="oldimg" value="<?php echo $r['Of_Img'] ?>"> -->
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Offer Name:</label>
                                    <input type="text" class="form-control" name="uonm" id="uonm"
                                        value="<?php echo $r['Of_Name'] ?>">
                                    <span id="uonm_er" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Description:</label>
                                    <textarea class="form-control" name="uodes"
                                        id="uodes"><?php echo $r['Of_Description'] ?></textarea>
                                    <span id="uodes_er" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Discount Percentage:</label>
                                    <input type="text" class="form-control" name="udp" id="udp"
                                        value="<?php echo $r['Of_Discount_Percentage'] ?>">
                                    <span id="udp_er" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Cart Total:</label>
                                    <input type="text" class="form-control" name="uoct" id="uoct"
                                        value="<?php echo $r['Of_Cart_Total'] ?>">
                                    <span id="uoct_er" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Max Discount Amount:</label>
                                    <input type="text" class="form-control" name="umd" id="umd"
                                        value="<?php echo $r['Of_Discount_Percentage'] ?>">
                                    <span id="udp_er" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Status:</label>
                                    <select class="form-control" name="ustatus">
                                        <option <?php if ($p_status == 'Active')
                                            echo 'selected'; ?> value="Active">Active
                                        </option>
                                        <option <?php if ($p_status == 'Deactivate')
                                            echo 'selected'; ?> value="Deactivate">
                                            Deactivate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Start Date:</label>
                                    <input type="date" class="form-control" name="usdt" id="usdt"
                                        value="<?php echo $r['Of_Start_Date'] ?>">
                                    <span id="ustd_er" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">End Date:</label>
                                    <input type="date" class="form-control" name="uedt" id="uedt"
                                        value="<?php echo $r['Of_End_Date'] ?>">
                                    <span id="uedt_er" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 mb-3">
                                </div>
                                <div class="col-md-3 mb-3" style="align-content: end;">
                                    <button class="btn btn-dark" onclick="update(2)"><i class="fa fa-times"></i></button>
                                    <button type="submit" class="btn btn-dark" name="updateOffer"><i
                                            class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- update product form -->

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function update(a) {
            if (a == 1) {
                $('#update_form').show();
            }
        }
        function addForm(a) {
            if (a == 1)
                $('#discount').show();
            else
                $('#discount').hide();
        }
    </script>
    <script>
        function discount() {
            validate = true;

            CommanValidate(document.getElementById('onm'), document.getElementById('onm_er'));
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
    </script>
    <?php
    include 'Footer.php';

    // Add offers
    // Add offers
    if (isset($_POST['offer_add'])) {
        $offer_title = $_POST['onm'];
        $offer_description = $_POST['odes'];
        $discount_percentage = $_POST['rate'];
        $max_discount_amount = $_POST['mda'];
        $start_date = $_POST['sdt'];
        $end_date = $_POST['edt'];
        $order_total = $_POST['odt'];

        // Generate unique name for the image
        $banner = $_FILES['bnr']['name'];

        $query = "INSERT INTO `offers_tbl`(`Of_Name`, `Of_Description`, `Of_Discount_Percentage`, `Of_Cart_Total`, `Of_Max_Discount`, `Of_Start_Date`, `Of_End_Date`, `Of_Banner`, `Of_Status`) 
    VALUES ('$offer_title','$offer_description','$discount_percentage','$order_total','$max_discount_amount','$start_date','$end_date','$banner','Active')";
        // echo $query;

        if (mysqli_query($con, $query)) {
            // Create directory if it doesn't exist
            if (!is_dir("db_img/offer_img")) {
                mkdir("db_img/offer_img");
            }

            // Move uploaded file to the directory
            move_uploaded_file($_FILES['bnr']['tmp_name'], "db_img/offer_img/" . $banner);

            setcookie('success', 'Offer added successfully', time() + 2, "/");
            ?>
            <script>
                window.location.href = 'AdOffers.php';
            </script>
            <?php
        } else {
            setcookie('error', 'Error in adding offer', time() + 2, "/");
            ?>
            <script>
                window.location.href = 'AdOffers.php';
            </script>
            <?php
        }
    }

    // if (isset($_POST['offer_add'])) {
    //     $offer_title = $_POST['onm'];
    //     $offer_description = $_POST['odes'];
    //     $discount_percentage = $_POST['rate'];
    //     $max_discount_amount = $_POST['mda'];
    //     $start_date = $_POST['sdt'];
    //     $end_date = $_POST['edt'];
    //     $order_total = $_POST['odt'];
    //     $banner = $_POST['bnr'];
    
    //     $query = "INSERT INTO `offers_tbl`(`Of_Name`,`Of_Description`, `Of_Discount_Percentage`, `Of_Cart_Total`, `Of_Max_Discount`, `Of_Start_Date`, `Of_End_Date`, `Of_Status`) 
    //     VALUES ('$offer_title','$offer_description','$discount_percentage','$order_total','$max_discount_amount','$start_date','$end_date','Active')";
    //     echo $query;
    
    //     if (mysqli_query($con, $query)) {
    //         setcookie('success', "Offer added successfully", time() + 5, "/");
    //         echo "<script>window.location.href = 'AdOffers.php';</script>";
    //     } else {
    //         setcookie('error', 'Error in adding offer', time() + 5, "/");
    //         echo "<script>window.location.href = 'AdOffers.php';</script>";
    //     }
    // }
    
    // Update offers
    if (isset($_POST['updateOffer'])) {
        $id = $_POST['ofid'];
        $otitle = $_POST['uonm'];
        $odescription = $_POST['uodes'];
        $discount_percentage = $_POST['udp'];
        $ototal = $_POST['uoct'];
        $max_discount = $_POST['umd'];
        $status = $_POST['ustatus'];
        $startdate = $_POST['usdt'];
        $enddate = $_POST['uedt'];
        $newImage = "";

        // Handle file upload
        if (isset($_FILES['ubnr']) && $_FILES['ubnr']['name'] != "") {
            $newImage = uniqid() . "_" . $_FILES['ubnr']['name']; // Generate unique name
            $uploadPath = "db_img/offer_img/" . $newImage;
            move_uploaded_file($_FILES['ubnr']['tmp_name'], $uploadPath);

            // Optional: Delete old image if necessary
            if (!empty($r['Of_Banner']) && file_exists("db_img/offer_img/" . $r['Of_Banner'])) {
                unlink("db_img/offer_img/" . $r['Of_Banner']);
            }
        } else {
            // Keep the old image if no new one is uploaded
            $newImage = $r['Of_Banner'];
        }

        $query = "UPDATE `offers_tbl` SET 
                `Of_Name`='$otitle',
                `Of_Description`='$odescription',
                `Of_Discount_Percentage`='$discount_percentage',
                `Of_Cart_Total`='$ototal',
                `Of_Max_Discount`='$max_discount',
                `Of_Start_Date`='$startdate',
                `Of_End_Date`='$enddate',
                `Of_Status`='$status',
                `Of_Banner`='$newImage'
              WHERE `Of_Id`=$id";
        // $query = "UPDATE `offers_tbl` SET `Of_Name`='$otitle',`Of_Description`='$odescription',`Of_Discount_Percentage`='$discount_percentage',
        // `Of_Cart_Total`='$ototal',`Of_Max_Discount`='$max_discount',`Of_Start_Date`='$startdate',`Of_End_Date`='$enddate',`Of_Status`='$status' WHERE `Of_Id`=$id";
        echo $query;

        if (mysqli_query($con, $query)) {
            setcookie('success', "Offer updated successfully", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdOffers.php';
            </script>
            <?php
        } else {
            setcookie('error', "Error in updating offer", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdOffers.php';
            </script>
            <?php
        }
    }
    // status update from table
    if (isset($_POST['changeStatus'])) {
        $id = $_POST['categoryId'];
        $currentStatus = $_POST['currentStatus'];

        // Determine the new status
        $newStatus = ($currentStatus == 'Active') ? 'Deactivate' : 'Active';

        // Update the status in the database
        $query = "UPDATE `offers_tbl` SET `Of_Status`='$newStatus' WHERE `Of_Id`=$id";

        if (mysqli_query($con, $query)) {
            setcookie('success', "Status updated successfully", time() + 5, "/");
        } else {
            setcookie('error', "Error in updating status", time() + 5, "/");
        }
        ?>
        <script>
            window.location.href = 'AdOffers.php';
        </script>
        <?php
    }
    ?>
</body>

</html>