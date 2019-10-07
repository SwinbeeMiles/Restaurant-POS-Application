<?php
	$conn = null;

	function connect()
	{
		global $conn;   
		if (!$conn)
		{
			$dbServername = 'localhost';
			$dbUsername = 'root';
			$dbPassword = '';
			$dbName = 'restaurantdatabase';
			$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);
		}
		return $conn;
	}
?>