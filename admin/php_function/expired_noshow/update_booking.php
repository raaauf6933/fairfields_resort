<?php
include "../dbconn.php";
date_default_timezone_set("Asia/Singapore");
$date_time_now = date("Y-m-d H:i:s");
$date = date("Y-m-d");

echo $date_time_now;

$sql_expire = mysqli_query($conn, "UPDATE reservation SET status = '3' WHERE expiration_date <= '$date_time_now' and status in (0,1)");
$sql_noshow = mysqli_query($conn, "UPDATE reservation SET status = '5' WHERE checkout_date <= '$date' and status in (4)");

?>