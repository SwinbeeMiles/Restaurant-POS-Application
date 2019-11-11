<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$OrderID = $request->OrderID;
    @$TotalPrice = $request->TotalPrice;
    @$PaidStatus = $request->PaidStatus;

    $dbServername = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'restaurantdatabase';

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO orderpayment (OrderID, TotalPrice, DiscountPrice, TotalPaid, Balance, PaidStatus) VALUES ($OrderID, $TotalPrice, 0, NULL, NULL, $PaidStatus)";
    
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully in Payment";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>