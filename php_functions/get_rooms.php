<?php
include('dbconn.php');

$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];

$sql = mysqli_query(
    $conn,
    "SELECT rm.room_id, rm.roomtype_id, rt.roomtype_capacity, rt.roomtype_name, rt.roomtype_price,rt.description,rt.roomtype_photo
FROM rooms rm
inner join room_type rt on rt.roomtype_id = rm.roomtype_id
where rm.room_id not in 
(select room_id 
 from room_reservation rr
left join reservation r on r.reservation_id = rr.reservation_id
where status in (0,1,4,6) and (('$check_in' between r.checkin_date and r.checkout_date) OR ('$check_out' BETWEEN r.checkin_date and r.checkout_date) OR ('$check_in' <= r.checkin_date and '$check_out' >= r.checkout_date)))"
);

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
