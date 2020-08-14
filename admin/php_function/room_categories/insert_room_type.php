<?php
include "../dbconn.php";

$room_name = $_POST['roomname'];
$room_capacity = $_POST['roomcapacity'];
$room_price = $_POST['roomprice'];
$room_description = $_POST['roomdescription'];


$file = $room_name."-" .rand(9999,99)."-". $_FILES['file']['name'];
$file_loc = $_FILES['file']['tmp_name'];
$folder = "../../dist/img/room/";

move_uploaded_file($file_loc, $folder . $file);



$sql = mysqli_query($conn,"INSERT INTO room_type (roomtype_name,roomtype_capacity,roomtype_price,description,roomtype_photo,status) 
VALUES ('$room_name','$room_capacity','$room_price ','$room_description','$file','1')");

echo json_encode('1');

?>