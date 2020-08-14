<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];

$sql = mysqli_query($conn, "SELECT ga.reservation_id, adt.description, adt.additional_id,adt.additional_amount, COUNT(adt.additional_id) as Qty, SUM(adt.additional_amount) as total_amount FROM guest_additional ga LEFT JOIN additional_type adt on adt.additional_id = ga.additional_id where ga.reservation_id = '$reservation_id'
GROUP BY ga.reservation_id, adt.description, adt.additional_id,adt.additional_amount");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
