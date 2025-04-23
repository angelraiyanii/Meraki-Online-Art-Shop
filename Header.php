<?php
session_start();
ob_start();
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <!-- <script src="js/jquery.validate.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/additional-methods.js"></script> -->
    <style> 
        .header {
            background-color: rgba(165, 165, 165, 0.7);
            padding: 10px 20px;
            border-radius: 30px;
            margin: 20px 5%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 30px;
        }

        .nav a {
            margin: 0 15px;
            text-decoration: none;
            color: white;
            font-size: 16px;
        }

        .login-register a {
            text-decoration: none;
            color: white;
            font-size: 16px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: rgba(165, 165, 165, 0.7);
            min-width: 160px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px 4px;
            z-index: 0;
        }

        .dropdown-menu {
            background-color: rgba(165, 165, 165, 0.7);
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            .nav a {
                margin: 5px 0;
            }

            .login-register {
                width: 100%;
                text-align: right;
            }
        }
    </style>
</head>

<body>
    <?php
    // Success cookie
     if (isset($_COOKIE['success'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert"> 
             <strong>Success!</strong> <?php echo $_COOKIE['success']; ?> 
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
    // Error cookie
    if (isset($_COOKIE['error'])) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?php echo $_COOKIE['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
   }
   
   // Clear cookies
    if (isset($_COOKIE['success']) || isset($_COOKIE['error'])) {
        setcookie('success', '', time() - 3600, '/');
        setcookie('error', '', time() - 3600, '/');
    }
    ?>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand logo" href="index.php">
                    <img src="img/logo1.png" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <?php if (isset($_SESSION['U_Admin'])) { ?>
                            <!-- Admin Menu -->
                            <li class="nav-item"><a class="nav-link" href="admin.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="admin.php#discount">Discount/Offers</a></li>
                            <li class="nav-item"><a class="nav-link" href="AdProducts.php">Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="AdUsers.php">Users</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Other</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="AdOrders.php">Orders</a></li>
                                    <li><a class="dropdown-item" href="AdCategory.php">Category</a></li>
                                    <li><a class="dropdown-item" href="AdSubcategory.php">Sub Category</a></li>
                                    <li><a class="dropdown-item" href="AdOffers.php">Offers</a></li>
                                    <li><a class="dropdown-item" href="AdReview.php">Reviews</a></li>
                                    <li><a class="dropdown-item" href="AdContactUs.php">Contact</a></li>
                                    <li><a class="dropdown-item" href="AdAboutUs.php">About Us</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">User Side</a>
                                <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php">Home</a></li>
                                    <li><a class="dropdown-item" href="index.php#latest">Latest</a></li>
                                    <li><a class="dropdown-item" href="Categories.php">Categories</a></li>
                                    <li><a class="dropdown-item" href="About.php">About Us</a></li>
                                </ul>
                            </li>

                        <?php } elseif (isset($_SESSION['U_User'])) { ?>
                            <!-- User Menu -->
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php#latest">Latest</a></li>
                            <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                            <li class="nav-item"><a class="nav-link" href="About.php">About Us</a></li>

                        <?php } else { ?>
                            <!-- Guest Menu -->
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php#latest">Latest</a></li>
                            <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                            <li class="nav-item"><a class="nav-link" href="About.php">About Us</a></li>
                        <?php } ?>
                    </ul>

                    <!-- account menu -->
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <?php if (isset($_SESSION['U_Admin']) || isset($_SESSION['U_User'])) { ?>
                            <li class="nav-item dropdown login-register">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="Account.php">My Profile</a></li>
                                    <li><a class="dropdown-item" href="cart.php">Cart</a></li>
                                    <li><a class="dropdown-item" href="wishlist.php">Wish List</a></li>
                                    <li><a class="dropdown-item" href="orderHistory.php">Order History</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item login-register">
                                <a class="nav-link" href="Login.php">Login</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>