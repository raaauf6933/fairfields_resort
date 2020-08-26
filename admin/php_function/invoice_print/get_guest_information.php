<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];
$sql = mysqli_query($conn, "SELECT *
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
where rv.reservation_id = '$reservation_id'");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data)

?>