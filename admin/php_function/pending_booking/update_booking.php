<?php
include "dbconn.php";
date_default_timezone_set("Asia/Singapore");

$billing_id = $_POST['billing_id'];
$payed_capital = $_POST['payed_capital'];
$payment_date = date("Y-m-d H:i:s");

$query_billing = mysqli_query($conn, "SELECT id,SUM(original_capital) as original_capital FROM billing where billing_id = '$billing_id'
GROUP BY id");

$total_amount = 0;
while ($row = mysqli_fetch_assoc($query_billing)) {
  $total_amount += $row['original_capital'];
}
$down_payment = $total_amount / 2;

if($payed_capital >= $down_payment && $payed_capital <= $total_amount){
    $sql = mysqli_query($conn, "INSERT INTO payment(billing_id,payed_capital,payment_date) 
VALUES ('$billing_id','$payed_capital','$payment_date')");
    $sql_update = mysqli_query($conn, "UPDATE reservation SET status = '4' WHERE billing_id ='$billing_id'");
echo json_encode('1');
}elseif($payed_capital > $total_amount){
    echo json_encode('2');
}else{

    echo json_encode('0');
}


?>