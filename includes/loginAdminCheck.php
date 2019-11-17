<?php
	if(isset($_SESSION["privilege"]) && $_SESSION["privilege"] === 1){

	}
	else{   
//        header('Location: '.$_SERVER['HTTP_REFERER']);
//        exit();
        echo "<script type='text/javascript'>alert('Admin access only!');
        history.back(-1);
        </script>";
	}
?>
