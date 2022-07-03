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
include 'Header.php';
if(filesize("selectedVenue.json")<=0){
		echo"No new request";
	}
	else{
	$f = fopen("selectedVenue.json", 'r');
	$s = fread($f, filesize("selectedVenue.json"));
	$data = json_decode($s);
	echo "<br>";
	echo "<fieldset>";
	echo "<legend>Selected Venue List</legend>";
	echo "<table>";
	echo "<tr>";
	echo "<th>Username</th>";
	echo "<th>Venue ID</th>";
	echo "<th>Date</th>";
	echo "</tr>";
	for ($x = 0; $x < count($data); $x++) {

		if($data[$x]->status=="unseen"){
			echo "<tr>";
		  	echo "<td>" . $data[$x]->username . "</td>";
			echo "<td>" . $data[$x]->venue . "</td>";
			echo "<td>" . $data[$x]->date . "</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	echo "</fieldset>";
	fclose($f);

$f = fopen("selectedFood.json", 'r');
	$s = fread($f, filesize("selectedFood.json"));
	$data = json_decode($s);
	echo "<br>";
	echo "<fieldset>";
	echo "<legend>Selected Food List</legend>";
	echo "<table>";
	echo "<tr>";
	echo "<th>Username</th>";
	echo "<th>Food ID</th>";
	echo "<th>Date</th>";
	echo "<th>Number of guest</th>";
	echo "</tr>";
	for ($x = 0; $x < count($data); $x++) {

		if($data[$x]->status=="unseen"){
			echo "<tr>";
		  	echo "<td>" . $data[$x]->username . "</td>";
			echo "<td>" . $data[$x]->food . "</td>";
			echo "<td>" . $data[$x]->date . "</td>";
			echo "<td>" . $data[$x]->guest . "</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	echo "</fieldset>";
	fclose($f);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$f = fopen("selectedFood.json", 'r');
	$s = fread($f, filesize("selectedFood.json"));
	$data = json_decode($s);
	for ($x = 0; $x < count($data); $x++) {
		$data[$x]->status="seen";
	}
		$f = fopen("selectedFood.json", "w");
				fwrite($f, json_encode($data));
				fclose($f);

				$f = fopen("selectedVenue.json", 'r');
	$s = fread($f, filesize("selectedVenue.json"));
	$data = json_decode($s);
	for ($x = 0; $x < count($data); $x++) {
		$data[$x]->status="seen";
	}
		$f = fopen("selectedVenue.json", "w");
				fwrite($f, json_encode($data));
				fclose($f);

				header("Location:Newrequest.php");
	
}
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<br>
<input type="submit" value="Mark as Done">
</form>



</body>
</html>
<?php
include 'Footer.php';
?>