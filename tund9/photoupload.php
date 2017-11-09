<?php
	require("functions.php");
	$notice = "";
	
	//kas sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	//fotode laadimine
	$target_dir = "../../pics/";
	$target_file = "";
	$uploadOk = 1;
	$maxWidth = 600;
	$maxHeight = 400;
	$marginHor = 10;
	$marginVer = 10;
	
	// Kas vajutati submit nuppu
	if(isset($_POST["submit"])) {
		
		// Kas fail on valitud
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			//fikseerin faili nime
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$target_file = $target_dir .pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .(microtime(1) * 10000) ."." .$imageFileType;
			// Kontrollin, kas on ikka pilt
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice.="Fail on pilt - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$notice.="Fail ei ole pilt.";
				$uploadOk = 0;
			}
	
	
			// Kontrollin, kas fail juba eksisteerib
			if (file_exists($target_file)) {
				$notice.="Vabandame, fail juba eksisteerib.";
				$uploadOk = 0;
			}
	
			// Kontrollin faili suurust
			if ($_FILES["fileToUpload"]["size"] > 2000000) {
				$notice="Vabandame, teie fail on liiga suur.";
				$uploadOk = 0;
			}
	
			// Failiformaatide lubamine
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif"){
				$notice.="Lubatud ainult JPG, JPEG, PNG & GIF failid.";
				$uploadOk = 0;
			}
	
			// Kas saab laadida
			if ($uploadOk == 0) {
				$notice.="Vabandame, teie fail ei laadinud üles.";
	
			// Kui saab üles laadida
			} else {
				/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$notice.="Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
				} else {
					$notice.="Vabandame, üleslaadimisel tekkis tõrge.";
				}*/
				
				//sõltuvalt faili tüübist loon pildiobjekti
				
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "png"){
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "gif"){
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				//suuruse muutmine
				//teeme kindlaks praeguse suuruse
				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				//arvutan suuruse suhte
				if($imageWidth > $imageHeight){
					$sizeRatio = $imageWidth / $maxWidth;
				} else {
					$sizeRatio = $imageHeight / $maxHeight;	
				}
				//tekitame uue, sobiva suurusega pikslikogumi
				$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth/$sizeRatio), round($imageHeight/$sizeRatio));
				
				//lisan vesimärgi
				$stamp = imagecreatefrompng("../../graphics/hmv_logo.png");
				$stampWidth = imagesx($stamp);
				$stampHeight = imagesy($stamp);
				$stampX = imagesx($myImage) - $stampWidth - $marginHor;
				$stampY = imagesy($myImage) - $stampHeight - $marginVer;
				imagecopy($myImage, $stamp, $stampX, $stampY, 0, 0, $stampWidth, $stampHeight);
				
				//lisan ka teksti vesimärgi
				$textToImage = "Heade mõtete veeb";
				//määrata värv
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 60);//alpha on 0-127
				//mis pildile, suurus, nurk vastupäeva, x ja y koordinaadid, värv, font, tekst
				imagettftext($myImage, 20, -45, 10, 25, $textColor, "../../graphics/ARIAL.TTF", $textToImage);
				
				//salvestame pildi
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
					if(imagejpeg($myImage, $target_file, 90)){
						$notice.="Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
					} else {
						$notice.="Vabandame, üleslaadimisel tekkis tõrge.";
					}
				}
				if($imageFileType == "png"){
					if(imagejpeg($myImage, $target_file, 5)){
						$notice.="Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
					} else {
						$notice.="Vabandame, üleslaadimisel tekkis tõrge.";
					}
				}
				if($imageFileType == "gif"){
					if(imagejpeg($myImage, $target_file)){
						$notice.="Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
					} else {
						$notice.="Vabandame, üleslaadimisel tekkis tõrge.";
					}
				}
				
				//vabastan mälu
				imagedestroy($myTempImage);
				imagedestroy($myImage);
				imagedestroy($stamp);
				
			}//saab salvestada lõppeb
			
		} else {
			$notice.="Palun valige kõigepealt pildifail.";
		}	
	}//if submit lõppeb
	
	function resizeImage($image, $origW, $origH, $w, $h){
		$newImage = imagecreatetruecolor($w, $h);
		//kuhu, kust, kuhu koordinaatidele x ja y, kust koordinaatidelt x ja y, kui laialt uude kohta, kui kõrgelt uude kohta, kui laialt võtta, kui kõrgelt võtta
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $newImage;
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Marii Helena veebiprogrammeerimine</title>
</head>
<body>
	<h1>Piltide üleslaadimine</h1>
	<p>See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="main.php">Pealeht</a></p>
	<hr>
	<h2>Lisa oma pilt</h2>
	<form action="photoupload.php" method="post" enctype="multipart/form-data">
		<label>Valige pildifail:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Lae üles" name="submit">
	</form>
	
	<span><?php echo $notice; ?></span>
	<hr>

</body>
</html>

