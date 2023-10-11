<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  

?>
<?php include'../assets/header.php';?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
<?php include'../assets/nav.php';?>
<?php include'../assets/sidebar.php'?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approved Appointment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Approved Appointment</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">

              <div class="card-body">
 <?php 
  $query = 'SELECT *, doctor_schedule.ID as doctor_id FROM doctor_schedule 
  LEFT JOIN accounts on accounts.ID = doctor_schedule.ID 
  INNER JOIN services on services.service_id = doctor_schedule.service_id
  WHERE sched_status = "2"
  GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
  <div class="table-responsive">
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Date / Time Requested</th>
          <th>Customer Name</th>
          <th>Service Type</th>
          <th>Dentist Incharge</th>
          <th>Status</th>
          <th>Action</th>
          
        </tr>
      </thead>
    <tbody>
  <?php 
  foreach ($g as $key => $value):
    $getCustomer = getSingleRow("*","ID","accounts",$value->customer_id);
  ?>
    <tr>
      <td><?php echo $value->available_date?> / <?php echo date("h:i a",strtotime($value->start_time));?> - <?php echo date("h:i a",strtotime($value->end_time));?></td>
      <td>
        <?php echo $getCustomer['FirstName']?> <?php echo $getCustomer['MiddleName']?> <?php echo $getCustomer['LastName']?>
      </td>
      <td>
       <?php echo $value->service_name?> - <?php echo number_format($value->service_price,2);?>
      </td>
      <td>
        <?php if($value->doctor_id == '0'):?>
          No Dentist Requested
        <?php else:?>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
        <?php endif;?>

      </td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Fulfilled'; endif; ?>
      </td>
      <td>
        <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">
   <li><a href="booking-information.php?ds_id=<?php echo $value->ds_id?>"><i class="fa fa-pencil"></i> View Details</a></li>
   <!--
   <li>
         <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'customer.php?delete='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Delete</a>
      </li>
    -->
                     


                    </ul>
                  </div>
      </td>
    </tr>
  <!-- Modals-->
     
  <?php endforeach;?>
</tbody>
</table>
</div>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->


  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>

</body>
</html>
