<?php
include '../../config/functions.php';
include '../../config/main_function.php';

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "letooth";

$dbcon = new mysqli($db_server, $db_user, $db_pass, $db_name);

if ($dbcon->connect_error) {
    die("Connection failed: " . $dbcon->connect_error);
}

// Assuming you have the image data as a file upload
$picture = addslashes(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
$name = $_POST["name"];
$desc = $_POST["desc"];
$qty = $_POST["qty"];


// Prepare the SQL statement with placeholders
$query = "INSERT INTO asset (ASSET_PICTURE, ASSET_NAME, ASSET_DESC, ASSET_QUANTITY, ASSET_TYPE) VALUES (?, ?, ?, ?, 1)";

// Create a prepared statement
$stmt = $dbcon->prepare($query);

if (!$stmt) {
    die("Prepared statement failed: " . $dbcon->error);
}

// Bind the variables to the placeholders
$stmt->bind_param("bssi", $picture, $name, $desc, $qty);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Record inserted successfully.";
    echo $picture;
} else {
    echo "Error: " . $stmt->error;
    echo $picture;
}

// Close the prepared statement and database connection
$stmt->close();


    
