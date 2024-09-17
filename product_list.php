<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== REMIXICONS ===============-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css"
    />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <title>Vintage Online Store</title>
  </head>
  <style></style>
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
              <a href="cart.php#history" class="nav__link">Order History</a>
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

    <!--==================== Product list ====================-->
    <script>
        function addParameterToURL(parameter) {
            // Get the current URL
            var url = window.location.href;

                // Check if the URL already has parameters
              if (url.indexOf('?') !== -1) {

                if (url.indexOf('cat=') !== -1) {
                    var regex = new RegExp('cat=[^&]+', 'g');
                    url = url.replace(regex, 'cat=' + parameter);
                }else{
                // URL already has parameters, add the new parameter
                url += '&cat=' + parameter;                    
                }
              } else {
                  // URL doesn't have parameters, add the new parameter with '?'
                  url += '?cat=' + parameter;
              }
            
          
            

            // Redirect to the updated URL
            window.location.href = url;
        }

        function addSortToURL(parameter) {
            // Get the current URL
            var url = window.location.href;

            if (url.indexOf('?') !== -1) {

                if (url.indexOf('sort=') !== -1) {
                    var regex = new RegExp('sort=[^&]+', 'g');
                    url = url.replace(regex, 'sort=' + parameter);
                }else{
                // URL already has parameters, add the new parameter
                url += '&sort=' + parameter;                    
                }

              } else {
                // URL doesn't have parameters, add the new parameter with '?'
                url += '?sort=' + parameter;
              }
                          

            // Redirect to the updated URL
            window.location.href = url;
        }
    </script>
    <section class="shop section" id="shop">
        <h2 class="section__title">Our Product</h2>
        <br>
        <p style="padding: 0 0 0 1.5rem; color: black">Category :</p> <br>
        <?php $sort=$_GET['sort'];?>
        <a href="../Group Assignment/product_list.php?sort=<?= $sort?>" class="select gg button__link" >All Category</a>
        <a href="javascript:void(0);" class="select aa button__link" onclick="addParameterToURL('Wearable Items');">Wearable Items</a>
        <a href="javascript:void(0);" class="select bb button__link" onclick="addParameterToURL('Ornaments');">Ornaments</a>
        <a href="javascript:void(0);" class="select cc button__link" onclick="addParameterToURL('Furniture');">Furniture</a>
        <a href="javascript:void(0);" class="select dd button__link" onclick="addParameterToURL('Tools');">Tools</a>
        <a href="javascript:void(0);" class="select ee button__link" onclick="addParameterToURL('Ceramics');">Ceramics</a>
        <a href="javascript:void(0);" class="select ff button__link" onclick="addParameterToURL('Artwork');">Artwork</a>
        <br><br><hr><br>
        
        <p style="padding: 0 0 0 1.5rem; color: black">SORT BY :</p> <br>
        <a href="javascript:void(0);" class="select l button__link" onclick="addSortToURL('like');">All Product</a>
        <a href="javascript:void(0);" class="select p button__link" onclick="addSortToURL('popular');">Most Popular</a>
        <a href="javascript:void(0);" class="select r button__link" onclick="addSortToURL('rate');">High Rate</a>
        

        <br><br><br><br>
        <?php
              if(isset($_GET['cat'])){
                  $cat = $_GET['cat'];
                  if($cat == 'Wearable Items'){
                    ?>
                  
                    <style>
                          .aa{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                    </style>
                    <?php
                  }elseif($cat == 'Ornaments'){
                    ?>
                  
                    <style>
                          .bb{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                    </style>
                    <?php
                  }elseif($cat == 'Furniture'){
                    ?>
                  
                    <style>
                          .cc{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                    </style>
                    <?php
                  }elseif($cat == 'Tools'){
                    ?>
                  
                    <style>
                          .dd{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                    </style>
                    <?php
                  }elseif($cat == 'Ceramics'){
                    ?>
                  
                    <style>
                          .ee{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                    </style>
                    <?php
                  }elseif($cat == 'Artwork'){
                    ?>
                  
                    <style>
                          .ff{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                    </style>
                    <?php
                  }
              } else{
                ?>
              
                <style>
                      .gg{
                          background-color: rgb(255, 136, 0);;
                          color: white;
                      }
                </style>
                
                <?php
              }

        ?>
        <div class="shop__container grid">
          <?php
              if(isset($_GET['sort'])){
                  $sort = $_GET['sort'];
                  if($sort == 'popular'){
                      ?>
                      <style>
                          .p{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                      </style>

                      <?php
                        include "Connection.php";

                        if(isset($_GET['cat'])){
                          $sql = "SELECT product.*, sum(payment.paymentProductQuantity) as 'Product Sold'  FROM product JOIN payment ON payment.productId = product.productId WHERE productCategory = '$cat' GROUP BY product.productName ORDER BY 'Product Sold' DESC";
                        }else{
                          $sql = "SELECT product.*, sum(payment.paymentProductQuantity) as 'Product Sold'  FROM product JOIN payment ON payment.productId = product.productId GROUP BY product.productName ORDER BY 'Product Sold' DESC";
                        }
                        // $sql = "SELECT product.*, sum(payment.paymentProductQuantity) as 'Product Sold'  FROM product JOIN payment ON payment.productId = product.productId "+$cat+" GROUP BY product.productName ORDER BY 'Product Sold' DESC";
                        $getAll = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($getAll)>0){
                          foreach($getAll as $get){
                      ?>  
                      <article class="shop__card">
                          <div class="shop__shape">
                              <img
                              src="../Group Assignment/assets/img/<?= $get["productImgUrl"];?>"
                              alt="image"
                              class="shop__img"
                              />
                          </div>

                          <div class="shop__data">
                              <h2 class="shop__price">$<?= $get["productPrice"];?></h2>
                              <h3 class="shop__title">
                                  <?= $get["productName"];?>
                              </h3>
                              

                              <a href="../Group Assignment/product.php?id=<?= $get["productId"];?>" class="shop__button" >
                              <i class="ri-shopping-bag-line"></i>
                              </a>
                          </div>


                        </article>
                        <?php
                                              }
                                            }
                                              ?>
                                    <?php
                  }elseif($sort == 'rate'){
                      ?>
                      <style>
                          .r{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                      </style>
                      <?php
                        include "Connection.php";

                        if(isset($_GET['cat'])){
                          $sql = "SELECT product.*, AVG(rating.ratingStar) AS averageRating FROM product JOIN rating ON rating.productId = product.productId WHERE productCategory = '$cat' GROUP BY product.productName ORDER BY averageRating DESC ";
                        }else{
                          $sql = "SELECT product.*, AVG(rating.ratingStar) AS averageRating FROM product JOIN rating ON rating.productId = product.productId GROUP BY product.productName ORDER BY averageRating DESC ";
                        }
                          // $sql = "SELECT product.*, AVG(rating.ratingStar) AS averageRating FROM product JOIN rating ON rating.productId = product.productId "+$cat+" GROUP BY product.productName ORDER BY averageRating DESC ";
                        $getAll = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($getAll)>0){
                          foreach($getAll as $get){
                      ?>  
                      <article class="shop__card">
                          <div class="shop__shape">
                              <img
                              src="../Group Assignment/assets/img/<?= $get["productImgUrl"];?>"
                              alt="image"
                              class="shop__img"
                              />
                          </div>

                          <div class="shop__data">
                              <h2 class="shop__price">$<?= $get["productPrice"];?></h2>
                              <h3 class="shop__title">
                                  <?= $get["productName"];?>
                              </h3>
                              

                              <a href="../Group Assignment/product.php?id=<?= $get["productId"];?>" class="shop__button" >
                              <i class="ri-shopping-bag-line"></i>
                              </a>
                          </div>


                        </article>
                        <?php
                                              }
                                            }
                                              ?>
                      <?php
                  }else{
                      ?>
                      <style>
                          .l{
                              background-color: rgb(255, 136, 0);;
                              color: white;
                          }
                      </style>
                      <?php
                        include "Connection.php";

                        if(isset($_GET['cat'])){
                          $sql = "SELECT * FROM product WHERE productCategory = '$cat' ORDER BY productVisit DESC  ";

                        }else{
                          $sql = "SELECT * FROM product ORDER BY productVisit DESC  ";
                        }
                        $getAll = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($getAll)>0){
                          foreach($getAll as $get){
                      ?>  
                      <article class="shop__card">
                          <div class="shop__shape">
                              <img
                              src="../Group Assignment/assets/img/<?= $get["productImgUrl"];?>"
                              alt="image"
                              class="shop__img"
                              />
                          </div>

                          <div class="shop__data">
                              <h2 class="shop__price">$<?= $get["productPrice"];?></h2>
                              <h3 class="shop__title">
                                  <?= $get["productName"];?>
                              </h3>
                              

                              <a href="../Group Assignment/product.php?id=<?= $get["productId"];?>" class="shop__button" >
                              <i class="ri-shopping-bag-line"></i>
                              </a>
                          </div>


                        </article>
                        <?php
                                              }
                                            }
                                              ?>
                      <?php
                  }
              }
          ?>
        </div>
        
    
        
      </section>
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

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup" id="scroll-up">
      <i class="ri-arrow-up-line"></i>
    </a>

    <!--=============== SCROLLREVEAL ===============-->
    <script src="assets/js/scrollreveal.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/scrollreveal.min.js"></script>
  </body>
</html>