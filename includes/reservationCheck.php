<?php
	require_once 'includes/connectDB.php';
	
	$conn = connect();
	
	//Timezone for later use, change timezone here
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date = date('Y-m-d');
	$time = date('H:i:s');
	
	$table = null;
	$start = null;
	$end = null;
	
	$sql = "SELECT TableID, ReservationTime, EndTime FROM reservation WHERE ReservationDate = ?";
	$stmt = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($stmt, 's', $date);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $tableid, $starttime, $endtime);
	
	$reservations = array();
	
	while(mysqli_stmt_fetch($stmt)){
		$reservations[] = array(
			'table' => $tableid, 
			'start' => $starttime,
			'end' => $endtime
		);
	}
	
	mysqli_stmt_close($stmt);
	
	foreach($reservations as $r){
		$table = $r['table'];
		$start = $r['start'];
		$end = $r['end'];
		if($start <= $time && $end >= $time){
			//Reserve tables
			$sql2 = "UPDATE tables SET Status = IF(Status <> 'occupied', 'reserved', Status) WHERE TableID = ?";
			$stmt2 = mysqli_prepare($conn, $sql2);
			mysqli_stmt_bind_param($stmt2, 'i', $table);
			mysqli_stmt_execute($stmt2);
			mysqli_stmt_close($stmt2);
		}else{
			//Unreserve tables
			$sql3 = "UPDATE tables SET Status = IF(Status <> 'occupied', 'available', Status) WHERE TableID = ?";
			$stmt3 = mysqli_prepare($conn, $sql3);
			mysqli_stmt_bind_param($stmt3, 'i', $table);
			mysqli_stmt_execute($stmt3);
			mysqli_stmt_close($stmt3);
		}
	}
	
	mysqli_close($conn);
	
	
?>