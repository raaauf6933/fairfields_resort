<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];

$sql = mysqli_query($conn, "SELECT adt.additional_id,adt.description,adt.additional_amount as rate,COUNT(adt.additional_id) as num_additional,SUM(adt.additional_amount) as additional_amount
FROM guest_additional ga
left join additional_type adt on adt.additional_id = ga.additional_id
left join reservation rv on rv.reservation_id = ga.reservation_id
where ga.reservation_id = '$reservation_id'
group by adt.additional_id,adt.description,adt.additional_amount");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data)

?>