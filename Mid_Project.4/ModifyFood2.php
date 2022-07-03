<?php
session_start();
$Username=$_SESSION["username"];
$fid=$_SESSION["fid"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
$errorcount=0;
$rice=$salad=$kabab=$curry=$desert=$cost ="";
$riceErrMsg=$saladErrMsg=$kababErrMsg=$curryErrMsg=$desertErrMsg=$costErrMsg="";
$InfoStatus="";
$UserIndex=-1;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Food Menu List</title>
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
include 'Foodtable.php';
if(filesize("Food.json")>0){
		$f = fopen("Food.json", 'r');
		$s = fread($f, filesize("Food.json"));
		$data = json_decode($s);
		for ($x = 0; $x < count($data); $x++) {
			if($data[$x]->fid==$fid){
				$UserIndex=$x;
				break;
			}
		}
		$rice=$data[$UserIndex]->rice;
		$salad=$data[$UserIndex]->salad;
		$kabab=$data[$UserIndex]->kabab;
		$curry=$data[$UserIndex]->curry;
		$desert=$data[$UserIndex]->desert;
		$cost =$data[$UserIndex]->cost;
		fclose($f);
		}

	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		$rice = test_input($_POST['rice']);
		$salad = test_input($_POST['salad']);
		$kabab = test_input($_POST['kabab']);
		$curry = test_input($_POST['curry']);
		$desert = test_input($_POST['desert']);
		$cost = test_input($_POST['cost']);


		if(empty($rice)){
			$riceErrMsg = "Rice Item is Empty";
			$errorcount++;
		}
		if(empty($salad)){
			$saladErrMsg = "Salad item is Empty";
			$errorcount++;
		}
		if(empty($kabab)){
			$kababErrMsg = "Kabab Item is Empty";
			$errorcount++;
		}
		if(empty($curry)){
			$curryErrMsg = "Curry item is Empty";
			$errorcount++;
		}
		if(empty($desert)){
			$desertErrMsg = "Desert Item is Empty";
			$errorcount++;
		}
		if(empty($cost)){
			$costErrMsg = "Cost is Empty";
			$errorcount++;
		}

		if($errorcount==0){
			if(filesize("Food.json")>0){
				$f = fopen("Food.json", 'r');
				$s = fread($f, filesize("Food.json"));
				$data = json_decode($s);
				$data[$UserIndex]->rice=$rice;
				$data[$UserIndex]->salad=$salad;
				$data[$UserIndex]->kabab=$kabab;
				$data[$UserIndex]->curry=$curry;
				$data[$UserIndex]->desert=$desert;
				$data[$UserIndex]->cost=$cost ;
				fclose($f);
				$f = fopen("Food.json", "w");
				fwrite($f, json_encode($data));
				fclose($f);
			}
			$InfoStatus="Changes saved successfully";
		}

	}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
<br><br>
	<fieldset>
		<legend>Food Set Menu</legend>
		<label for="rice"><b>Rice Items:</b></label>
		<input type="text" name="rice" id="rice" value="<?php if($InfoStatus!="Added Successfully"){echo $rice;}?>">
		<span style="color: red">*
		<?php
			echo $riceErrMsg;
		?>
		</span>
		<br><br>
		<label for="salad"><b>Salad Items:</b></label>
		<input type="text" name="salad" id="salad" value="<?php if($InfoStatus!="Added Successfully"){echo $salad;}?>">
		<span style="color: red">*
		<?php
			echo $saladErrMsg;
		?>
		</span>
		<br><br>
		
		<label for="kabab"><b>Kabab Items:</b></label>
		<input type="text" name="kabab" id="kabab" value="<?php if($InfoStatus!="Added Successfully"){echo $kabab;}?>">
		<span style="color: red">*
		<?php
			echo $kababErrMsg;
		?>
		</span>
		<br><br>
		<label for="curry"><b>Curry Items:</b></label>
		<input type="text" name="curry" id="curry" value="<?php if($InfoStatus!="Added Successfully"){echo $curry;}?>">
		<span style="color: red">*
		<?php
			echo $curryErrMsg;
		?>
		</span>
		<br><br>
		<label for="desert"><b>Desert Items:</b></label>
		<input type="text" name="desert" id="desert" value="<?php if($InfoStatus!="Added Successfully"){echo $desert;}?>">
		<span style="color: red">*
		<?php
			echo $desertErrMsg;
		?>
		</span>
		<br><br>
		<label for="cost"><b>Cost:</b></label>
		<input type="number" name="cost" id="cost" value="<?php if($InfoStatus!="Added Successfully"){echo $cost;}?>">
		<span style="color: red">*
		<?php
			echo $costErrMsg;
		?>
		</span>
		<br><br>
</fieldset>
<br>
<input type="submit" name="submit" value="Save changes">
</form>
<br>
<form action="ModifyFood2.php"><input type="submit" name="submit" value="Refresh"></form>
<br>
<form action="ModifyFood.php">
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