<?php
    Require_once 'connectDB.php';
    $con=connect();
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$sql = $request->sql;
    @$rowNum = $request->numOfRow;
    $rows = $con->query($sql);

    if ($con->connect_error) {
        return $con->connect_error;
    } else if ($con->error) {
        return $con->error;
    } else {
        while ($row = $rows->fetch_array(MYSQLI_ASSOC)) {
            if($rowNum==0)
            {
                $data = $row;
            }
            else if($rowNum==1)
            {
                $data[] = $row;
            }
         }
    }
    echo json_encode($data);
    $conn->close();
?>