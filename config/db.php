<?php
ob_start();
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);    
date_default_timezone_set('Asia/Manila');

$db_server = "localhost"; // server 127.0.0.1
$db_user = "root"; // studycal
$db_pass = "";// h88a6Z6eMt
$db_name = "letooth"; //studycal_letooth

$dbcon = new mysqli($db_server,$db_user,$db_pass,$db_name);
if ($dbcon->connect_error) 
{
    die("Connection failed: " . $dbcon->connect_error);
}
$checkout_cancel = 'http://letooth.study-call.ph/login/client/transaction.php';
$checkout_success = 'http://letooth.study-call.ph/login/client/success.php?payment_option=';
?>
