<?php
include "dbconn.php";



$sample_array = json_decode('[{"roomtype_id":"1","roomtype_name":"Family Room","num_rooms":2,"new_capacity":4,"new_price":4000,"room_ids":["1","2"]},{"roomtype_id":"2","roomtype_name":"Vip Room","num_rooms":4,"new_capacity":16,"new_price":12000,"room_ids":["3","4","5","6"]},{"roomtype_id":"3","roomtype_name":"Ordinary Room","num_rooms":2,"new_capacity":12,"new_price":5000,"room_ids":["7","8"]}]');

$billing_id="000";
$reservation_id="000";



foreach ($sample_array as $room_array) {
    foreach($room_array as $rooms){
        $sql1 = "INSERT INTO `room_reservation` (`reservation_id`, `room_id`) VALUES ('$reservation_id', '$rooms[$room]')";
        $result1 = mysqli_query($conn, $sql1);
    }

    $sql = "INSERT INTO `billing` (`billing_id`, `original_capital`) VALUES ('$billing_id', '$room_array->new_price')";
    $result = mysqli_query($conn, $sql);
}

