<?php
include "../dbconn.php";


$room_id = $_POST['room_id'];


$sql_validation = mysqli_query($conn, "SELECT rr.* 
FROM room_reservation rr
LEFT JOIN reservation rv on rv.reservation_id = rr.reservation_id
where rv.status in (0,1,4,6) and rr.room_id = '$room_id'");

$ctr = mysqli_num_rows($sql_validation);


if($ctr > 0){
    echo json_encode("0");
}else{
    $sql = mysqli_query($conn, "DELETE FROM rooms WHERE room_id = '$room_id'");
    echo json_encode("1");
}
