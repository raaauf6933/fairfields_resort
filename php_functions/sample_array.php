<?php
include "dbconn.php";



$sample_array = json_decode('[{"roomtype_id":"1","roomtype_name":"Family Room","num_rooms":2,"new_capacity":4,"new_price":4000,"room_ids":["1","2"]},{"roomtype_id":"2","roomtype_name":"Vip Room","num_rooms":4,"new_capacity":16,"new_price":12000,"room_ids":["3","4","5","6"]},{"roomtype_id":"3","roomtype_name":"Ordinary Room","num_rooms":2,"new_capacity":12,"new_price":5000,"room_ids":["7","8"]}]');

$billing_id = "000";
$reservation_id = "000";

$email = "";

$room_row = array();
$room_counter = array();

$ctr = 0;
foreach ($sample_array as $room_array) {
    foreach ($room_array->room_ids as $rooms) {

        $sql_get_room = mysqli_query($conn, "SELECT rt.roomtype_name,rt.roomtype_price,rm.room_num FROM rooms rm
            left join room_type rt on rt.roomtype_id = rm.roomtype_id
            where rm.room_id = '$rooms'");

        $room_name = 0;
        $room_price = 0;
        $room_num = 0;
        while ($row = mysqli_fetch_assoc($sql_get_room)) {
            $room_name = $row['roomtype_name'];
            $room_price = $row['roomtype_price'];
            $room_num = $row['room_num'];
          array_push($room_counter,$room_name);
        }


       
        if (
            in_array($room_name, $room_row)
        ) { //If in array, skip iteration

            continue;
        }

        
       // echo $room_name . $room_price  . '<br>';
        $room_row[] = $room_name;


        //$sql1 = "INSERT INTO `room_reservation` (`reservation_id`, `room_id`) VALUES ('$reservation_id', '$rooms[$room]')";
        //$result1 = mysqli_query($conn, $sql1);


    }

    //$sql = "INSERT INTO `billing` (`billing_id`, `original_capital`) VALUES ('$billing_id', '$room_array->new_price')";
    //$result = mysqli_query($conn, $sql);
}

foreach ($sample_array as $room_array) {
    echo $room_array->roomtype_name.$room_array->new_price/$room_array->num_rooms. $room_array->num_rooms. $room_array->new_price.'<br/>  ';
}

