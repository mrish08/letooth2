<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
 
?>

<?php include'../assets/header.php';?>
<style type="text/css">
	@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<body>
	<div class="container">
<center>
	<img src="../../images/22552571_731008620426935_7850773402246720261_n.jpg" width="200">
	<h1>Schedule Report</h1>
</center>
		<?php 
  $from = filter($_GET['from']);
  $until = filter($_GET['until']);

  $kweri = "SELECT * FROM doctor_schedule 
  LEFT JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  WHERE available_date BETWEEN '$from' AND '$until' AND sched_status = '".$_GET['sched_status']."'";
  $view = SQLJoin($kweri);
?>
  <?php if(!empty($view)):?>
    <table id="example2" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Date Requested</th>
          <th>Service Type</th>
          <th>Customer</th>
          <th>Status</th>          
        </tr>
      </thead>
    <tbody>
    <?php foreach ($view as $key => $value):?>
      <tr>
      <td><?php echo $value->available_date?></td>
      <td>
        <?php 
        $query = "SELECT * FROM reservation INNER JOIN services on services.service_id = reservation.service_id WHERE ds_id = '".$value->ds_id."' AND customer_id = '".$value->customer_id."'";
        $getService = SQLJoin($query);
        if( !empty($getService)){
          foreach ($getService as $key => $row) {
            echo '<span style="background:#e26c78; color:white;padding:5px;">'.$row->service_name.'</span> &nbsp;';
          }
        }else{  
          echo 'Empty';
        }
        ?>
      </td>
      <td>
        <?php if(Empty($value->FirstName)):?>
          No Customer appointment
        <?php else:?>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
        <?php endif;?>
      </td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Fulfilled'; endif; ?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>
  <center>
  	<a href="" class="btn btn-primary" id="printPageButton" onClick="window.print();">Print Preview</a>
  	<a href="approve-schedule.php" class="btn btn-danger" id="printPageButton">Return</a>
  </center>
  <?php else:?>
    <div class="alert alert-danger">No Records</div>
  <?php endif;?>
	</div>
</body>