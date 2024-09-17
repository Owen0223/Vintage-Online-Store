<!DOCTYPE html>

<?php
    require_once 'Connection.php';
?>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./assets/css/login_styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--=============== REMIXICONS ===============-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css"
    />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css" />
    <title>Login/Signup</title>
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
    <!-- ====================LOGIN==================== -->
	<main>
        <h1>Login/Signup</h1>
        <div class="forms">
        <div class="login">
            <h2>Login</h2>
            <form action = "login.php" method= 'post'>
            <table>
                <!-- NAME -->
                <tr>
                    <td>Name:</td>
                    <td><input type = "text" name = "name"> 
                    </td>
                </tr>

                <!-- PASSWORD -->
                <tr>
                    <td>Password:</td>
                    <td><input type = "password" name = "pw"></td>
                </tr>

                <!-- LOGIN BUTTON & REMEMBER ME CHECKBOX -->
                    <tr><td colspan="2" align="center"><input type="submit" value="Login" class="login" name="login"></td></tr>
                </table>
            </form>
        </div>

        <div class="signup">
            <h2>Sign up a new account</h2>
            <form action = "login.php" method= 'post'>
            <table>
                <tr><td>Full Name:</td><td><input type = "text" name = "username"></td></tr>
                <tr><td>Address</td><td><input type = "text" name = "address"></td></tr>
                <tr><td>Email:</td><td><input type = "text" name = "email"></td></tr>

                <tr><td>Password:</td><td><input type = "password" name = "pw"></td></tr>
                <tr><td>Re-enter password:</td><td><input type = "password" name = "re-pw"></td></tr>

                <tr><td colspan="2" align="center"><input type="submit" value="Sign Up" class="signup" name="signup"></td></tr>
                </table>
            </form>
        </div>
        </div>

	</main>

    <?php
    // session_start();

    if(isset($_POST['login'])){

        // Check if there is input in the LOGIN form
        if(!empty($_POST["name"]) && !empty($_POST["pw"])){
            // Get name and pw input from form
            $name_input = $_POST["name"];
            $pw_input = $_POST["pw"];

            $get_query = "SELECT * FROM users WHERE userName = '$name_input'";
            $result = mysqli_query($conn, $get_query);

            while($row = mysqli_fetch_assoc($result))
            {
                $check_name = $row['userName'];
                $check_pw = $row['password'];
                $userId = $row['userId'];
                $isAdmin = $row['isAdmin'];
            }

            if($name_input == $check_name && $pw_input == $check_pw){
                $_SESSION['name'] = $name_input;
                $_SESSION['userId'] = $userId;

                if($isAdmin == 1) {
                    echo "<script>alert('Welcome, admin')</script>";
                    echo "<script>location.href='admin.php'</script>";
                }

                echo "<script>location.href='home.php'</script>";
            }
            

            else {
            echo "<script>alert('Username or password incorrect. Please re-enter.')</script>";
            echo "<script>location.href='login.php'</script>";
            }

        }

        else {
            echo "<script>alert('Username or password incorrect. Please re-enter.')</script>";
            echo "<script>location.href='login.php'</script>";
        }
    }

    // We need cookies here or the user experience gonna suck

    // Get name and pw input from SIGNUP form ONLY IF signup button is pressed
    if(isset($_POST['signup'])){
        if(!empty($_POST["username"]) && !empty($_POST["address"]) && !empty($_POST["email"]) && !empty($_POST["pw"]) && !empty($_POST["re-pw"])){
        
            $username = $_POST["username"];
            $address = $_POST["address"];
            $email = $_POST["email"];
            
            $pw = $_POST["pw"];
            $re_pw = $_POST["re-pw"];

            if($pw == $re_pw){
                // To get the latest userID & insert a new one by adding 1, e.g., 002 + 1 = 003
                $get_query = "SELECT MAX(userId) AS nth_userId FROM users";
                $result = mysqli_query($conn, $get_query);

                while($row = mysqli_fetch_assoc($result))
                {
                    $nth_userId = (int)$row['nth_userId']; // Extract and cast the maximum UserID to an integer
                    $nplus1_userId = $nth_userId + 1; // Increment the maximum UserID to generate the new UsererID
                }

                $insert_query = "INSERT INTO users (userID, userName, userAddress, userEmail, password) 
                VALUES ('$nplus1_userId', '$username', '$address', '$email', '$pw')";
                $result = mysqli_query($conn, $insert_query);
    
                echo "<script>alert('Sign up successful.')</script>";
                echo "<script>location.href='login.php';</script>"; // Redirect after successful signup
            }
    
            else if ($pw != $re_pw){
                 echo "<script>alert('Password and re-entered password does not match.')</script>";
                 echo "<script>location.href='login.php';</script>"; 
            }
        
        }
    
        else {
            echo "<script>alert('Please fill up all the information first.')</script>";
            echo "<script>location.href='login.php';</script>"; 
        }
    }

    else;

    ?>

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