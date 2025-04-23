<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    include 'Header.php';
    if (!isset($_SESSION['U_Admin']) && !isset($_SESSION['U_User'])) {
        header("Location: Login.php");
        exit();
    }
    $Email_Session = isset( $_GET['Id']) && !empty($_GET['Id'] ) 
            ? $_GET['Id'] 
            : (isset($_SESSION['U_User'])
                ? $_SESSION['U_User'] 
                : $_SESSION['U_Admin']);

    ?>
</head>


<!-- <body style="background-image: url(img/bg6.png);background-size: cover;color:white;"> -->

<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5">
        <div class="row" style="text-align: center;">
            <h2>Order History</h2>
        </div>
    </div>

    <div class="container-fluid bgcolor mt-5 mb-5">
        <?php
        // Fetch order data from the order_tbl
        
        $query = "SELECT o.*,p.* FROM order_tbl o JOIN product_tbl p ON o.O_P_Id=p.P_Id WHERE O_U_Email = '$Email_Session' ORDER BY O_Date DESC";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($order = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row mb-4">
                <!-- Left column : Image -->
                <div class="col-md-4">
                    <a href="single_product.php?Id=<?php echo $order['P_Id'];?>">
                        <div class="product-image-circle">
                            <img src="db_img/product_img/<?php echo $order['P_Img1']?>" alt="product Image" class="img-fluid rounded">
                        </div>
                    </a>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="product-image-large">
                        <h4><?php echo $order['P_Name']?></h4></a>
                        <p class="price" style="font-size: 16px;">Rs. <?php echo $order['O_Total_Amount']?></p>
                        <b>Quantity:</b><?php echo $order['O_Quantity'];?><br>
                        <b>Date & Time:</b><?php echo $order['O_Date']?><br>
                        <b>Status:</b><?php echo $order['O_Delivery_Status'];?>

                    </div>
                </div>
            </div>
            <?php
            }
        } else {
            echo "<p>No orders placed yet.</p>";
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <?php
    include('Footer.php');
    ?>
</body>

</html>