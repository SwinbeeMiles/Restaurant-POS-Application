<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$TableID = $request->TableID;

    require_once 'connectDB.php';
	$conn = connect();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE tables SET Status = 'occupied' WHERE TableID = $TableID";
    
    if ($conn->query($sql) === TRUE) {
    echo "Record successfully updated in Tables";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>