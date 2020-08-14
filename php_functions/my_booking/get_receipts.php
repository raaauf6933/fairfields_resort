<?php
include "../dbconn.php";

$guest_id = $_POST['guest_id'];

$sql = mysqli_query($conn, "SELECT * FROM receipt_photo rp LEFT JOIN reservation rv on rv.reservation_id = rp.reservation_id  WHERE rv.guest_id = '$guest_id'");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);

?>