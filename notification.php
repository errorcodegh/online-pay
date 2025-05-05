<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");

@$id = $_SESSION['id'];
$sql = "SELECT * FROM platform_table WHERE id = '$id'";
$query = mysqli_query($connection, $sql);
$result = mysqli_fetch_array($query);

// Fetch notifications for the user
$notification_sql = "SELECT * FROM notifications WHERE user_id = '$id' ORDER BY created_at DESC";
$notification_query = mysqli_query($connection, $notification_sql);

// Mark notifications as read when the user visits the page
mysqli_query($connection, "UPDATE notifications SET is_read = 1 WHERE user_id = '$id'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Messages | SemRush</title>
    <style>
        /* Your custom styles for notification page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
        }

        #headerme {
            background-color: #007bff;
            color: white;
            padding: 20px;
        }

        #headerme h1 {
            margin: 0;
        }

        #messages {
            padding: 20px;
        }

        #messages ul {
            list-style: none;
            padding: 0;
        }

        #messages li {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        #messages li.unread {
            background-color: #d1ecf1;
        }

        #messages li p {
            font-size: 0.9em;
            color: #6c757d;
            margin: 5px 0 0;
        }

         .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            transition: 0.3s;
        }

    </style>
</head>
<body>

<div id="headerme">
    <h3>SemRush - Notifications</h3>
</div>

<section id="messages">
    <i class="fa fa-times close-btn" onclick="closepage()"></i>
    <h2>Your Notifications</h2>
    <?php if (mysqli_num_rows($notification_query) > 0): ?>
        <ul>
            <?php while ($notification = mysqli_fetch_assoc($notification_query)): ?>
                <li class="<?php echo $notification['is_read'] == 0 ? 'unread' : ''; ?>">
                    <strong>Admin:</strong> <?php echo nl2br(htmlspecialchars($notification['message'])); ?>
                    <p><em>Received: <?php echo $notification['created_at']; ?></em></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No new messages.</p>
    <?php endif; ?>
</section>


 <script>
        function closepage() {
            window.location.href='profile.php';
        }
    </script>

</body>
</html>
