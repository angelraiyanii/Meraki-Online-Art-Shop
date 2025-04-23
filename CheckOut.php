<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    include 'Header.php';
    require 'vendor/autoload.php';

    // session of logged in user
    if (!isset($_SESSION['U_Admin']) && !isset($_SESSION['U_User'])) {
        header("Location: Login.php");
        exit();
    }
    $Email_Session = isset($_SESSION['U_User']) ? $_SESSION['U_User'] : $_SESSION['U_Admin'];

    // Razorpay Integration - Generate Order ID
    if (isset($_SESSION['total'])) {
        $new_cart_total = $_SESSION['total'];  // Assuming the total amount is in session
        
    
        // Initialize Razorpay API
        $api = new Razorpay\Api\Api('rzp_test_yCgrsfXSuM7SxL', 'eaxt0pkgow03xe2s2ufGFmBK');

        $orderData = [
            'receipt' => 'order_rcptid_' . uniqid(),
            'amount' => $new_cart_total * 100,  // Amount in paise
            'currency' => 'INR',
            'payment_capture' => 1  // Auto capture the payment after the transaction
        ];

        $razorpayOrder = $api->order->create($orderData);
        $_SESSION['razorpay_order_id'] = $razorpayOrder['id'];  // Store Razorpay order ID in session
    }
    ?>
</head>

<body class="bg-dark">
    <div class="container-fluid mt-5 bgcolor">
        <div class="row mb-5" style="text-align: center;">
            <h2>Payment for <?php echo $Email_Session?></h2>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <form method="POST">
                    <div class="form-group">
                        <label for="total"><b>Net Payable Amount</b></label>
                        <input type="text" class="form-control" readonly value="<?php echo $_SESSION['total']; ?>">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="order_id"><b>Order ID</b></label>
                        <input type="text" class="form-control" readonly
                            value="<?php echo isset($_SESSION['razorpay_order_id']) ? $_SESSION['razorpay_order_id'] : 'Order ID not generated'; ?>" />
                    </div>
                    <br>
                    <button id="rzp-button" class="btn btn-dark" type="button">Pay Now</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        // Attach event to the Pay Now button
        $('#rzp-button').click(function (e) {
            e.preventDefault();

            var razorpay_order_id = '<?php echo isset($_SESSION['razorpay_order_id']) ? $_SESSION['razorpay_order_id'] : ''; ?>';  // Fetch Razorpay Order ID from session
            var razorpay_key_id = 'rzp_test_yCgrsfXSuM7SxL';  // Your Razorpay key ID

            if (!razorpay_order_id) {
                alert('Order ID not generated.');
                return;
            }

            var options = {
                "key": razorpay_key_id,
                "amount": <?php echo $_SESSION['total'] * 100; ?>,  // Amount in paise
                "currency": "INR",
                "order_id": razorpay_order_id,  // Razorpay order ID
                "name": "Meraki:Fine art supplies",
                "description": "Check Out",
                "image": "img/logo1.png",  // Logo for your business
                "handler": function (response) {
                    console.log(response);
                    // If payment is successful
                    alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);

                    // Redirect to the server-side script for order processing
                    var redirect_url = "process_order.php?payment_id=" + response.razorpay_payment_id +
                        "&order_id=" + response.razorpay_order_id +
                        "&total_amount=" + <?php echo $_SESSION['total'] * 100; ?> +
                        "&email=<?php echo $Email_Session; ?>";

                    // Redirect to the order processing page
                    window.location.href = redirect_url;
                },
                "modal": {
                    "ondismiss": function () {
                        alert('Payment process was cancelled');
                    }
                },
                "error": function (error) {
                    alert("Payment Failed: " + error.error.description);
                },
                "prefill": {
                    "name": "Customer Name",  // Prefill customer's name (can fetch from session or database)
                    "email": "<?php echo $Email_Session; ?>",  // Prefill customer's email (can fetch from session)
                    "contact": "Customer Contact"  // Prefill customer's contact number
                },
                "theme": {
                    "color": "#000000"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
        });
    </script>

    <?php
    include 'Footer.php';
    ?>
</body>

</html>