<?php
include "../dbconn.php";

$reservation_id = $_POST['reservation_id'];

$sql = mysqli_query($conn, "SELECT * FROM reservation rv LEFT JOIN guest g on rv.guest_id = g.guest_id where reservation_id = '$reservation_id'");


while ($row = mysqli_fetch_assoc($sql)) {
    echo json_encode($row);
}


