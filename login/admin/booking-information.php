<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $doctor= fetchWhere("*","UserRole","accounts","1");
  $services = fetchAll("*","services");

  $getAppointment = getSingleRow("*","ds_id","doctor_schedule",$_GET['ds_id']);
  if(isset($_POST['update_btn'])){
    $start_time = filter($_POST['from']);
    $end_time = filter($_POST['until']);
    $doctor_id = filter($_POST['doctor_id']);
    $available_date = filter($_POST['available_date']);

    $check = $dbcon->query("SELECT * FROM doctor_schedule WHERE ID = '$doctor_id' AND available_date = '$available_date' AND (start_time < '$start_time' AND end_time > '$end_time')") or die(mysqli_error());

    if(mysqli_num_rows($check) > 0){
      echo '<script>alert("Schedule between'.$from.' - '.$until.' on '.$available_date.' already exist.");window.location="book.php";</script>';
    }else{

      $arr_where = array("ds_id"=>$_GET['ds_id']);//update where
      $arr_set = array(
        "start_time"      =>$start_time,
        "end_time"        =>$end_time,
        "ID"              =>$doctor_id,
        "sched_status"    =>"2"
      );//set update
      $tbl_name = "doctor_schedule";
      $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);

      $msg = 'Please be informed that your appointment to this date: '.$available_date.': From: '.date("h:i a",strtotime($start_time)).' - '.date("h:i a",strtotime($end_time)).' already approved by our staff.';

      $msg2 = 'Please be informed that you have an appointment set by our staff on  this date: '.$available_date.': From: '.date("h:i a",strtotime($start_time)).' - '.date("h:i a",strtotime($end_time)).'';

      $notif1 = array(
        "ds_id"             =>$_GET['ds_id'],
        "notif_status"      =>"0",
        "notif_type"        =>"2",
        "notif_user"        =>$getAppointment['customer_id'],
        "notif_desc"        =>$msg,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      $notif2 = array(
        "ds_id"             =>$_GET['ds_id'],
        "notif_status"      =>"0",
        "notif_type"        =>"1",
        "notif_user"        =>$doctor_id,
        "notif_desc"        =>$msg2,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      SaveData("notifications",$notif1);
      SaveData("notifications",$notif2);   

      echo '<script>alert("You have successfully confirm the time of the doctor.");window.location="index.php";</script>'; 
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
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Appointment Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Appointment Appointment</li>
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
<?php if($getAppointment['sched_status'] == '1'):?>
  <div class="alert alert-primary">PENDING FOR APPROVAL</div>
<?php elseif($getAppointment['sched_status'] == '2'):?>
  <div class="alert alert-danger">RESERVED</div>
<?php elseif($getAppointment['sched_status'] == '3'):?>
  <div class="alert alert-success">PAID: Fulfilled</div>
<?php endif;?>
 <form method="post">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Available Date:</strong>
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="available_date" class="form-control" required min="<?php echo date("Y-m-d");?>" value="<?php echo $getAppointment['available_date']?>" readonly>
                  </div>
                  <div class="col-md-3">
                    <strong>Services:</strong>
                  </div>
                  <div class="col-md-3">
                    <?php if(!empty($services)):?>
                      <select class="form-control" name="service_id" readonly>
                      <?php foreach ($services as $key => $value):?>
                        <option value="<?php echo $value->service_id?>" <?php if($_GET['ds_id']){
                          if($value->service_id == $getAppointment['service_id']){
                            echo 'selected';
                          }
                        }?>><?php echo $value->service_name?> - <?php echo number_format($value->service_price,2)?></option>
                      <?php endforeach;?>
                      </select>
                    <?php endif;?>
                  </div>
                </div>
                <p></p>
                <div class="row">
                  <div class="col-md-3">
                    <strong>From:</strong>
                  </div>
                  <div class="col-md-3">
                    <input type="time" name="from" class="form-control" required min="08:00" max="09:00" value="<?php echo $getAppointment['start_time']?>">
                  </div>
                  <div class="col-md-3">
                    <strong>Until:</strong>
                  </div>
                  <div class="col-md-3">
                    <input type="time" name="until" class="form-control" required min="09:00" max="17:00" value="<?php echo $getAppointment['end_time']?>">
                  </div>
                </div>
                <p></p>
                <div class="row">
                  <div class="col-md-3">
                    <strong>Decription:</strong>
                  </div>
                  <div class="col-md-3">
                    <textarea class="form-control" name="sched_desc" placeholder="Description" readonly><?php echo $getAppointment['sched_desc']?></textarea>
                  </div>
                  <div class="col-md-3">
                   <strong>
                    <?php if($getAppointment['ID'] == '0'):?>
                      Assign Doctor:
                    <?php else:?>
                      Request Doctor (Optional):
                    <?php endif;?>
                   </strong>
                  </div>
                  <div class="col-md-3">
                  <?php if($getAppointment['ID'] == '0'):?>
                     <?php if(!empty($doctor)):?>
                      <select class="form-control" name="doctor_id">
                        <?php foreach ($doctor as $key => $value):?>
                        <option value="<?php echo $value->ID?>"><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?></option>
                      <?php endforeach;?>
                      </select>
                    <?php endif;?>
                  <?php else:?>
                    <?php if(!empty($doctor)):?>
                      <select class="form-control" name="doctor_id" readonly>
                      <?php foreach ($doctor as $key => $value):?>
                        <option value="<?php echo $value->ID?>" <?php if($_GET['ds_id']){
                          if($value->ID == $getAppointment['ID']){
                            echo 'selected';
                          }
                        }?>><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?></option>
                      <?php endforeach;?>
                      </select>
                    <?php endif;?>
                  <?php endif;?>
                  </div>
                </div>
                <br>
                <center>
                  <button class="btn btn-info" name="update_btn"><i class="fa fa-pencil"></i> Update Appointment</button>
                  <a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                </center>
</form>
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
