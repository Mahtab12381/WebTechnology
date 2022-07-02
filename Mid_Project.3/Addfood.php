<?php
session_start();
$Username=$_SESSION["username"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
$errorcount=0;
$rice=$salad=$kabab=$curry=$desert=$cost ="";
$riceErrMsg=$saladErrMsg=$kababErrMsg=$curryErrMsg=$desertErrMsg=$costErrMsg="";
$Addstatus="";
$fid=1000;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Food</title>
</head>
<body>
<?php
include 'header.php';
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
			if(filesize("Food.json")<=0){
			$arr = array(array('rice' => $rice, 'salad' => $salad ,'kabab' => $kabab,'curry'=> $curry,'desert'=>$desert,'cost'=> $cost,'fid'=>$fid));
			$f = fopen("Food.json", "a");
			fwrite($f, json_encode($arr));
			fclose($f);
			}
			elseif(filesize("Food.json")>0){
			
			$f = fopen("Food.json", "r");
			$s = fread($f, filesize("Food.json"));
			$data = json_decode($s);
			$fid=$data[count($data)-1]->fid;
			$arr2 = array('rice' => $rice, 'salad' => $salad ,'kabab' => $kabab,'curry'=> $curry,'desert'=>$desert,'cost'=> $cost,'fid'=>$fid+1);
			array_push($data, $arr2);
			fclose($f);
			$f = fopen("Food.json", "w");
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
		<legend>Food Set Menu</legend>
		<label for="rice"><b>Rice Items:</b></label>
		<input type="text" name="rice" id="rice" value="<?php if($Addstatus!="Added Successfully"){echo $rice;}?>">
		<span style="color: red">*
		<?php
			echo $riceErrMsg;
		?>
		</span>
		<br><br>
		<label for="salad"><b>Salad Items:</b></label>
		<input type="text" name="salad" id="salad" value="<?php if($Addstatus!="Added Successfully"){echo $salad;}?>">
		<span style="color: red">*
		<?php
			echo $saladErrMsg;
		?>
		</span>
		<br><br>
		
		<label for="kabab"><b>Kabab Items:</b></label>
		<input type="text" name="kabab" id="kabab" value="<?php if($Addstatus!="Added Successfully"){echo $kabab;}?>">
		<span style="color: red">*
		<?php
			echo $kababErrMsg;
		?>
		</span>
		<br><br>
		<label for="curry"><b>Curry Items:</b></label>
		<input type="text" name="curry" id="curry" value="<?php if($Addstatus!="Added Successfully"){echo $curry;}?>">
		<span style="color: red">*
		<?php
			echo $curryErrMsg;
		?>
		</span>
		<br><br>
		<label for="desert"><b>Desert Items:</b></label>
		<input type="text" name="desert" id="desert" value="<?php if($Addstatus!="Added Successfully"){echo $desert;}?>">
		<span style="color: red">*
		<?php
			echo $desertErrMsg;
		?>
		</span>
		<br><br>
		<label for="cost"><b>Cost:</b></label>
		<input type="number" name="cost" id="cost" value="<?php if($Addstatus!="Added Successfully"){echo $cost;}?>">
		<span style="color: red">*
		<?php
			echo $costErrMsg;
		?>
		</span>
		
</fieldset>
<br>
<input type="submit" name="submit" value="Add">
</form>
<br>
<form action="Viewfood.php">
	<label >View Food menu List?</label>
	<input type="Submit" value="Click here">
</form>
<h1><?php
			echo $Addstatus;
?></h1>
</body>
</html>
<?php
include 'Footer.php';
?>