<?php
session_start();
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}
$Username=$_SESSION["username"];
$UserIndex=-1;
$errorcount=0;
$First_Name =$Last_Name =$Email =$Mobile_no =$SHR =$Gender =$Country=$DOB=$NID=$Nationality=$Blood=$BIO="";
$img="";
$firstnameErrMsg =$lastnameErrMsg = $genderErrMsg = $emailErrMsg = $mobileErrMsg = $address1ErrMsg = $countryErrMsg ="";
$InfoStatus="";
$uppercase=$lowercase=$number=$specialChars="";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Profile</title>
</head>
<body>
<?php
include 'header.php';
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
		$First_Name=$data[$UserIndex]->firstname;
		$Last_Name=$data[$UserIndex]->lastname;
		$Gender=$data[$UserIndex]->gender;
		$Email=$data[$UserIndex]->email;
		$Mobile_no=$data[$UserIndex]->mobile_no;
		$SHR=$data[$UserIndex]->address;
		$Country=$data[$UserIndex]->country;
		$img=$data[$UserIndex]->image;
		$DOB=$data[$UserIndex]->dob;
		$NID=$data[$UserIndex]->nid;
		$Nationality=$data[$UserIndex]->nationality;
		$BIO=$data[$UserIndex]->bio;
		$Blood=$data[$UserIndex]->blood;


		fclose($f);
		}

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$First_Name = test_input($_POST['firstname']);
		$Last_Name = test_input($_POST['lastname']);
		$Email = test_input($_POST['email']);
		$Mobile_no = test_input($_POST['mobile_no']);
		$SHR = test_input($_POST['address']);
		$Gender = isset($_POST['gender']) ? test_input($_POST['gender']):NULL;
		$Country = isset($_POST['country']) ? test_input($_POST['country']):NULL;
		$DOB=isset($_POST['dob']) ? test_input($_POST['dob']):NULL;
		$NID=test_input($_POST['nid']);
		$Nationality=test_input($_POST['nationality']);
		$Blood=isset($_POST['blood']) ? test_input($_POST['blood']):NULL;
		$BIO=test_input($_POST['bio']);
		$img=test_input($_POST['imgurl']);
		if($img==""){
			$img="DefaultUser.png";
		}
		

		if(empty($First_Name)){
			$firstnameErrMsg = "First Name is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$First_Name)) {
				$errorcount++;
				$firstnameErrMsg = "Only letters and spaces";
			}}
		if(empty($Last_Name)){
			$lastnameErrMsg = "Last Name is Empty";
			$errorcount++;
		}
		else {
			if (!preg_match("/^[a-zA-Z-' ]*$/",$Last_Name)) {
				$errorcount++;
				$lastnameErrMsg = "Only letters and spaces";
			}
		}
		if(empty($Gender)){
			$genderErrMsg = "Gender is Empty";
			$errorcount++;
		}

		if(empty($Country)){
			$countryErrMsg = "Country is Empty";
			$errorcount++;
		}
		if(empty($Mobile_no)){
			$mobileErrMsg = "Mobile  is Empty";
			$errorcount++;
		}
		if(empty($Email)){
			$emailErrMsg = "Email  is Empty";
			$errorcount++;
		}
		else {
			if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
				$emailErrMsg .= "Please correct your email";
				$errorcount++;
			}
		}
		if(empty($SHR)){
			$address1ErrMsg = "Address is Empty";
			$errorcount++;
		}

		if($errorcount==0){
			if(filesize("data.json")>0){
				$f = fopen("data.json", 'r');
				$s = fread($f, filesize("data.json"));
				$data = json_decode($s);
				$data[$UserIndex]->firstname=$First_Name;
				$data[$UserIndex]->lastname=$Last_Name;
				$data[$UserIndex]->gender=$Gender;
				$data[$UserIndex]->email=$Email;
				$data[$UserIndex]->mobile_no=$Mobile_no;
				$data[$UserIndex]->address=$SHR;
				$data[$UserIndex]->country=$Country;
				$data[$UserIndex]->image=$img;
				$data[$UserIndex]->dob=$DOB;
				$data[$UserIndex]->nid=$NID;
				$data[$UserIndex]->nationality=$Nationality;
				$data[$UserIndex]->bio=$BIO;
				$data[$UserIndex]->blood=$Blood;
				fclose($f);
				$f = fopen("Data.json", "w");
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
	<legend>Profile Photo</legend>
	<img src="img\<?php echo $img ?>" height = "100" width="100" alt="Profile Picture">
	<label><b>Enter Url:</b></label>
	<input type="text" id="impurl" name="imgurl" value="<?php echo $img;?>">
</fieldset>
<br><br>
<fieldset>
	<legend>Bio</legend>
	<label for="bio"> Write something about you</label>
	<input type="text" id="bio" name="bio" value="<?php echo $BIO;?>">
</fieldset>
<br><br>
<fieldset>

	<legend>Profile Info</legend>
	<fieldset>
		<legend>General Info</legend>
		<label for="fname"><b>First Name:</b></label>
		<input type="text" name="firstname" id="fname" value="<?php echo $First_Name;?>">
		<span style="color: red">*
		<?php
			echo $firstnameErrMsg;
		?>
		</span>
		<br><br>
		<label for="lname"><b>Last Name:</b></label>
		<input type="text" name="lastname" id="lname" value="<?php echo $Last_Name;?>">
		<span style="color: red">*
		<?php
			echo $lastnameErrMsg;
		?>
		</span>
		<br><br>
		<label><b>Gender:</b></label>
		<input type="radio" id="male" name="gender" value="Male" <?php if($Gender=="Male"){echo "checked";}?> >
		<label for="male">Male</label>
		<input type="radio" id="female" name="gender" value="Female" <?php if($Gender=="Female"){echo "checked";}?> >
		<label for="female">Female</label>
		<span style="color: red">*
		<?php
			echo $genderErrMsg;
		?>
		</span>
		<br><br>
		<label for="dob"><b>Date of birth:</b></label>
		<input type="date" id="dob" name="dob"value="<?php echo $DOB;?>">
		<br><br>
		<label for ="nid"><b>NID number:</b></label>
		<input type="number" id="nid" name="nid" value="<?php echo $NID;?>">
		<br><br>
		<label for="nationality"><b>Nationality:</b></label>
		<input type="text" id="nationality" name="nationality" value="<?php echo $Nationality;?>">
		<br><br>
		<label for=blood><b>Blood group:</b></label>
		<select id="blood" name="blood">
			<option>A Positive</option>
		    <option>A Negative</option>
		    <option>A Unknown</option>
		    <option>B Positive</option>
		    <option>B Negative</option>
		    <option>B Unknown</option>
		    <option>AB Positive</option>
		    <option>AB Negative</option>
		    <option>AB Unknown</option>
		    <option>O Positive</option>
		    <option>O Negative</option>
		    <option>O Unknown</option>
		    <option>Unknown</option>
		    <option value="<?php echo $Blood;?>"selected><?php echo $Blood;?></option>
		</select>
	</fieldset>
<br>
	<fieldset>
		<legend>Contact Info</legend>
		<label for="email"><b>Email</b></label>
		<input type="text" name="email" id="email"value="<?php echo $Email;?>">
		<span style="color: red">*
		<?php
			echo $emailErrMsg;
		?>
		</span>
		<br><br>
		<label for="mno"><b>Mobile No</b></label>
		<input type="number" name="mobile_no" id="mno"value="<?php echo $Mobile_no;?>">
		<span style="color: red">*
		<?php
			echo $mobileErrMsg;
		?>
		</span>
	</fieldset>
<br>
	<fieldset>
		<legend>Address</legend>
		<label for="address"><b>Street/House/Road</b></label>
		<input type="text" name="address" id="address"value="<?php echo $SHR;?>">
		<span style="color: red">*
		<?php
			echo $address1ErrMsg;
		?>
		</span>
		<br><br>
		<label for="country"><b>Country</b></label>
		<select id="country" name="country">
			<option value="Afghanistan">Afghanistan</option>
			<option value="Albania">Albania</option>
			<option value="Algeria">Algeria</option>
			<option value="American Samoa">American Samoa</option>
			<option value="Andorra">Andorra</option>
			<option value="Angola">Angola</option>
			<option value="Anguilla">Anguilla</option>
			<option value="Antartica">Antarctica</option>
			<option value="Antigua and Barbuda">Antigua and Barbuda</option>
			<option value="Argentina">Argentina</option>
			<option value="Armenia">Armenia</option>
			<option value="Aruba">Aruba</option>
			<option value="Australia">Australia</option>
			<option value="Austria">Austria</option>
			<option value="Azerbaijan">Azerbaijan</option>
			<option value="Bahamas">Bahamas</option>
			<option value="Bahrain">Bahrain</option>
			<option value="Bangladesh">Bangladesh</option>
			<option value="Barbados">Barbados</option>
			<option value="Belarus">Belarus</option>
			<option value="Belgium">Belgium</option>
			<option value="Belize">Belize</option>
			<option value="Benin">Benin</option>
			<option value="Bermuda">Bermuda</option>
			<option value="Bhutan">Bhutan</option>
			<option value="Bolivia">Bolivia</option>
			<option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
			<option value="Botswana">Botswana</option>
			<option value="Bouvet Island">Bouvet Island</option>
			<option value="Brazil">Brazil</option>
			<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
			<option value="Brunei Darussalam">Brunei Darussalam</option>
			<option value="Bulgaria">Bulgaria</option>
			<option value="Burkina Faso">Burkina Faso</option>
			<option value="Burundi">Burundi</option>
			<option value="Cambodia">Cambodia</option>
			<option value="Cameroon">Cameroon</option>
			<option value="Canada">Canada</option>
			<option value="Cape Verde">Cape Verde</option>
			<option value="Cayman Islands">Cayman Islands</option>
			<option value="Central African Republic">Central African Republic</option>
			<option value="Chad">Chad</option>
			<option value="Chile">Chile</option>
			<option value="China">China</option>
			<option value="Christmas Island">Christmas Island</option>
			<option value="Cocos Islands">Cocos (Keeling) Islands</option>
			<option value="Colombia">Colombia</option>
			<option value="Comoros">Comoros</option>
			<option value="Congo">Congo</option>
			<option value="Congo">Congo, the Democratic Republic of the</option>
			<option value="Cook Islands">Cook Islands</option>
			<option value="Costa Rica">Costa Rica</option>
			<option value="Cota D'Ivoire">Cote d'Ivoire</option>
			<option value="Croatia">Croatia (Hrvatska)</option>
			<option value="Cuba">Cuba</option>
			<option value="Cyprus">Cyprus</option>
			<option value="Czech Republic">Czech Republic</option>
			<option value="Denmark">Denmark</option>
			<option value="Djibouti">Djibouti</option>
			<option value="Dominica">Dominica</option>
			<option value="Dominican Republic">Dominican Republic</option>
			<option value="East Timor">East Timor</option>
			<option value="Ecuador">Ecuador</option>
			<option value="Egypt">Egypt</option>
			<option value="El Salvador">El Salvador</option>
			<option value="Equatorial Guinea">Equatorial Guinea</option>
			<option value="Eritrea">Eritrea</option>
			<option value="Estonia">Estonia</option>
			<option value="Ethiopia">Ethiopia</option>
			<option value="Falkland Islands">Falkland Islands (Malvinas)</option>
			<option value="Faroe Islands">Faroe Islands</option>
			<option value="Fiji">Fiji</option>
			<option value="Finland">Finland</option>
			<option value="France">France</option>
			<option value="France Metropolitan">France, Metropolitan</option>
			<option value="French Guiana">French Guiana</option>
			<option value="French Polynesia">French Polynesia</option>
			<option value="French Southern Territories">French Southern Territories</option>
			<option value="Gabon">Gabon</option>
			<option value="Gambia">Gambia</option>
			<option value="Georgia">Georgia</option>
			<option value="Germany">Germany</option>
			<option value="Ghana">Ghana</option>
			<option value="Gibraltar">Gibraltar</option>
			<option value="Greece">Greece</option>
			<option value="Greenland">Greenland</option>
			<option value="Grenada">Grenada</option>
			<option value="Guadeloupe">Guadeloupe</option>
			<option value="Guam">Guam</option>
			<option value="Guatemala">Guatemala</option>
			<option value="Guinea">Guinea</option>
			<option value="Guinea-Bissau">Guinea-Bissau</option>
			<option value="Guyana">Guyana</option>
			<option value="Haiti">Haiti</option>
			<option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
			<option value="Holy See">Holy See (Vatican City State)</option>
			<option value="Honduras">Honduras</option>
			<option value="Hong Kong">Hong Kong</option>
			<option value="Hungary">Hungary</option>
			<option value="Iceland">Iceland</option>
			<option value="India">India</option>
			<option value="Indonesia">Indonesia</option>
			<option value="Iran">Iran (Islamic Republic of)</option>
			<option value="Iraq">Iraq</option>
			<option value="Ireland">Ireland</option>
			<option value="Israel">Israel</option>
			<option value="Italy">Italy</option>
			<option value="Jamaica">Jamaica</option>
			<option value="Japan">Japan</option>
			<option value="Jordan">Jordan</option>
			<option value="Kazakhstan">Kazakhstan</option>
			<option value="Kenya">Kenya</option>
			<option value="Kiribati">Kiribati</option>
			<option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
			<option value="Korea">Korea, Republic of</option>
			<option value="Kuwait">Kuwait</option>
			<option value="Kyrgyzstan">Kyrgyzstan</option>
			<option value="Lao">Lao People's Democratic Republic</option>
			<option value="Latvia">Latvia</option>
			<option value="Lebanon" selected>Lebanon</option>
			<option value="Lesotho">Lesotho</option>
			<option value="Liberia">Liberia</option>
			<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
			<option value="Liechtenstein">Liechtenstein</option>
			<option value="Lithuania">Lithuania</option>
			<option value="Luxembourg">Luxembourg</option>
			<option value="Macau">Macau</option>
			<option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
			<option value="Madagascar">Madagascar</option>
			<option value="Malawi">Malawi</option>
			<option value="Malaysia">Malaysia</option>
			<option value="Maldives">Maldives</option>
			<option value="Mali">Mali</option>
			<option value="Malta">Malta</option>
			<option value="Marshall Islands">Marshall Islands</option>
			<option value="Martinique">Martinique</option>
			<option value="Mauritania">Mauritania</option>
			<option value="Mauritius">Mauritius</option>
			<option value="Mayotte">Mayotte</option>
			<option value="Mexico">Mexico</option>
			<option value="Micronesia">Micronesia, Federated States of</option>
			<option value="Moldova">Moldova, Republic of</option>
			<option value="Monaco">Monaco</option>
			<option value="Mongolia">Mongolia</option>
			<option value="Montserrat">Montserrat</option>
			<option value="Morocco">Morocco</option>
			<option value="Mozambique">Mozambique</option>
			<option value="Myanmar">Myanmar</option>
			<option value="Namibia">Namibia</option>
			<option value="Nauru">Nauru</option>
			<option value="Nepal">Nepal</option>
			<option value="Netherlands">Netherlands</option>
			<option value="Netherlands Antilles">Netherlands Antilles</option>
			<option value="New Caledonia">New Caledonia</option>
			<option value="New Zealand">New Zealand</option>
			<option value="Nicaragua">Nicaragua</option>
			<option value="Niger">Niger</option>
			<option value="Nigeria">Nigeria</option>
			<option value="Niue">Niue</option>
			<option value="Norfolk Island">Norfolk Island</option>
			<option value="Northern Mariana Islands">Northern Mariana Islands</option>
			<option value="Norway">Norway</option>
			<option value="Oman">Oman</option>
			<option value="Pakistan">Pakistan</option>
			<option value="Palau">Palau</option>
			<option value="Panama">Panama</option>
			<option value="Papua New Guinea">Papua New Guinea</option>
			<option value="Paraguay">Paraguay</option>
			<option value="Peru">Peru</option>
			<option value="Philippines">Philippines</option>
			<option value="Pitcairn">Pitcairn</option>
			<option value="Poland">Poland</option>
			<option value="Portugal">Portugal</option>
			<option value="Puerto Rico">Puerto Rico</option>
			<option value="Qatar">Qatar</option>
			<option value="Reunion">Reunion</option>
			<option value="Romania">Romania</option>
			<option value="Russia">Russian Federation</option>
			<option value="Rwanda">Rwanda</option>
			<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
			<option value="Saint LUCIA">Saint LUCIA</option>
			<option value="Saint Vincent">Saint Vincent and the Grenadines</option>
			<option value="Samoa">Samoa</option>
			<option value="San Marino">San Marino</option>
			<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
			<option value="Saudi Arabia">Saudi Arabia</option>
			<option value="Senegal">Senegal</option>
			<option value="Seychelles">Seychelles</option>
			<option value="Sierra">Sierra Leone</option>
			<option value="Singapore">Singapore</option>
			<option value="Slovakia">Slovakia (Slovak Republic)</option>
			<option value="Slovenia">Slovenia</option>
			<option value="Solomon Islands">Solomon Islands</option>
			<option value="Somalia">Somalia</option>
			<option value="South Africa">South Africa</option>
			<option value="South Georgia">South Georgia and the South Sandwich Islands</option>
			<option value="Span">Spain</option>
			<option value="SriLanka">Sri Lanka</option>
			<option value="St. Helena">St. Helena</option>
			<option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
			<option value="Sudan">Sudan</option>
			<option value="Suriname">Suriname</option>
			<option value="Svalbard">Svalbard and Jan Mayen Islands</option>
			<option value="Swaziland">Swaziland</option>
			<option value="Sweden">Sweden</option>
			<option value="Switzerland">Switzerland</option>
			<option value="Syria">Syrian Arab Republic</option>
			<option value="Taiwan">Taiwan, Province of China</option>
			<option value="Tajikistan">Tajikistan</option>
			<option value="Tanzania">Tanzania, United Republic of</option>
			<option value="Thailand">Thailand</option>
			<option value="Togo">Togo</option>
			<option value="Tokelau">Tokelau</option>
			<option value="Tonga">Tonga</option>
			<option value="Trinidad and Tobago">Trinidad and Tobago</option>
			<option value="Tunisia">Tunisia</option>
			<option value="Turkey">Turkey</option>
			<option value="Turkmenistan">Turkmenistan</option>
			<option value="Turks and Caicos">Turks and Caicos Islands</option>
			<option value="Tuvalu">Tuvalu</option>
			<option value="Uganda">Uganda</option>
			<option value="Ukraine">Ukraine</option>
			<option value="United Arab Emirates">United Arab Emirates</option>
			<option value="United Kingdom">United Kingdom</option>
			<option value="United States">United States</option>
			<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
			<option value="Uruguay">Uruguay</option>
			<option value="Uzbekistan">Uzbekistan</option>
			<option value="Vanuatu">Vanuatu</option>
			<option value="Venezuela">Venezuela</option>
			<option value="Vietnam">Viet Nam</option>
			<option value="Virgin Islands (British)">Virgin Islands (British)</option>
			<option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
			<option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
			<option value="Western Sahara">Western Sahara</option>
			<option value="Yemen">Yemen</option>
			<option value="Serbia">Serbia</option>
			<option value="Zambia">Zambia</option>
			<option value="Zimbabwe">Zimbabwe</option>
			<option value="<?php echo $Country;?>"selected><?php echo $Country;?></option>

		</select>
		<span style="color: red">*
		<?php
			echo $countryErrMsg;
		?>
		</span>
	</fieldset>
</fieldset>
<br>
<input type="submit" name="submit" value="save change">
</form>
<h1><?php
			echo $InfoStatus;
?></h1>
</body>
</html>
<?php include 'Footer.php';?>