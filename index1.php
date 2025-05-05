<?php
// Connect to database
$connection = mysqli_connect("localhost", "root", "", "platform");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch 16 random images
$sql = "SELECT image_url FROM product_table ORDER BY RAND() LIMIT 4";
$query = mysqli_query($connection, $sql);
?>

<div class="gallery">
    <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <img src="images_file/<?= $row['image_url']; ?>" alt="loading">
    <?php endwhile; ?>
</div>

<?php mysqli_close($connection); ?>
