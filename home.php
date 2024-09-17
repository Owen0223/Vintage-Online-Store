<!DOCTYPE html>

<?php
    // Start the session
    session_start();

    // Check if user is logged in (if name is set in the session)
    if(!empty($_SESSION['name'])){
      // Assign the session variables to local variables
      $userName = $_SESSION['name'];
      $userId = $_SESSION['userId'];
    }

    else;			
?>


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

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
      <section class="home grid" id="home">
          <div class="home__container">
            <div class="home__content container">
                <h1 class="home__title">
                    <span>Welcome to </span><br>Vintage Online Store
                </h1>
                <p class="home__description">
                    "Step Into History, Take Home Memories"
                </p>

                <div class="home__data">
                    <div class="home__data-group">
                        <h2 class="home__data-number">120k</h2>
                        <h3 class="home__data-title">Testimonials</h3>
                    </div>

                    <div class="home__data-group">
                        <h2 class="home__data-number">60+</h2>
                        <h3 class="home__data-title">Exclusive Product</h3>
                    </div>
                </div>

                <div class="home__buttons">
                    <a href="#shop  " class="button">
                        <span>
                        <i class="ri-arrow-right-line"></i>
                        </span>
                        GO TO SHOP
                    </a>

                    <!-- <a href="#" class="home__link"> MORE DETAILS </a> -->
                </div>

                <a href="#"></a>
            </div>
          </div>

          <img src="../Group Assignment/assets/img/home.jpg" alt="" class="home__img">
      </section>
    </main>


    <!--==================== Popular ====================-->
    <section class="shop section" id="shop">
        <h2 class="section__title">What's Popular?</h2>

        <div class="shop__container grid">
        <?php
          include "Connection.php";

          $sql = "SELECT product.*, sum(payment.paymentProductQuantity) as 'Product Sold'  FROM product JOIN payment ON payment.productId = product.productId GROUP BY product.productName ORDER BY 'Product Sold' DESC LIMIT 4";
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
    
        </div>

        <div class="shop__vbutton">
            <a href="../Group Assignment/product_list.php?sort=popular" class="vbutton button__link">View More --></a>
        </div>
      </section>

      <!--==================== rate ====================-->
    <section class="shop section" id="shop">
        <h2 class="section__title">Best Rating in Our Shop</h2>

        <div class="shop__container grid">
        <?php
          include "Connection.php";

            $sql = "SELECT product.*, AVG(rating.ratingStar) AS averageRating FROM product JOIN rating ON rating.productId = product.productId GROUP BY product.productName ORDER BY averageRating DESC LIMIT 4 ";
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
    
        </div>
        <div class="shop__vbutton">
            <a href="../Group Assignment/product_list.php?sort=rate" class="vbutton button__link">View More --></a>
        </div>
      </section>

      <!--==================== visit ====================-->
    <section class ="shop section" id="shop">
        <h2 class="section__title">You May like</h2>

        <div class="shop__container grid">
        <?php
          include "Connection.php";

          $sql = "SELECT * FROM product ORDER BY productVisit DESC LIMIT 4 ";
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
    
        </div>
        <div class="shop__vbutton">
            <a href="../Group Assignment/product_list.php?sort=rate" class="vbutton button__link">View More --></a>
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