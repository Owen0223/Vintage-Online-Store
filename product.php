<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--=============== REMIXICONS ===============-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css"
    />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css" />
    <title>Product Details</title>
</head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            font-size: 24px;
            margin: 0 0 20px;
            color: #333;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        label {
            font-weight: bold;
        }
        input[type="number"] {
            width: 60px;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="text"] {
            width: 150px;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .comment {
            margin-bottom: 20px;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
<body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <?php session_start();?>
      <nav class="nav container">
        <a href="../Group Assignment/home.php#" class="nav__logo">
        <i class="ri-ancient-gate-fill"></i> Vintage Online Store
        </a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item">
              <a href="../Group Assignment/home.php#home" class="nav__link">Home</a>
            </li>

            <!-- <li class="nav__item">
              <a href="#new" class="nav__link">News</a>
            </li> -->

            <li class="nav__item">
              <a href="../Group Assignment/product_list.php?sort=like" class="nav__link">Shop</a>
            </li>

            </li>
            <li class="nav__item">
              <a href="Cart.php" class="nav__link">Cart</a>
            </li>

            </li>
            <li class="nav__item">
              <a href="favourite.php" class="nav__link">Favourite</a>
            </li>

            </li>
            <li class="nav__item">
              <a href="Order.php" class="nav__link">Order History</a>
            </li>

          </ul>

          <!--logout and cart button -->
          <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
          </div>
        </div>
        <div class="nav__action">
          <?php
            if (!isset($_SESSION['userId'])) {
                ?>
                <a href="../Group Assignment/login.php" class="button button__login">Login</a>
                <?php
            }else{
                ?>
                <a href="?clear_cookie=1" class="button__link"><i class="ri-logout-box-line"></i></a>
                <?php
            }

            if(isset($_GET['clear_cookie'])) {
              // Set a new cookie with the same name and an expiration time in the past to clear the existing cookie
              setcookie("username", "", time() - 3600, "/");
              
              // Quit the session
              session_destroy();
              echo "<script>alert('Logout Successfull.'); window.close(); </script>";
              // Redirect to the same page to reflect the changes
              header("Location: ../Group Assignment/home.php");
              exit;
            }
          ?>

          <!-- <a href="../Group Assignment/Cart.php" class="button__link"><i class="ri-shopping-cart-line"></i></a> -->
          

          <!-- Toggle button -->
          <div class="nav__toggle" id="nav-toggle">
            <i class="ri-menu-line"></i>
          </div>
        </div>
      </nav>
    </header>

    <!--=================== PRODUCT =====================-->
<?php

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Please login to view product details.'); window.close();";
    echo 'window.location.href = "home.php";</script>';
    exit();
}

$userID = $_SESSION['userId'] ;


if (isset($_GET['id'])) {
    $productId = $_GET['id'];
}

require_once 'Connection.php';

$updateVisitSql = "UPDATE product SET productVisit = productVisit + 1 WHERE productId = $productId";
$conn->query($updateVisitSql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        $productId = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;

        $checkCartSql = "SELECT * FROM cart WHERE productId = $productId AND userId = $userID";
        $checkCartResult = $conn->query($checkCartSql);

        if ($checkCartResult->num_rows > 0) {
            $updateSql = "UPDATE cart SET cartProductQuantity = $quantity WHERE productId = $productId AND userId = $userID";
            if ($conn->query($updateSql) === TRUE) {
                echo "<script>alert('Item updated successfully.'); 
                window.location.href = 'Cart.php'</script>";  
            } else {
                echo "Error: Update not successful: " . $conn->error;
            }
        } else {
            $insertSql = "INSERT INTO cart (userId, productId, cartProductQuantity) VALUES ($userID, $productId, $quantity)";
            if ($conn->query($insertSql) === TRUE) {
                echo "<script>alert('Item added to cart successfully.'); 
                window.location.href = 'Cart.php'</script>";  
            } else {
                echo "Error: Insertion not successful: " . $conn->error;
            }
        }
    } elseif (isset($_POST['add_fav'])) {

        $checkFavouriteSql = "SELECT * FROM favourite WHERE productId = $productId AND userId = $userID";
        $checkFavouriteResult = $conn->query($checkFavouriteSql);

        if ($checkFavouriteResult->num_rows > 0) {
            echo "<script>alert('Product already added in Favorites.');
            location.href = 'product.php?id=" . $productId . "'</script>";
        }else{
            $insertSql = "INSERT INTO favourite (userId, productId) VALUES ($userID, $productId)";
            if ($conn->query($insertSql) === TRUE) {
                echo "<script>alert('Product added to Favorites successfully.');
                window.location.href = 'home.php'</script>";
            } else {
                echo "Error: Insertion not successful: " . $conn->error;
            }
        }
    }elseif (isset($_POST['submit_rating'])) {

        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        
        
        $insertRatingSql = "INSERT INTO rating (productId, userId, ratingStar, ratingComment) VALUES ($productId, $userID, $rating, '$comment')";
        if ($conn->query($insertRatingSql) === TRUE) {
            echo "<script>alert('Rating submitted successfully.');
            window.location.href = 'product.php?id=" . $productId . "'</script>"; 

        } else {
            echo "Error: " . $insertRatingSql . "<br>" . $conn->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sqlProduct = "SELECT * FROM product WHERE productId = $productId";
    $sqlCart = "SELECT * FROM cart WHERE productId = $productId AND userId = {$_SESSION['userId']}";
    $productResult = $conn->query($sqlProduct);
    $cartResult = $conn->query($sqlCart);
    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
        $cart = $cartResult->fetch_assoc();
?>

    <h1><?php echo $product['productName']; ?></h1>
    <img src="../Group Assignment/assets/img/<?= $product["productImgUrl"];?>">
    <p>Description: <?php echo $product['productDesc']; ?></p>
    <form action="" method="post">
        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="0" value="<?php echo $cart ? $cart['cartProductQuantity'] : 0; ?>">
        <br>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $product['productPrice']; ?>" readonly>
        <br>
        <input type="submit" name="update_cart" value="Update Cart">
        <input type="submit" name="add_fav" value="Add to Favorites">
    </form>
    <h2>Rating for us !</h2>
    <form action="" method="post">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br>
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="3" cols="30"></textarea>
        <br>
        <input type="submit" name="submit_rating" value="Submit Rating">
    </form>

        <h2>Comments</h2>
        <?php
            $ratingSql = "SELECT r.ratingStar, r.ratingComment, u.userName FROM rating r INNER JOIN users u ON r.userId = u.userId WHERE r.productId = $productId";
            $ratingResult = $conn->query($ratingSql);

            if ($ratingResult->num_rows > 0) {
                while ($row = $ratingResult->fetch_assoc()) {
                    echo "<div class='comment'>";
                    echo "<p><strong>{$row['userName']}</strong></p>";
                    echo "<p>";
                    generateStarRating($row['ratingStar']);
                    echo "</p>";
                    echo "<p>{$row['ratingComment']}</p>";
                    echo "</div>";
                }
            } else {
                echo "No comments available.";
            }
        ?>
    <?php
        } else {
            echo "Product not found.";
    }
}

$conn->close();
?>

<!--==================== FOOTER ====================-->
<footer class="footer">
        
        <div class="footer__container container grid">
          <div>
            <a href="#" class="footer__logo">
            <i class="ri-ancient-gate-fill"></i> Vintage Online Store
            </a>
  
            <p class="footer__description">
              Find your most  <br />
              Oldest thing thing
            </p>
          </div>
  
          <div class="footer__content grid">
            <div>
              <h3 class="footer__title">COMPANY</h3>
  
              <ul class="footer__links">
                <li>
                  <a href="#" class="footer__link">About Us</a>
                </li>
  
                <li>
                  <a href="#" class="footer__link">Products</a>
                </li>
  
                <li>
                  <a href="#" class="footer__link">Features</a>
                </li>
              </ul>
            </div>
  
            <div>
              <h3 class="footer__title">INFORMATION</h3>
  
              <ul class="footer__links">
                <li>
                  <a href="#" class="footer__link"> Blogs & News</a>
                </li>
  
                <li>
                  <a href="#" class="footer__link">Contacts Us</a>
                </li>
  
                <li>
                  <a href="#" class="footer__link">FAQs</a>
                </li>
              </ul>
            </div>
  
            <div>
              <h3 class="footer__title">SOCIAL MEDIA</h3>
  
              <div class="footer__social">
                <a
                  href="https://www.facebook.com/"
                  target="_blank"
                  class="footer__social-link"
                >
                  <i class="ri-facebook-circle-fill"></i>
                </a>
                <a
                  href="https://www.instagram.com/"
                  target="_blank"
                  class="footer__social-link"
                >
                  <i class="ri-instagram-line"></i>
                </a>
                <a
                  href="https://twitter.com/"
                  target="_blank"
                  class="footer__social-link"
                >
                  <i class="ri-twitter-fill"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
  
        <span class="footer__copy">
          &#169; This website   used for education
        </span>
    </footer>
  
</body>
</html>
<?php
function generateStarRating($rating) {
    $fullStar = '&#9733;';
    $emptyStar = '&#9734;';
    
    $rating = intval($rating);

    for ($i = 0; $i < $rating; $i++) {
        echo '<span>' . $fullStar . '</span>';
    }

    for ($i = $rating; $i < 5; $i++) {
        echo '<span style="opacity: 0.5;">' . $emptyStar . '</span>';
    }
}
?>