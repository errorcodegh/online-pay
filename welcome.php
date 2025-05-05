<?php
session_start();

$connection = mysqli_connect("localhost","root","","testtest");
$database = mysqli_select_db($connection,"testtest");

$username = "";

$id = $_SESSION["id"];
$sql = "SELECT * FROM testtable WHERE id = '$id'";
$query = mysqli_query($connection,$sql);
$result = mysqli_fetch_array($query);

?>


<!DOCTYPE HTML>
<HTML>
<head></head>
<body>

<center><h1><?php echo $result["username"]; ?></h1></center>

</body>
</HTML>