<?php
include '../../config/functions.php';
include '../../config/main_function.php';

    // Retrieve the data sent via AJAX
    $newName = $_POST["newName"];
    $newQty = $_POST["newQty"];
    $suppId = $_POST["suppliesId"];
    

    // Perform your processing here, e.g., update the database
    // Example: Update the equipment quantity in a hypothetical database
    // Replace this with your actual database update code
    $success = updateSuppliesQuantity($suppId, $newQty, $newName);

    // Prepare a response
    if ($success) {
        echo "Supplies details updated successfully";
    } else {
        echo "Failed to update supplies details.";
    }

// Replace this function with your actual database update code
function updateSuppliesQuantity($suppId, $newQty, $newName) {

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "letooth";

    $dbcon = new mysqli($db_server, $db_user, $db_pass, $db_name);

    if ($dbcon->connect_error) {
        die("Connection failed: " . $dbcon->connect_error);
    }

    $query = "UPDATE asset SET ASSET_QUANTITY = '".$newQty."', ASSET_NAME = '".$newName."' WHERE ASSET_ID = '".$suppId."'";
    $result = mysqli_query($dbcon, $query);

    return true;
}