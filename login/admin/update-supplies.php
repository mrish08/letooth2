<?php
include '../../config/functions.php';
include '../../config/main_function.php';


if(isset($_POST["asset_id"]))
{

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "letooth";
    
    $dbcon = new mysqli($db_server, $db_user, $db_pass, $db_name);
    
    if ($dbcon->connect_error) {
        die("Connection failed: " . $dbcon->connect_error);
    }

    $query = "SELECT * FROM asset WHERE ASSET_ID = '".$_POST["asset_id"]."'";
    $result = mysqli_query($dbcon, $query);

    while($row = mysqli_fetch_array($result))
    {
        $imageData = base64_encode($row['ASSET_PICTURE']);
        $src = 'data:image/jpeg;base64,' . $imageData;

        $output = '
        <div class="d-flex flex-column align-items-center">
        <img src="' . $src . '" alt="Asset Image" width="100" height="100">
        <p class="text-bold">'.$row['ASSET_NAME'].'</p>
        </div>
        <div class="mb-3">
        <label for="updateSupplyQty">Quantity</label>
        <input type="hidden" id="updateSupplyId" value="'.$row['ASSET_ID'].'">
        <input class="form-control" type="number" name="updateSupplyQty" id="updateSupplyQty" value="'.$row['ASSET_QUANTITY'].'">
        </div>
        ';

    }

    echo $output;
}