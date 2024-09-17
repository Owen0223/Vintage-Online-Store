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
    <title>Favorite Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        .product img {
            width: 100%;
            height: auto;
            max-height: 200px;
            border-radius: 8px;
        }
        .product h2 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }
        .product form {
            display: inline;
        }
        .product form input[type="submit"] {
            padding: 8px 16px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .product form input[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
</head>
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

    <!-- ================== FAVOURITE ===================-->
    <div class="container">
        <h1>Favorite Products</h1>
        <table>
            <tr>
                <?php

                if (!isset($_SESSION['userId'])) {
                    echo "<script>alert('Please login to view product details.'); window.close();";
                    echo 'window.location.href = "home.php";</script>';
                    exit();
                }

                $userID = $_SESSION['userId'];

                require_once 'Connection.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel'])) {
                    $productID = $_POST['productId'];
                    $deleteSql = "DELETE FROM favourite WHERE userId = $userID AND productId = $productID";
                    if ($conn->query($deleteSql) === TRUE) {
                        echo "<script>alert('Product removed from favourites successfully.'); window.location.href='favourite.php'; </script>";
                        exit();
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                $sql = "SELECT * FROM favourite WHERE userId = $userID";
                $result = $conn->query($sql);

                $count = 0;
                if ($result->num_rows > 0) {
                    while ($favourite = $result->fetch_assoc()) {
                        $productID = $favourite['productId'];
                        $productSql = "SELECT * FROM product WHERE productId = $productID";
                        $productResult = $conn->query($productSql);

                        if ($productResult->num_rows > 0) {
                            $product = $productResult->fetch_assoc();
                            $count++;

                            if ($count % 5 == 0) {
                                echo "</tr><tr>";
                            }
                            ?>
                            <td>
                                <div class="product">
                                    <a href="product.php?id=<?php echo $product['productId']; ?>">
                                        <img src="../Group Assignment/assets/img/<?= $product["productImgUrl"];?>">
                                        <h2><?php echo $product['productName']; ?></h2>
                                    </a>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="productId" value="<?php echo $productID; ?>">
                                        <input type="submit" name="cancel" value="Cancel">
                                    </form>
                                </div>
                            </td>
                        <?php
                        }
                    }
                } else {
                    echo "<td>No favourite products found.</td>";
                }

                $conn->close();
                ?>
            </tr>
        </table>
    </div>

    <!--  =================FOOTER=================== -->
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
