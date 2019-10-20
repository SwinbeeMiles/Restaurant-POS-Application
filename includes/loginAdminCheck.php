<?php
	if(isset($_SESSION["privilege"]) && $_SESSION["privilege"] === true){
		
	}
	else{
		header("location: homepage.php");
		exit;
	}
?>
