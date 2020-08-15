<?php
include "../dbconn.php";

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$password = $_POST['password'];
$status = $_POST['status'];


$sql = mysqli_query($conn, "UPDATE user_accounts SET username = '$username', password = '$password', status = '$status' WHERE user_id = '$user_id'");

echo json_encode("success");
