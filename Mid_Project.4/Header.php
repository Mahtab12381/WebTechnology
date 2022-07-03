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
		echo '
			<h1><center>Wedding Management System</center></h1>
		';
		echo	"<img src="."img/".$img." height="."60" ."width="."60".">";
echo " <b> &nbsp  Welcome " . $Username."&nbsp&nbsp</b>";

echo "<fieldset>";
echo"	<legend>Menu</legend>";

echo'<a href="HomePage.php">Home</a>-
	<a href="Addvenue.php">Add Venues</a>-
	<a href="Addfood.php">Add Foods</a>-
	<a href="Newrequest.php">Booking requests</a>-
	<a href="ProfileV.php">View Profile</a>-
	<a href="ProfileE.php">Edit Profile</a>-
	<a href="ChangePass.php">Change Password</a>-
	<a href="Logout.php">Logout</a>
	</fieldset>'
?>

