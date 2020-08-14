<?php
include "../dbconn.php";

$billing_id = $_POST['billing_id'];

$sql = mysqli_query($conn, "SELECT * FROM payment where billing_id = '$billing_id'");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
