<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>HomePage</title>
</head>
<body>
<h1>
<?php
echo "Welcome " . $_SESSION["username"] . "<br>";
?>
</h1>
<br><br>
<form action="Login.php">
	<input type="Submit" value="Log Out">
</form>
</body>
</html>