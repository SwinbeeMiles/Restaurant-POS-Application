<?php;
	define('servername','localhost');
	define('username','root');
	define('password','');
	define('dbname','restaurantdatabase');
	
	$conn = mysqli_connect(servername, username, password, dbname);
	
	if ($conn == false) {
		die("ERROR: Connection failed. ".mysqli_connect_error());
	}
?>