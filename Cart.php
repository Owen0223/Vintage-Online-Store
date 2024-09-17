<?php
    require_once 'Connection.php';
?>

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

    <title>Shopping Cart</title>
    <style>
        table {
            margin: 0 auto;
            margin-top: 20px;
            width: 90%;
            text-align: center;
        }

        thead {
            background-color: #B2FFFF;
            font-size: 18px; 
            line-height: 30px; 
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
    <!-- =================== CART ======================-->
    <div id="cart" class="cart">
        <h1>Cart List</h1>
        <table id="cart-list" border="3">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price per unit (RM)</th>
                    <th>Quantity</th>
                    <th>Total Price (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if (!isset($_SESSION['userId'])) {
                    echo "<script>alert('Please login to view product details.'); window.close();";
                    echo 'window.location.href = "home.php";</script>';
                    exit();
                }

                $user = $_SESSION['userId'] ;
                $finalprice = 0;
                $totalprice = 0;
                $no = 1;

                $sql = "SELECT * FROM cart INNER JOIN product ON cart.productID = product.productID WHERE cart.userId = ? AND cart.cartProductQuantity > 0";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $priceunit = $row['productPrice'];
                        $totalprice = $priceunit * $row['cartProductQuantity'];
                        $finalprice += $totalprice;
                        ?>

                        <tr onclick="window.location.href = 'product.php?id=<?php echo $row['productId']; ?>';" style="cursor: pointer;"> 
                        <?php
                        echo "<td>{$no}</td>";
                        echo "<td><img src='../Group Assignment/assets/img/" . $row['productImgUrl'] . "' width='100' height='100'></td>";
                        echo "<td>{$row['productName']}</td>";
                        echo "<td>". number_format($priceunit, 2) . "</td>";
                        echo "<td>{$row['cartProductQuantity']}</td>";
                        echo "<td>" . number_format($totalprice, 2) . "</td>";
                        ?>
                        </tr>
                        <?php

                        $no++;
                    }
                    echo "<tr>";
                    echo "<td colspan='5' style='text-align: right;'>Total</td>";
                    echo "<td>". number_format($finalprice, 2) . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='6'>No items in the cart.</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table><br/><br/>
        <input type="hidden" name="totalprice" value="<?php echo $totalprice; ?>">
    </div> 
        <button onclick="toggle()" style="width: 50px; height: 30px;">Pay</button><br/>
        <form id="billingForm" action="cartconn.php" method="POST" onsubmit="return validateForm()"> 
        <div id="billing-info" class="billing-info" style="display: none;">
        <table>
            <tr>
                <h2>Billing Information</h2><hr>
            </tr>
            <tr>
                <h3>Contact:</h3>
                <input type="text" name="email" id="email" placeholder="Email">&nbsp
                <input type="text" name="telephone" id="txtPhone" placeholder="Tel">
                <span id="emailError" class="error"></span>
                <span id="phoneError" class="error"></span><br>
            </tr>
            <tr>
                <h3>Order Pick-up:</h3>
                <label><input type="radio" name="shippingOption" value="pickUp" class="shipping-option"/> Pick Up &nbsp&nbsp&nbsp&nbsp</label>
                <label><input type="radio" name="shippingOption" value="shipping" class="shipping-option"/> Shipping</label><br/><br/>
            </tr>
            <tr>
        <label for="customize" style="font-weight: bold; font-size: 20px;">Select your packaging style:</label>
        <select name="customize" id="customize">
            <?php
            $customizeOptions = array("Normal", "Wedding Aniversary", "Birthday", "Annual Event");

            foreach ($customizeOptions as $option) {
                // Check if the option matches the one selected by the user, and add the 'selected' attribute if so
                $selected = ($_POST['customize'] === $option) ? 'selected' : '';
                echo "<option value=\"$option\" $selected>$option</option>";
            }
            ?>
        </select><br/><br/>
        </tr>
            <tr>
                <h3>Payment By:</h3>
                <button type="button" class="card-btn" onclick="selectPaymentMethod('Card')">
                    <img src="Card.png" alt="Credit Card">
                </button>
                <button type="button" class="master-btn" onclick="selectPaymentMethod('MasterCard')">
                    <img src="MasterCard.png" alt="MasterCard">
                </button>
                <button type="button" class="TouchnGo-btn" onclick="selectPaymentMethod('TouchnGo')">
                    <img src="TouchnGo.png" alt="Touch 'n Go">
                </button>
                <input type="hidden" name="method" id="paymentMethod">            
            </tr>

            <tr>
                <h3>Receiver Details:</h3>
                <input type="text" name="fname" id="fname" placeholder="First Name">&nbsp
                <input type="text" name="lname" id="lname" placeholder="Last Name"><br>
                <span id="nameError" class="error"></span><br>
                <input type="text" name="address" id="address" placeholder="Address">
                <span id="addressError" class="error"></span>
            </tr>
        </table>
        <br><button class="btnDone" type="submit">Done</button>
    </div>
</form>

<script>
    function toggle() {
            var billing = document.querySelector(".billing-info");
            billing.scrollIntoView({ behavior: 'smooth', block: 'start' });

            billing.style.display = "block";
        }
    
    function selectPaymentMethod(method) {
        document.getElementById('paymentMethod').value = method;
    }

    function validateForm() {
        var email = document.getElementById("email").value;
        var telephone = document.getElementById("txtPhone").value;
        var fname = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var address = document.getElementById("address").value;
        var errorMessages = "";


        var emailPattern = /\S+@\S+\.\S+/;
        if (!emailPattern.test(email)) {
            errorMessages += "Must be valid email.\n";
        }


        var phonePattern = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/;
        if (!phonePattern.test(telephone)) {
            errorMessages += "Phone number must be xxx-xxxxxxx\n";
        }


        if (fname === "" || lname === "") {
            errorMessages += "Name is required\n";
        }


        if (address === "") {
            errorMessages += "Address is required\n";
        }

        if (errorMessages !== "") {
            alert(errorMessages);
            return false;
        }

        var finalpriceInput = document.createElement("input");
        finalpriceInput.type = "hidden";
        finalpriceInput.name = "finalprice";
        finalpriceInput.value = document.querySelector("input[name=finalprice]").value;
        document.getElementById("billingForm").appendChild(finalpriceInput);

        return true;
    }
</script>

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