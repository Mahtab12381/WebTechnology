<?php
session_start();
$Username=$_SESSION["username"];
?>
<!DOCTYPE html>
<html>
<head>
<title>HomePage</title>
</head>
<body>
	<h1>
<?php
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
include 'header.php';
?>
</h1>
</body>
</html>