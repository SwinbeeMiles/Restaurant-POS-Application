<?php
    Require_once 'connectDB.php';
    $con=connect();
    $select = mysqli_query($con,"select * from orderdetails");
    $data = array();

if(mysqli_num_rows($select)>0)
{
    while($row = mysqli_fetch_array($select))
    {
        $data[] = array("OrderID"=>$row['OrderID'],"FoodID"=>$row['FoodID'],"Quantity"=>$row['Quantity'],"Total"=>$row['Total']);
    }

    echo json_encode($data);
}
?>