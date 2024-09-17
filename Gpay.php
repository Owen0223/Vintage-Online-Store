<!DOCTYPE html>
<html>
<head>
    <style>
         .btnDone {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .btnDone:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<form id="billingForm" action="" method="POST" onsubmit="return validateForm()">
    <div class="billing-info">
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
                <h3>Logistics Choices:</h3>
                <label><input type="radio" name="shippingOption" value="pickUp" class="shipping-option"/> Pick Up &nbsp&nbsp&nbsp&nbsp</label>
                <label><input type="radio" name="shippingOption" value="shipping" class="shipping-option"/> Shipping</label><br/>
            </tr>
            <tr>
                <h3>Payment By:</h3>
                    <button type="button" class="card-btn" onclick="selectPaymentMethod('Card')">
                        <img src="Card.png" alt="Logout">
                    </button>
                    <button type="button" class="master-btn" onclick="selectPaymentMethod('MasterCard')">
                        <img src="MasterCard.png" alt="Logout">
                    </button>
                    <button type="button" class="TouchnGo-btn" onclick="selectPaymentMethod('TouchnGo')">
                        <img src="TouchnGo.png" alt="Logout">
                    </button>
                    <input type="hidden" name="method" id="paymentMethod">            
            </tr>
            <tr>
                <h3>Personal Details:</h3>
                <input type="text" name="fname" id="fname" placeholder="First Name">&nbsp
                <input type="text" name="lname" id="lname" placeholder="Last Name"><br>
                <span id="nameError" class="error"></span><br>
                <input type="text" name="address" id="address" placeholder="Address">
                <span id="addressError" class="error"></span>
            </tr>
        </table>
        <br><button class="btnDone">Done</button>
    </div>
</form>

<script>
    function validateForm() {
        var email = document.getElementById("email").value;
        var telephone = document.getElementById("txtPhone").value;
        var fname = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var address = document.getElementById("address").value;
        var errorMessages = "";

        // Email validation
        var emailPattern = /\S+@\S+\.\S+/;
        if (!emailPattern.test(email)) {
            errorMessages += "Must be valid email.\n";
        }

        // Phone number validation
        var phonePattern = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/;
        if (!phonePattern.test(telephone)) {
            errorMessages += "Phone number must be xxx-xxxxxxx\n";
        }

        // Name validation
        if (fname === "" || lname === "") {
            errorMessages += "Name is required\n";
        }

        // Address validation
        if (address === "") {
            errorMessages += "Address is required\n";
        }

        if (errorMessages !== "") {
            alert(errorMessages);
            return false;
        }

        return true;
    }
</script>
</body>
</html>
