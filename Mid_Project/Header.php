<?php
$Username=$_SESSION["username"];
$UserIndex=-1;
$img="";
if(filesize("data.json")>0){
		$f = fopen("data.json", 'r');
		$s = fread($f, filesize("data.json"));
		$data = json_decode($s);
		for ($x = 0; $x < count($data); $x++) {
			if($data[$x]->username===$Username){
				$UserIndex=$x;
				break;
			}
		}
		$img=$data[$UserIndex]->image;
		fclose($f);
}
		echo	"<img src="."img/".$img." height="."80" ."width="."80".">";
		echo " <h1> Welcome " . $Username . "</h1>";

echo '<fieldset>
	<legend>Menu</legend>
	<a href="HomePage.php">Home</a>-
	<a href="ProfileV.php">View Profile</a>-
	<a href="ProfileE.php">Edit Profile</a>-
	<a href="ChangePass.php">Change Password</a>-
	<a href="Logout.php">Logout</a>
	</fieldset>'
?>

