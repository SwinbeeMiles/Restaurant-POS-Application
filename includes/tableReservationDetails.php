<?php
    Require_once 'connectDB.php';
    $con=connect();
    $select = mysqli_query($con,"select * from reservation");
    $data = array();

if(mysqli_num_rows($select)>0)
{
    while($row = mysqli_fetch_array($select))
    {
        $data[] = array("RevID"=>$row['ReservationID'],"TableID"=>$row['TableID'],"RevTime"=>$row['ReservationTime'],"RevDate"=>$row['ReservationDate'],"RevEndTime"=>$row['EndTime']);
    }

    echo json_encode($data);
}
?>