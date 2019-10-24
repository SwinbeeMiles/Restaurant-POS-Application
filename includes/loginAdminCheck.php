<?php
	if(isset($_SESSION["privilege"]) && $_SESSION["privilege"] === 1){

	}
	else{

	header('Location: '.$_SERVER['HTTP_REFERER']);
				exit;
	}


?>
