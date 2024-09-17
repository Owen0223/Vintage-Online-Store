<!DOCTYPE html>

<?php
    require_once 'Connection.php';
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./assets/css/admin_styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
</head>


<body>
    
    <style>
        .logout{
            color: white;
            right: 1rem;
            padding: 0.5rem 1rem 0.5rem 1rem;
            float: right;
            background-color: red;
            /* border: 1 solid hsla(0, 0%, 100%, 0.1); */
            border-radius: 0.5rem 0.5rem 0.5rem 0.5rem;
        }
    </style>
    
    <main>
    <a href="?logout=1" class="logout">Logout</a>
    <?php
        if(isset($_GET['logout'])) {
            session_start();
            // Quit the session
            session_destroy();
            echo "<script>alert('Logout Successfull.'); window.close(); </script>";
            // Redirect to the same page to reflect the changes
            header("Location: ../Group Assignment/login.php");
            exit;
        }
    ?>
        <h1 class="page-title">Administrator Dashboard</h1>

        <!-- FORM: ADD PRODUCT -->
        <h2 class="add">Add product</h2>
        <div class="add">
            <form action="admin.php" method='post'>
                <table>
                    <tr>
                        <td>Product Category:</td>
                        <td>
                            <select name="productCategory">
                                <option value="Wearable Items">Wearable Items</option>
                                <option value="Ornaments">Ornaments</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Tools">Tools</option>
                                <option value="Ceramics">Ceramics</option>
                                <option value="Artwork">Artwork</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Product Name:</td>
                        <td><input type="text" name="productName"></td>
                    </tr>
                    <tr>
                        <td>Product Description:</td>
                        <td><input type="text" name="productDes"></td>
                    </tr>
                    <tr>
                        <td>Product Image Link:</td>
                        <td><input type="text" name="productImgUrl"></td>
                    </tr>
                    <tr>
                        <td>Unit Price:</td>
                        <td><input type="text" name="productPrice"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" value="Submit" class="add" name="add_action"></td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- PREVIEW -->
        <div class="preview">
                <h2>Update product</h2>
                <form action="admin.php" method='GET'>
                    <table>
                        <tr>
                            <td>Product ID:</td>
                            <td><input type="text" name="productId"></td>
                            </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="Preview" name="preview"></td>
                        </tr>
                    </table>
                </form>

                <table border=5 class="preview">
                    <tr>
                        <th>Product Image</th>
                        <th>Product ID</th>
                        <th>Product Category</th>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Unit Price</th>
                    </tr>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        if (isset($_GET['preview'])) {
                        // Check if every field is filled up.
                        // IF one of the field is empty, THEN display 'Fill in all the information'

                            if (!empty($_GET['productId'])) {
                                // Get all the information from the form GET methods to the local variables
                                $productId = $_GET['productId'];
                                $query = "SELECT * FROM product WHERE productId = $productId";
                                $result = mysqli_query($conn, $query);
                                
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['productImgUrl'] . "</td>";
                                    echo "<td>" . $row['productId'] . "</td>";
                                    echo "<td>" . $row['productCategory'] . "</td>";
                                    echo "<td>" . $row['productName'] . "</td>";
                                    echo "<td>" . $row['productDesc'] . "</td>";
                                    echo "<td>" . $row['productPrice'] . "</td>";
                                    echo "</tr>";
                                }

                            }
                        }
                    }
                ?>
                </table>
        </div>

        <!-- UPDATE PRODUCT -->
        <div class="update">
                <h2 class="update">Enter latest information</h2>
                <form class="update" action="admin.php" method='post'>
                    <table>
                        <tr>
                            <td>Product ID:</td>
                            <td><input type="text" name="productId"></td>
                        </tr>
                        <tr>
                            <td>Product Category:</td>
                            <td>
                                <select name="productCategory">
                                    <option value="Wearable Items">Wearable Items</option>
                                    <option value="Ornaments">Ornaments</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Tools">Tools</option>
                                    <option value="Ceramics">Ceramics</option>
                                    <option value="Artwork">Artwork</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Product Name:</td>
                            <td><input type="text" name="productName"></td>
                        </tr>
                        <tr>
                            <td>Product Description:</td>
                            <td><input type="text" name="productDes"></td>
                        </tr>
                        <tr>
                            <td>Product Image Link:</td>
                            <td><input type="text" name="productImgUrl"></td>
                        </tr>
                        <tr>
                            <td>Unit Price:</td>
                            <td><input type="text" name="productPrice"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="submit" value="Submit" class="add" name="update_action"></td>
                        </tr>
                    </table>
                </form>
        </div>

        <?php
        $get_query = "SELECT MAX(productId) AS nth_productId FROM product";
        $result = mysqli_query($conn, $get_query);

        while ($row = mysqli_fetch_assoc($result)) {
            $nth_productId = (int)$row['nth_productId']; // Extract and cast the maximum productID to an integer
            $productId = $nth_productId + 1; // Increment the maximum productID to generate the new productID
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if every field is filled up.
            // IF one of the field is empty, THEN display 'Fill in all the information'
            if (isset($_POST['add_action'])) {
                if(!empty($_POST['productCategory']) && !empty($_POST['productName']) && !empty($_POST['productImgUrl']) && !empty($_POST['productPrice']))
                {
                    // Get all the information from the form POST methods to the local variables
                    $productCategory = $_POST['productCategory'];
                    $productName = $_POST['productName'];
                    $productImgUrl = $_POST['productImgUrl'];
                    $productPrice = $_POST['productPrice'];

                    $query = "INSERT INTO product 
                    (productId, productCategory, productName, productImgUrl, productPrice) 
                    VALUES ('$productId', '$productCategory', '$productName', '$productImgUrl', '$productPrice')";

                    if (mysqli_query($conn, $query)) {
                        echo "<script>alert('Product added successfully.')</script>";
                        echo "<script>location.href='admin.php';</script>";
                    } else {
                        $error_str = "Error: " . mysqli_error($conn);
                        echo "<script>alert('$error_str')</script>";
                    }
                } 

            }

            elseif (isset($_POST['update_action'])) {
                if(!empty($_POST['productId']) && !empty($_POST['productCategory']) && !empty($_POST['productName']) && !empty($_POST['productImgUrl']) && !empty($_POST['productPrice'])) {
                    // Check if every field is filled up.
                    // IF one of the field is empty, THEN display 'Fill in all the information'

                    // Get all the information from the form POST methods to the local variables
                    $productId = $_POST['productId'];
                    $productCategory = $_POST['productCategory'];
                    $productName = $_POST['productName'];
                    $productImgUrl = $_POST['productImgUrl'];
                    $productPrice = $_POST['productPrice'];

                    $query = "UPDATE product 
                    SET productCategory = '$productCategory', 
                        productName = '$productName', 
                        productImgUrl = '$productImgUrl', 
                        productPrice = '$productPrice', 
                    WHERE productId = '$productId'";

                    if (mysqli_query($conn, $query)) {
                        echo "<script>alert('Product updated successfully.')</script>";
                        echo "<script>location.href='admin.php';</script>";
                    } else {
                        $error_str = "Error: " . mysqli_error($conn);
                        echo "<script>alert('$error_str')</script>";
                    }
                }
            }
            
            else {
                echo "<script>alert('Please fill in all the information.')</script>";
                // echo "<script>location.href='admin.php';</script>";
            }
        }
        ?>

    <h2 class="product">Product manifest</h2>
    <div class="product">
        <table border=5 class="product">
            <tr>
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Category</th>
                <th>ProductName</th>
                <th>Unit Price (RM)</th>
            </tr>
            <?php
            $query = "SELECT * FROM product";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                // echo "<td>" . $row['productImgUrl'] . "</td>";
                ?><td>  <img src="../Group Assignment/assets/img/<?= $row["productImgUrl"];?>" alt="image" class="shop__img" /> </td>
                <?php
                echo "<td>" . $row['productId'] . "</td>";
                echo "<td>" . $row['productCategory'] . "</td>";
                echo "<td>" . $row['productName'] . "</td>";
                echo "<td>" . $row['productPrice'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <style>
        .shop__img {
            width: 150px;
            max-height: 150px;
            /* transition: 0.4s; */
            justify-content: center;
            align-items: center;
            }
    </style>
    <h2 class="most-visited">Most visited product pages</h2>
    <div class="most-visited">
        <table border=5 class="most-visited">
            <tr>
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Category</th>
                <th>ProductName</th>
                <th>User Visits</th>
            </tr>
            <?php
            $query = "SELECT * FROM product ORDER BY productVisit DESC LIMIT 10;";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                ?><td>  <img src="../Group Assignment/assets/img/<?= $row["productImgUrl"];?>" alt="image" class="shop__img" /> </td>
                <?php
                echo "<td>" . $row['productId'] . "</td>";
                echo "<td>" . $row['productCategory'] . "</td>";
                echo "<td>" . $row['productName'] . "</td>";
                echo "<td>" . $row['productVisit'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <h2 class="most-popular">Most popular product</h2>
    <div class="most-popular">
        <table border=5 class="most-popular">
            <tr>
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Category</th>
                <th>ProductName</th>
                <th>Product Sold</th>
            </tr>
            <?php
            $query = "SELECT product.*, sum(payment.paymentProductQuantity) as 'Product Sold' FROM product JOIN payment ON payment.productId = product.productId GROUP BY product.productName ORDER BY sum(payment.paymentProductQuantity) DESC;";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                ?><td>  <img src="../Group Assignment/assets/img/<?= $row["productImgUrl"];?>" alt="image" class="shop__img" /> </td>
                <?php
                echo "<td>" . $row['productId'] . "</td>";
                echo "<td>" . $row['productCategory'] . "</td>";
                echo "<td>" . $row['productName'] . "</td>";
                echo "<td>" . $row['Product Sold'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <h2 class="reg-users">Registered users</h2>
    <div class="users">
        <table border=5 class="users">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Admin?</th>
            </tr>
            
            <?php
            $query = "SELECT * FROM users";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['userId'] . "</td>";
                echo "<td>" . $row['userName'] . "</td>";
                echo "<td>" . $row['userEmail'] . "</td>";
                echo "<td>" . $row['userAddress'] . "</td>";
                echo "<td>" . $row['isAdmin'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

        </main>

    <footer>
		<br>
    	<h3>Disclaimer: This website is for educational purposes only. <br> This is a fictitious entity created as part of a university course. Any resemblance to real businesses, living or dead, is purely coincidental.</h3>
	</footer>

</html>