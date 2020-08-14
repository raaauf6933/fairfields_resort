<?php
include "../dbconn.php";

$guest_id = $_POST['guest_id'];

$sql = mysqli_query($conn, "SELECT *
FROM payment p
left join reservation rv on rv.billing_id = p.billing_id
where rv.guest_id = '$guest_id'");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);

?>