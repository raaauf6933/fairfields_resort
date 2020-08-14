<?php
include "../dbconn.php";

$sql = mysqli_query($conn, "SELECT g.guest_id,g.first_name,g.last_name,g.contact_number,g.email,g.addressline_1,g.city,g.zipcode,r.reservation_id,r.billing_id,r.booking_reference,r.num_guest,r.reservation_date,r.checkin_date,r.checkout_date,r.expiration_date,count(rp.receipt_photo_id) as num_uploaded_recpt
FROM reservation r 
LEFT JOIN guest g on g.guest_id = r.guest_id 
LEFT JOIN receipt_photo rp on r.reservation_id = rp.reservation_id
WHERE r.status in (6)
group by g.guest_id,g.first_name,g.last_name,g.contact_number,g.email,g.addressline_1,g.city,g.zipcode,r.reservation_id,r.billing_id,r.booking_reference,r.num_guest,r.reservation_date,r.checkin_date,r.checkout_date,r.expiration_date");

$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
}

echo json_encode($data);
