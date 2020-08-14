<?php
include "../dbconn.php";

$sql = mysqli_query($conn, "SELECT * FROM rooms rm LEFT JOIN room_type rt on rt.roomtype_id = rm.roomtype_id WHERE rm.status = '0' ");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
