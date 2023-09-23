<?php
include '../../config/functions.php';
include '../../config/main_function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $id = $_POST['updateEquipmentQty'];
    $newQty = $_POST['updateAssetId'];

    header("Location: success.php");
}
else 
{
    header("Location: fail.php");
}