<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];

$sql = mysqli_query($conn, "SELECT reservation_id,additional_id,additional_type as description,additional_amount,COUNT(additional_id) as Qty,SUM(additional_amount) as total_amount
FROM guest_additional
where reservation_id = '$reservation_id'
GROUP BY reservation_id,additional_id,additional_type,additional_amount");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
