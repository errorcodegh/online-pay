<?php
$connection = mysqli_connect("localhost", "root", "", "platform");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Reshuffle images
$sql = "SET @counter = 0;
        UPDATE images 
        SET position = (@counter := @counter + 1) 
        ORDER BY RAND();";

if (mysqli_multi_query($connection, $sql)) {
    echo "Images reshuffled!";
} else {
    echo "Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
