<?php
session_start();
$Username=$_SESSION["username"];
$vid=$_SESSION["vid"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
$errorcount=0;
$Name=$Location=$Capacity=$Cost=$Status=$Rating ="";
$statusErrMsg=$locationErrMsg=$nameErrMsg=$capacityErrMsg=$costErrMsg=$ratingErrMsg="";
$InfoStatus="";
$UserIndex=-1;
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
if(filesize("Venue.json")>0){
		$f = fopen("Venue.json", 'r');
		$s = fread($f, filesize("Venue.json"));
		$data = json_decode($s);
		for ($x = 0; $x < count($data); $x++) {
			if($data[$x]->vid==$vid){
				$UserIndex=$x;
				break;
			}
		}
		$Name=$data[$UserIndex]->name;
		$Location=$data[$UserIndex]->location;
		$Capacity=$data[$UserIndex]->capacity;
		$Cost=$data[$UserIndex]->cost;
		$Status=$data[$UserIndex]->status;
		$Rating =$data[$UserIndex]->rating;
		fclose($f);
		}

	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
$Name = test_input($_POST['name']);
		$Location = test_input($_POST['location']);
		$Status = isset($_POST['status']) ? test_input($_POST['status']):NULL;
		$Capacity = test_input($_POST['capacity']);
		$Cost = test_input($_POST['cost']);
		$Rating = test_input($_POST['rating']);


		if(empty($Name)){
			$nameErrMsg = "Name is Empty";
			$errorcount++;
		}
		
		if(empty($Location)){
			$locationErrMsg = "Location is Empty";
			$errorcount++;
		}
		
		if(empty($Status)){
			$statusErrMsg = "Status is Empty";
			$errorcount++;
		}
		if(empty($Capacity)){
			$capacityErrMsg = "Capacity is Empty";
			$errorcount++;
		}
		if(empty($Rating)){
			$ratingErrMsg = "Rating is Empty";
			$errorcount++;
		}
		if(empty($Cost)){
			$costErrMsg = "Cost is Empty";
			$errorcount++;
		}

		if($errorcount==0){
			if(filesize("Venue.json")>0){
				$f = fopen("Venue.json", 'r');
				$s = fread($f, filesize("Venue.json"));
				$data = json_decode($s);
				$data[$UserIndex]->name=$Name;
				$data[$UserIndex]->location=$Location;
				$data[$UserIndex]->capacity=$Capacity;
				$data[$UserIndex]->cost=$Cost;
				$data[$UserIndex]->status=$Status;
				$data[$UserIndex]->rating=$Rating ;
				fclose($f);
				$f = fopen("Venue.json", "w");
				fwrite($f, json_encode($data));
				fclose($f);
			}
			$InfoStatus="Changes saved successfully";
		}

	}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
<br>
	<fieldset>
		<legend>Modify Venue</legend>
		<label ><b>ID:</b><?php echo "$vid" ?></label>
		<br><br>
		<label for="name"><b>Name:</b></label>
		<input type="text" name="name" id="name" value="<?php if($InfoStatus!="Added Successfully"){echo $Name;}?>">
		<span style="color: red">*
		<?php
			echo $nameErrMsg;
		?>
		</span>
		<br><br>
		<label for="location"><b>Location:</b></label>
		<input type="text" name="location" id="location" value="<?php if($InfoStatus!="Added Successfully"){echo $Location;}?>">
		<span style="color: red">*
		<?php
			echo $locationErrMsg;
		?>
		</span>
		<br><br>
		
		<label for="capacity"><b>Capacity:</b></label>
		<input type="number" name="capacity" id="capacity" value="<?php if($InfoStatus!="Added Successfully"){echo $Capacity;}?>">
		<span style="color: red">*
		<?php
			echo $capacityErrMsg;
		?>
		</span>
		<br><br>
		<label for="rating"><b>Rating:</b></label>
		<input type="number" name="rating" id="rating" value="<?php if($InfoStatus!="Added Successfully"){echo $Rating;}?>">
		<span style="color: red">*
		<?php
			echo $ratingErrMsg;
		?>
		</span>
		<br><br>
		<label for="cost"><b>Cost:</b></label>
		<input type="number" name="cost" id="cost" value="<?php if($InfoStatus!="Added Successfully"){echo $Cost;}?>">
		<span style="color: red">*
		<?php
			echo $costErrMsg;
		?>
		</span>
		<br><br>
		
		<label><b>Status:</b></label>
		<input type="radio" id="available" name="status" value="Available" <?php if($Status=="Available"and $InfoStatus!="Added Successfully"){echo "checked";}?> >
		<label for="available">Available</label>
		<input type="radio" id="navailable" name="status" value="Not available" <?php if($Status=="Not available" and $InfoStatus!="Added Successfully"){echo "checked";}?> >
		<label for="navailable">Not Available</label>
		<span style="color: red">*
		<?php
			echo $statusErrMsg;
		?>
		</span>
		<br><br>
</fieldset>
<br>
<input type="submit" name="submit" value="Save changes">
</form>
<br>
<form action="ModifyVenue2.php"><input type="submit" name="submit" value="Refresh"></form>
<br>
<form action="ModifyVenue.php">
	<label >Modify Another?</label>
	<input type="Submit" value="Click here">
</form>
<h1><?php
			echo $InfoStatus;
?></h1>
</body>
</html>
<?php
include 'Footer.php';
?>