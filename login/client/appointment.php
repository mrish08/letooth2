<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $kweri = $dbcon->query("SELECT * FROM reservation WHERE reservation.ds_id = '".$_GET['ds_id']."' AND reserve_status = '0'") or die(mysqli_error());
  $getData = $kweri->fetch_assoc();


  $kweri2 = "SELECT * FROM doctor_schedule INNER JOIN accounts on accounts.ID = doctor_schedule.ID WHERE ds_id = '".$_GET['ds_id']."'";
  $getUser = fetchRow($kweri2);

  $kweri3 = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '".$_GET['ds_id']."' AND reserve_status = '1' AND customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());

  if(isset($_POST['select_btn'])){
    $service_id = filter($_POST['service_id']);
    $ds_id = filter($_GET['ds_id']);

    $h = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '$ds_id' AND service_id = '$service_id' AND customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());

    $checkServices = $dbcon->query("SELECT * FROM reservation INNER JOIN services on services.service_id = reservation.service_id WHERE ds_id = '$ds_id' AND reservation.customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());
    $fetch = $checkServices->fetch_assoc();

    $checkNone = $dbcon->query("SELECT * FROM reservation  WHERE ds_id = '$ds_id' AND service_type = '1'") or die(mysqli_error());
    $checkSurgical = $dbcon->query("SELECT * FROM reservation  WHERE ds_id = '$ds_id' AND service_type = '0'") or die(mysqli_error());


    if(mysqli_num_rows($h) > 0){
      echo "<script>alert('This service already added. Please select other services.'); window.location = 'appointment.php?ds_id=".$ds_id."';</script>";      
    }else{

      
        $insert = array(
        "service_id"  =>$service_id,
        "ds_id"       =>$ds_id,
        "customer_id" =>$_SESSION['ID'],
        "service_type"=>$_POST['service_type']
        );
        SaveData("reservation",$insert);
        header("location: appointment.php?ds_id=".$ds_id."");
      
      
    }
  }
  if(isset($_POST['remove_btn'])){
    $ds_id = filter($_POST['ds_id']);
    $service_id = filter($_POST['service_id']);
    $ar = array("ds_id" =>$ds_id, "service_id" =>$service_id);
    $tbl_name = "reservation";
    $del = delete($dbcon,$tbl_name,$ar);
    if($del){
    header("location: appointment.php?ds_id=".$ds_id."");
    }
  }
  if(isset($_POST['reserve_btn'])){
    $ds_id = filter($_GET['ds_id']);
    $ID = filter($_SESSION['ID']);
    $sched_desc = $_POST['sched_desc'];

    $arr_where = array("ds_id"=>$ds_id);//update where
    $arr_set = array(
    "sched_status" => "1"
    );//set update
    $tbl_name = "doctor_schedule";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);

    $arr_where2 = array("ds_id"=>$ds_id);//update where
    $arr_set2 = array("reserve_status"=>"1");//set update
    $tbl_name2 = "reservation";
    $update = UpdateQuery($dbcon,$tbl_name2,$arr_set2,$arr_where2);

    $insert_array = array(
      "ds_id"             =>$ds_id,
      "customer_id"       =>$ID,
      "reserve_desc"      =>$sched_desc
    );
    SaveData("reservation_description",$insert_array);
    $msg = 'Customer: '.$_SESSION['FirstName'].' '.$_SESSION['LastName'].' has set an appointment to you.';
    $msg2 = 'Customer: '.$_SESSION['FirstName'].' '.$_SESSION['LastName'].' has set an appointment.';
    $notif = array(
      "ds_id"       =>$ds_id,
      "notif_date"  =>date("Y-m-d"),
      "notif_type"  =>"1",
      "notif_user"  =>$getUser['ID'],
      "notif_desc"  =>$msg,    
    );
    /*
    $notif2 = array(
      "ds_id"       =>$_GET['ds_id'],
      "notif_date"  =>date("Y-m-d"),
      "notif_type"  =>"0",
      "notif_user"  =>$getUser['ID'],
      "notif_desc"  =>$msg2,    
  );
  */
    Savedata("notifications",$notif);
    //Savedata("notifications",$notif2);
    echo "<script>alert('You have successfully set an appointment'); window.location = 'index.php';</script>"; 
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
            <h1>Welcome! <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Appointment</li>
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
              <div class="card-header p-2">
                <h4><i class="fa fa-calendar-o"></i> Appointment</h4>

              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
<form method="post">
<div class="row">
  <div class="col-md-2"><strong>Date Scheduled</strong></div>
  <div class="col-md-4"><?php echo $getUser['available_date']?></div>
  <div class="col-md-2"><strong>Status:</strong></div>
  <div class="col-md-4">
    <?php if($getUser['sched_status'] == '0'): echo 'Available'; elseif($getUser['sched_status'] == '1'): echo 'Pending for Approval'; elseif($getUser['sched_status'] == '2'): echo 'Approved'; elseif($getUser['sched_status'] == '3'): echo 'Fulfilled'; endif;?>
  </div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Doctor Name:</strong></div>
  <div class="col-md-4"><?php echo $getUser['FirstName']?>  <?php echo $getUser['MiddleName']?> <?php echo $getUser['LastName']?></div>
  <div class="col-md-2"><strong>Contact Number:</strong></div>
  <div class="col-md-4"><?php echo $getUser['ContactNumber']?></div>
</div>
<p></p>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Email Address:</strong></div>
  <div class="col-md-4"><?php echo $getUser['EmailAddress']?></div>
  <div class="col-md-2"><strong>Service Offered</strong></div>
  <div class="col-md-4">
    <?php 
    if($getUser['surgical_type'] == '1'){
      echo 'Non Surgical only';
    }else{
      echo 'Both Surgical and Non Surgical';
    }
    ?>
  </div>
</div>
<hr>



<?php if(mysqli_num_rows($kweri3) == '0'):?>
<div class="row">
<div class="col-md-7">
  <h4><i class="fa fa-th"></i> Services Avail</h4><hr>
    <?php 
$d_sched = getSingleRow("*","ds_id","doctor_schedule",$_GET['ds_id']);

  $checkNone = $dbcon->query("SELECT * FROM reservation INNER JOIN doctor_schedule on doctor_schedule.ds_id = reservation.ds_id WHERE service_type = '1' AND available_date = '".$d_sched['available_date']."'") or die(mysqli_error());
$checkSurgical = $dbcon->query("SELECT * FROM reservation INNER JOIN doctor_schedule on doctor_schedule.ds_id = reservation.ds_id WHERE service_type = '0' AND available_date = '".$d_sched['available_date']."'") or die(mysqli_error());

$count1 = mysqli_num_rows($checkNone) ; 
$count2 = mysqli_num_rows($checkSurgical); 



  
  ?>
  <?php if(mysqli_num_rows($checkNone) > 10 OR mysqli_num_rows($checkSurgical) > 2):?>
<div class="alert alert-warning">You have reached the maximum number of appointment. <br>
We only accept total number of 2 Surgical and 10 Non Surgical Per day.</div>
<?php else:?>

<?php endif;?>
<?php if($d_sched['available_date'] < date("Y-m-d")):?>
<div class="alert alert-warning">You cannot reserve previous dates</div>
<?php endif;?>

  <?php 
  $query = 'SELECT * FROM reservation INNER JOIN services on services.service_id = reservation.service_id WHERE ds_id = "'.$_GET['ds_id'].'" AND reserve_status = "0"';
  $f = SQLJoin($query);
  ?>
  <?php if(!empty($f)):?>
    <table id="example2" class="table table-bordered table-hover" style="font-size:13px;">
      <thead>
        <tr>
          <th>Service Name</th>
          <th>Service Type</th>
          <th>Action</th>
          
        </tr>
      </thead>
    <tbody>
  <?php foreach ($f as $key => $value):?>
    <tr>
      <td><?php echo $value->service_name?></td>
      <td><?php if($value->service_type == '0'): echo 'Surgical'; else: echo 'Non Surgical'; endif;?></td>
      <td>
        <form method="post">
          <input type="hidden" name="service_id" value="<?php echo $value->service_id?>">
          <input type="hidden" name="ds_id" value="<?php echo $_GET['ds_id']?>">
          <button class="btn btn-danger" name="remove_btn"><i class="fa fa-remove"></i> </button>
        </form>
      </td>
    </tr>
  <?php endforeach;?>
</tbody>
</table>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
  <hr>
  <strong>Description:</strong>
  <textarea class="form-control" name="sched_desc"></textarea>

</div>
<div class="col-md-5">
  <h4><i class="fa fa-wrench"></i>Services</h4><hr>
  <?php 

  $surgical_type = $getUser['surgical_type'];

  if($surgical_type == '1'){
   $query = 'SELECT * FROM services WHERE service_type = "1"';
  }elseif($surgical_type == '2'){
   $query = 'SELECT * FROM services';
  }

  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead>
        <tr>
          <th>Service Name</th>
          <th>Service Type</th>
          <th>Action</th>
          
        </tr>
      </thead>
    <tbody>
  <?php foreach ($g as $key => $value):?>
    <tr>
      <td><?php echo $value->service_name?></td>
      <td><?php if($value->service_type == '0'): echo 'Surgical'; else: echo 'Non Surgical'; endif;?></td>
      <td>
        <?php
      $checkNone2 = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '".$_GET['ds_id']."' AND service_type = '1' AND customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());
      $checkSurgical2 = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '".$_GET['ds_id']."' AND service_type = '0'  AND customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());

      $checkNone = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '".$_GET['ds_id']."' AND service_type = '1'") or die(mysqli_error());
      $checkSurgical = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '".$_GET['ds_id']."' AND service_type = '0'") or die(mysqli_error());

    
      ?> 
      <?php if($value->service_type == '0'):?> 
      <?php if(mysqli_num_rows($checkSurgical2) == 0):?>
        <form method="post">
          <input type="hidden" name="service_type" value="<?php echo $value->service_type?>">
          <input type="hidden" name="service_id" value="<?php echo $value->service_id?>">
          <button class="btn btn-info" name="select_btn"><i class="fa fa-plus"></i></button>
        </form>
      <?php else:?>
        <small style="color:red;">Accept 1 Surgical per day</small>
      <?php endif;?>
      <?php elseif($value->service_type == '1'):?>
        <?php if(mysqli_num_rows($checkNone2) == 2):?>
         <small style="color:red;">Accept 2 Non Surgical per day</small>
      <?php else:?>
       <form method="post">
          <input type="hidden" name="service_type" value="<?php echo $value->service_type?>">
          <input type="hidden" name="service_id" value="<?php echo $value->service_id?>">
          <button class="btn btn-info" name="select_btn"><i class="fa fa-plus"></i> </button>
        </form>
      <?php endif;?>
      <?php endif;?>
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
<?php 

$d_sched = getSingleRow("*","ds_id","doctor_schedule",$_GET['ds_id']);

$checkNone = $dbcon->query("SELECT * FROM reservation INNER JOIN doctor_schedule on doctor_schedule.ds_id = reservation.ds_id WHERE service_type = '1' AND available_date = '".$d_sched['available_date']."'") or die(mysqli_error());


$checkSurgical = $dbcon->query("SELECT * FROM reservation INNER JOIN doctor_schedule on doctor_schedule.ds_id = reservation.ds_id WHERE service_type = '0' AND available_date = '".$d_sched['available_date']."'") or die(mysqli_error());

$count1 = mysqli_num_rows($checkNone) ; 
$count2 = mysqli_num_rows($checkSurgical); 


?>
<?php if(mysqli_num_rows($checkNone) > 10 OR mysqli_num_rows($checkSurgical) > 2 ):?>
<button class="btn btn-info" name="reserve_btn" disabled><i class="fa fa-calendar"></i> Reserve Date</button>
<a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Return</a>
<?php elseif($d_sched['available_date'] < date("Y-m-d")):?>
<button class="btn btn-info" name="reserve_btn" disabled><i class="fa fa-calendar"></i> Reserve Date</button>
<a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Return</a>
<?php else:?>
<?php
$b = $dbcon->query("SELECT * FROM reservation WHERE ds_id = '".$_GET['ds_id']."' AND customer_id = '".$_SESSION['ID']."'") or die(mysqli_error());
if(mysqli_num_rows($b) == 0){
    echo '<button class="btn btn-info" name="reserve_btn" disabled><i class="fa fa-calendar"></i> Reserve Date</button>
<a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Return</a>';
}else{
?>
<button class="btn btn-info" name="reserve_btn"><i class="fa fa-calendar"></i> Reserve Date</button>
<a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Return</a>
<?php } ?>
<?php endif;?>



</form> 
<?php else:?>
<?php   
$query2 = "SELECT * FROM  reservation 
INNER JOIN services on services.service_id = reservation.service_id 
WHERE ds_id = '".$_GET['ds_id']."' AND customer_id = '".$_SESSION['ID']."'";
$service_taken = SQLJOIN($query2);
?>

<div class="row">
  <div class="col-md-7">
    <div class="tab-pane" id="timeline">
      <h3><i class="fa fa-wrench"></i> Services Availed</h3><hr>
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
    <?php if(!empty($service_taken)):?>
      <?php foreach ($service_taken as $key => $value):?>
                              <li>
                        <i class="fa fa-plus bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?php echo $value->date_created;?></span>

                          <h3 class="timeline-header"><a href="#"><?php echo $value->service_name;?></a> <?php if($value->service_type == '0'): echo 'Surgical'; else: echo 'Non Surgical'; endif;?></h3>

                          <div class="timeline-body">
                            <?php echo $value->service_desc;?>
                          </div>
                        </div>
                      </li>
      <?php endforeach;?>
    </ul>
  </div>
    <?php else:?>
      <div class="alert alert-danger">There are no records on the database.</div>
    <?php endif;?>
  </div>
  <div class="col-md-5">
    <h3><i class="fa fa-pencil"></i> Recommendations:</h3>
    <strong>Description:</strong>
  <?php 
  $kweri4 = "SELECT * FROM reservation_description WHERE ds_id = '".$_GET['ds_id']."' AND customer_id = '".$_SESSION['ID']."'";
  $getDesc = fetchRow($kweri4);
  ?>
  <blockquote><?php echo $getDesc['reserve_desc']?></blockquote>
  <br>
  <strong>Doctor Recommendation:</strong>
  <blockquote><?php echo $getData['doc_rec']?></blockquote>
  
  <?php 
    $t = $dbcon->query("SELECT * FROM doctor_schedule WHERE ds_id = '".$_GET['ds_id']."'") or die(mysqli_error());
    $result = $t->fetch_assoc();
  ?>
  
  <strong>Reservation Status:</strong>
  <?php if($result['customer_id'] == '0'):?>
  <div class="alert alert-warning">Waiting for approval of Doctor</div>
  <?php elseif($result['customer_id'] != $_SESSION['ID']):?>
  <div class="alert alert-danger">Rejected</div>
  <?php else:?>
  <div class="alert alert-success">Approved by Doctor</div>
  <?php endif;?>
  </div>
</div>
  


<?php endif;?>


                  </div>


                </div>
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


<?php include'../assets/footer.php';?>

</body>
</html>
