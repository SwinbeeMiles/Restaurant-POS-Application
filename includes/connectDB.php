<?php
	$conn = null;

	function connect()
	{
		global $conn;   
		if (!$conn)
		{
			$dbServername = 'localhost';
			$dbUsername = 'root'; // $dbUsername = 'id11040270_admin';
			$dbPassword = ''; // $dbPassword = '*****';
			$dbName = 'restaurantdatabase'; //dbName = 'id11040270_restaurantdatabase';
			$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);
		}
		
		if($conn === false){
			die("ERROR: Could not connect to database.".mysqli_connect_error());
		}
		else{
			return $conn;
		}
	}
?>
