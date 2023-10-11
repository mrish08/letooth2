<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';

  require __DIR__ . '/../../vendor/autoload.php';

  use Twilio\Rest\Client;

  $sid = "ACc0bcfbfb05c34c103b0d842d7f9f0ea5";
  $token = "3a49c19d7af65b5de4b101d88d12e8b9";
  $client = new Twilio\Rest\Client($sid, $token);

  $invoiceNum = $_GET['invoice_num'];
  
  $getData = getSingleRow("*","invoice_num","doctor_schedule",$_GET['invoice_num']);
  $getUser = getSingleRow("*","ID","accounts",$getData['customer_id']);
  $getService = getSingleRow("*","service_id","services",$getData['service_id']);

  $formattedPhoneNumber = '+63' . substr($getUser['ContactNumber'], 1); // Adding the country code '63'

  $message = $client->messages->create(
    // Phone number ni user
    $formattedPhoneNumber, 
    [
        // Twilio phone number
        'from' => '+16144524962',
        // Body of text message
        'body' => "Hello," . $getUser['FirstName'] . $getUser['LastName']."! Payment for your appoinment to Letooth Dental Clinic has been completed. Invoice Num: " . $_GET['invoice_num'] 
    ]
);

  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  
  $update = $dbcon->query("UPDATE doctor_schedule SET paypal_status = '1' WHERE invoice_num = '".$_GET['invoice_num']."'") or die();
  $msg = 'Please be informed that '.$getUser['FirstName'].' '.$getUser['LastName'].' was already pay via paypal with the amount of '.$getService['service_price'].'.';
  $notif = array(
        "ds_id"         =>$getData['ds_id'],
        "notif_type"    =>"0",
        "notif_user"    =>"0",
        "notif_desc"    =>$msg,
        "notif_date"    =>date("Y-m-d h:i a"),
        "notif_status"  =>'0'
      );
  SaveData("notifications",$notif);
  echo '<script>alert("You have successfully Paid the amount worth: '.$getService['service_price'].'");</script>';
  
  echo '<script>alert("Text confirmation has been sent");window.location="transactions.php";</script>';

?>