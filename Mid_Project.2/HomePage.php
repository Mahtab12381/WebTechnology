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
	
<?php
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
include 'header.php';
?>

</body>
</html>
<?php include 'Footer.php';?>