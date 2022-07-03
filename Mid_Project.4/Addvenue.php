<?php
session_start();
$Username=$_SESSION["username"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}
$errorcount=0;
$Name=$Location=$Capacity=$Cost=$Status=$Rating ="";
$statusErrMsg=$locationErrMsg=$nameErrMsg=$capacityErrMsg=$costErrMsg=$ratingErrMsg="";
$Addstatus="";
$vid=1000;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Venue</title>
</head>
<body>
<?php
include 'Header.php';
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
			if(filesize("Venue.json")<=0){
			$arr = array(array('name' => $Name, 'location' => $Location ,'capacity' => $Capacity,'rating'=> $Rating,'cost'=>$Cost,'status'=> $Status,'vid'=>$vid));
			$f = fopen("Venue.json", "a");
			fwrite($f, json_encode($arr));
			fclose($f);
			}
			elseif(filesize("Venue.json")>0){
			
			$f = fopen("Venue.json", "r");
			$s = fread($f, filesize("Venue.json"));
			$data = json_decode($s);
			$vid=$data[count($data)-1]->vid;
			$arr2 = array('name' => $Name, 'location' => $Location ,'capacity' => $Capacity,'rating'=> $Rating,'cost'=>$Cost,'status'=> $Status,'vid'=>$vid+1);
			array_push($data, $arr2);
			fclose($f);
			$f = fopen("Venue.json", "w");
			fwrite($f, json_encode($data));
			fclose($f);
			}

			$Addstatus="Added Successfully";
		}
		else	
		$Addstatus="Failed to Add";
	}

?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
<br><br>
	<fieldset>
		<legend>Venue Info</legend>
		<label for="name"><b>Name:</b></label>
		<input type="text" name="name" id="name" value="<?php if($Addstatus!="Added Successfully"){echo $Name;}?>">
		<span style="color: red">*
		<?php
			echo $nameErrMsg;
		?>
		</span>
		<br><br>
		<label for="location"><b>Location:</b></label>
		<input type="text" name="location" id="location" value="<?php if($Addstatus!="Added Successfully"){echo $Location;}?>">
		<span style="color: red">*
		<?php
			echo $locationErrMsg;
		?>
		</span>
		<br><br>
		
		<label for="capacity"><b>Capacity:</b></label>
		<input type="number" name="capacity" id="capacity" value="<?php if($Addstatus!="Added Successfully"){echo $Capacity;}?>">
		<span style="color: red">*
		<?php
			echo $capacityErrMsg;
		?>
		</span>
		<br><br>
		<label for="rating"><b>Rating:</b></label>
		<input type="number" name="rating" id="rating" value="<?php if($Addstatus!="Added Successfully"){echo $Rating;}?>">
		<span style="color: red">*
		<?php
			echo $ratingErrMsg;
		?>
		</span>
		<br><br>
		<label for="cost"><b>Cost:</b></label>
		<input type="number" name="cost" id="cost" value="<?php if($Addstatus!="Added Successfully"){echo $Cost;}?>">
		<span style="color: red">*
		<?php
			echo $costErrMsg;
		?>
		</span>
		<br><br>
		
		<label><b>Status:</b></label>
		<input type="radio" id="available" name="status" value="Available" <?php if($Status=="Available"and $Addstatus!="Added Successfully"){echo "checked";}?> >
		<label for="available">Available</label>
		<input type="radio" id="navailable" name="status" value="Not available" <?php if($Status=="Not available" and $Addstatus!="Added Successfully"){echo "checked";}?> >
		<label for="navailable">Not Available</label>
		<span style="color: red">*
		<?php
			echo $statusErrMsg;
		?>
		</span>
		<br><br>
</fieldset>
<br>
<input type="submit" name="submit" value="Add">
</form>
<br>
<form action="ViewVenue.php">
	<label >View Venue List?</label>
	<input type="Submit" value="Click here">
</form>
<h1><?php
			echo $Addstatus;
?></h1>
</body>
</html><?php
include 'Footer.php';
?>