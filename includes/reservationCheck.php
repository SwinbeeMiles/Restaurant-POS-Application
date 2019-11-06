<?php
	require_once 'includes/connectDB.php';
	
	$conn = connect();
	
	//Timezone for later use, change timezone here
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date = date('Y-m-d');
	$time = date('H:i:s');
	
	$sql = "SELECT * FROM reservation WHERE ReservationDate = '$date'";
	$result = mysqli_query($conn, $sql);
	
	while($row = mysqli_fetch_assoc($result)){
		$table = null;
		$start = null;
		$end = null;
		
		foreach($row as $key => $value){
			if($key == "TableID"){
				$table = $value;
			}
			if($key == "ReservationTime"){
				$start = $value;
			}
			if($key == "EndTime"){
				$end = $value;
			}
		}
		
		if($table != null && $start != null && $end != null){
			if($start <= $time && $end >= $time){
				//Reserve tables
				$sql = "UPDATE tables SET Status = IF(Status <> 'occupied', 'reserved', Status) WHERE TableID = $table";
				mysqli_query($conn, $sql);
				echo mysqli_error($conn);
				break;
			}else{
				//Unreserve tables
				$sql = "UPDATE tables SET Status = IF(Status <> 'occupied', 'available', Status) WHERE TableID = $table";
				mysqli_query($conn, $sql);
			}
		}
	}
	
	mysqli_close($conn);
	
	
?>