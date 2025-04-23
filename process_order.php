<?php
session_start();
include 'conn.php';  // Your database connection file

// Check if data is received via GET request
if (isset($_GET['payment_id']) && isset($_GET['order_id']) && isset($_GET['total_amount']) && isset($_GET['email'])) {
    $payment_id = $_GET['payment_id'];
    $order_id = $_GET['order_id'];
    $total_amount = $_GET['total_amount'];
    $email = $_GET['email'];

    // Fetch cart products directly from the cart_tbl based on the user's email
    $query = "SELECT * FROM cart_tbl WHERE Ct_U_Email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Assuming customer address and other details are stored in session
        $address = $_SESSION['user_address'];
        $phone = $_SESSION['user_phone'];
        $city = $_SESSION['user_city'];
        $zip = $_SESSION['user_zip'];
        $state = $_SESSION['user_state'];
        $offer = $_SESSION['offer-name'];

        $total = $_SESSION['total'];

        // Generate a unique sub-order ID
        $sub_order_id = uniqid();

        // Prepare the SQL query for each product in the cart
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['Ct_P_Id'];  // The product ID in the cart
            $quantity = $row['Ct_Quantity'];  // The quantity of the product
            // $Payment_Status = Paid;

            // Prepare the SQL insert statement for the order
            $query = "INSERT INTO order_tbl 
    (O_U_Email, O_Order_Id, O_Sub_Order_Id, O_P_Id, O_Total_Amount, O_Quantity, O_Add, O_Phn, O_City, O_Zip, O_State,O_Delivery_Status, O_Payment_Status, O_Offer_Name, O_Payment_Mode, O_Date) 
    VALUES 
    ('$email', '$order_id', '$sub_order_id', '$product_id', '$total', '$quantity', '$address', '$phone', '$city', '$zip', '$state','Delivered', 'Completed', '$offer', 'Online', NOW())";

            // Execute the query
            if (!mysqli_query($con, $query)) {
                echo 'Error while inserting order details';
                exit();
            }

            // Update the product stock in the product_tbl
            $update_stock_query = "UPDATE product_tbl SET P_Stock = P_Stock - $quantity WHERE P_Id = '$product_id'";

            if (!mysqli_query($con, $update_stock_query)) {
                echo 'Error while updating product stock';
                exit();
            }

        }

        // After successfully inserting into the order table, empty the cart
        $delete_query = "DELETE FROM cart_tbl WHERE Ct_U_Email = '$email'";

        if (mysqli_query($con, $delete_query)) {
            // Redirect to the order history page after clearing the cart
            header('Location: orderHistory.php');
            exit();
        } else {
            echo 'Error while emptying the cart';
            exit();
        }

        // // After all products are inserted, you can redirect to an order confirmation page
        // header('Location: orderHistory.php');
        // exit();
    } else {
        echo 'Cart is empty.';
    }
} else {
    // If necessary parameters are missing, redirect to error page or show a message
    echo 'Payment details are missing.';
}
?>