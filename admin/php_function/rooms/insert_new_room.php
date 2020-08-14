<?php
include "../dbconn.php";

$roomtype_id = $_POST['roomtype_id'];
$room_num = $_POST['room_num'];

$sql = mysqli_query($conn,"INSERT INTO rooms (roomtype_id,room_num,status) VALUES ('$roomtype_id','$room_num','0')");

echo json_encode("1");


?>