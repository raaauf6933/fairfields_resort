<?php
include "../dbconn.php";

$item_id = $_POST['item_id'];
$item_price = $_POST['item_price'];
$status = $_POST['status'];

$sql = mysqli_query($conn, "UPDATE additional_type SET additional_amount = '$item_price', status ='$status' WHERE additional_id = '$item_id'");

echo json_encode("success");


?>