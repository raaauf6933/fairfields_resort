<?php
include "../dbconn.php";

$billing_id = $_POST['billing_id'];

$sql = mysqli_query($conn, "SELECT billing_id,SUM(original_capital) as original_capital
FROM billing
where billing_id = '$billing_id'
GROUP BY billing_id");

while ($row = mysqli_fetch_assoc($sql)) {
    echo json_encode($row['original_capital']);
}
