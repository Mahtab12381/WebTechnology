<?php
session_start();
$Username=$_SESSION["username"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
$vid="";
$errorcount=0;
$vidErrMsg="";
$count1=0;
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

	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		$vid=test_input($_POST['vid']);
		if(empty($vid)){
			$vidErrMsg="Id is empty";
			$errorcount++;
		}
		else{

			if(filesize("Venue.json")>0){
					$f = fopen("Venue.json", 'r');
					$s = fread($f, filesize("Venue.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->vid==$vid){
							$count1++;
						}
					}
					fclose($f);
					if($count1==0){
						$vidErrMsg=" Wrong Id";
						$errorcount++;
					}
			}
		}

		if($errorcount==0){
				$_SESSION["vid"] = $vid;
				Header("Location:ModifyVenue2.php");
		}
	}
?>
<br>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<fieldset>
		<legend>Modify venue</legend>
			<label for="vid"><b>Enter ID:</b></label>
		<input type="number" name="vid" id="vid" value="<?php echo $vid; ?>">
		<span style="color: red">*
		<?php
			echo $vidErrMsg;
		?>
		</span>
		<br><br>
			<input type="submit" value="submit">
	</fieldset>
</form>
</body>
</html>
<?php
include 'Footer.php';
?>