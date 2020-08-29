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
  $total_amount += $row['original_capital'];
}
$down_payment = $total_amount / 2;

if($payed_capital >= $down_payment && $payed_capital <= $total_amount){
    $sql = mysqli_query($conn, "INSERT INTO payment(billing_id,payed_capital,payment_date) 
VALUES ('$billing_id','$payed_capital','$payment_date')");
    $sql_update = mysqli_query($conn, "UPDATE reservation SET status = '4' WHERE billing_id ='$billing_id'");
echo json_encode('1');


$sql_guest = mysqli_query($conn, "SELECT *
FROM reservation rv
left join guest g on g.guest_id = rv.guest_id
where rv.billing_id = '$billing_id'");

$guest_name = "";
$guest_email = "";
$guest_phone = "";
$guest_address = "";
$num_guest = "";
$check_in = "";
$check_out = "";

    while ($row = mysqli_fetch_assoc($sql_guest)) {
        $guest_name = $row['first_name']." ".$row['last_name'];
        $guest_email = $row['email'];
        $guest_phone = $row['contact_number'];
        $guest_address = $row['addressline_1'].", ".$row['city'].", ".$row['zipcode'];
        $num_guest = $row['num_guest'];
        $check_in = $row['checkin_date'];
        $check_out = $row['checkout_date'];
        $reservation_date = $row['reservation_date'];
        $booking_reference = $row['booking_reference'];
        $reservation_id = $row['reservation_id'];
    }

$sql_rooms = mysqli_query($conn, "SELECT rr.roomtype_name as availed,
rr.room_price as rate,
count(case when rv.billing_id = '$billing_id' then rr.roomtype_name end) as qty,
SUM(rr.room_price) as total_amount
FROM reservation rv
left join room_reservation rr on rr.reservation_id = rv.reservation_id
where rv.billing_id = '$billing_id'
group by rr.roomtype_name,rr.room_price");


$array_rooms = array();
$room_rows = "";
    while ($row = mysqli_fetch_assoc($sql_rooms)) {
        array_push($array_rooms,$row);
    }

    foreach ($array_rooms as $rooms) {
        $room_rows .= '<tr style="text-align: center;">
        <td  style="padding:15px;">
          <p style="font-size:14px;margin:0;padding:0px;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;">' . $rooms->availed . '</span>
          </p>
        </td>
        <td  style="padding:15px;">
          <p style="font-size:14px;margin:0;padding:0px;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;">' . $rooms->rate . '</span>
          </p>
        </td>
        <td  style="padding:15px;">
          <p style="font-size:14px;margin:0;padding:0px;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;"></span>
          </p>
        </td>
        <td  style="padding:15px;">
          <p style="font-size:14px;margin:0;padding:0px;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;">' . $rooms->qty . '</span>
          </p>
        </td>
        <td  style="padding:15px;">
          <p style="font-size:14px;margin:0;padding:0px;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;">' . $rooms->total_amount . '</span>
          </p>
        </td>
  
      </tr>';
    }

    $vat = ($total_amount * 0.12);
    $vatable = $total_amount - $vat;

$email_body = '<html>
<style>
</style>
<body style="background-color:#ffffff;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width:670px;margin:50px auto 10px;background-color:#efefef;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px #ef7e24;     box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;">
    <thead>
      <tr>
        <th style="text-align:left;" colspan="4"><img style="max-width: 70px;" src="cid:logo_2u" ><strong> Fairfields Resort & Playhouse Inn.</strong></th>
        <th style="text-align:right;font-weight:400;">' . $reservation_date . '</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px; text-align: center; padding: 2rem; color:#28a745!important" colspan="5"><h2>YOUR BOOKING IS CONFIRMED!</h2></td>
      </tr>
      <tr>
        <td colspan="5" style="border: solid 1px #ddd; padding:10px 20px;">
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Status</span><b style="color:green;font-weight:normal;margin:0">Confirmed</b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Reservation ID</span> ' . $reservation_id . '</p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Booking Reference</span> ' . $booking_reference . '</p>
          
        </td>
      </tr>
      
      <tr>
        <td style="width:50%;padding:20px;vertical-align:top" colspan="3">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> ' . $guest_name. '</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> ' . $guest_email . '</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> ' . $guest_phone . '</p>
        </td>
        <td style="width:50%;padding:20px;vertical-align:top" colspan="2">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Address</span> ' .$guest_address. '</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Number of gusets</span> ' . $num_guest . '</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Duration of your vacation</span><div style="font-size: 17px; color:mediumblue; font-weight: bold;"><small>' . $check_in . '</small>  to <small>' . $check_out . '.</small></p>
        </td>
      </tr>
      <tr  >
        <th  style="font-size:14px; padding:10px; border-bottom: 3px solid #929090; border-top:3px solid #929090 ;">Availed</th>
        <th  style="font-size:14px; padding:10px; border-bottom: 3px solid #929090; border-top:3px solid #929090 ;">Rate</th>
        <th  style="font-size:14px; padding:10px; border-bottom: 3px solid #929090; border-top:3px solid #929090 ;">Night(s)</th>
        <th  style="font-size:14px; padding:10px; border-bottom: 3px solid #929090; border-top:3px solid #929090 ;">Qty</th>
        <th  style="font-size:14px; padding:10px; border-bottom: 3px solid #929090; border-top:3px solid #929090 ;">Total Amount</th>
      </tr>
     '.$room_rows.'
    </tbody>
    <tfooter>
      <tr style="text-align: center;">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px;"><b>Vatable Sales</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px;">
         Php ' . $vatable . '
        </td>
      </tr>
        <tr style="text-align: center;">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px;"><b>VAT (12%)</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px;">
         Php ' . $vat . '
        </td>
      </tr>
        <tr style="text-align: center; ">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px; /*border-bottom: 3px solid #929090;*/"><b>Subtotal</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px; /*border-bottom: 3px solid #929090;*/">
         Php ' . $total_amount . '
        </td>
      </tr>
      
        <!--<tr style="text-align: center;">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px;"><b>Payed Amount</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px;">
         Php 5,000.00
        </td>
      </tr> 
        <tr style="text-align: center;">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px;"><b>Balance</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px;">
         Php 5,000.00
        </td>
      </tr>-->

      <tr>
          <td style="height: 1rem;"></td>
      </tr>
       <tr style="text-align: center;  ">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px; /*border-bottom: 3px solid #929090;*/ color:navy"><b>Payed Amount</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px; /*border-bottom: 3px solid #929090;*/color:navy">
         Php ' . $payed_capital . '
        </td>
      </tr>
       <tr style="text-align: center;  ">
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size:14px;padding:10px 15px 0 15px; /*border-bottom: 3px solid #929090;*/ color:navy"><b>Balance</b></td>
        <td colspan="1" style="font-size:14px;padding:10px 15px 0 15px; /*border-bottom: 3px solid #929090;*/color:navy">
         Php ' . $total_amount - $payed_capital . '
        </td>
      </tr>
    </tfooter>
    <tr>
        <td style="height: 3rem;"></td>
    </tr>
    
    <tr>
        <td colspan="5" style="color: #6b6b6b;">*This is auto generated email, Do not reply.</td>
       
    </tr>
  </table>
</body>

</html>';


    require("email/PHPMailer-master/src/PHPMailer.php");
    require("email/PHPMailer-master/src/SMTP.php");
    require("email/PHPMailer-master/src/Exception.php");


    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();

    $mail->CharSet = "UTF-8";
    $mail->Host = "sg3plcpnl0031.prod.sin3.secureserver.net";
    //$mail->SMTPAutoTLS = false; 
    $mail->SMTPDebug = 1;
    $mail->Port = 25; //465 or 587

    $mail->SMTPSecure = 'tsl';
    $mail->SMTPAuth = true;
    $mail->IsHTML(true);

    //Authentication
    $mail->Username = "desk.resort@fairfieldsresort.com";
    $mail->Password = "Fa2425dS";

    //Set Params
    $mail->AddEmbeddedImage('../../../img/icon.png', 'logo_2u');

    $mail->SetFrom("desk.resort@fairfieldsresort.com", "FairFields Resort & Playhouse Inn");
    $mail->AddAddress($guest_email);
    $mail->AddCC("desk.resort@fairfieldsresort.com");
    $mail->Subject = "Booking Confirmation | Fairfields Resort & Playhouse Inn";
    $mail->Body = $email_body;



    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message has been sent";
    }


}elseif($payed_capital > $total_amount){
    echo json_encode('2');
}else{

    echo json_encode('0');
}
