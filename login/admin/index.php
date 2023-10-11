<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $pending = getSingleRow("COUNT(*) as total","sched_status","doctor_schedule","1");
  $reserved = getSingleRow("COUNT(*) as total","sched_status","doctor_schedule","2");
  $fulfilled = getSingleRow("COUNT(*) as total","sched_status","doctor_schedule","3");
  $unpaid = getSingleRow("COUNT(*) as total","paypal_status","doctor_schedule","0");

  $sched = $dbcon->query("SELECT * FROM doctor_schedule WHERE sched_status != '4' OR sched_status != '0'") or die(mysqli_error());
  $count = mysqli_num_rows($sched);

if(isset($_GET['create_schedule'])){
  $available_date = filter($_GET['available_date']);
  //$start_time = filter($_POST['start_time']);
  //$end_time = filter($_POST['end_time']);
  $user_id = filter($_GET['user_id']);

  $check = $dbcon->query("SELECT * FROM doctor_schedule WHERE available_date='$available_date' AND ID ='$user_id'") or die(mysqli_error());
  $j = mysqli_num_rows($check);
  
  if($j > 0){
    echo '<script>alert("Data you enter already exist. Please try other schedule");window.location = "index.php";</script>';
  }else{
    
    $insert = array(
      "ID"            =>$user_id,
      //"start_time"    =>$start_time,
      //"end_time"      =>$end_time,
      "available_date"=>$available_date
    );
    SaveData("doctor_schedule",$insert);
    echo "<script>alert('You have successfully created a schedule.'); window.location = 'index.php';</script>";
  }
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
        <h1>Welcome! <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?></h1><hr>
        <?php if(isset($msg)): echo $msg; endif;?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row" style="background:white; padding:10px;">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $pending['total']?></h3>

                <p>Pending</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $reserved['total']?></h3>

                <p>Reserved</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $fulfilled['total'];?></h3>

                <p>Fulfilled</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $unpaid['total'];?></h3>

                <p>Unpaid</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <hr>
<div class="row">
  <div class="col-md-8">
              <h4 style="border-bottom:1px solid #a59c9c;width:100%; padding-bottom: 10px;"><i class="fa fa-calendar-o"></i> Schedule 
<!--
            <a href="" data-toggle="modal" data-target="#my-schedule" class="btn btn-success"><i class="fa fa-plus"></i> Create Schedule</a>
--></h4>

          <div id="calendar"></div>
  </div>
  <div class="col-md-4" >
     <h4 style="border-bottom:1px solid #a59c9c;width:100%; padding-bottom: 10px;"><i class="fa fa-calendar"></i> Calendar Legend 
</h4>
    <div class="card card-primary">
              <div class="card-header" style="background:rgb(184, 90, 233);">
                <h3 class="card-title" ><i class="fa fa-bell"></i> Appointment Today</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
  <?php 
  $query = 'SELECT *, doctor_schedule.ID as doctor_id FROM doctor_schedule 
  LEFT JOIN accounts on accounts.ID = doctor_schedule.ID 
  INNER JOIN services on services.service_id = doctor_schedule.service_id
  WHERE sched_status = "2" AND available_date = "'.date("Y-m-d").'"
  GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
  <?php 
  foreach ($g as $key => $value):
    $getCustomer = getSingleRow("*","ID","accounts",$value->customer_id);
  ?>
                  <div class="callout callout-danger">
                  <h5 style="font-size:16px;"><?php echo $value->available_date?> / <?php echo date("h:i a",strtotime($value->start_time));?> - <?php echo date("h:i a",strtotime($value->end_time));?></h5>

                  <p>Customer Name: <?php echo $getCustomer['FirstName']?> <?php echo $getCustomer['MiddleName']?> <?php echo $getCustomer['LastName']?></p>
                  <p>Doctor Incharge: <?php if($value->doctor_id == '0'):?>
          No Doctor Requested
        <?php else:?>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
        <?php endif;?></p>
        <a href="appointment.php?ds_id=9" style="color:red;">Click here</a>
                </div>
  <?php
  endforeach;
  ?>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
              </div>
              <!-- /.card-body -->
            </div>
  <div class="card card-primary">
              <div class="card-header" style="background:rgb(184, 90, 233);">
                <h3 class="card-title"><i class="fa fa-calendar"></i> Calendar Legend</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>Reserved</strong>
                <div style="background: red; height:20px; width:20px;"></div>
                <strong>Fulfilled</strong>
                <div style="background: green; height:20px; width:20px;"></div>              
              </div>
              <!-- /.card-body -->
            </div>
  </div>
</div>

        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<!-- Modals-->
     <div class="modal fade" id="my-schedule" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i> Create Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="get">
                <div class="row">
          <div class="col-md-12">
            <strong>Date:</strong><br>
            <input type="date" name="available_date" class="form-control" required min="<?php echo date("Y-m-d");?>">
          </div>

        </div><br>
        <!--
        <div class="row">
          <div class="col-md-12">
            <strong>Start Time:</strong><br>
            <input type="time" name="start_time" class="form-control" required>
          </div>

        </div><br>
        <div class="row">
        <div class="col-md-12">
            <strong>End Time:</strong><br>
            <input type="time" name="end_time" class="form-control" required>
          </div>
        </div>
        <br>
      -->
        <div class="row">
        <div class="col-md-12">
            <strong>Doctor Name:</strong><br>
            
            <select class="form-control" name="user_id">
              <?php 
              $query = "SELECT * FROM accounts WHERE UserRole = '1' AND UserStatus = '1'";
              $user = SQLJoin($query);
              ?>
              <?php if(!empty($user)):?>
                <?php foreach ($user as $key => $value):?>
                  <option value="<?php echo $value->ID?>"><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?></option>
                <?php endforeach;?>
              <?php else:?>
                <option>No Value</option>
              <?php endif;?>
            </select>
          </div>
        </div>
        <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button class="btn btn-primary" name="create_schedule"><i class="fa fa-save"></i> Create Schedule</button>
            
          </div>
          <div class="col-3">
            
          </div>
          <!-- /.col -->
        </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
<!-- End of Modal -->
<?php include'../assets/footer.php';?>
<script type="text/javascript">
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        defaultView: 'month',
        events: {
            url: 'getEvent-admin.php',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching events.');
            }
           
        }

    });
});
</script>

</body>
</html>
