<?php
include '../../config/functions.php';
include '../../config/main_function.php';


if(isset($_POST["asset_id"]))
{
    $output = '';

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

        $output .= '
            <tr><td><strong>Name of Equipment</strong></td><td>'.$row['ASSET_NAME'].'</td></tr>
            <tr><td><strong>Description</strong><td>'.$row['ASSET_DESC'].'</td></tr>
            <tr><td><strong>Quantity</strong><td>'.$row['ASSET_QUANTITY'].'</td></tr>
        ';
    }


    echo $output;

}
else {
    $output = 'wew';

    echo $output;
}
?>
