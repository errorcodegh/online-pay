<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "platform");

// Fetch images ordered by their shuffled position
$sql = "SELECT * FROM images ORDER BY position ASC";
$query = mysqli_query($connection, $sql);


echo "<div style='display: flex; flex-wrap: wrap; gap: 10px; width: 50%; height: 75vh; overflow: hidden; margin: 2em auto;' box-shadow: 0 30px 20px rgba(0,0,0,0.6);>";
while ($row = mysqli_fetch_assoc($query)) {
    echo "<img src='" . $row['image_url'] . "' alt='Image' width='80' height='80'>";
}
echo "</div>";

mysqli_close($connection);
?>

<html>
<body>

<script>
    function reshuffleImages() {
        fetch('reshuffle.php') // Calls a PHP script to reshuffle
            .then(response => response.text())
            .then(data => console.log("Reshuffled:", data)) // Debugging
            .catch(error => console.error("Error reshuffling:", error));
    }

    // Run reshuffle every 10 seconds
    setInterval(reshuffleImages, 10000);
</script>

</body>
</html>

