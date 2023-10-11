<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $services = fetchAll("*","services");
  
  if(isset($_POST['save_btn'])){
    $available_date = filter($_POST['available_date']);
    $from = filter($_POST['from']);
    $until = filter($_POST['until']);
    $sched_desc = $_POST['sched_desc'];
    $doctor_id = filter($_POST['doctor_id']);
    $service_id = filter($_POST['service_id']);

    $check = $dbcon->query("SELECT * FROM doctor_schedule WHERE ID = '$doctor_id' AND available_date = '$available_date' AND (start_time < '$from' AND end_time > '$until')") or die(mysqli_error());
    
    $check2 = $dbcon->query("SELECT * FROM doctor_schedule WHERE ID = '$doctor_id' AND available_date = '$available_date' AND start_time = '$from' AND end_time = '$until'") or die(mysqli_error());

    if(mysqli_num_rows($check) > 0){
      echo '<script>alert("Schedule between'.date("h:i a",strtotime($from)).' - '.date("h:i a",strtotime($until)).' on '.$available_date.' already exists.");window.location="book.php";</script>';
    }elseif(mysqli_num_rows($check2) > 0){
      echo '<script>alert("Schedule between'.date("h:i a",strtotime($from)).' - '.date("h:i a",strtotime($until)).' on '.$available_date.' already exists.");window.location="book.php";</script>';
    }else{
      $insertSQL = array(
        "available_date"    =>$available_date,
        "start_time"        =>$from,
        "end_time"          =>$until,
        "sched_desc"        =>$sched_desc,
        "ID"                =>$doctor_id,
        "customer_id"       =>$_SESSION['ID'],
        "sched_status"      =>"1",
        "service_id"        =>$service_id,
        "invoice_num"       =>rand(0,10000),
        "paypal_status"     =>"0"
      );
      SaveData("doctor_schedule",$insertSQL);
      $ID = mysqli_insert_id($dbcon);
      $msg = 'Please be informed that there is a client book appointment to this date: '.$available_date.': From: '.date("h:i a",strtotime($from)).' - '.date("h:i a",strtotime($until)).'';
      $notification = array(
        "ds_id"             =>$ID,
        "notif_status"      =>"0",
        "notif_type"        =>"0",
        "notif_user"        =>"0",
        "notif_desc"        =>$msg,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      SaveData("notifications",$notification);
      

      echo '<script>alert("You have successfully book a reservation. Please wait for the confirmation");window.location="index.php";</script>';
    }
  }
  $doctor= fetchWhere("*","UserRole","accounts","1");
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
            <h1>Book an Appointment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Book an Appointment</li>
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
<form method="post">
                <div class="row">
                  <div class="col-md-3">
                    <strong>Appointment Date:</strong>
                  </div>
                  <div class="col-md-3">
                    <input type="date" name="available_date" class="form-control" required min="<?php echo date("Y-m-d");?>" value="<?php if(isset($_POST['save_btn'])): echo $_POST['available_date']; endif;?>" onkeydown="return false">
                  </div>
                  <div class="col-md-3">
                    <strong>Services:</strong>
                  </div>
                  <div class="col-md-3">
                    <?php if(!empty($services)):?>
                      <select class="form-control" name="service_id">
                      <?php foreach ($services as $key => $value):?>
                        <option value="<?php echo $value->service_id?>" <?php 
                        if(isset($_POST['save_btn'])){
                          if($_POST['service_id'] == $value->service_id){
                            echo 'selected';
                          }
                        }
                        ?>><?php echo $value->service_name?> - <?php echo number_format($value->service_price,2)?></option>
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
                    <input type="time" name="from" class="form-control" value="<?php if(isset($_POST['save_btn'])): echo $_POST['from']; endif;?>" required >
                  </div>
                  <div class="col-md-3">
                    <strong>Until:</strong>
                  </div>
                  <div class="col-md-3">
                    <input type="time" name="until" class="form-control" required value="<?php if(isset($_POST['save_btn'])): echo $_POST['until']; endif;?>">
                  </div>
                </div>
                <p></p>
                <div class="row">
                  <div class="col-md-3">
                    <strong>Decription:</strong>
                  </div>
                  <div class="col-md-3">
                    <textarea class="form-control" name="sched_desc" placeholder="Description"><?php if(isset($_POST['save_btn'])): echo $_POST['sched_desc']; endif;?></textarea>
                  </div>
                  <div class="col-md-3">
                   <strong>Request Dentist (Optional):</strong>
                  </div>
                  <div class="col-md-3">
                    <?php if(!empty($doctor)):?>
                      <select class="form-control" name="doctor_id">
                        <option value="0" <?php 
                        if(isset($_POST['save_btn'])){
                          if($_POST['doctor_id'] == '0'){
                            echo 'selected';
                          }
                        }
                        ?>>Any dentist available</option>
                      <?php foreach ($doctor as $key => $value):?>
                        <option value="<?php echo $value->ID?>" <?php 
                        if(isset($_POST['save_btn'])){
                          if($_POST['doctor_id'] == $value->ID){
                            echo 'selected';
                          }
                        }
                        ?>><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?></option>
                      <?php endforeach;?>
                      </select>
                    <?php endif;?>
                  </div>
                </div>
                <br>
                <center>
                  <button class="btn btn-info" name="save_btn"><i class="fa fa-calendar-o"></i> Book Appointment</button>
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
