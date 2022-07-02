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
	<title>View Venue List</title>
	<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 8px;
}
</style>
</head>
<body>
<?php
include 'header.php';
include 'Venuetable.php';
?>
<form action="ModifyVenue.php">
	<br><label>Modify venue?</label>
	<input type="submit" value="Click Here">
	</input>
	<br><br>
</form>
</body>
</html><?php
include 'Footer.php';
?>