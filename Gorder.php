<?php
require_once 'Connection.php';

$query = "SELECT p.productName, p.productPrice, u.userName, u.userEmail, pay.* 
          FROM payment AS pay 
          JOIN users AS u ON pay.userId = u.userId 
          JOIN product AS p ON pay.productId = p.productId 
          ORDER BY pay.paymentId";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            text-align: center;
        }

        table {
            margin: 0 auto;
            margin-top: 20px;
            width: 50%;
            text-align: left;
        }

        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            background-color: #F7418F;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            width: 100px;
            height: 30px;
        }

        .button:hover {
            background-color: #FFD0EC;
        }
    </style>
</head>
<body>

<?php
$current_paymentId = null; // Initialize current paymentId variable

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['paymentId'] !== $current_paymentId) {
        // Start new table for each paymentId
        if ($current_paymentId !== null) {
            // Output total price for the order
            echo "<tr><td>TOTAL:</td><td colspan='3'>" . $total . "</td></tr>";
            echo "</table>";
            // Output reorder button
            echo "</br><form action='Gre_order.php' method='post'>";
            echo "<input type='hidden' name='paymentId' value='" . $current_paymentId . "'>";
            echo "<input type='submit' class='button' name='Re-order' value='Re-Order'>";
            echo "</form>";
        }
        echo "<table border='1'>";
        // Output shared payment information
        echo "<tr><td>NAME:</td><td colspan='3'>" . $row['userName'] . "</td></tr>";
        echo "<tr><td>EMAIL:</td><td colspan='3'>" . $row['userEmail'] . "</td></tr>";
        echo "<tr><td>PAYMENT METHOD:</td><td colspan='3'>" . $row['paymentMethod'] . "</td></tr>";
        echo "<tr><td>LOGISTICS CHOICES:</td><td colspan='3'>" . $row['paymentChoices'] . "</td></tr>";
        echo "<tr><td>YOUR ORDERS:</td><td colspan='3'>";
        $total = 0; // Initialize total price for the current order
    }
    // Output product details for each order
    echo $row['productName'] . " x " . $row['paymentProductQuantity'] . "<br>";
    $total += ($row['productPrice'] * $row['paymentProductQuantity']); // Add the price of each product to the total
    $current_paymentId = $row['paymentId'];
}
// Output total price for the last order
echo "<tr><td>TOTAL:</td><td colspan='3'>" . $total . "</td></tr>";
echo "</table>";
// Output reorder button for the last order
echo "</br><form action='Gre_order.php' method='post'>";
echo "<input type='hidden' name='paymentId' value='" . $current_paymentId . "'>";
echo "<input type='submit' class='button' name='Re-order' value='Re-Order'>";
echo "</form>";
?>

</body>
</html>
