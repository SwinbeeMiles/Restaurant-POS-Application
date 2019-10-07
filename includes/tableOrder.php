<?php
    Require_once 'connectDB.php';
    $con=connect();
    $select = mysqli_query($con,"select * from orders");
    $data = array();

if(mysqli_num_rows($select)>0)
{
    while($row = mysqli_fetch_array($select))
    {
        $data[] = array("OrderID"=>$row['OrderID'],"OrderDate"=>$row['OrderDate'],"OrderTime"=>$row['OrderTime'],"TableID"=>$row['TableID'],"PaidStatus"=>$row['PaidStatus']);
    }

    echo json_encode($data);
}
?>