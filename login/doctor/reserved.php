<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
    header("Location: ../../index.php");
    exit;
  }
$kweri = $dbcon->query("SELECT  *, doctor_schedule.customer_id as USER_ID FROM doctor_schedule 
  LEFT JOIN accounts on accounts.ID = doctor_schedule.customer_id
  LEFT JOIN reservation_description on reservation_description.ds_id = doctor_schedule.ds_id
  WHERE doctor_schedule.ds_id = '".$_GET['ds_id']."'") or die(mysqli_error());
$getData = $kweri->fetch_assoc();

$doctor_id = getSingleRow("*","ID","accounts",$_SESSION['ID']);

if(isset($_POST['recommendation_btn'])){
  $ds_id = filter($_GET['ds_id']);
  $arr_where = array("ds_id"=>$ds_id);//update where
  $arr_set = array("doc_rec" => $_POST['doc_rec'],"sched_status" =>"3");//set update
  $tbl_name = "doctor_schedule";
  $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
   echo "<script>alert('You have successfully update recommendation. The schedule was tag as done'); window.location = 'index.php';</script>";
}

if(isset($_POST['approve_btn'])){
  $ds_id = filter($_GET['ds_id']);
  $arr_where = array("ds_id"=>$ds_id);//update where
  $arr_set = array("sched_status" => "2");//set update
  $tbl_name = "doctor_schedule";
  $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
  header("location: index.php");
}
if(isset($_POST['cancel_btn'])){
  $ds_id = filter($_GET['ds_id']);
  $arr_where = array("ds_id"=>$ds_id);//update where
  $arr_set = array("sched_status" => "0");//set update
  $tbl_name = "doctor_schedule";
  $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
  header("location: index.php");
}

if(isset($_GET['approve'])){
  $ds_id = filter($_GET['ds_id']);
  $arr_where = array("ds_id"=>$ds_id);//update where
  $arr_set = array("sched_status" => "2","customer_id"=>$_GET['ID']);//set update
  $tbl_name = "doctor_schedule";
  $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
  $getdata = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $msg = 'Please be informed that doctor: '.$getdata['FirstName'].' '.$getdata['LastName'].' has approve your appointment';
  $msg = 'Please be informed that doctor: '.$getdata['FirstName'].' '.$getdata['LastName'].' has approve the appointment';
  $notif = array(
      "ds_id"       =>$_GET['ds_id'],
      "notif_date"  =>date("Y-m-d"),
      "notif_type"  =>"2",
      "notif_user"  =>$_GET['ID'],
      "notif_desc"  =>$msg,    
  );
  /*
  $notif2 = array(
      "ds_id"       =>$_GET['ds_id'],
      "notif_date"  =>date("Y-m-d"),
      "notif_type"  =>"0",
      "notif_user"  =>$_GET['ID'],
      "notif_desc"  =>$msg2,    
  );
  */
  Savedata("notifications",$notif);
  //Savedata("notifications",$notif2);
  header("location: index.php");
}

if(isset($_POST['choose_btn'])){
    $ID = $_POST['ID'];
    $reservation_id = $_POST['reservation_id'];
    
    header("location: nonsurgical-vacany.php?ID=$ID&reservation_id=$reservation_id");
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
            <h1 class="m-0 text-dark"><i class="fa fa-plus"></i> Appointment Information</h1>
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
<br>
<?php if($getData['USER_ID'] == '0'):?>
  <?php 
  $query = "SELECT * FROM reservation 
  INNER JOIN accounts on accounts.ID = reservation.customer_id 
  WHERE ds_id = '".$_GET['ds_id']."' GROUP BY customer_id";
  $fetch = SQLJoin($query);
  ?>
  <?php
  if(!empty($fetch)):
  ?>
  <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead>
        <tr>
          <th>Customer Name</th>
          <th>Contact Number</th>
          <th>Email Address</th>
          <th>Inquired Services</th>
          <th>Action</th>          
        </tr>
      </thead>
    <tbody>
  <?php 
    foreach ($fetch as $key => $value):
  ?>
  <tr>
      <td><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
      </td>
      <td><?php echo $value->ContactNumber?></td>
      <td><?php echo $value->EmailAddress?></td>
      <td>
        <a href="view-data.php?ds_id=<?php echo $value->ds_id?>&ID=<?php echo $value->ID?>">View Details</a>
      </td>
      <td>
        <a href="reserved.php?ds_id=<?php echo $value->ds_id?>&ID=<?php echo $value->ID?>&approve=1" class="btn btn-info"><i class="fa fa-check"></i> Accept </a>
      </td>
  </tr>

  <?php endforeach;?>
</table>
  <?php else:?>
    <div class="alert alert-danger">No Records on the database</div>
  <?php endif;?>
<?php else:?>
<div class="card-body">
<div class="row">
  <div class="col-md-2"><strong>Date Scheduled</strong></div>
  <div class="col-md-4"><?php echo $getData['available_date']?></div>
  <div class="col-md-2"></div>
  <div class="col-md-4"></div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Customer Name:</strong></div>
  <div class="col-md-4"><?php echo $getData['FirstName']?>  <?php echo $getData['MiddleName']?> <?php echo $getData['LastName']?></div>
  <div class="col-md-2"><strong>Contact Number:</strong></div>
  <div class="col-md-4"><?php echo $getData['ContactNumber']?></div>
</div>
<p></p>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Email Address:</strong></div>
  <div class="col-md-4"><?php echo $getData['EmailAddress']?></div>
  <div class="col-md-2"><strong>Status</strong></div>
  <div class="col-md-4">
     <?php if($getData['sched_status'] == '1'): echo 'Pending for Approval'; elseif($getData['sched_status'] == '0'): echo 'Draft'; elseif($getData['sched_status'] == '2'): echo 'Approved'; elseif($getData['sched_status'] == '3'): echo 'Fulfilled'; endif; ?>
  </div>
</div>


            </div>
<?php endif;?>

            
            </div>
              </div>
<?php if($getData['USER_ID'] == '0'):?>
<?php else:?>
          <div class="col-lg-12">
            <div class="card">
<div class="card-body">
<?php 
  $query = 'SELECT * FROM reservation 
  INNER JOIN services on services.service_id = reservation.service_id 
  WHERE ds_id = "'.$_GET['ds_id'].'" AND customer_id = "'.$getData['ID'].'"';
  $f = SQLJoin($query);
  ?>
  <?php if(!empty($f)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
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
      <td><?php echo $value->service_name?> </td>
      <td><?php if($value->service_type == '0'): echo 'Surgical'; else: echo 'Non Surgical'; endif;?></td>
      <td>
          <?php if($value->service_type == '0'): echo ''; else:?>
          <?php if($doctor_id['surgical_type'] == '2'):?>
          <a href="" data-toggle="modal" data-target="#transfer<?php echo $value->reservation_id?>">Choose Non Surgical Doctor</a>
          <?php endif;?>
        <?php endif;?>
      </td>
    </tr>
     <div class="modal fade" id="transfer<?php echo $value->reservation_id?>" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i> Choose Non Surgical Doctor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="post">
                <div class="row">
          <div class="col-md-12">
            <strong>Doctor Name:</strong><br>
        <?php $t = getSingleRow("*","reservation_id","reservation", $value->reservation_id);?>
        <input type="hidden" name="reservation_id" value="<?php echo $t['reservation_id'];?>">
           <select class="form-control" name="ID">
               <?php 
               $query = "SELECT * FROM accounts WHERE UserRole = '1' AND Surgical_type = '1'";
               $g = SQLJoin($query);
               ?>
               <?php if(!empty($g)):?>
               <?php foreach($g as $row):?>
               <option value="<?php echo $row->ID?>"><?php echo $row->FirstName?> <?php echo $row->MiddleName?> <?php echo $row->LastName?></option>
               <?php endforeach;?>
               <?php else:?>
               <option>No Records</option>
               <?php endif;?>
           </select>
          </div>

        </div><br>
      
        <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button class="btn btn-primary" name="choose_btn"><i class="fa fa-save"></i> Choose</button>
            
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
  <?php endforeach;?>
</tbody>
</table>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
<br>
<strong>Description / Concern:</strong>
<textarea class="form-control" readonly><?php echo $getData['reserve_desc']?></textarea>
<br>
<?php if($getData['sched_status'] == '1'):?>
<form method="post">
    <button class="btn btn-info" name="approve_btn"><i class="fa fa-remove"></i> Approve</button>
  <button class="btn btn-danger" name="cancel_btn"><i class="fa fa-remove"></i> Cancel</button>
</form>
<?php else:?>
<form method="post">
  <strong>Doctor Recommendations:</strong>
  <textarea class="form-control" name="doc_rec" <?php if($getData['sched_status'] != '2'):?>readonly <?php endif;?>><?php echo $getData['doc_rec']?></textarea>
  <br>
  <?php if($getData['sched_status'] == '2'):?>
    <button class="btn btn-info" name="recommendation_btn"><i class="fa fa-save"></i> Save</button>
  <?php endif;?>
  <a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Returned</a>
  </form>
<?php endif;?>
</div>

            
            </div>

             
              </div>
<?php endif;?>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>
</body>
</html>
