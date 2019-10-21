<?php
	if(isset($_SESSION["privilege"]) && $_SESSION["privilege"] === true){

	}
	else{

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;
	}


?>
