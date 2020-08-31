<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];

$sql = mysqli_query($conn, "SELECT ga.additional_id,ga.additional_type,ga.additional_amount as rate,COUNT(ga.additional_id) as num_additional,SUM(ga.additional_amount) as additional_amount
FROM guest_additional ga
left join reservation rv on rv.reservation_id = ga.reservation_id
where ga.reservation_id = '$reservation_id'
group by ga.additional_id,ga.additional_type,ga.additional_amount");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data)

?>