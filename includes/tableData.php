<?php
    Require_once 'connectDB.php';
    $con=connect();

    $select = mysqli_query($con,"select * from tables");
    $data = array();

if(mysqli_num_rows($select)>0)
{
    while($row = mysqli_fetch_array($select))
    {
        $data[] = array("TableID"=>$row['TableID'],"Chairs"=>$row['Chairs'],"Status"=>$row['Status']);
    }

    echo json_encode($data);
}
?>