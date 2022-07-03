<?php
session_start();
$Username=$_SESSION["username"];
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
$fid="";
$errorcount=0;
$fidErrMsg="";
$count1=0;
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

	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		$fid=test_input($_POST['fid']);
		if(empty($fid)){
			$fidErrMsg="Id is empty";
			$errorcount++;
		}
		else{

			if(filesize("Food.json")>0){
					$f = fopen("Food.json", 'r');
					$s = fread($f, filesize("Food.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->fid==$fid){
							$count1++;
						}
					}
					fclose($f);
					if($count1==0){
						$fidErrMsg=" Wrong Id";
						$errorcount++;
					}
			}
		}

		if($errorcount==0){
				$_SESSION["fid"] = $fid;
				Header("Location:ModifyFood2.php");
		}
	}
?>
<br>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<fieldset>
		<legend>Modify Food menu</legend>
			<label for="fid"><b>Enter ID:</b></label>
		<input type="number" name="fid" id="fid" value="<?php echo $fid; ?>">
		<span style="color: red">*
		<?php
			echo $fidErrMsg;
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