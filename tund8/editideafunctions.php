<?php
	$database = "if17_keermari";
	require("../../../config.php");
	
	function getSingleIdea($editId) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($idea, $color);
		$stmt->execute();
		$ideaObject = new Stdclass();
		if($stmt->fetch()){
			$ideaObject->text = $idea;
			$ideaObject->color = $color;
		} else {
			//sellist mõtet polnudki
			header("Location:usersideas.php");
			exit();
		}
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
	}
	
	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET idea=?, ideacolor=? WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $idea, $color, $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteIdea ($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET deleted=NOW() WHERE id=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		echo $stmt->error;
		$stmt->close();
		$mysqli->close();
	}
?>