<?php
include "../dbconn.php";


$reservation_id = $_POST['reservation_id'];
$additional_id = $_POST['additional_id'];
$qty = $_POST['qty'];

$additional_type = "";
$additional_amount = 0;

$sql_additional = mysqli_query($conn, "SELECT * FROM additional_type WHERE additional_id = '$additional_id'");

while($row = mysqli_fetch_array($sql_additional)){
  $additional_type = $row['additional_type'];
  $additional_amount = (int)$row['additional_amount'];
}


for($i=1; $qty >= $i; $i++){
    $sql_insert = mysqli_query($conn, "INSERT INTO guest_additional (reservation_id,additional_id,additional_type,additional_amount) 
    VALUES ('$reservation_id','$additional_id','$additional_type','$additional_amount')");
}


$sql_guest_billing = mysqli_query($conn, "SELECT rv.reservation_id, SUM(b.original_capital) as original_capital, adt.additional_amount, p.payed_capital
from reservation rv
left join billing b on b.billing_id = rv.billing_id
left join
(
select 
  ga.reservation_id as reservation_id,
  SUM(ga.additional_amount) as additional_amount
  from guest_additional ga
  where ga.reservation_id = '$reservation_id'
  group by ga.reservation_id
) adt on adt.reservation_id = rv.reservation_id
left JOIN
(
select p.billing_id as billing_id,
  sum(p.payed_capital) as payed_capital
  FROM payment p
  left join reservation rv on rv.billing_id = p.billing_id
  where rv.reservation_id = '$reservation_id'
  group by billing_id
) p on p.billing_id = rv.billing_id
where rv.reservation_id = '$reservation_id'
group by rv.reservation_id");



$data = array();
while ($row = mysqli_fetch_assoc($sql_guest_billing)) {
  array_push($data, $row);
}


echo json_encode($data);



?>