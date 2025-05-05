
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Reshuffle Images (4x4 Grid)</title>
    <style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 4 columns */
            grid-template-rows: repeat(2, 1fr); /* 4 rows */
            gap: 10px;
            width: 60%;
            height: auto;
            line-height: 5em;
            margin: 1em auto;
            box-shadow: 0px 10px 60px rgba(0,0,0,0.4);
            padding: 3em;
          
        }
        .gallery img {
            width: 90%;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }


    </style>
</head>
<body>




    <div id="imageGallery">
        <?php include 'index1.php'; ?> <!-- Load images from index1.php -->
    </div>

    <script>
        function loadNewImages() {
            fetch('index1.php') // Fetch only index1.php
                .then(response => response.text())
                .then(data => {
                    document.getElementById("imageGallery").innerHTML = data; // Replace only gallery
                })
                .catch(error => console.error("Error loading images:", error));
        }

        // Auto-refresh images every 10 seconds
        setInterval(loadNewImages, 3000);
    </script>

    



</body>
</html>
