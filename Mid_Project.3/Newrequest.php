<?php
session_start();
$Username=$_SESSION["username"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Food List</title>
</head>
<body>
<?php
include 'Header.php';
?>
</body>
</html>
<?php
include 'Footer.php';
?>