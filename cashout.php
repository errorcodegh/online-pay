<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");

@$id = $_SESSION['id'];
$sql = "SELECT * FROM platform_table WHERE id = '$id'";
$query = mysqli_query($connection, $sql);
$result = mysqli_fetch_array($query);
$username = $result["username"];

?>

<!DOCTYPE html>
<html>
<head><title>succesfull cashout page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, scalable=no">
<style>
	body{background: cyan;}
	@keyframes anima{
		from{opacity: 1.0;}
		to{opacity: 0.1;}
	}
   #cn{margin: 5em auto; opacity: 0.8; animation: anima 1s infinite;}

   #cls{font-size: 2em; position: absolute; top: 2em; text-align: center;}

</style>
</head>
	<body>

		<center><i class="fa fa-times" id="cls" onclick="cls1()"></i></center>
    <center><h1 id="cn">Thank you <?php echo $username; ?> , payment is few seconds away</h1></center>

    <script>
      function cls1(){
     document.getElementById("#").innerHTML = window.location.href = 'indexplatform.php';
      }
    </script>

	</body>
	</html>

