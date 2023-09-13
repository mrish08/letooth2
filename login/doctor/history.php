<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
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
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="fa fa-th"></i> History </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
          <?php 
  $query = 'SELECT * FROM doctor_schedule 
  INNER JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  WHERE doctor_schedule.ID = "'.$_SESSION['ID'].'" AND sched_status = "3"
  GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Date Requested</th>
          <th>Service Type</th>
          <th>Customer</th>
          <th>Status</th>
          <th>Action</th>
          
        </tr>
      </thead>
    <tbody>
  <?php foreach ($g as $key => $value):?>
    <tr>
      <td><?php echo $value->available_date?></td>
      <td>
        <?php 
        $query = "SELECT * FROM services WHERE service_id = '".$value->service_id."'";
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
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
      </td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Fulfilled'; endif; ?>
      </td>
      <td>
        <a href="view-billing.php?ds_id=<?php echo $value->ds_id?>" class="btn btn-info btn-sm"><i class="fa fa-file"></i> View History</a>
      </td>
    </tr>
  
  <?php endforeach;?>
</tbody>
</table>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>        
              </div>
            </div>


          </div>
          <!-- /.col-md-6 -->

          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>
</body>
</html>
