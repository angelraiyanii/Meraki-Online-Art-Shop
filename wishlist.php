<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
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
    $Email_Session = isset($_GET['Id']) && !empty($_GET['Id'])
        ? $_GET['Id']
        : (isset($_SESSION['U_User'])
            ? $_SESSION['U_User']
            : $_SESSION['U_Admin']);

    $query = "SELECT p.*,w.* FROM product_tbl p JOIN wishlist_tbl w ON p.P_Id=w.W_P_Id WHERE w.W_U_Email='$Email_Session' order by w.W_Id desc";
    $result = mysqli_query($con, $query);
    ?>
</head>

<body class="bg-dark">
    <div class="container-fluid mt-5 bgcolor">
        <div class="row" style="text-align: center;">
            <h2>Welcome to Wishlist!</h2>
            <div class="col-md-6">
                <p> </p>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-dark">Remove All</button>
            </div>

        </div>
    </div>

    <div class="container-fluid mt-5 mb-5 bgcolor">
        <?php
        while ($r = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row mb-5">
                <!-- Left column : Image -->
                <div class="col-md-3">
                    <div class="product-image-circle">
                        <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" alt="User Image" class="img-fluid rounded">
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="product-image-large">
                        <!-- product Information -->
                        <h4><?php echo $r['P_Name'] ?></h4>
                        <p class="price" style="font-size: 16px;">Rs. <?php echo $r['P_Price'] ?></p>
                        <p><?php echo $r['P_Company_Name'] ?></p>
                        <a href="single_product.php?Id=<?php echo $r['W_P_Id'] ?>"><button class="btn btn-dark">See
                                Product</button></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-image-large">
                        <form method="post">
                            <input type="hidden" name="W_Id" value="<?php echo $r['W_Id'] ?>">
                            <input type="hidden" name="W_P_Id" value="<?php echo $r['W_P_Id'] ?>">
                            <input type="hidden" name="W_U_Email" value="<?php echo $Email_Session ?>">
                            <a href="cart.php"><button type="submit" class="btn btn-dark" name="addCart"><i
                                        class="fa fa-shopping-cart"></i></button></a>
                            <!-- <a href="order.php"><button type="submit" class="btn btn-dark"><i
                                        class="fa fa-arrow-right"></i></button></a> -->
                            <button type="submit" class="btn btn-dark" name="deleteitem"><i
                                    class="fa fa-times"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    <?php
    include 'Footer.php';

    // add to cart
    if (isset($_POST['addCart'])) {
        $pid = $_POST['W_P_Id'];

        $chechQuery = "select * from cart_tbl where Ct_P_Id=$pid And Ct_U_Email=$Email_Session";
        $CheckData = mysqli_query($con, $chechQuery);

        $chechQuery = "select * from cart_tbl where Ct_P_Id=$pid And Ct_U_Email='$Email_Session'";
        $CheckData = mysqli_num_rows(mysqli_query($con, $chechQuery));
        if ($CheckData == 0) {
            $sql = "INSERT INTO cart_tbl (Ct_Quantity, Ct_P_Id, Ct_U_Email) VALUES ('1', '$pid', '$Email_Session')";
            $data = mysqli_query($con, $sql);

            if ($data) {
                echo "<script>window.location.href='cart.php';</script>";
            } else {
                echo "Error inserting data into cart";
            }
        } else {
            setcookie('success', "This product is already in cart!!!", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'cart.php';
            </script>";
            <?php
        }
    }

    // delete from wishlist
    if (isset($_POST['deleteitem'])) {
        $id = $_POST['W_Id'];

        $query = "delete from wishlist_tbl where W_Id=$id";
        $data = mysqli_query($con, $query);

        if ($data) {
            setcookie('success', "Product removed from wishlist", time() + 5, "/");
            ?>
            <script>
                window.location.href = "wishlist.php";
            </script>
            <?php
        }
        // echo $id;
    }
    ?>
</body>

</html>