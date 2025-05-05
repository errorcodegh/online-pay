<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$id = $_SESSION["id"];

$updateSuperOrder = "
    UPDATE transaction_history t
    JOIN super_price_table s ON t.user_id = s.user_id AND t.product_id = s.product_id
    SET t.super_order = 1
    WHERE t.user_id = '$id'
";
mysqli_query($connection, $updateSuperOrder);

$sql = "SELECT * FROM transaction_history WHERE user_id = '$id' ORDER BY id DESC";
$query = mysqli_query($connection, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            opacity: 0.8;
            margin-top: 20px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        img {
            width: 2em;
            height: 2em;
            border-radius: 50%;
            border: 1px solid slateblue;
        }

        th {
            background: #333;
            color: white;
        }

        /* Super Order Row Highlight */
        .super-order {
            background-color: #ffdddd !important; /* Light Red */
        }



        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            th, td {
                padding: 8px;
                font-size: 14px;
            }
        }

        @media screen and (max-width: 480px) {
            body {
                font-size: 14px;
            }
            th, td {
                padding: 6px;
                font-size: 12px;
            }
            h2 {
                font-size: 18px;
            }
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 2em;
            font-size: 20px;
            cursor: pointer;
        }

         #btn{
             position: absolute;
            top: 10px;
            right: 4em;
            font-size: 20px;
            cursor: pointer;
            display: none;
         }
    </style>
</head>
<body>
   <div class="table-container" id="container">
    <i class="fa fa-times close-btn" onclick="cls1()" id="closeme1"></i>
    <h2>Transaction History</h2>

        <table>
            <tr>
                <th>Product Name</th>
                <th>Amount</th>
                <th>Commission Earned</th>
                <th>Image</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($query)) { 
    
                // Check if the transaction is a Super Order
                $isSuperOrder = ($row["super_order"] == 1) ? "super-order" : "";  
            ?>
                <tr class="<?php echo $isSuperOrder; ?>">
                    <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["amount"]); ?> USDT</td>
                    <td><?php echo htmlspecialchars($row["commission_earn"]); ?> USDT</td>
                    <td><img src="images_file/<?php echo $row['image_url']; ?>"></td>  
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function cls1() {
            
        if (document.referrer.includes("history.php")) {
            window.location.href = "profile.php";
        } else {
            window.history.back();
        }
   

        }
       
    </script>

</body>
</html>
