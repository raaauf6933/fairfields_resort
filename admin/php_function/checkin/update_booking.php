<?php
include "../dbconn.php";
date_default_timezone_set("Asia/Singapore");

$billing_id = $_POST['billing_id'];
$payed_capital = $_POST['payed_capital'];
$payment_date = date("Y-m-d H:i:s");

$sql = mysqli_query($conn, "INSERT INTO payment(billing_id,payed_capital,payment_date) 
VALUES ('$billing_id','$payed_capital','$payment_date')");
$sql_update = mysqli_query($conn, "UPDATE reservation SET status = '7' WHERE billing_id ='$billing_id'");
echo json_encode('1');
