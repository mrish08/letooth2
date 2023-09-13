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
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
<?php include'../assets/nav.php';?>
<?php include'../assets/sidebar.php'?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row" style="background:white; padding:10px;">
        <h3><i class="fa fa-calendar-o"></i> Schedule Report</h3>
        <hr>
<div class="col-lg-12">
<form method="post">
<div class="row">
  <div class="col-md-4">
    <strong>From:</strong>
    <input type="date" name="from" class="form-control" value="<?php if(isset($_POST['search_data'])): echo $_POST['from']; endif;?>">
  </div>
  <div class="col-md-4">
     <strong>Until:</strong>
     <input type="date" name="until" class="form-control" value="<?php if(isset($_POST['search_data'])): echo $_POST['until']; endif;?>">
  </div>
  <div class="col-md-4">
     <strong>Status:</strong>
     <select class="form-control" name="sched_status">
       <option value="0">Available</option>
       <option value="2">Approved</option>
       <option value="3">Fulfilled</option>
     </select>
  </div>
  <div class="col-md-4">
    <br>
    <button class="btn btn-info" name="search_data"><i class="fa fa-search"></i> Search</button>
  </div>
</div>
</form>
<hr>
<?php 
if(isset($_POST['search_data'])):
  $from = filter($_POST['from']);
  $until = filter($_POST['until']);

  $kweri = "SELECT * FROM doctor_schedule 
  LEFT JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  INNER JOIN services on services.service_id = doctor_schedule.service_id
  WHERE available_date BETWEEN '$from' AND '$until' AND sched_status = '".$_POST['sched_status']."'";
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
        <?php echo $value->service_name; ?> / <?php echo number_format($value->service_price,2); ?>
      </td>
      <td>
        <?php if(Empty($value->FirstName)):?>
          No Customer appointment
        <?php else:?>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
        <?php endif;?>
      </td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Done Transaction'; endif; ?>
      </td>
      
    </tr>
    <?php endforeach;?>
  </table>
  <hr>
  <center><a href="print-sched.php?from=<?php echo $from;?>&until=<?php echo $until; ?>&sched_status=<?php echo $_POST['sched_status']?>" class="btn btn-danger">Print Preview</a></center>
  <?php else:?>
    <div class="alert alert-danger">No Records</div>
  <?php endif;?>
<?php endif;?>
</div>
          
      </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </div>
  </div>
<?php include'../assets/footer.php';?>
</body>
</html>
