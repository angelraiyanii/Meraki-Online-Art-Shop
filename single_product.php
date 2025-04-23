<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Product Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <style>
        .art-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .art-item {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
        }

        tr {
            /* border: 2px solid #ddd; */
            text-align: center;
        }

        table {
            width: 100%;
            /* border: 2px solid #ddd; */
        }

        th,
        td {
            width: 100%;
            /* border: 2px solid #ddd; */
            padding: 10px;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 20%;
            text-align: left;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 40%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 30%;
            text-align: right;
        }
    </style>
    <?php
    include 'Header.php';
    // error_reporting(0);
    // session_start();
    // if (!isset($_SESSION['U_User']) && !isset($_SESSION['U_Admin'])) {
    //     header("Location: Login.php");
    //     exit();
    // }
    if (isset($_SESSION['U_Admin']) || isset($_SESSION['U_User'])) {
        // header("Location: Login.php");
        // exit();
        $Email_Session = isset($_SESSION['U_User']) ? $_SESSION['U_User'] : $_SESSION['U_Admin'];
    }

    ?>
</head>

<?php
$id = $_GET['Id'];

$querySelect = "Select p.*,s.SC_Id,c.C_Id from product_tbl p JOIN subcategory_tbl s ON p.P_SC_Id=s.SC_Id JOIN category_tbl c ON s.C_Id=c.C_Id where p.P_Id=$id";
$resultSelect = mysqli_query($con, $querySelect);
if ($resultSelect) {
    if (mysqli_num_rows($resultSelect) > 0) {
        $rSelect = mysqli_fetch_assoc($resultSelect);
        $sc_id = $rSelect['P_SC_Id'];
        $c_id = $rSelect['C_Id'];

        // $qRating = "SELECT SUM(R_Rating)/COUNT(R_Rating) as avg FROM review_tbl WHERE R_P_Id= '$id'";
// $avg = mysqli_fetch_assoc(mysqli_query($con, $qRating));
// Calculate average rating, if no reviews, set to 0
        $qRating = "SELECT SUM(R_Rating) / COUNT(R_Rating) as avg FROM review_tbl WHERE R_P_Id = '$id'";
        $avgResult = mysqli_query($con, $qRating);
        $avg = mysqli_fetch_assoc($avgResult);

        // If there are no reviews, set average rating to 0
        $rating = isset($avg['avg']) ? $avg['avg'] : 0;
        ?>

        <body class="bg-dark">
            <div class="container-fluid mt-5 bgcolor">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-4">
                        <h3 class="mb-5" style="color:white;"><?php echo $rSelect['P_Company_Name'] ?></h3>
                        <p class="price" style="color:white;">Rs. <?php echo $rSelect['P_Price'] ?></p>
                        <div class="product-image">
                            <img src="db_img/product_img/<?php echo $rSelect['P_Img1'] ?>" alt="Product Image"
                                class="img-fluid rounded">
                        </div>
                        <form method="POST" action="single_product.php?Id=<?php echo $rSelect['P_Id']; ?>">
                            <div class="quantity mt-3">
                                <label for="quantity">Quantity:</label>
                                <select name="quan" class="form-select">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="col-md-8 mt-3">
                                <a href="order.php?id=<?php echo $rSelect['P_Id'] ?>"><button type="submit" name="order"
                                        id="order" class="cirbutton">
                                        <div class="icon-container">
                                            <i class="fa fa-shopping-bag" style="color:white;"></i>
                                        </div><span>Buy Now</span>
                                    </button></a><br /><br />
                                <a href="cart.php?id=<?php echo $rSelect['P_Id'] ?>"><button type="submit" name="cart" id="cart"
                                        class="cirbutton">
                                        <div class="icon-container">
                                            <i class="fa fa-shopping-cart" style="color:white;"></i>
                                        </div><span>Add to Cart</span>
                                    </button></a>
                                <br /><br />
                                <a href="wishlist.php" value="<?php echo $rSelect['P_Id'] ?>"><button type="submit"
                                        class="cirbutton" name='wish' id='wish'>
                                        <div class="icon-container">
                                            <i class="fa fa-heart" style="color: white;"></i>
                                        </div><span>Add to Wishlist</span>
                                    </button></a>
                            </div>
                        </form>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-8">
                        <h2 class="mb-5" style="color:white;"><?php echo $rSelect['P_Name'] ?></h2>
                        <div class="product-image-large">
                            <img src="db_img/product_img/<?php echo $rSelect['P_Img2'] ?>" alt="Large Product Image"
                                class="img-fluid rounded">
                            <div class="description-on-hover">
                                <p><?php echo $rSelect['P_Desc'] ?></p>
                                <div class="stars">
                                    <?php
                                    // $rating = intval($avg['avg']); // Assuming the column name for rating is P_Rating
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="fa fa-star"></span>'; // Filled star
                                        } else {
                                            echo '<span class="fa fa-star-o"></span>'; // Empty star
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Add a Review Section -->
    <?php
    if (isset($Email_Session) && !empty($Email_Session)) {
        $checkReview = "SELECT * FROM review_tbl WHERE R_P_Id='$id' AND R_U_Email='$Email_Session' ";
        $checkReviewData = mysqli_num_rows(mysqli_query($con, $checkReview));

        if ($checkReviewData > 0) {
            // echo 'chipcip';
            // setcookie('success', "You've already reviewed this product once.", time() + 5, "/");
        } else {
            $checkOrderStat = "SELECT * FROM order_tbl WHERE O_U_Email='$Email_Session' AND O_P_Id='$id' AND O_Delivery_Status='Delivered'
                       AND O_Payment_Status='Completed' ";
            $checkOrderStatData = mysqli_query($con, $checkOrderStat);

            // Fetch the first row of the result as an associative array
            $orderData = mysqli_fetch_assoc($checkOrderStatData);

            if ($orderData == false) {
                setcookie('success', "You can review this product after confirmed order.", time() + 5, "/");
            } else {
                // Fetch the order ID from the associative array
                $o_id = $orderData['O_Order_Id'];
                // echo $o_id;

                // Continue with your review form
                ?>
                <div class="container-fluid mt-5 bgcolor">
                    <div class="row">
                        <div class="col">
                            <h2>Add a review</h2>
                            <form method="post">
                                <input type="hidden" value="<?php echo $o_id; ?>" name="O_id">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name :</label>
                                        <input type="text" class="form-control" id="name" name="nm"
                                            placeholder="First Name Last Name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Email :</label>
                                        <input type="text" class="form-control" id="email" value="<?php echo $Email_Session; ?>"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="review" class="form-label">Review</label>
                                        <textarea class="form-control" id="review" name="reviewText" rows="3"></textarea>
                                    </div>

                                    <!-- Ratings -->
                                    <div class="col-md-6">
                                        <label for="rating" class="form-label">Rating</label>
                                        <div class="star-rating">

                                            <input type="radio" name="rating" id="r5" value="5" class="star-input" required>
                                            <label for="r5" class="star-label">&#9733;</label>

                                            <input type="radio" name="rating" id="r4" value="4" class="star-input" required>
                                            <label for="r4" class="star-label">&#9733;</label>

                                            <input type="radio" name="rating" id="r3" value="3" class="star-input" required>
                                            <label for="r3" class="star-label">&#9733;</label>

                                            <input type="radio" name="rating" id="r2" value="2" class="star-input" required>
                                            <label for="r2" class="star-label">&#9733;</label>

                                            <input type="radio" name="rating" id="r1" value="1" class="star-input" required>
                                            <label for="r1" class="star-label">&#9733;</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-dark" name="SubmitReview">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } else {
        echo '<div class="container-fluid mt-5 bgcolor">
                <div class="row">
                    <p>Please log in to leave a review.</p>
                </div>
              </div>';
    }
    ?>

    <!-- similar products area -->
    <div class="container-fluid mt-5 mb-5 bgcolor">
        <section class="featured" id="latest">
            <h2>Featured Products</h2>
            <div class="row mt-1">
                <div class="art-grid">
                    <?php
                    // $q = "Select * from product_tbl where P_SC_Id=$sc_id";
                    $qSimilar = "Select p.*,s.SC_Id,c.C_Id from product_tbl p JOIN subcategory_tbl s ON p.P_SC_Id=s.SC_Id JOIN category_tbl c ON s.C_Id=c.C_Id where p.P_Id != $id AND (s.C_Id=$c_id OR p.P_SC_Id=$sc_id )";
                    $result = mysqli_query($con, $qSimilar);
                    if (mysqli_num_rows($result)) {
                        while ($rSimilar = mysqli_fetch_assoc($result)) {
                            $discount = $rSimilar['P_Discount'];
                            $original_price = $rSimilar['P_Price'];
                            $discounted_price = $original_price - ($original_price * $discount / 100);
                            ?>
                            <!-- <div class="card">
                            <a href="single_product.php?Id=<?php echo $r['P_Id'] ?>" class="card">
                                <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" class="card__image"
                                    alt="<?php echo $r['P_Name']; ?>" />
                                <div class="card__overlay">
                                    <div class="card__header">
                                        <div class="card__header-text">
                                            <h3 class="card__title"><?php echo $r['P_Name'] ?></h3>
                                            <span class="card__status">Rs. <?php echo $r['P_Price'] ?></span>
                                        </div>
                                    </div>
                                    <p class="card__description"><?php echo $r['P_Company_Name'] ?></p>
                                </div>
                            </a>
                        </div> -->

                            <div class="card <?php echo ($rSimilar['P_Stock'] == 0) ? 'out-of-stock' : ''; ?>">
                                <?php if ($discount > 0 && $rSimilar['P_Stock'] > 0) { ?>
                                    <div class="ribbon"><?php echo $discount; ?>% off</div>
                                <?php } ?>
                                <img src="db_img/product_img/<?php echo $rSimilar['P_Img1'] ?>" class="card__image"
                                    alt="<?php echo $rSimilar['P_Name']; ?>" />
                                <?php if ($rSimilar['P_Stock'] == 0) { ?>
                                    <!-- Always visible Out of Stock badge -->
                                    <div class="out-of-stock-badge">Out of Stock</div>
                                <?php } ?>
                                <div class="card__overlay">
                                    <div class="card__header">
                                        <div class="card__header-text">
                                            <h3 class="card__title"><?php echo $rSimilar['P_Name'] ?></h3>
                                            <?php if ($discount > 0 && $rSimilar['P_Stock'] > 0) { ?>
                                                <span class="card__status">
                                                    <span style="text-decoration: line-through; color: #888;">Rs.
                                                        <del><?php echo number_format($original_price, 2); ?></del></span>
                                                    <span style="color: #f00;"> Rs.
                                                        <?php echo number_format($discounted_price, 2); ?></span>
                                                </span>
                                            <?php } else { ?>
                                                <span class="card__status">Rs.
                                                    <?php echo number_format($original_price, 2); ?></span>
                                            <?php } ?>
                                            <p><?php echo $rSimilar['P_Company_Name'] ?></p>
                                        </div>
                                    </div>
                                    <?php if ($rSimilar['P_Stock'] > 0) { ?>
                                        <form method="post">
                                            <p class="card__description">
                                                <input type="hidden" name="p_id" value="<?php echo $rSimilar['P_Id']; ?>">
                                                <a href="single_product.php?Id=<?php echo $rSimilar['P_Id'] ?>">
                                                    <button type="button" class="btn btn-dark">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                <a href="cart.php">
                                                    <button type="submit" name="cart" class="btn btn-dark">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </button>
                                                </a>
                                                <a href="wishlist.php">
                                                    <button type="submit" name="wish" class="btn btn-dark">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </a>
                                            </p>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '';
                    } ?>
                </div>
            </div>
        </section>
    </div>

    <?php
    } else {
        echo '<body class="bg-dark">
            <div class="container-fluid mt-5 bgcolor">
                <div class="row">No product found for this ID.</div></div>';
    }
} else {
    echo '<body class="bg-dark">
            <div class="container-fluid mt-5 bgcolor">
                <div class="row">Error in SQL query: ' . mysqli_error($con).'</div></div>';
}
?>
    <div class="container-fluid mt-5 mb-5 bgcolor">
        <section class="featured" id="latest">
            <h2>Reviews</h2>
            <div class="row mt-1">
                <div class="row" id="product">
                    <table>
                        <!-- <tr>
                            <th>img</th>
                            <th>nm</th>
                            <th>text</th>
                            <th>stars</th>
                        </tr> -->
                        <?php
                        $q = "SELECT r.*,u.* FROM review_tbl r JOIN user_tbl u ON r.R_U_Email=u.U_Email where r.R_P_Id='$id' ORDER BY r.R_Id DESC LIMIT 3";
                        $resultreview = mysqli_query($con, $q);

                        if (mysqli_num_rows($resultreview) > 0) {
                            while ($review = mysqli_fetch_assoc($resultreview)) {
                                ?>
                                <tr>
                                    <td><img src="db_img/user_img/<?php echo $review['U_Profile']; ?>" alt="User Image"
                                            class="user-image"></td>
                                    <td><?php echo $review['R_U_Name'] ?><br>
                                        <p style="text-size:2px"><?php echo $review['R_U_Email'] ?></p>
                                    </td>
                                    <td><?php echo $review['R_Review'] ?></td>
                                    <td>
                                        <div class="stars-review">
                                            <?php
                                            $rating = $review['R_Rating']; // Assuming the column name for rating is R_Rating
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $rating) {
                                                    echo '<span class="fa fa-star"></span>'; // Filled star
                                                } else {
                                                    echo '<span class="fa fa-star-o"></span>'; // Empty star
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            // No reviews
                            echo '<tr><td colspan="4">No reviews available.</td></tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <?php
    include "Footer.php";
    // order
    if (isset($_POST['order'])) {
        $or_Quantity = $_POST['quan'];
        $or_P_Id = $id;
        $or_U_Email = $Email_Session;

        $sql = "INSERT INTO orders_tbl (or_U_Email,or_P_Id, or_Quantity) VALUES ('$or_U_Email', '$or_P_Id', '$or_Quantity')";
        $data = mysqli_query($con, $sql);

        if ($data) {
            echo "<script>location.replace('order.php');</script>";
        } else {
            echo "Error inserting data into wishlist";
        }

    }
    // cart
    if (isset($_POST['cart'])) {
        $Ct_Quantity = $_POST['quan'];
        $Ct_P_Id = $id;
        $Ct_U_Email = $Email_Session;

        $chechQuery = "select * from cart_tbl where Ct_P_Id='$Ct_P_Id' And Ct_U_Email='$Ct_U_Email'";
        $CheckData = mysqli_num_rows(mysqli_query($con, $chechQuery));

        if ($CheckData == 0) {
            $sql = "INSERT INTO cart_tbl (Ct_Quantity, Ct_P_Id, Ct_U_Email) VALUES ('$Ct_Quantity', '$Ct_P_Id', '$Ct_U_Email')";
            $data = mysqli_query($con, $sql);

            if ($data) {
                echo "<script>location.replace('cart.php');</script>";
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
    // wishlist
    if (isset($_POST['wish'])) {
        $W_Quantity = $_POST['quan'];
        $W_P_Id = $id;
        $W_U_Email = $Email_Session;

        $checkQuery = "select * from wishlist_tbl where W_P_Id=$W_P_Id And W_U_Email=$W_U_Email";
        $CheckData = mysqli_query($con, $checkQuery);

        if (!$CheckData) {
            $sql = "INSERT INTO wishlist_tbl (W_U_Email,W_P_Id, W_Quantity) VALUES ('$W_U_Email', '$W_P_Id', '$W_Quantity')";
            $data = mysqli_query($con, $sql);

            if ($data) {
                echo "<script>location.replace('wishlist.php');</script>";
            } else {
                echo "Error inserting data into wishlist";
            }
        } else {
            setcookie('success', "This product is already in your Wishlist!!!", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'wishlist.php';
            </script>";
            <?php
        }

    }
    // review
    if (isset($_POST['SubmitReview'])) {
        $userEmail = $Email_Session;
        $userName = $_POST['nm'];
        $reviewText = $_POST['reviewText'];
        $orderId = $_POST['O_id'];
        $rating = $_POST['rating'];  // Fetch the rating directly
    
        $query = "INSERT INTO review_tbl (R_U_Email, R_U_Name, R_Order_Id, R_P_Id, R_Rating, R_Review, R_Date)
                  VALUES ('$userEmail', '$userName', '$orderId', '$id', '$rating', '$reviewText', NOW())";

        echo $query;

        if (mysqli_query($con, $query)) {
            setcookie('success', 'Review Added', time() + 5, "/");
            ?>
            <script>
                window.location.href = "single_product.php?Id=<?php echo $id ?>";
            </script>
            <?php
        } else {
            setcookie('error', 'Error in adding Review', time() + 5, "/");
            ?>
            <script>
                window.location.href = "single_product.php?Id=<?php echo $id ?>";
            </script>
            <?php
        }
    }

    ?>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>