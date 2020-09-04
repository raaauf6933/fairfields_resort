<?php
include "../dbconn.php";

$report_type = $_POST['report_type'];
$from = $_POST['from'];
$to = $_POST['to'];


if($report_type == 'Pending Reservation'){
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(adt.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  left join additional_type adt on adt.additional_id = ga.additional_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to' and rv.status in (0,1)
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);

}else if($report_type == 'Expired Reservation'){
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(adt.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  left join additional_type adt on adt.additional_id = ga.additional_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to' and rv.status in (3)
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
}else if ($report_type == 'Confirmed Reservation'){
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(adt.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  left join additional_type adt on adt.additional_id = ga.additional_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to' and rv.status in (4)
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
}else if($report_type == 'No Show Reservation'){
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(adt.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  left join additional_type adt on adt.additional_id = ga.additional_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to' and rv.status in (5)
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
}else if ($report_type == 'Check-in Reservation'){
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(adt.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  left join additional_type adt on adt.additional_id = ga.additional_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to' and rv.status in (6)
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
}else if($report_type == 'Check-out Reservation'){
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(ga.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to' and rv.status in (7)
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
}else{
    $sql = mysqli_query($conn, "SELECT 
rv.reservation_id, 
g.guest_id, 
g.first_name,
g.last_name,
count(rr.room_reservation_id) as num_rooms,
rv.num_guest,
rv.checkin_date, 
rv.checkout_date, 
rv.status,
SUM(rr.room_price)as total_amount,
coalesce(adt.additional_amount,0) as additional_amount,
coalesce(p.payed_capital,0) as total_payed
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
left join room_reservation rr on rr.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(adt.additional_amount) as additional_amount
  from reservation rv
  left join guest_additional ga on ga.reservation_id = rv.reservation_id
  left join additional_type adt on adt.additional_id = ga.additional_id
  group by rv.reservation_id
) adt on adt.reservation_id = rv.reservation_id

left join
(
select 
  rv.reservation_id as reservation_id,
  SUM(p.payed_capital) as payed_capital
  from reservation rv
  left join payment p on p.billing_id = rv.billing_id
  group by rv.reservation_id
) p on p.reservation_id = rv.reservation_id

where cast(rv.reservation_date as date) between '$from' and '$to'
group by rv.reservation_id, 
g.guest_id, 
g.first_name,rv.checkin_date, 
rv.checkout_date, 
rv.status,
rv.num_guest,g.last_name");


    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);

}

?>