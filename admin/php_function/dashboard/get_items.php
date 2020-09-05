<?php
include "../dbconn.php";


$sql= mysqli_query($conn, "SELECT 
count(distinct case when rv.status in (0) then rv.reservation_id end) as pending_booking,
count(distinct case when rv.status in (1) then rv.reservation_id end) as pending_with_picture,
count(distinct case when rv.status in (4) then rv.reservation_id end) as num_confirmed,
count(case when rv.status in (6) then rr.room_reservation_id end) as no_room_using,
count(distinct case when rv.status not in (6) then rm.room_id end) as no_vacant_today,
count(distinct case when rv.checkin_date = DATE_ADD(cast(NOW() as date),INTERVAL 1 DAY) and rv.status in (4) then rv.reservation_id end) as confirmed_tommorow,
coalesce(SUM(case when rv.checkin_date = cast(NOW() as date ) and rv.status in (6) then rv.num_guest end),0) as num_guest_today,
count(DISTINCT case when rv.checkout_date = cast(NOW() as date) and rv.status in (6) then rv.reservation_id end) as num_checkout_today
FROM reservation rv
left join room_reservation rr on rr.reservation_id = rv.reservation_id
left join rooms rm on rm.room_id = rr.room_id");


$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);



?>