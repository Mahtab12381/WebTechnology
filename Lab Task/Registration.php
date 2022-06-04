<?php 
	
	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		$First_Name = $_POST['firstname'];
		$Last_Name = $_POST['lastname'];
		$Email = $_POST['email'];
		$Mobile_no = $_POST['mobile_no'];
		$SHR = $_POST['address'];
		$Country = $_POST['country'];
		if (empty($First_Name) or empty($Last_Name) or empty($Email) or empty($Mobile_no)or empty($SHR)or empty($Country)){
			echo "please fill up the form properly";
		}
		else
			echo "Registration Successfull";
	}
	else
		echo "Request Regected";
?>