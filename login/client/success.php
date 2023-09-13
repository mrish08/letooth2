<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }

  $item_no = $_GET['item_number'];
  $item_transaction = $_GET['tx'];
  $item_price = $_GET['amt'];
  $item_currency = $_GET['cc'];
  
  $getData = getSingleRow("*","invoice_num","doctor_schedule",$_GET['invoice_num']);
  $getUser = getSingleRow("*","ID","accounts",$getData['customer_id']);
  $getService = getSingleRow("*","service_id","services",$getData['service_id']);
  
  $update = $dbcon->query("UPDATE doctor_schedule SET paypal_status = '1' WHERE invoice_num = '".$_GET['invoice_num']."'") or die();
  $msg = 'Please be informed that '.$getUser['FirstName'].' '.$getUser['LastName'].' was already pay via paypal with the amount of '.$item_price.'.';
  $notif = array(
        "ds_id"         =>$getData['ds_id'],
        "notif_type"    =>"0",
        "notif_user"    =>"0",
        "notif_desc"    =>$msg,
        "notif_date"    =>date("Y-m-d h:i a")
      );
  SaveData("notifications",$notif);
  echo '<script>alert("You have successfully Paid the amount worth: '.$getService['service_price'].'");window.location="transactions.php";</script>';
?>