<?php

$connection = mysqli_connect("localhost","root","","platform");
$database = mysqli_select_db($connection,"platform");

$username = $email = $msg = $errormsg = "";

if(isset($_POST["submit"])){

if(empty($_POST["uname"]) || empty($_POST["umail"]) || empty($_POST["msg"])){
	echo "<script>alert('empty fields');</script>";
}

$username = $_POST["uname"];
$email = $_POST["umail"];
$msg = $_POST["msg"];

$sql = "INSERT INTO contact_table (name,email,message) VALUES ('$username','$email','$msg')";
$query = mysqli_query($connection,$sql);

if($query){
	echo "<script>alert('data sent successfully');</script>";
	header("location: indexplatform.php");
}
 else{
 	echo "<script>alert('data not sent');</script>";
 }

}



?>