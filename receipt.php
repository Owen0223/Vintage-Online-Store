<!DOCTYPE html>
<html>
<head>
        <!--=============== REMIXICONS ===============-->
        <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css"
    />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css" />
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

    <!-- ========================== RECEIPT ====================== -->
<section class="receipt section" id="cart">
<h2 class="section__title">Order Successfully!!</h2>
<h4 style="text-align: center;">Thanks for your order, your order will be shipped out in a few days</h4>
<br><br>
<div class="recept__container container">
<?php
include('Connection.php');

// // Retrieve the latest paymentId
$sqlMaxPaymentId = "SELECT MAX(paymentId) AS maxPaymentId FROM payment";
$resultMaxPaymentId = mysqli_query($conn, $sqlMaxPaymentId);
$rowMaxPaymentId = mysqli_fetch_assoc($resultMaxPaymentId);

// // Assign the last payment ID to a variable
$lastPaymentId = $rowMaxPaymentId['maxPaymentId'];

// // Fetch cart details
// $sql = "SELECT users.userName, payment.paymentDate, payment.paymentId AS lastPaymentId, payment.paymentChoices, payment.productId, payment.paymentProductQuantity, product.productName, product.productPrice
//         FROM cart 
//         INNER JOIN users ON cart.userId = users.userId 
//         INNER JOIN product ON cart.productId = product.productId
//         INNER JOIN payment ON cart.userId = payment.userId
//         WHERE payment.paymentId = $lastPaymentId";
//         // WHERE cart.userId = ?"

$sql = "SELECT * FROM payment INNER JOIN users ON payment.userId = users.userId INNER JOIN product ON payment.productId = product.productId WHERE paymentId = $lastPaymentId AND payment.paymentProductQuantity > 0";
$getAll = mysqli_query($conn, $sql);
$geth = mysqli_fetch_assoc($getAll);
$total = 0;
$status = '';
?>

User name: <?php echo $geth['userName'];?><br>
Date: <?php echo date('Y-m-d H:i:s');?> <br>
Order ID: <?php echo 'H00'.$lastPaymentId; ?><br>
Pickup Method: <?php echo $geth['paymentChoices'];?><br><br>
Order product: <br><br>
<table width=100% class="pro__table" style="text-align: center;">
<thead>
<tr>
<th>Image</th>
<th width=30%>Name</th>
<th>Quantity</th>
<th>Price</th>
</tr>
</thead>
<tbody>
<?php
if(mysqli_num_rows($getAll) > 0){
    foreach($getAll as $get){
?>
<tr>
<td><img src="../Group Assignment/assets/img/<?= $get["productImgUrl"];?>" width="100px" height="100px" alt="<?= $get["productName"];?>"></td>
<td><?= $get["productName"];?></td>
<td><?= $get["paymentProductQuantity"];?></td>
<td><?= $get["productPrice"];?></td>
</tr>
<?php
        $total += $get['productPrice'];
    }
}else{
    $status = 'No record found';
}
?>
</tbody>
</table><br><br>
<h3 style="text-align: right;">Total price: <?php echo '$'.$total; ?></h3>
<br><br>
<table width:100%>
<tr>
<td width=85%></td>
<td style="text-align: right;">
<a href="Order.php" class="button pay">Back to Home</a>
</td>
</tr>
</table>
</div><br>

<!-- =======================FOOTER==================== -->
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
