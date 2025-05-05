<?php
session_start();

// Database connection
$connection = mysqli_connect("localhost", "root", "", "platform");
$database = mysqli_select_db($connection, "platform");

$product_price = $account = $new_account = $commission = "";
$no_fund = "";

// Fetch user data from session
$id = $_SESSION["id"];
$sql = "SELECT * FROM platform_table WHERE id = '$id'";
$query = mysqli_query($connection, $sql);
$result = mysqli_fetch_array($query);
$account = $result["account"];

// Fetch product data
$sql = "SELECT * FROM product_table";
$query = mysqli_query($connection, $sql);
$row_count = mysqli_num_rows($query);

if (!isset($_SESSION['current_product_id'])) {
    $_SESSION['current_product_id'] = 0;
}

// Get the current product details
mysqli_data_seek($query, $_SESSION['current_product_id']);
$current_product = mysqli_fetch_assoc($query);
$product_price = $current_product["product_price"];
$product_name = $current_product["product_name"];
$commission = $product_price * 0.004;

if (isset($_POST['submit'])) {
    // Check if the user has enough balance to purchase the product
    if ($product_price <= $account) {
        // Deduct the price from the account balance
        $new_account = $account - $product_price;

        // Update the account balance in the database
        $setsql = "UPDATE platform_table SET account = $new_account WHERE id = '$id'";
        $check = mysqli_query($connection, $setsql);

        if ($check) {
            // Update the product clicked counter
            $sql_update = "UPDATE platform_table SET products_clicked = products_clicked + 1 WHERE id = '$id'";
            $sql_query = mysqli_query($connection, $sql_update);

            // Increment to the next product
            $_SESSION['current_product_id']++;

            // If we've passed the last product, reset to the first one
            if ($_SESSION['current_product_id'] >= $row_count) {
                $_SESSION['current_product_id'] = 0;
            }

            // Redirect back to product_purchase.php to show the next product
            header("Location: product_purchase.php");
            exit();
        } else {
            echo "Error updating account balance.";
        }
    } else {
        $no_fund = "Not enough funds to purchase this product.";
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Purchase</title>
    <style>
        body {
            background: cyan;
        }
        #purch {
            text-align: center;
            width: 50%;
            margin: 4em auto;
            line-height: 4em;
            border-right: 5px solid gold;
            box-shadow: 0px 30px 40px rgba(0, 0, 0, 0.6);
            background: cyan;
            opacity: 0.9;
            font-weight: bold;
        }
        button {
            font-size: 1.3em;
            font-weight: bold;
            border-right: 5px solid gold;
        }
        button:hover {
            font-size: 1.5em;
            background: silver;
        }
    </style>
</head>
<body>
    <div id="purch">
        <h1>Product: <?php echo $product_name; ?></h1>
        <p>Price: <?php echo $product_price; ?> USDT</p>
        <p>Commission: <?php echo $commission; ?> USDT</p>
        <p>Your Account Balance: <?php echo $account; ?> USDT</p>
        <h3><?php echo $no_fund; ?></h3>

        <!-- Form to submit purchase -->
        <form action="purchase.php" method="POST">
            <button type="submit" name="submit" <?php if ($product_price > $account) echo 'disabled'; ?>>Submit</button>
        </form>
    </div>
</body>
</html>
