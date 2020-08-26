<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];

$sql = mysqli_query($conn, "SELECT roomtype_name, room_price, count(roomtype_name) as num_room, SUM(room_price) as room_total
FROM room_reservation 
where reservation_id = '$reservation_id'
group by  roomtype_name, room_price");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data)

?>