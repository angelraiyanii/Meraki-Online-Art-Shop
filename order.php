<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
    $Email_Session = isset($_SESSION['U_User']) ? $_SESSION['U_User'] : $_SESSION['U_Admin'];
    ?>
    
</head>
<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5">
        <div class="row">
            <h2>Order Details</h2>
            <h6>Enter your order details to buy the product.</h6>
        </div>
        <div class="container-fluid bgcolor mt-3 mb-2" style="padding:20px">
            <div class="row">
                <!-- Left column : Image -->
                <div class="col-md-4">
                    <div class="product-image-circle">
                    <?php
                $query = "SELECT p.*,o.* FROM product_tbl p JOIN orders_tbl o ON p.P_Id=o.or_P_Id WHERE o.or_U_Email='$Email_Session'";
                $result = mysqli_query($con, $query);
                while ($r = mysqli_fetch_assoc($result)) {
                    ?>
                        <!-- <img src="img/easeal1.png" alt="User Image" class="img-fluid rounded"> -->
                         <?php echo $r['P_Img1']; ?>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="product-image-large">
                        <!-- product Information -->
                      
                        <h4>
                            <?php
                            echo $r['P_Name'];
                            ?>
                        </h4>
                        <p class="price" style="font-size: 16px;">Price : <?php echo $r['P_Price'] ?></p>
                        Quantity : <?php echo $r['or_Quantity']; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bgcolor mt-5 mb-5">
        <!-- Add a Review Section -->
        <div class="row mb-3">
            <h4 class="mb-3">Shipping Details</h4>
            <div class="col">
                <form onsubmit="return order()">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">First Name :</label>
                            <input type="text" class="form-control" id="fnm" placeholder="First Name">
                            <span id="fnm_er"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Last Name :</label>
                            <input type="text" class="form-control" id="lnm" placeholder="Last Name">
                            <span id="lnm_er"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Shipping Address :</label>
                            <textarea class="form-control" id="sadd"
                                placeholder="Enter your shipping address"></textarea>
                            <span id="sadd_er"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Payment Address :</label>
                            <textarea class="form-control" id="padd"
                                placeholder="Enter your payment address"></textarea>
                            <span id="padd_er"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">City :</label>
                            <input type="text" class="form-control" id="city" placeholder="Enter City(Shipment)">
                            <span id="city_er"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">State :</label>
                            <input type="text" class="form-control" id="state" placeholder="Enter State(Shipment)">
                            <span id="state_er"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Zip :</label>
                            <input type="text" class="form-control" id="zip" placeholder="Enter Zip code for shipping">
                            <span id="zip_er"></span><br>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <button type="submit" class="cirbutton">
                                <div class="icon-container">
                                    <i class="fa fa-shopping-bag" style="color:white;"></i>
                                </div><span>COD</span>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="cirbutton">
                                <div class="icon-container">
                                    <i class="fa fa-shopping-bag" style="color:white;"></i>
                                </div><span>Pay Now</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Add a Review Section -->
    <!-- <div class="container mt-5">
    <div class="row mt-5">
        <div class="col">
            <h5>Add a review</h5>
            <form>
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name :</label>
                    <input type="text" class="form-control" id="name" placeholder="First Name Last Name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="review" class="form-label">Review</label>
                    <textarea class="form-control" id="review" rows="3"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="rating" class="form-label">Ratings:</label>
                    <div class="stars">
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                        <span class="fa fa-star-o"></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark"><i class="fa fa-arrow-right"></i></button>
            </form>
        </div>
    </div>
  </div> -->

    

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script>
        function order() {
            event.preventDefault();
            
            let validate = true;
            var fn = document.getElementById('fnm');
            var fn_er = document.getElementById('fnm_er');
            var ln = document.getElementById('lnm');
            var ln_er = document.getElementById('lnm_er');
            var sadd = document.getElementById('sadd');
            var sadd_er = document.getElementById('sadd_er');
            var padd = document.getElementById('padd');
            var padd_er = document.getElementById('padd_er');
            var city = document.getElementById('city');
            var city_er = document.getElementById('city_er');
            var state = document.getElementById('state');
            var state_er = document.getElementById('state_er');
            var zip = document.getElementById('zip');
            var zip_er = document.getElementById('zip_er');
            
            NameValidate(fn,fn_er);
            NameValidate(ln,ln_er);
            BigTextValidate(sadd,sadd_er);
            BigTextValidate(padd,padd_er);
            NameValidate(city,city_er);
            NameValidate(state,state_er);
            ZipValidate(zip,zip_er);

            return validate;

        }
    </script>
    <?php
    include('Footer.php');
    ?>
</body>

</html>