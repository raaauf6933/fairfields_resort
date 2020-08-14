<?php
include "dbconn.php";

$reservation_id = $_POST['reservation_id'];
$billing_id = $_POST['billing_id'];
$actual_capital = $_POST['actual_capital'];

$room_ids = json_decode($_POST['room_ids']); // array;


    $sql = "INSERT INTO `billing` (`billing_id`, `original_capital`) VALUES ('$billing_id', '$actual_capital')";
    $result = mysqli_query($conn, $sql);

    foreach ($room_ids as $row) {

        $sql1 = "INSERT INTO `room_reservation` (`reservation_id`, `room_id`) VALUES ('$reservation_id', '$row')";
        $result1 = mysqli_query($conn, $sql1);
    }

 
   


?>