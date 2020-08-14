<?php
include "../dbconn.php";
date_default_timezone_set("Asia/Singapore");

$reservation_id = $_POST['reservation_id'];
$datenow = date("Y-m-d H:i:s");

$file = rand(9999, 99) . "-" . $_FILES['file']['name'];
$file_loc = $_FILES['file']['tmp_name'];
$folder = "../../admin/dist/img/bank_receipts/";

move_uploaded_file($file_loc, $folder . $file);

$sql = mysqli_query($conn, "INSERT INTO receipt_photo (reservation_id,photo,upload_date) VALUES ('$reservation_id','$file','$datenow')");
echo json_encode("1");
?>