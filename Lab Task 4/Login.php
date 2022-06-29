<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Log In</title>
</head>
<body>
	<?php
		$passwordErrMsg=$usernameErrMsg="";
		$Password=$Username=$Remember=$Remembered="";
		$loginStatus="";
		$cookie_name = "user";
		$count1=0;
			$errorcount=0;
			if ($_SERVER['REQUEST_METHOD'] === "POST"){
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			$Password = test_input($_POST['password']);
			$Username = test_input($_POST['username']);
			$Remember = isset($_POST['Remember']) ? test_input($_POST['Remember']):NULL;
			if(empty($Password)){
				$passwordErrMsg = "Password is Empty";
				$errorcount++;
			}
			if(empty($Username)){
				$usernameErrMsg = "Username is Empty";
				$errorcount++;
			}	
			}
			if($errorcount==0 and $Username!="" and $Password!=""){
				if(filesize("data.json")>0){
					$f = fopen("data.json", 'r');
					$s = fread($f, filesize("data.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username===$Username and $data[$x]->password===$Password){
							$count1++;
							Header("Location:HomePage.php");
							if($Remember==="Remember me"){
								$cookie_value =$Username;
								setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
								$_SESSION["username"] = $Username;
							}
							break;
						}
						else
							$loginStatus="Login Error";
					}
						
				}				
			}
			
		if(isset($_COOKIE[$cookie_name])) {
		  $Remembered = $_COOKIE[$cookie_name];
		} 			
	?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<fieldset>
		<legend>Log in Info</legend>
		<label for="username">Username</label>
		<input type="text" name="username" id="username">
		<span style="color: red">*
		<?php
			echo $usernameErrMsg;
		?>
		</span>
		<br><br>
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
		<span style="color: red">*
		<?php
			echo $passwordErrMsg;
		?>
		</span>
		<br><br>
		<input type="checkbox" id="Remember" name="Remember" value="Remember me">
		<label for="Remember"> Remember me</label><br>
	</fieldset>
	<br>
	<input type="Submit" value="Log in">
</form>
<br>
<form action="Registration.php">
	<label >Don't Have an account?</label>
	<input type="Submit" value="Click here">
</form>
	<h1><?php
			echo $loginStatus;
?></h1>
<h1><?php
			echo $Remembered;
?></h1>
</form>
</body>
</html>