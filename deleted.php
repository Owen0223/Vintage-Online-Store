<?php
    require_once 'Connection.php';
        $cartId = $_POST['cartId'];
    
        $sql = "DELETE FROM cart WHERE CartID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cartId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Record deleted successfully");
            window.location.href = "Cartlist.php";</script>';
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
?>