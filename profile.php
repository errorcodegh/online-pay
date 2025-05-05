<?php
session_start();

// Determine the correct database
$source_db = $_SESSION['source_db'] ?? 'platform'; // fallback to 'platform' if not set
$table_name = $source_db === 'platform1' ? 'platform_table1' : 'platform_table';

// Connect to the right database
$connection = mysqli_connect("localhost", "root", "", $source_db);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$vip = ""; 
$progress = 0;
$random_bonus = 0;
$total = 0;

$id = $_SESSION['id'] ?? null;

if ($id) {
    // Fetch user data
    $sql = "SELECT * FROM $table_name WHERE id = '$id'";
    $query = mysqli_query($connection, $sql);
    $result = mysqli_fetch_array($query);

    if ($result) {
        $account = $result["account"];
        $user_commission = $result["user_commission"];
        $total = $user_commission + $account;

        // Unread notifications (assumes notifications are in the same DB)
        $unread_sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = '$id' AND is_read = 0";
        $unread_result = mysqli_query($connection, $unread_sql);
        $unread_row = mysqli_fetch_assoc($unread_result);
        $unread_count = $unread_row['unread_count'] ?? 0;

        // VIP and bonus logic
        if ($account <= 100) {
            $vip = 'VIP1 : 0.004%';
            $progress = 25;
            $random_bonus = $account * 0.004;
        } elseif ($account <= 2000) {
            $vip = 'VIP2 : 0.006%';
            $progress = 50;
            $random_bonus = $account * 0.006;
        } elseif ($account <= 3000) {
            $vip = 'VIP3 : 0.008%';
            $progress = 75;
            $random_bonus = $account * 0.008;
        } else {
            $vip = 'VIP4 : 1%';
            $progress = 100;
            $random_bonus = $account * 0.01;
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile | ActiveCampaign</title>
    <style>
        * {
            margin: 0;
            border: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: cyan;
            overflow-x: hidden;
        }

        .logo img{width: 5em; height: 2em;}
        img{font-size: 0.3em;}

        #headerme {
            width: 100vw;
            height: 6em;
            background-color: #0063b1;
            display: flex;
            position: sticky;
            top: 0px;
            z-index: 999;
        }

        #bigview {
            position: absolute;
            right: 0px;
            display: flex;
        }

        #bigview ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            font-weight: bold;
            box-shadow: 0 0px 10px rgba(0, 0, 0, 0.2);
            margin-right: 1.5em;
            padding: 0.7em;
        }

 ul li i{
          margin-right: 0.7em;
        }

        #bigview ul li a:hover {
            color: silver;
        }

        #bigview ul li {
            list-style: none;
            margin-left: 3em;
            margin: 2em 1.3em;
            display: inline-block;
        }

        .logo {
            padding: 1.2em;
            color: white;
        }

        .logo h2 {
            box-shadow: 0 30px 30px rgba(0, 0, 0, 0.6);
        }

        .auto-type {
            font-family: monospace;
            font-weight: lighter;
            font-size: 0.8em;
        }

        #smallview {
            display: none;
        }

        #list {
            display: none;
        }

        .auto-type1 {
            font-size: 2em;
            font-family: monospace;
            letter-spacing: 2px;
        }

        /* Profile Section */
        .profile-section {
            display: flex;
            justify-content: center;
            padding: 40px 0;
        }

        .profile-container {
            display: flex;
            gap: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
        }

        
        /* Cards */
        .profile-card, .actions-card {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            background: whitesmoke;
            box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.4);
            text-align: center;
            opacity: 0.8;
            font-family: monospace;
        }

        .profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 10px;
    display: block;
    border: 4px solid #007bff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}



.php-data {
    color: green;
}

.credit-score {
    margin-top: 20px;
    text-align: center;
}

.score-bar-container {
    width: 90%;
    height: 20px;
    background-color: silver;
    border-radius: 10px;
    margin: 0 auto;
    overflow: hidden;
    box-shadow: inset 0 0 5px #000;
}

.score-bar {
    height: 100%;
    background-color: green;
    border-radius: 10px;
    transition: width 0.5s ease-in-out;
}


        .actions-card a {
            text-decoration: none;
        }

        .profile-card {
            line-height: 4em;
            text-align: justify;
        }

        .profile-card h2 {
            color: #007bff;
        }

        #log {
            font-weight: bold;
        }

        .actions-card h2 {
            color: #333;
            margin-bottom: 15px;
        }

        #pro {
            text-align: center;
            font-size: 3em;
            
        }

        .fa{justify-content: flex-end;}
        
        #container {
            width: 100%;
            height: 0.5em;
            background-color: silver;
        }

      
       .btn-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin: 10px 0;
}

.btn-wrapper button {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 12px;
    border: none;
    border-radius: 5px;
    background: #007bff;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-wrapper button i {
    margin-right: 8px;
}

.btn-wrapper button:hover {
    background: #0056b3;
}

.end-link {
    padding: 12px;
    background: #0056b3;
    border-radius: 5px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.3s;
}

.end-link:hover {
    background: #003f7f;
}

#log {
    flex: 1;
    background: crimson;
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 12px;
    border-radius: 5px;
    display: flex;
    align-items: center;
}

#log i {
    margin-right: 8px;
}

@keyframes cnt{
    from{opacity: 1.0;}
    to{opacity: 0.2;}
}





        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
                gap: 20px;
            }

            #bigview {
                display: none;
            }

            .auto-type {
                font-family: monospace;
                display: none;
            }

            #list {
                display: block;
                position: absolute;
                right: 2em;
                top: 1em;
                font-size: 1.5em;
            }

            #smallview {
                position: sticky;
                top: 2em;
                left: 1em;
                right: 1em;
                width: 90%;
                height: auto;
                line-height: 6em;
                font-family: monospace;
                background: #0063b1;
                box-shadow: 0 0px 30px rgba(0, 0, 0, 0.8);
                z-index: 9999;
                display: none;
            }

            #smallview a {
                text-decoration: none;
                padding: 2em;
                font-size: 1.7em;
                color: white;
            }

            #cls {
                padding: 1em;
                font-size: 1.7em;
            }
        }
    </style>
</head>
<body>

<div id="headerme">
    <div class="logo">
        <h2><img src="images_file/logome.webp">SemRush  <span class="auto-type"></span></h2>
        <i class="fa fa-bars" id="list" onclick="small()"></i>
    </div>

    <div id="bigview">
        <ul>
         <li><a href="indexplatform.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="notification.php"><i class="fa fa-bell" style="color: white;"></i> Messages  
                <?php if ($unread_count > 0): ?>
                    <span style="color: gold; font-weight: bolder; padding: 0.3em;     
                     animation: 1s cnt infinite;
                    "><?php echo $unread_count; ?></span>
                <?php endif; ?>
            </a></li>
        <li><a href="profile.php"><i class="fa fa-user-circle"></i> Profile</a></li>
        </ul>
    </div>
</div>

<div id="smallview">
    <i class="fa fa-times" id="cls" onclick="cls()"></i>
    <ul>
        <li><a href="indexplatform.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="notification.php"><i class="fa fa-bell" style="color: white;"></i> Messages  
                <?php if ($unread_count > 0): ?>
                    <span style="color: gold; font-weight: bolder; padding: 0.3em;     
                     animation: 1s cnt infinite;
                    "><?php echo $unread_count; ?></span>
                <?php endif; ?>
            </a></li>
        <li><a href="profile.php"><i class="fa fa-user-circle"></i> Profile</a></li>
    </ul>
</div>

<!-- Main Profile Section -->
<section class="profile-section">
    <div class="profile-container">
        <!-- Left Side (User Info) -->
        <!-- Left Side (User Info) -->
<div class="profile-card">
    <div id="pro">
       <h6>Welcome, <span class="php-data"><?php echo $result["username"]; ?></span></h6><br>
        <img src="images_file/user.png" class="profile-img">
    </div>
    
    <div class="account-info">
        <h4><strong>Account:</strong> <span class="php-data"><?php echo $result["account"]; ?></span> USDT</h4>
        <h4><strong>Earnings:</strong> <span class="php-data"><?php echo $result["user_commission"]; ?></span> USDT</h4>
    </div>

   
    <h3><strong>Invite Code:</strong> <span class="php-data"><?php echo $result["my_code"]; ?></span></h3>

    <h3><?php echo $vip; ?></h3>
    <h3>Random Bonus: <span class="php-data"><?php echo $random_bonus; ?></span> USDT</h3>

    <div class="credit-score">
        <h3>Credit Score</h3>
        <div class="score-bar-container">
            <div class="score-bar" style="width: <?php echo $progress; ?>%;"></div>
        </div>
        <p class="php-data"><?php echo $progress; ?>%</p>
    </div>

    <h3><strong>Total Withdraw:</strong> <span class="php-data"><?php echo $total; ?></span> USDT</h3>
</div>


        <!-- Right Side (Actions) -->


          <!-- Right Side (Actions) -->
<div id="action-section" class="actions-card">
    <h2>Financial Services</h2>
    
    <div class="btn-wrapper">
        <button onclick="window.location.href='deposit.php'">
            <i class="fa fa-credit-card"></i> Deposit
        </button>
        <a href="deposit.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="btn-wrapper">
        <button onclick="window.location.href='withdraw.php'">
            <i class="fa fa-arrow-circle-down"></i> Withdraw
        </button>
        <a href="withdraw.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <h2>Personal Profile</h2>

    <div class="btn-wrapper">
        <button onclick="window.location.href='update.php'">
            <i class="fa fa-edit"></i> Update
        </button>
        <a href="update.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="btn-wrapper">
        <button onclick="window.location.href='history.php'">
            <i class="fa fa-history"></i> Records
        </button>
        <a href="history.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="btn-wrapper">
        <button onclick="window.location.href='events.php'">
            <i class="fa fa-calendar"></i> Events
        </button>
        <a href="events.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <h2>Wallets Info</h2>

    <div class="btn-wrapper">
        <button onclick="window.location.href='terms.php'">
            <i class="fa fa-file-text"></i> Terms and Conditions
        </button>
        <a href="terms.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="btn-wrapper">
        <button onclick="window.location.href='bindwallet.php'">
            <i class="fa fa-wallet"></i> Bind Wallet
        </button>
        <a href="bindwallet.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="btn-wrapper">
        <button onclick="window.location.href='faq.php'">
            <i class="fa fa-question-circle"></i> FAQs
        </button>
        <a href="faq.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>

    <br>

    <div class="btn-wrapper">
        <a href="logout.php" id="log"><i class="fa fa-sign-out"></i> LogOut</a>
        <a href="logout.php" class="end-link"><i class="fa fa-arrow-right"></i></a>
    </div>
</div>



       
</section>

<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    var typed = new Typed('.auto-type', {
        strings: ['Lets help you', 'with our digital platform', 'That pays daily', 'Get registered and earn'],
        typeSpeed: 60,
        backSpeed: 10,
        loop: true
    });

    function small(){
        document.getElementById("smallview").style.display ="block";
    }

    function cls(){
        document.getElementById("smallview").style.display ="none";
    }
</script>

</body>
</html>
