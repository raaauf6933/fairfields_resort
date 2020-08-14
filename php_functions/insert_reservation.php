<?php
include "dbconn.php";
date_default_timezone_set("Asia/Singapore");
$reservation_id = (int)$_POST['reservation_id'];
$guest_id = (int)$_POST['guest_id'];
$billing_id = (int)$_POST['billing_id'];
$reservation_date = date("Y-m-d H:i:s");
$md5c = md5(date("Y-m-d H:i:sa"));
$booking_reference = substr(strtoupper($md5c), 1, 6);
$num_guest = (int)$_POST['num_guest'];
$check_in = $_POST['checkin_date'];
$check_out = $_POST['checkout_date'];
if ((date("Y-m-d", strtotime($check_in))) == (date("Y-m-d", strtotime($reservation_date . '+1 day')))) {
    $expiration_date = date("Y-m-d 23:59:59");
} else {
    $expiration_date = date("Y-m-d H:i:s", strtotime($reservation_date . '+1 day'));
}
$reservation_type = (int)$_POST['reservation_type'];
$status = (int)$_POST['status'];




$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$zipcode = $_POST['zip_code'];

$query1 = "INSERT INTO guest (guest_id,first_name,last_name,gender,contact_number,email,addressline_1,city,zipcode) VALUES
      ('" . $guest_id . "','" . $first_name . "','" . $last_name . "','" . $gender . "','" . $contact_number . "','" . $email . "',
      '" . $address . "','" . $city . "','" . $zipcode . "')" or die('error');
$result1 = mysqli_query($conn, $query1);

$query1 = "INSERT INTO `reservation` (`reservation_id`, `guest_id`, `billing_id`, `reservation_date`,`booking_reference`,`num_guest`, `checkin_date`, `checkout_date`, `expiration_date`, `reservation_type`, `status`) VALUES 
('$reservation_id', '$guest_id', '$billing_id', '$reservation_date','$booking_reference','$num_guest', '$check_in', '$check_out', '$expiration_date', '$reservation_type', '$status')";
$result2 = mysqli_query($conn, $query1);


$room_array = json_decode($_POST['room_details']);

foreach ($room_array as $room_array) {
    foreach ($room_array->room_ids as $rooms) {

        $sql_get_room = mysqli_query($conn, "SELECT rt.roomtype_name,rt.roomtype_price,rm.room_num FROM rooms rm
            left join room_type rt on rt.roomtype_id = rm.roomtype_id
            where rm.room_id = '$rooms'");

        $room_name = 0;
        $room_price = 0;
        $room_num = 0;
        while ($row = mysqli_fetch_assoc($sql_get_room)) {
            $room_name = $row['roomtype_name'];
            $room_price = $row['roomtype_price'];
            $room_num = $row['room_num'];
        }
        $sql_room = "INSERT INTO `room_reservation` (`reservation_id`, `room_id`,`roomtype_name`,`room_price`,`room_num`) VALUES ('$reservation_id', '$rooms','$room_name','$room_price','$room_num')";
        $result_room = mysqli_query($conn, $sql_room);
    }

    $sql_billing = "INSERT INTO `billing` (`billing_id`, `original_capital`) VALUES ('$billing_id', '$room_array->new_price')";
    $resul_billing = mysqli_query($conn, $sql_billing);
}
