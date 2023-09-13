<?php 
include'../../config/db.php';
include'../../config/functions.php';
include'../../config/main_function.php';
        $result = $dbcon->query("SELECT * FROM doctor_schedule 
            INNER JOIN accounts on accounts.ID = doctor_schedule.ID 
            WHERE customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());
        $events = array();
        /*SELECT * FROM doctor_schedule 
            INNER JOIN accounts on accounts.ID = doctor_schedule.ID 
            WHERE (sched_status='1' OR sched_status = '2' OR sched_status = '0') AND customer_id = '17'
        */
        while ($row = $result->fetch_array()) {
            
            if($row['sched_status'] == '0'){
                $availability = $row['FirstName']." ".$row['LastName'];
                $mycolor = 'blue';
            }elseif($row['sched_status'] == '1'){
                $availability = 'Pending';
                $mycolor = 'blue';
            }elseif($row['sched_status'] == '2'){
                $availability = 'Approved';
                $mycolor = 'green';
            }elseif($row['sched_status'] == '3'){
                $availability = 'Fulfilled';
                $mycolor = 'green';
            }elseif($row['sched_status'] == '4'){
                $availability = 'Cancelled';
                $mycolor = 'red';
            }
            
            $e = array();
            $e['id'] = "";
            $e['title'] = $availability;
            $e['start'] = $row['available_date'];
            $e['end'] = "";
            $e['color'] = $mycolor;
            $e['url'] = 'view-billing.php?ds_id='.$row['ds_id'].'';
            //$e['allDay'] = false;

        // Merge the event array into the return array
        array_push($events, $e);
        }
    echo json_encode($events);

?>