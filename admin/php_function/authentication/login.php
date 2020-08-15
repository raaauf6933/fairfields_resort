<?php
include "../dbconn.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = mysqli_query($conn, "SELECT * FROM user_accounts WHERE username = '$username' AND password = '$password' AND status ='1'");

$tmp = mysqli_num_rows($sql);

if ($tmp > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        array_push($data, $row);
    }

    echo json_encode($data);
} else {
    echo json_encode("0");
}
