<?php
$connection = mysqli_connect("localhost", "root", "", "platform");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Shuffle images
$sql = "UPDATE images SET position = FLOOR(1 + (RAND() * 50))";
mysqli_query($connection, $sql);

mysqli_close($connection);
?>
