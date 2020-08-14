<?php
include "../dbconn.php";
$roomtype_id = $_POST['roomtype_id'];
$room_name = $_POST['room_name'];
$room_price = $_POST['room_price'];
$room_description = $_POST['description'];
$tmp = $_POST['tmp'];


if($tmp > 0){
    $file = $room_name . "-" . rand(9999, 99) . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $folder = "../../dist/img/room/";
    move_uploaded_file($file_loc, $folder . $file);
    $sql = mysqli_query($conn, "UPDATE room_type SET roomtype_price = '$room_price', description = '$room_description', roomtype_photo = '$file' WHERE roomtype_id = '$roomtype_id'");

    echo json_encode("1");

}else{
    $sql1 = mysqli_query($conn, "UPDATE room_type SET roomtype_price = '$room_price', description = '$room_description' WHERE roomtype_id = '$roomtype_id'");
    echo json_encode("2");
}
