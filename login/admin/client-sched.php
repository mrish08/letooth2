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
	<img src="../../images/277855546_399124208329516_5361779838833002494_n.png" width="200">
	<h1>Schedule Report</h1>
</center>
<?php 
$getInfo = getSingleRow("*","ID","accounts",$_GET['ID']);
?>
<form method="post">
                <div class="row">
          <div class="col-md-6">
            <strong>Username:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['UserName'];?></p>
          </div>
          <div class="col-md-6">
            <strong>Email Address:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['EmailAddress']; ?>
          </div>
          
        </div>
        <div class="row">
          <div class="col-md-6">
            <strong>First Name:</strong><br>
             <p style="font-size:25px;"><?php echo $getInfo['FirstName'];?></p>
          </div>
          <div class="col-md-6">
            <strong>Middle Name:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['MiddleName']; ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <strong>Last Name:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['LastName']; ?></p>
          </div>
          <div class="col-md-6">
            <strong>Contact Number:</strong><br>
           <p style="font-size:25px;"><?php echo $getInfo['ContactNumber']; ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <strong>Permanent Address:</strong><br>
            <p style="font-size:25px;"><?php  echo $getInfo['PermanentAddress']; ?></p>
          </div>
          <div class="col-md-6">
          
          </div>
        </div>
                <div class="row">
          <div class="col-md-6">
            <strong>Age:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['user_age']; ?></p>
          </div>
          <div class="col-md-6">
            <strong>Birthday:</strong><br>
             <p style="font-size:25px;"><?php echo $getInfo['bday']; ?></p>
          </div>
        </div>
                <div class="row">
          <div class="col-md-6">
            <strong>Gender:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['sex']; ?></p>
          </div>
          <div class="col-md-6">
            <strong>Civil Status:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['civil_status']; ?></p>
          </div>
        </div>
                <div class="row">
          <div class="col-md-6">
            <strong>Occupation:</strong><br>
            <p style="font-size:25px;"><?php echo $getInfo['occupation']; ?></p>
          </div>
          <div class="col-md-6">
            
          </div>
        </div>
        

                </form>
<?php 
  $kweri = "SELECT * FROM doctor_schedule 
  LEFT JOIN accounts on accounts.ID = doctor_schedule.customer_id
  INNER JOIN services on services.service_id = doctor_schedule.service_id 
  WHERE doctor_schedule.customer_id = '".$_GET['ID']."'";
  $view = SQLJoin($kweri);
?>
  <?php if(!empty($view)):?>
    <table id="example2" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Date Requested</th>
          <th>Service Type</th>
          <th>Remarks</th>
          <th>Status</th>          
        </tr>
      </thead>
    <tbody>
    <?php foreach ($view as $key => $value):?>
      <tr>
      <td><?php echo $value->available_date?> <?php echo $value->ds_id?> <?php echo $value->customer_id?></td>
      <td>
        <?php echo $value->service_name; ?> / <?php echo number_format($value->service_price,2); ?>
      </td>
      <td>
        <?php echo $value->sched_desc; ?>
      </td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Fulfilled'; endif; ?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>
  <center>
  	<a href="" class="btn btn-primary" id="printPageButton" onClick="window.print();">Print Preview</a>
  	<a href="per-client.php" class="btn btn-danger" id="printPageButton">Return</a>
  </center>
  <?php else:?>
    <div class="alert alert-danger">No Records</div>
  <?php endif;?>
	</div>
</body>