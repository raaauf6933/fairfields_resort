<?php
include "dbconn.php";

$selected_rooms = json_decode($_POST['selected_rooms']);
$check_in = $_POST['checkin_date'];
$check_out = $_POST['checkout_date'];


$validate_rooms = mysqli_query(
    $conn,
    "SELECT room_id 
 from room_reservation rr
left join reservation r on r.reservation_id = rr.reservation_id
where status in (0,1,4,6) and (('$check_in' between r.checkin_date and r.checkout_date) OR ('$check_out' BETWEEN r.checkin_date and r.checkout_date) OR ('$check_in' <= r.checkin_date and '$check_out' >= r.checkout_date))"
);

$data = array();
while ($row = mysqli_fetch_assoc($validate_rooms)) {
    array_push($data, $row['room_id']);
}

$counter_duplicates = 0;

foreach ($selected_rooms as $row) {
    for ($i = 0; count($data) > $i; $i++) {
        if ($row == $data[$i]) {
            $counter_duplicates += 1;
        }
    }
}


if ($counter_duplicates == 0) {
    echo json_encode("1");
}else{
        echo json_encode("0");
}

?>