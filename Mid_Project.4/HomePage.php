<?php
session_start();
$Username=$_SESSION["username"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
$count1=0;
$notification = "No notification available";
$notice="No notice right now";
$Project="No Ongoing project right now";
?>
<!DOCTYPE html>
<html>
<head>
<title>HomePage</title>
</head>
<body>
	
<?php
include 'Header.php';

	$f = fopen("selectedFood.json", 'r');
	$s = fread($f, filesize("selectedFood.json"));
	$data = json_decode($s);
	for ($x = 0; $x < count($data); $x++) {
		if($data[$x]->status=="unseen"){
			$count1++;
		}
	}
	fclose($f);
	$f = fopen("selectedVenue.json", 'r');
	$s = fread($f, filesize("selectedVenue.json"));
	$data = json_decode($s);
	for ($x = 0; $x < count($data); $x++) {
		if($data[$x]->status=="unseen"){
			$count1++;
		}
	}
	fclose($f);

	if($count1!=0){
		$notification = "New Booking request Arrived for venue or food.";
	}
?>
<h3><center>Notification</center></center></h3>
<fieldset>
	
<label><?php echo $notification; ?> </label>

</fieldset>
<h3><center>Notice</center></center></h3>
<fieldset>
	<label><?php echo $notice; ?> </label>
</fieldset>
</fieldset>
<h3><center>Overview</center></center></h3>
<fieldset>
<p>Getting married is a remarkable experience in anyone’s life, regardless of that person’s nationality. It is a day of utmost importance to any couple, and that is why the celebration must be regarded and approached in the same way.

In a wedding event there are many sectors which need to be managed properly like venue, decoration, photography and catering etc. It is very difficult for one to manage everything all alone. So that we are offering all of the sectors together in one platform which will help someone to get the proper wedding plan according to his needs and budget.
</p>
</fieldset>
<h3><center>Ongoing Projects</center></center></h3>
<fieldset>
	<label><?php echo $Project; ?> </label>
</fieldset>
</body>
</html>
<?php include 'Footer.php';?>