<?php
include "dbconn.php";

$guest_id = $_POST['guest_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$zipcode = $_POST['zip_code'];

$query = "INSERT INTO guest (guest_id,first_name,last_name,gender,contact_number,email,addressline_1,city,zipcode) VALUES
      ('" . $guest_id . "','" . $first_name . "','" . $last_name . "','" . $gender . "','" . $contact_number . "','" . $email . "',
      '" . $address . "','" . $city . "','" . $zipcode . "')" or die('error');
$result = mysqli_query($conn, $query);

echo json_encode("success");

?>