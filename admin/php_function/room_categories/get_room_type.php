<?php
include "../dbconn.php";

$sql = mysqli_query($conn, "SELECT * FROM room_type WHERE status = '1'");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
