<?php
include "../dbconn.php";

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$password = $_POST['password'];

$year = date('Y');
$random_num = rand(99999,999);
$id= (int)$year."".$random_num;

$sql = mysqli_query($conn, "INSERT INTO user_accounts (user_id,first_name,last_name,username,password,status) 
VALUES ('$id','$first_name','$last_name','$username','$password','1')");

echo json_encode("success");

?>