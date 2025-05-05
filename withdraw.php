<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");

$username = $amount = $trans_pas = $errormsg = $account = $success  = $total = "";

@$id = $_SESSION['id'];
$sql = "SELECT * FROM platform_table WHERE id = '$id'";
$query = mysqli_query($connection, $sql);
$result = mysqli_fetch_array($query);
$account = $result["account"];
$user_commission = $result["user_commission"];
$total = $user_commission + $account;

if (isset($_POST["submit"])) {

    if (empty($_POST["username"]) || empty($_POST["trans_pass"])) {
        $errormsg = "All fields are required.";
    } else {
        $username = mysqli_real_escape_string($connection, $_POST["username"]);
        @$amount = floatval($_POST["amount"]);
        $trans_pas = mysqli_real_escape_string($connection, $_POST["trans_pass"]);
    

        // Check if username and transaction password match
        $sql = "SELECT * FROM platform_table WHERE username = '$username' AND transaction_password = '$trans_pas'";
        $query = mysqli_query($connection, $sql);
        $result = mysqli_fetch_array($query);
        $rows = mysqli_num_rows($query);

        if ($rows == 1) {
            $account = $result["account"];
            $user_id = $result["id"];

            if ($amount > $total) {
                $errormsg = "Insufficient balance.";
            } else {
                // Deduct the amount from the user's account
                $new_balance = $total - $amount;
                $update_balance_sql = "UPDATE platform_table SET account = 0, user_commission = 0, total = 0 WHERE id = '$id'";

                mysqli_query($connection, $update_balance_sql);

                // Insert withdrawal request into withdrawal_table
                $insert_withdrawal_sql = "INSERT INTO withdrawal_table (user_id, username, amount, statuss) 
                                          VALUES ('$user_id', '$username', '$amount', 'pending')";
                mysqli_query($connection, $insert_withdrawal_sql);

                // Success message
                $success = "Withdrawal request submitted successfully. Processing will take 2 minutes or less. Redirecting...";
                $_SESSION['withdraw_success'] = true;
            }
        } else {
            $errormsg = "Invalid username or transaction password.";
        }
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, scalable=no">
    <title>Withdrawal Form</title>
    <link rel="stylesheet" href="withdraw.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="form-container">
        <i class="fa fa-times" id="cls" onclick="cls1()"></i><br>
        <h3 style="color: green;"><?php echo $success; ?></h3>
        <h2>Withdrawal Form</h2>
        <h3 style="color: red;"><?php echo $errormsg; ?></h3><br>

        <form id="withdrawal-form" action="withdraw.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label><br>
                <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo $username; ?>" required>
            </div>

       <div class="form-group">
    <label for="amount">Amount</label><br>
    <div class="input-with-button">
        <input type="number" id="amount" name="amount" placeholder="Enter amount" min="1" value="<?php echo $amount; ?>" disabled>
        <button type="button" onclick="amounthere()" class="inside-button">ALL</button>
    </div>
</div>

            <div class="form-group">
                <label for="transaction_password">Transaction Password</label><br>
                <input type="password" id="transaction_password" name="trans_pass" placeholder="Enter your transaction password" value="<?php echo $trans_pas; ?>" required>
            </div>

            <div class="form-group"><br>
                <button type="submit" id="withdraw-button" name="submit">Withdraw</button><br><br>
            </div>
        </form>
    </div>

    <script>
        function cls1() {
            window.location.href = 'profile.php';
        }

        if ("<?php echo $success; ?>" !== "") {
            setTimeout(function() { window.location.href = 'cashout.php'; }, 5000);
        }
    </script>

    <script>
    const userTotal = <?php echo isset($total) && is_numeric($total) ? $total : 0; ?>;

    function amounthere() {
        document.getElementById('amount').value = userTotal;
    }


</script>
</body>
</html>
