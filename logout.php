<?php 
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
   
</head>
<body>
    <center><h1>You are being logged out...</h1></center>

     <script>
        // Redirect after 2 seconds
        setTimeout(function() {
            window.location.href = "logingpage.php?message=Logged out successfully";
        }, 2000);
    </script>
    
</body>
</html>
