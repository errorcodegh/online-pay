<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");
$database = mysqli_select_db($connection,"platform");

$username = $crypto = $wallet = $errormsg = $success = "";

if (isset($_POST["bind"])) {
    if (empty($_POST["username"]) || empty($_POST["crypto"]) || empty($_POST["wallet"])) {
        $errormsg = "Empty field !!";
    } else {
        $username = mysqli_real_escape_string($connection, $_POST["username"]);
        $crypto = mysqli_real_escape_string($connection, $_POST["crypto"]);
        $wallet = mysqli_real_escape_string($connection, $_POST["wallet"]);

        $id = $_SESSION['id'];

        // Check if username exists
        $sql = "SELECT * FROM platform_table WHERE username = '$username'";
        $query = mysqli_query($connection, $sql);
        $result = mysqli_num_rows($query);

        if ($result == 1) {
            // Check if the same crypto name and wallet address already exist
            $check_sql = "SELECT * FROM platform_table WHERE crypto_name = '$crypto' AND wallet_address = '$wallet'";
            $check_query = mysqli_query($connection, $check_sql);
            $exists = mysqli_num_rows($check_query);

            if ($exists == 1) {
                $errormsg = "Crypto name and wallet address already exist!";
            } else {
                // Update wallet and crypto name
                $updatesql = "UPDATE platform_table SET wallet_address = '$wallet', crypto_name = '$crypto' WHERE id = '$id'";
                $query_update = mysqli_query($connection, $updatesql);

                if ($query_update) {
                    $success = "Bind successful!";
                } else {
                    $errormsg = "Error updating wallet!";
                }
            }
        } else {
            $errormsg = "Username not found!";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Crypto Wallet binding page</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
 <style>

/* Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: silver;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: silver;
    padding: 20px;
    width: 50%;

    box-shadow: 0 30px 20px rgba(0, 0, 0, 0.8);
    border-radius: 8px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

.input-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background: #007bff;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}

@keyframes anim{
    from{opacity: 1.0;}
    to{opacity: 0.1;}
}


.error{
    color: red;
    animation: 1s anim infinite;
}


button:hover {
    background: #0056b3;
}

   .close-btn {
            position: absolute;
            top:3em;
            font-size: 1.5em;
            cursor: pointer;
        }

@media screen and (max-width: 480px) {
    .container {
        width: 95%;
    }
}


 </style>

</head>
<body>
    <div class="container">
        <i class="fa fa-times close-btn" onclick="cls1()"></i><br>
        <h2>Bind Wallet</h2>
        <h3 class="error"><?php  echo $success; ?></h3>
        <h3 class="error"><?php  echo $errormsg; ?></h3>
        <form action="bindwallet.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>

            <div class="input-group">
                <label for="crypto">Crypto Name</label>
                <select id="crypto" name="crypto">
                    <option value="" disabled selected>Select Cryptocurrency</option>
                    <option value="Bitcoin">Bitcoin (BTC)</option>
                    <option value="Ethereum">Ethereum (ETH)</option>
                    <option value="Ripple">Ripple (XRP)</option>
                    <option value="Litecoin">Litecoin (LTC)</option>
                    <option value="USDT">Tether (USDT)</option>
                </select>
            </div>

            <div class="input-group">
                <label for="wallet">Wallet Address</label>
                <input type="text" id="wallet" name="wallet" placeholder="Enter your wallet address">
            </div>

            <button type="submit" name="bind">Bind</button>
        </form>
    </div>

     <script>
        function cls1() {
            window.location.href = 'profile.php';
        }


        if("<?php echo $success; ?>" !== ""){
            setTimeout(function() { window.location.href="profile.php"}, 2000);
        }
    </script>

</body>
</html>