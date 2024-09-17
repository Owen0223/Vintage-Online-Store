<?php
session_start();
require_once 'Connection.php';

if (isset($_POST['method']) && isset($_POST['shippingOption'])) {
    $paymentMethod = $_POST['method'];
    $shippingOption = $_POST['shippingOption'];
    $choices = ($shippingOption === 'pickUp') ? 'Pick Up' : 'Shipping';
} 

$address = $_POST['address'];
$option = $_POST['customize'];
$paymentDate = date('Y-m-d');
$user = $_SESSION['userId'];


$max_payment_id_query = "SELECT MAX(paymentId) AS max_payment_id FROM payment";
$result = $conn->query($max_payment_id_query);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $next_order_id = $row['max_payment_id'] + 1;
} else {
    echo '<script>alert("Error: Failed to fetch maximum payment ID.");</script>';
    exit();
}

        $insert_order_sql = "INSERT INTO payment (paymentId, paymentDate, paymentMethod, paymentChoices, userId, productId, paymentProductQuantity, paymentAddress, paymentProductCus) 
        SELECT ?, ?, ?, ?, userId, productId, cartProductQuantity, ?, ?
        FROM cart WHERE userId = ? ";
        $stmt_order = $conn->prepare($insert_order_sql);
        $stmt_order->bind_param("isssssi", $next_order_id, $paymentDate, $paymentMethod, $choices, $address, $option, $user);
        $stmt_order->execute();
        $stmt_order->close(); 
    
        $sql = "DELETE FROM cart WHERE cart.userId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Payment Successfully!!");
            window.location.href = "receipt.php";</script>';
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
?>
