<?php
include('dbconn.php');

$roomtype_id = $_POST['roomtype_id'];


$sql = mysqli_query(
    $conn,
    "SELECT rm.*,rt.*,
COALESCE((SELECT reservation_id FROM reservation where status=6),0) as reservation_id
FROM rooms rm
LEFT JOIN room_type rt on rt.roomtype_id = rm.roomtype_id"
);

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
