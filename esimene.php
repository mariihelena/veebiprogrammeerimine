<?php
	//muutujad
	$myName = "Marii Helena";
	$myFamilyName = "Keerig";
	
	//hindan päeva osa
	$hourNow = date("H");
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "koolipäev";
	}
	if ($hourNow > 16) {
		$partOfDay = "vaba aeg";
	}
	echo $partOfDay 
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
	<?php
		echo "<p>Algas PHP õppimine.</p>";
		echo "<p>Täna on ";
		echo date("d.m.Y") .", kell oli lehe avamise hetkel " .date ("H:i:s");
		echo ".</p>";
	?>
</body>
</html>