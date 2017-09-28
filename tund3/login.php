<?php
	//muutujad
	$myName = "Marii Helena";
	$myFamilyName = "Keerig";
	
	//sisselogimine
	$myUsername="";
	if (isset($_POST["loginEmail"])){
		$myUsername=$_POST["loginEmail"];
	}
	
	//registreerumine
	$myFirstName="";
	if (isset($_POST["signupFirstName"])){
		$myFirstName=$_POST["signupFirstName"];
	}	
	$myFamilyName2="";
	if (isset($_POST["signupFamilyName"])){
		$myFamilyName2=$_POST["signupFamilyName"];
	}
	$maleChecked="";
	if (isset($_POST["gender"])){
		$maleChecked=$_POST["gender"];
	}
	$femaleChecked="";	
	if (isset($_POST["gender"])){
		$femaleChecked=$_POST["gender"];
	}
	$myEmail="";
	if (isset($_POST["signupEmail"])){
		$myEmail=$_POST["signupEmail"];
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Marii Helena Keerig </title>
</head>
<body>
	<h1><?php echo $myName ." " .$myFamilyName; ?>, veebiprogrammeerimine</h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	
	<h2>Sisse logimine</h2>
	<form method="POST">
		<label>Kasutajanimi: </label>
		<input name="loginEmail" type="email" value="<?php echo $myUsername; ?>">
		<label>Parool: </label>
		<input name="loginPassword" type="password" value="">
		<input name="submitUser" type="submit" value="Sisene">
	</form>
	
	<h3>Registreerimine</h3>
	<form method="POST">
		<label>Eesnimi: </label>
		<input name="signupFirstName" type="text" value="<?php echo $myFirstName; ?>" >
		<label>Perekonnanimi: </label>
		<input name="signupFamilyName" type="text" value="<?php echo $myFamilyName2; ?>">
		<label>Sugu: </label>
		<label>Mees </label>
		<input name="gender" type="radio" value="1" <?php echo $maleChecked; ?>>
		<label>Naine </label>
		<input name="gender" type="radio" value="2" <?php echo $femaleChecked; ?>>
		<label>Email: </label>
		<input name="signupEmail" type="email" value="<?php echo $myEmail; ?>"> 
		<label>Parool: </label>
		<input name="signupPassword" type="password" value="">
		<input name="submitNewUser" type="submit" value="Registreeru">
	</form>
	
	
</body>
</html>