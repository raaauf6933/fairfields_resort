<?php
include "../dbconn.php";

$email = $_POST['email'];
$booking_reference = $_POST['booking_reference'];

$sql = mysqli_query($conn, "SELECT *
FROM guest g
left join reservation rv on rv.guest_id = g.guest_id
where g.email = '$email' and rv.booking_reference = '$booking_reference' and rv.status in (0,1,4)");

$tmp = mysqli_num_rows($sql);

if($tmp > 0){
    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
}else{
    echo json_encode("0");
}

?>