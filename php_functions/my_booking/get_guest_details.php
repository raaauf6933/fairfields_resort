<?php
include "../dbconn.php";

$guest_id = $_POST['guest_id'];

$sql = mysqli_query($conn, "SELECT *
FROM guest g
left join reservation rv on rv.guest_id = g.guest_id
where g.guest_id = '$guest_id'");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
