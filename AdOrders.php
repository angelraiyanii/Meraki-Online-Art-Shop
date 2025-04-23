<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    // if (!isset($_SESSION['U_Admin'])) {
    //     header("Location: Index.php");
    //     exit();
    // }
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
            <h2 class="col-md-8" style="color:white">Orders</h2>
            <div class="col-md-3" style="text-align:right">
                <!-- form for search Start -->
                <form method="get"><input type="text" name="search" class="form-control"
                        placeholder="Search here...">&nbsp;
            </div>
            <div class="col-md-1"><button class="btn btn-dark"><i class="fa fa-search "></i></button></div>
            </form>
            <!-- form for search End -->
        </div>


        <div class="row" id="product">
            <table>
                <tr>
                    <th style="width:50px">Id</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Date</th>
                    <th>Address</th>
                    <th>City State</th>
                    <th>Payment Status</th>
                    <th>Ordered Status</th>
                    <th>View</th>
                </tr>
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $search_query = '';
                if (!empty($search)) {
                    // $search_query = "WHERE o.O_Id LIKE '%$search%' OR u.U_Fnm LIKE '%$search%' OR p.P_Name LIKE '$search'";
                    $search_query = "WHERE 
                                    o.O_Id LIKE '%$search%' OR 
                                    o.O_Order_Id LIKE '%$search%' OR 
                                    o.O_Sub_Order_Id LIKE '%$search%' OR 
                                    o.O_Add LIKE '%$search%' OR 
                                    o.O_City LIKE '%$search%' OR 
                                    o.O_State LIKE '%$search%' OR 
                                    o.O_Delivery_Status LIKE '%$search%' OR 
                                    o.O_Payment_Status LIKE '%$search%' OR 
                                    u.U_Fnm LIKE '%$search%' OR 
                                    u.U_Lnm LIKE '%$search%' OR 
                                    u.U_Email LIKE '%$search%' OR 
                                    u.U_City LIKE '%$search%' OR 
                                    u.U_State LIKE '%$search%' OR 
                                    p.P_Name LIKE '%$search%' OR 
                                    p.P_Company_Name LIKE '%$search%'";
                }

                $q = "SELECT u.*,o.*,p.* FROM user_tbl u JOIN order_tbl o ON u.U_Email=o.O_U_Email JOIN product_tbl p ON p.P_Id=o.O_P_Id $search_query";
                $result = mysqli_query($con, $q);
                $total_records = mysqli_num_rows($result);

                $records_per_page = 4;

                $total_pages = ceil($total_records / $records_per_page);

                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                $start_from = ($page - 1) * $records_per_page;

                $q = "SELECT u.*,o.*,p.* FROM user_tbl u JOIN order_tbl o ON u.U_Email=o.O_U_Email JOIN product_tbl p ON p.P_Id=o.O_P_Id $search_query order by o.O_Id Desc LIMIT $start_from, $records_per_page";
                $result = mysqli_query($con, $q);


                while ($r = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $r['O_Id'] ?></td>
                        <td><a href="AdUsers.php#user_profile"
                                style="color:white;"><?php echo $r['U_Fnm'] . ' ' . $r['U_Lnm'] ?></a></td>
                        <td><?php echo $r['P_Id'] ?></td>
                        <td><?php echo $r['O_Date'] ?></td>
                        <td><?php echo $r['O_Add'] ?></td>
                        <td><?php echo $r['O_City'] . ',' . $r['O_State'] ?></td>
                        <td><?php echo $r['O_Payment_Status'] ?></td>
                        <td><?php echo $r['O_Delivery_Status'] ?></td>
                        <td>
                            <form method="post" action="AdOrders.php#SeeOrder">
                                <a href="#update_form">
                                    <button type="submit" class="btn btn-dark" value="<?php echo $r['O_Id'] ?>"
                                        name="showOrder" onclick="update(1)"><i class="fa fa-eye"></i>
                                    </button>
                                </a>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div><br>
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
    if (isset($_POST['showOrder'])) {
        //echo $_POST['showUsr'];
        $id = $_POST['showOrder'];

        $query = "SELECT u.*,o.*,p.* FROM user_tbl u JOIN order_tbl o ON u.U_Email=o.O_U_Email JOIN product_tbl p ON p.P_Id=o.O_P_Id where o.O_Id=$id";
        $result = mysqli_query($con, $query);
        $r = mysqli_fetch_assoc($result);
        $p_status = $r['O_Payment_Status'];
        $d_status = $r['O_Delivery_Status'];
        ?>
        <div class="container-fluid bgcolor mt-5" id="SeeOrder">
            <div class="row">
                <!-- Images Column -->
                <div class="col-md-4">
                    <a href="single_product.php?Id=<?php echo $r['P_Id'] ?>">
                        <div class="product-image">
                            <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" height="100px" width="100px"
                                alt="Product Image" class="img-fluid rounded">
                        </div>
                    </a>
                    <label for="name" class="form-label">Product:</label>
                    <p style="font-weight: bold;"><?php echo $r['P_Name']; ?></p>
                </div>
                <!-- Right Column -->
                <div class="col-md-8">
                    <div class="product-image-large">
                        <!-- update information -->
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $r['O_Order_Id']?>" name="Oid">
                            <div id="info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">User Email :</label>
                                        <a href="AdUsers.php"><p style="font-weight: bold;"><?php echo $r['U_Email']; ?></p></a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Total Amount :</label>
                                        <p style="font-weight: bold;"><?php echo $r['O_Total_Amount']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Address :</label>
                                        <p style="font-weight: bold;"><?php echo $r['O_Add']; ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Quantity :</label>
                                        <p style="font-weight: bold;"><?php echo $r['O_Quantity']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">City-Zip, State :</label>
                                        <p style="font-weight: bold;">
                                            <?php echo $r['O_City'] . '-' . $r['O_Zip'] . ', ' . $r['O_State']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Offer Name :</label>
                                        <p style="font-weight: bold;">
                                            <?php $offer = $r['O_Offer_Name'] == '' ? '-' : $r['O_Offer_Name'];
                                            echo $offer; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Order Date :</label>
                                        <p style="font-weight: bold;"><?php echo $r['O_Date']; ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Payment Mode :</label>
                                        <p style="font-weight: bold;"><?php echo $r['O_Payment_Mode']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Delivery Status :</label>
                                        <select class="form-control" name="d_status">
                                            <option <?php if ($d_status == 'Ordered')
                                                echo 'selected'; ?> value="Ordered">Ordered
                                            </option>
                                            <option <?php if ($d_status == 'Shipped')
                                                echo 'selected'; ?> value="Shipped">
                                                Shipped</option>
                                            <option <?php if ($d_status == 'Delivered')
                                                echo 'selected'; ?> value="Delivered">
                                                Delivered</option>
                                            <option <?php if ($d_status == 'Returned')
                                                echo 'selected'; ?> value="Returned">
                                                Returned</option>
                                            <option <?php if ($d_status == 'Replaced')
                                                echo 'selected'; ?> value="Replaced">
                                                Replaced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Payment Status :</label>
                                        <select class="form-control" name="p_status">
                                        <option <?php if ($p_status == 'Panding')
                                                echo 'selected'; ?> value="Panding">
                                                Panding</option>
                                                <option <?php if ($p_status == 'Completed')
                                                echo 'selected'; ?> value="Completed">
                                                Completed</option>
                                                <option <?php if ($p_status == 'Failed')
                                                echo 'selected'; ?> value="Failed">
                                                Failed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                    </div>
                                    <div class="col-md-3 mb-3" style="align-content: end;">
                                        <button class="btn btn-dark" onclick="update(2)"><i
                                                class="fa fa-times"></i></button>
                                        <button type="submit" class="btn btn-dark" name="updateOrder"><i
                                                class="fa fa-arrow-right"></i></button>
                                    </div>
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

    <?php
    include 'Footer.php';

    if(isset($_POST['updateOrder'])){
        $oid=$_POST['Oid'];
        $delivery=$_POST['d_status'];
        $payment=$_POST['p_status'];

        $query="update order_tbl set O_Delivery_Status='$delivery', O_Payment_Status='$payment' where O_Order_Id='$oid'";
        // echo $query;
        if(mysqli_query($con,$query)){
            setcookie('success', "Order updated successfully", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdOrders.php';
            </script>";
            <?php
        }else{
            setcookie('error', "Error in updating order", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdOrders.php';
            </script>";
            <?php
        }
    }
    ?>
</body>

</html>