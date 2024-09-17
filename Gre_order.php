<?php
require_once 'Connection.php';

// Check if $_POST data is set
if(isset($_POST['paymentId'])) {
    $order_id = $_POST['paymentId'];

    // Prepare and execute the insert statement
    $insert_sql = "INSERT INTO cart (productId, cartProductQuantity, userId) 
                   SELECT productId, paymentProductQuantity, userId
                   FROM payment 
                   WHERE paymentId = ?";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("i", $order_id);

    // Execute the prepared statement
    if($insert_stmt->execute()) {
        echo '<script>alert("Re-Order Successfully!!");
        window.location.href = "Cart.php";</script>';
        exit(); 
    } else {
        // Handle case where insertion fails
        echo "Failed to insert into cart.";
    }
} else {
    // Handle case where $_POST data is missing
    echo "Missing POST data.";
}
?>
