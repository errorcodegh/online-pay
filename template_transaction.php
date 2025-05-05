<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");
$user_id = $_SESSION['id'] ?? 1;

$query = mysqli_query($connection, "SELECT * FROM btc_transactions WHERE user_id = '$user_id' AND status = 'pending' ORDER BY created_at DESC");
$btc_to_usd = 65000;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending BTC Transactions</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 15px auto;
            max-width: 600px;
            position: relative;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .status {
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-block;
            text-transform: capitalize;
        }

        .status.pending { background: #fff3cd; color: #856404; }
        .status.failed { background: #f8d7da; color: #721c24; }

        .wallet, .amount, .timestamp, .extra {
            margin: 6px 0;
            color: #444;
        }

        .btc {
            font-weight: bold;
            font-size: 1.1em;
        }

        .usd {
            color: #888;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h2>Unsuccessful Transactions</h2>

    <!-- 🔴 One Failed Summary -->
    <div class="card">
        <div class="status failed">Pending</div>
        <div class="extra"><strong>Hash/Email:</strong> RedheadNTX@proton.me</div>
        <div class="extra"><strong>Result:</strong> Failed (5 times)</div>
        <div class="timestamp"><small>Date: 13/04/2025</small></div>
    </div>

    <!-- 🟡 Static Pending Transaction -->
    <div class="card">
        <div class="status pending">Failed</div>
        <div class="wallet"><strong>From:</strong> bnb1wwns3r8jdwc6ncc7g3xs5ju25r3ax8de9qhcmj</div>
        <div class="wallet"><strong>To:</strong> bc1q4z7xugrap9vsghtjpq5ad0fa6hlllhfq6vqlwy</div>
        <div class="amount">
            <h2>Transfered<span class="btc">  0.610349 BTC</span></h2>
        </div>
       
    </div>

    <!-- 🔄 Dynamic Pending Transactions -->
    <?php while ($tx = mysqli_fetch_assoc($query)) { 
        $usd = $tx['amount_btc'] * $btc_to_usd;
    ?>
        <div class="card">
            <div class="status failed">Failed</div>
            <div class="wallet"><strong>From:</strong> <?php echo htmlspecialchars($tx['user_wallet']); ?></div>
            <div class="wallet"><strong>To:</strong> <?php echo htmlspecialchars($tx['recipient_wallet']); ?></div>
            <div class="amount">
                <span class="btc"><?php echo $tx['amount_btc']; ?> BTC</span> 
                <span class="usd">(~$<?php echo number_format($usd, 2); ?> USD)</span>
            </div>
            <div class="timestamp">
                <small><?php echo date("M d, Y H:i A", strtotime($tx['created_at'])); ?></small>
            </div>
        </div>
    <?php } ?>
</body>
</html>
