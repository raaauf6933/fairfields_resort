<?php
include "../dbconn.php";

$guest_id = $_POST['guest_id'];

$sql = mysqli_query($conn, "SELECT *
FROM room_reservation rr
left join reservation rv on rr.reservation_id = rv.reservation_id
where rv.guest_id = '$guest_id'");


$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);

?>