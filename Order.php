<?php
    require_once 'Connection.php';
?>

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
    <style>
        /* Add your CSS styles here */
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
            <!--============== ORDER ======================= -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Orders History</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price per unit(RM)</th>
                                    <th>Subtotal(RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $user = $_SESSION['userId'];
                                    $sql = "SELECT paymentId, paymentDate, paymentProductQuantity, product.productPrice, product.productName FROM payment INNER JOIN product ON payment.productId = product.productId WHERE payment.userId = ? AND payment.paymentProductQuantity > 0 ORDER BY payment.paymentId";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $user);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $current = null;
                                    $total = 0;
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        if($row['paymentId'] !== $current){
                                        if($current !== null){
                                            echo "<tr><td colspan='5'>TOTAL:</td><td>" . $total . "</td></tr>";
                                            echo "<form action='Gre_order.php' method='POST'>";
                                            echo "<input type='hidden' name='paymentId' value='" . $current . "'>";
                                            echo "<td><input type='submit' class='button' name='Re-order' value='Re-Order'></td>";
                                            echo "</form>";
                                            $total = 0;
                                        }
                                        echo "<tr>";
                                        echo "<td>P00{$row['paymentId']}</td>";
                                        echo "<td>{$row['paymentDate']}</td>";
                                        $current = $row['paymentId'];
                                        }else{
                                            echo "<tr>";
                                            echo "<td colspan='2'></td>";
                                        }
                                        echo "<td>{$row['productName']}</td>";
                                        echo "<td>{$row['paymentProductQuantity']}</td>";
                                        echo "<td>{$row['productPrice']}</td>";
                                        $subtotal = $row['productPrice'] * $row['paymentProductQuantity'];
                                        $total += $subtotal;
                                        echo "<td>" . number_format($subtotal, 2) . "</td>";
                                        echo "</tr>";
                                        $current = $row['paymentId'];
                                    }

                                    echo "<tr><td colspan='5'>TOTAL:</td><td>" . $total . "</td></tr>";
                                    echo "<form action='Gre_order.php' method='POST'>";
                                    echo "<input type='hidden' name='paymentId' value='" . $current . "'>";
                                    echo "<td><input type='submit' class='button' name='Re-order' value='Re-Order'></td>";
                                    echo "</form>";

                                    mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
