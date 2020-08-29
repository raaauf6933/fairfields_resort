<?php
include "../dbconn.php";
date_default_timezone_set("Asia/Singapore");

$billing_id = $_POST['billing_id'];
$payed_capital = $_POST['payed_capital'];
$payment_date = date("Y-m-d H:i:s");


$query_billing = mysqli_query($conn, "SELECT id,SUM(original_capital) as original_capital FROM billing where billing_id = '$billing_id'
GROUP BY id");

$total_amount = 0;
while ($row = mysqli_fetch_assoc($query_billing)) {
    $total_amount += (int)$row['original_capital'];
}

$query_additional = mysqli_query($conn, "SELECT g.reservation_id, SUM(adt.additional_amount) as additional_amount
FROM guest_additional g
left join additional_type adt on adt.additional_id = g.additional_id
left join reservation rv on rv.reservation_id = g.reservation_id
where rv.billing_id = '$billing_id'
group by g.reservation_id");

$total_additional = 0;
while ($row = mysqli_fetch_assoc($query_additional)){
    $total_additional = (int)$row['additional_amount'];
}


$query_payment = mysqli_query($conn, "SELECT payment_id,SUM(payed_capital) as payed_capital FROM payment where billing_id = '$billing_id' GROUP BY payment_id");

$total_payed = 0;
while ($row = mysqli_fetch_assoc($query_payment)) {
    $total_payed += (int)$row['payed_capital'];
}

$balance = ($total_amount + $total_additional) - $total_payed;

if ($payed_capital == $balance) {
    $sql = mysqli_query($conn, "INSERT INTO payment(billing_id,payed_capital,payment_date) 
VALUES ('$billing_id','$payed_capital','$payment_date')");
    $sql_update = mysqli_query($conn, "UPDATE reservation SET status = '7' WHERE billing_id ='$billing_id'");
    echo json_encode('1');
} elseif ($payed_capital > $balance) {
    echo json_encode('2');
} else {
    echo json_encode('0');
}




/*
$sql = mysqli_query($conn, "INSERT INTO payment(billing_id,payed_capital,payment_date) 
VALUES ('$billing_id','$payed_capital','$payment_date')");
$sql_update = mysqli_query($conn, "UPDATE reservation SET status = '7' WHERE billing_id ='$billing_id'");
echo json_encode('1');
*/