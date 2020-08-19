<?php
include "../dbconn.php";

$item_name = $_POST['item_name'];
$item_price = $_POST['item_price'];

$sql = mysqli_query($conn, "INSERT INTO additional_type (additional_type,description,additional_amount,status)
VALUES ('$item_name','$item_name','$item_price','1')");
echo json_encode("success");


?>