<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize variables
$product_price = $account = $new_account = $product_clicked = $commission = $order_status = $random_bonus = "";
$vip = "";
$errormsgg = "";
$total = 0;

// Fetch user data from session
$id = $_SESSION["id"];
$sql = "SELECT * FROM platform_table WHERE id = '$id'";
$query = mysqli_query($connection, $sql);
$result = mysqli_fetch_array($query);
$account = $result["account"];
$user_commission = $result["user_commission"];
$username = $result["username"];
$total = $result["total"];

// Assign VIP levels
if ($account <= 100) {
    $vip = 'VIP1 : 0.004%';
    $random_bonus = $account * 0.004;
} elseif ($account <= 2000) {
    $vip = 'VIP2 : 0.006%';
    $random_bonus = $account * 0.006;
} elseif ($account <= 3000) {
    $vip = 'VIP3 : 0.008%';
    $random_bonus = $account * 0.008;
} else {
    $vip = 'VIP4 : 1%';
    $random_bonus = $account * 0.01;
}

// Update total
mysqli_query($connection, "UPDATE platform_table SET total = $account + $user_commission WHERE id = '$id'");

// Fetch last clicked product
$product_query = "SELECT last_product_id FROM platform_table WHERE id = '$id'";
$product_result = mysqli_query($connection, $product_query);
$last_product_id = mysqli_fetch_assoc($product_result)['last_product_id'] ?? 0;

// Fetch product list
$product_query = "SELECT * FROM product_table";
$product_result = mysqli_query($connection, $product_query);
$row_count = mysqli_num_rows($product_result);

// Initialize current product ID
if (!isset($_SESSION['current_product_id'])) {
    $_SESSION['current_product_id'] = $last_product_id;
}

// Handle purchase
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['next'])) {
    if ($_SESSION['current_product_id'] < $row_count) {
        mysqli_data_seek($product_result, $_SESSION['current_product_id']);
        $current_product = mysqli_fetch_assoc($product_result);
        $product_id = $current_product["product_id"];
        $product_name = $current_product["product_name"];
        $product_price = $current_product["product_price"];
        $image_url = $current_product["image_url"];

        // Check for super order override
        $super_sql = "SELECT super_price, statuss, super_product_id FROM super_price_table WHERE user_id = '$id' AND product_id = '$product_id'";
        $super_query = mysqli_query($connection, $super_sql);
        if (mysqli_num_rows($super_query) > 0) {
            $super_data = mysqli_fetch_array($super_query);
            $order_status = $super_data['statuss'];
            $product_price = $super_data['super_price'];

            if (!empty($super_data['super_product_id'])) {
                $replacement_id = $super_data['super_product_id'];
                $replacement_query = mysqli_query($connection, "SELECT * FROM product_table WHERE product_id = '$replacement_id'");
                if (mysqli_num_rows($replacement_query) > 0) {
                    $replacement = mysqli_fetch_array($replacement_query);
                    $product_id = $replacement["product_id"];
                    $product_name = $replacement["product_name"];
                    $image_url = $replacement["image_url"];
                }
            }
        }

        $commission = $product_price * 0.04;

        // Process purchase
        if ($account >= $product_price) {
            $new_account = $account - $product_price;
            mysqli_query($connection, "UPDATE platform_table SET account = $new_account, user_commission = user_commission + $commission, products_clicked = products_clicked + 1 WHERE id = '$id'");

            mysqli_query($connection, "INSERT INTO transaction_history (user_id, product_id, product_name, amount, commission_earn, image_url) VALUES ('$id', '$product_id', '$product_name', '$product_price', '$commission','$image_url')");

            $_SESSION['show_popup'] = true;
        } else {
            $errormsgg = "Super Order, NOT enough Funds";
        }

        // Next product
        $_SESSION['current_product_id']++;
        if ($_SESSION['current_product_id'] >= $row_count) {
            $_SESSION['current_product_id'] = 0;
        }

        mysqli_query($connection, "UPDATE platform_table SET last_product_id = '{$_SESSION['current_product_id']}' WHERE id = '$id'");

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Load product display
if ($_SESSION['current_product_id'] < $row_count) {
    mysqli_data_seek($product_result, $_SESSION['current_product_id']);
    $current_product = mysqli_fetch_assoc($product_result);
    $product_id = $current_product["product_id"];
    $product_name = $current_product["product_name"];
    $product_price = $current_product["product_price"];
    $image_url = $current_product["image_url"];

    $super_sql = "SELECT super_price, statuss, super_product_id FROM super_price_table WHERE user_id = '$id' AND product_id = '$product_id'";
    $super_query = mysqli_query($connection, $super_sql);
    if (mysqli_num_rows($super_query) > 0) {
        $super_data = mysqli_fetch_array($super_query);
        $order_status = $super_data['statuss'];
        $product_price = $super_data['super_price'];

        if (!empty($super_data['super_product_id'])) {
            $replacement_id = $super_data['super_product_id'];
            $replacement_query = mysqli_query($connection, "SELECT * FROM product_table WHERE product_id = '$replacement_id'");
            if (mysqli_num_rows($replacement_query) > 0) {
                $replacement = mysqli_fetch_array($replacement_query);
                $product_id = $replacement["product_id"];
                $product_name = $replacement["product_name"];
                $image_url = $replacement["image_url"];
            }
        }
    }

    $commission = $product_price * 0.04;
}

// Fetch product click count
$product_clicked = mysqli_fetch_array(mysqli_query($connection, "SELECT products_clicked FROM platform_table WHERE id = '$id'"))["products_clicked"];
if ($product_clicked >= 45) {
    $errormsgg = "Task complete, reset and proceed";
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <title>Product Purchase</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* General Styles */
        body,html {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            
        }

        #list,#smallview{display: none;}

        .logo img{width: 5em; height: 2em;}
        img{font-size: 0.3em;}

.auto-type1{font-size: 1em; 
    font-family: monospace; 
    letter-spacing: 2px;

     }

header {
    background: #0063b1; 
    width: 100vw;
    color: white;
    padding: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0px;
    z-index: 999;


}

header .logo h2 {
    font-size: 2em;
    letter-spacing: 2px;
    font-weight: bold;
    animation: slideInLeft 1s ease-out;
    margin: 0px 0.5em;
    box-shadow: 0 30px 30px rgba(0, 0, 0, 0.6);

    


}


header nav ul {
    list-style: none;
    display: flex;
    justify-content: space-between;
    margin: 0;
    gap: 15px;
    flex-wrap: wrap;

}

header nav ul li {
    margin-left: 2em;
    margin: 0px 1em;

}

header nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 1.1rem;
    transition: color 0.3s;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
    
}


header nav ul li a:hover {
    color: #f5c518;
}


        /* Container Styling */
        .container {
            width: 80%;
            background: #f4f4f4;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 20px;
            text-align: center;

        }

        /* Profile Section */
        .profile {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile i {
            font-size: 50px;
            color: #007BFF;
        }

        /* Balance & Earnings */
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .stats .box {
            flex: 1;
            background: #f4f4f4;
            color: black;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            padding: 15px;
            margin: 5px;
            border-radius: 8px;
            font-weight: bold;
        }

        /* VIP Section */
        .vip-section {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .vip-section h4 {
            margin: 5px 0;
        }
    
      

        /* Popup Modal */
        .popup {
            display: none;
            position: fixed;
            line-height: 2.5em;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 80%;
            max-width: 400px;
            z-index: 9999;
            transition: transform 0.3s ease-in-out;
        }
        .popup.show {
            transform: translate(-50%, -50%) scale(1);
            display: block;
        }

            .image-container img{
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .popup button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 5px;
            margin-top: 10px;
        }

        @keyframes animat{
            from{opacity: 1.0;}
            to{opacity: 0.5;}
        }

        /* Purchase Button */
        .purchase-btn {
            background: #F4F4F4;
            color: black;
            box-shadow: 0px 5px 30px rgba(0, 0, 0, 0.6);
            border-left: 2px solid blue;
            padding: 12px;
            font-size: 1.2em;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
            width: 5em;
            height: 5em;
            border-radius: 50%;
            box-sizing: border-box;
            animation: 2s animat infinite;

        }
        .purchase-btn:hover {
            background: #218838;
        }


        @keyframes animm{
            from{opacity: 1.0;}
            to{opacity: 0.1;}
        }

        #immg{
            width: 5em;
            height: 5em;
            border-radius: 50%;
            background-color: green;
        }

        .error,#status {color: red; animation: 1s animm infinite; font-weight: bolder;}

         #tot{color: red; font-family: monospace;}

         #down{
            display: flex;
            padding: 1em;
            justify-content: space-between;

         }



         .fa{font-size: 1.2em;}
         #btn{display: block;}


        /* Responsive */
        @media (max-width: 468px) {

            body,html{
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
                margin: 0;
                padding: 0;
            }

            .stats {
                display: flex;
                padding: 1em;
                font-weight: lighter;
            }

            #tot {
    display: block !important;
}

    #list {
    display: block;
    position: absolute;
    right: 2em;
    top: 1em;
    font-size: 1.5em;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
}

#smallview{
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    width: 100vw;
    height: auto;
    line-height: 5em;
    font-family: monospace;
    background: #0063b1;
    box-shadow: 0 0px 30px rgba(0, 0, 0, 0.8);
    z-index: 1;
    display: none;
    }

    #smallview a{
    text-decoration: none;
    padding: 2em;
    font-size: 1.7em;
    color: white;

}



nav,.auto-type{display: none;}

#cls{
    padding: 1em;
    font-size: 1.7em;
}

        }
    </style>
</head>
<body>

     <header>
        <div id="smallview">
            <i class="fa fa-times" id="cls" onclick="cls()"></i>
            <ul>
                <li><a href="indexplatform.php">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>

        <div class="logo">
            <h2><img src="images_file/logome.webp">semrush  <span class="auto-type"></span></h2>
            <i class="fa fa-bars" id="list" onclick="small()"></i>
        </div>
        
        <nav>
            <ul>
        <li><a href="indexplatform.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#about"><i class="fa fa-info-circle"></i> About</a></li>
        <li><a href="#services"><i class="fa fa-cogs"></i> Services</a></li>
        <li><a href="#contact"><i class="fa fa-envelope"></i> Contact</a></li>
        <li><a href="profile.php">Profile  <i class="fa fa-user-circle"></i></a></li>
                

            </ul>
        </nav>
    </header>


    <div class="container">
        <div class="profile">
            <i class="fa fa-user"></i>
            <h2>Welcome, <?php echo $username; ?></h2>
        </div>

        <!-- VIP Section -->
        <div class="vip-section">
            <h4> VIP Status: <?php echo $vip; ?> </h4>
            <h4>Earn more to reach the next level!</h4>
        </div>

        <div id="clicks">
        <h3>Total clicks</h3>
        <h3><?php echo $product_clicked; ?> / 45</h3>
        </div>

        <div class="stats">
            <div class="box">Balance: <?php echo $account - $product_price; ?> USDT</div>
            <div class="box">Earnings: <?php echo $user_commission; ?> USDT</div>
        </div>

         <div id="tot"><h3>Total Withdrawal : <?php echo $total; ?></h3></div>

        <div class="image-container"><?php include 'indexindex.php'; ?></div>

        <div class="popup" id="popup">
            <h2>Transaction Details</h2>
            <img src="images_file/<?php echo $image_url; ?>" id="immg">
            <p>Product: <?php echo $product_name; ?></p>
            <p id="status"><?php echo $order_status; ?></p>
            <p>Product_price: <?php echo $product_price; ?></p>
            <p>current Balance: <?php echo $account; ?> USDT</p>
            <p>Commission Earned: <?php echo $commission; ?> USDT</p>
            
            <button onclick="closePopup()">SUbmit</button>
        </div>

        <h4 id="js-error-msg" class="error"></h4>
        <h6 class="error"><?php echo $product_name, " ", ":", " ", $product_price; ?></h6>

        <div id="down">
         <a href="indexplatform.php"><i class="fa fa-home" class="fa">  <br><br> Home</i></a>
        <form action="" method="POST">
            <button type="submit" class="purchase-btn" name="next" <?php if ($product_price > $account || $product_clicked >= 45) echo 'disabled'; ?>>START</button></form>
         <a href="history.php"><i class="fa fa-history" class="fa">   <br><br>History</i></a>

        
    </div>

    <script>
        function closePopup() {
            document.getElementById('popup').classList.remove('show');
        }
        window.onload = function() {
            if (<?php echo isset($_SESSION['show_popup']) ? 'true' : 'false'; ?>) {
                document.getElementById('popup').classList.add('show');
                <?php unset($_SESSION['show_popup']); ?>
            }
        };
    </script>

    <script>
     function small(){
   document.getElementById("smallview").style.display ="block";
 }

  function cls(){
   document.getElementById("smallview").style.display ="none";
 }
    </script>


     <script>
document.addEventListener("DOMContentLoaded", function() {
    let productPrice = <?php echo $product_price; ?>;
    let accountBalance = <?php echo $account; ?>;
    let productClicked = <?php echo $product_clicked; ?>;
    let errorMsg = document.getElementById("js-error-msg");
    let nextButton = document.querySelector("button[name='next']");

    function checkBalance() {
        if (productPrice > accountBalance) {
            errorMsg.innerHTML = "Super Order, NOT enough Funds";
            nextButton.disabled = true;
        } else if (productClicked >= 45) {
            errorMsg.innerHTML = "Task complete, reset and proceed";
            nextButton.disabled = true;
        } else {
            errorMsg.innerHTML = "";
            nextButton.disabled = false;
        }
    }

    checkBalance(); // Run check on page load

    // Prevent form submission if the balance is too low
    document.querySelector("form").addEventListener("submit", function(event) {
        if (productPrice > accountBalance) {
            event.preventDefault(); // Stop form submission
            errorMsg.innerHTML = "Super Order, NOT enough Funds";
        }
    });
});

    </script>

    <script>
        function cls22() {
            window.location.href = 'product_purchase.php';
        }


    </script>


</body>
</html>