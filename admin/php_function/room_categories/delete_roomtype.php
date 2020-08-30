<?php
include "../dbconn.php";

$roomtype_id = $_POST['roomtype_id'];

$sql = mysqli_query($conn, "SELECT * FROM rooms WHERE roomtype_id = '$roomtype_id'");
$num_rows = mysqli_num_rows($sql);

if($num_rows > 0){
    echo json_encode("0");
}else{
    $sql_delete = mysqli_query($conn,"DELETE FROM room_type where roomtype_id = '$roomtype_id'");
    echo json_encode("1");
}

?>