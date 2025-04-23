<?php
include_once "conn.php"; // Ensure you include your database connection

// Check if payment ID and other necessary data are available
if (isset($_POST['payment_id']) && isset($_POST['total_amount'])) {
    $payment_id = $_POST['payment_id'];
    $total_amount = $_POST['total_amount'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $state = $_POST['state'];

    // Prepare the insert query
    $sql = "INSERT INTO offer_tbl (payment_id, total_amount, address, phone, city, zip, state, offer_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sissssss", $payment_id, $total_amount, $address, $phone, $city, $zip, $state);
        $stmt->execute();
        
        // You can also return a response here if needed
        echo "Offer data inserted successfully!";
    } else {
        echo "Error inserting offer data.";
    }
}
?>
