<?php
include 'config/db.php';
include 'config/functions.php';
include 'config/main_function.php';
require'src/Clockwork.php';
require'src/ClockworkException.php';

$approved = $dbcon->query("SELECT *, doctor_schedule.ID as DocID FROM doctor_schedule INNER JOIN accounts on accounts.ID = doctor_schedule.customer_id WHERE sched_status = '2' AND sms_notif = '0'") or die(mysqli_error());
$row = $approved->fetch_assoc();
    
    
   $getDoctor = getSingleRow("*","ID","accounts", $row['DocID']);  
   
    try
                {
                    // Create a Clockwork object using your API key
                    $API_KEY = 'c283edc4e035db0790957fb41a08ed0a3e4f11cf';
                    $clockwork = new mediaburst\ClockworkSMS\Clockwork( $API_KEY );

                    // Setup and send a message
                    $message = array( 'to' => $row['ContactNumber'], 'message' => 'Greetings! This is Jancen Cosmetic and Aesthetic Center. Please be informed that your appointment with Dr. '.$getDoctor['FirstName'].' '.$getDoctor['LastName'].' is on '.$row['available_date'].'. Thank you');
                    $result = $clockwork->send( $message );

                    // Check if the send was successful
                    if($result['success']) {
                        $update = $dbcon->query("UPDATE doctor_schedule SET sms_notif = '1' WHERE ds_id = '".$row['ds_id']."'") or die(mysqli_error()); 
                    } else {
                        echo '';
                    }
                }
                catch (mediaburst\ClockworkSMS\ClockworkException $e)
                {
                    echo 'Exception sending SMS: ' . $e->getMessage();
                }
   
   
   /*
   $subject = "Jancen Cosmetics Website Registration";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: admin@jancen-cosmetics.com" . "\r\n";
  $to = ''.$row['UserName'].'';
  
  $message = 'Greetings! This is Jancen Cosmetic and Aesthetic Center. Please be informed that your appointment with Dr. '.$getDoctor['FirstName'].' '.$getDoctor['LastName'].' is on '.$row['available_date'].' '.$row['ContactNumber'].'. Thank you, Dear Clients!';
  $mailme = mail($to,$subject,$message,$headers);
  */
  
   /*
  
    */
    
   
    //$update = $dbcon->query("UPDATE doctor_schedule SET sms_notif = '1' WHERE ds_id = '".$row['ds_id']."'") or die(mysqli_error()); 



   

  




?>
