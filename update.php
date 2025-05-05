<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch user ID from session
if (!isset($_SESSION["id"])) {
    die("User not logged in.");
}

$id = $_SESSION["id"];
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $transaction_password = mysqli_real_escape_string($connection, $_POST["transaction_password"]);

   
    // Update user details
    $update_sql = "UPDATE platform_table SET username = '$username', passwordd = '$password', transaction_password = '$transaction_password' WHERE id = '$id'";
    
    if (mysqli_query($connection, $update_sql)) {
        $success_message = "Update successful! Redirecting to login...";
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            text-align: center;
            padding: 30px;
        }
        form {
            background: white;
            padding: 20px;
            box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.8);
            width: 50%;
            margin: auto;
            border-radius: 5px;
            line-height: 5em;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background: #218838;
        }
        .success {
            color: green;
            font-weight: bold;
        }

  @media screen and (max-width: 480px){
    form{
        width: 90%;
        height: auto;
        font-size: 1.5em;
        overflow: hidden;
    }

    input,button{font-size: 1.2em;}
  }



    </style>
</head>
<body>

    <h2>Update Your Details</h2>

    <form method="POST">
    <i class="fa fa-times" id="cls" onclick="cls1()"></i><br>
    <p class="success" id="successMessage"><?php echo $success_message; ?></p>
        <input type="text" name="username" placeholder="New Username" required>
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="transaction_password" placeholder="New Transaction Password" required>
        <button type="submit">Update</button>
    </form>

    

    <script>
        // Redirect after update success
        if ("<?php echo $success_message; ?>" !== "") {
            setTimeout(function() 
{ window.location.href = "logingpage.php"; },  3000); 
        }
    </script>

    <script>
      function cls1(){
     document.getElementById("#").innerHTML = window.location.href = 'profile.php';
      }
    </script>

</body>
</html>