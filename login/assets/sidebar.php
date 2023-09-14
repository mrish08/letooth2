<?php
$g = getSingleRow("*","ID","accounts",$_SESSION['ID']);
if(isset($_POST['upload_photo'])){
  $allowedExts = array("jpeg", "png", "jpg");
  $temp = explode(".", $_FILES["photo"]["name"]);
  $photo =$_FILES['photo'] ["name"];
  $extension = end($temp);

  $checkPhoto = getSingleRow("*","ID","accounts",$_SESSION['ID']);

  if(empty($photo)): $photo2 = $checkPhoto['UserPhoto']; else: $photo2 = $photo; endif;
  $arr_where = array("ID"=>$_SESSION['ID']);//update where
  $arr_set = array("UserPhoto"   =>$photo2);//set update
  $tbl_name = "accounts";
  UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
  move_uploaded_file($_FILES["photo"]["tmp_name"],"../../images/". $_FILES["photo"]["name"]);
   echo "<script>alert('Photo has been uploaded'); window.location = 'index.php';</script>";

}
$sched = $dbcon->query("SELECT * FROM doctor_schedule WHERE sched_status = '1'") or die(mysqli_error());
$count = mysqli_num_rows($sched);

$sched2 = $dbcon->query("SELECT * FROM doctor_schedule WHERE sched_status = '2'") or die(mysqli_error());
$count2 = mysqli_num_rows($sched2);
?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:rgb(184, 90, 233); color:#333;">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../../images/277855546_399124208329516_5361779838833002494_n.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Le Tooth Dental</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar" >


      <!-- Sidebar Menu -->
      <nav class="mt-3">
              <div style="margin-left: 20%;">
      <!--
        <div class="image">
          <a href="" data-toggle="modal" data-target="#upload-photo">
        <?php if(empty($g['UserPhoto'])):?>
        <img src="../../images/avatar.png" width="70%" class="img-circle" alt="User Image">
        <?php else:?>
          <img src="../../images/<?php echo $g['UserPhoto']?>" width="70%" class="img-circle" alt="User Image">
        <?php endif;?>
          </a>
        </div>
      -->
        <!-- Modals-->
     <div class="modal fade" id="upload-photo" style="width:100%;">
    
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-upload"></i> Upload Photo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                  <input type="file" name="photo" class="form-control" required="required"><br>
                  <button class="btn btn-info" name="upload_photo"><i class="fa fa-upload"></i> Upload Photo</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
<!-- End of Modal -->
        
      </div>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-home"></i>
             Dashboard
            </a>
          </li>
<?php if($_SESSION['UserRole'] == '0'):?>
  
          <li class="nav-item has-treeview">
            <a href="general_appointment.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-calendar"></i>
              <p>
                Manage Appointments <span class="right badge badge-danger"></span>
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Pending</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Approved</p>
                </a>
              </li>
              <?php if($_SESSION['ID'] == '1'):?>
              <li class="nav-item">
                <a href="#" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>No Show</p>
                </a>
              </li>
            <?php endif;?>
            </ul>
          </li>
  
          
          <li class="nav-item has-treeview" >
            <a href="#" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Accounts
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="customer.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Customer Profiles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="doctor.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Doctor's Profile</p>
                </a>
              </li>
            </ul>
          </li>
         
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-plus"></i>
              <p>
                Services
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="service-category.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Other Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="services.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pending.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Pending Appointments <span class="right badge badge-danger"><?php echo $count;?></span></p>
                </a>
              </li>
             

            </ul>
           
          </li>
           <?php if($_SESSION['ID'] == '1'):?>
                    <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-calendar-o"></i>
              <p>
                Reports
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="" class="nav-link" style="color:white;" data-toggle="modal" data-target="#sched-report">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Appointment Reports</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif;?>

          <li class="nav-item has-treeview" >
            <a href="#" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Inventory
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="supplies.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>View Supplies</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="equipment.php" class="nav-link" style="color:white;">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>View Equipment</p>
                </a>
              </li>
            </ul>
          </li>
          
<?php endif;?>
<?php if($_SESSION['UserRole'] == '2'):?>
  <?php 
  $query = $dbcon->query("SELECT * FROM inquiries WHERE client_id = '".$_SESSION['ID']."' AND inquiry_status = '0'") or die(mysqli_error());
  $count3 = mysqli_num_rows($query);
  ?>
           <li class="nav-item">
            <a href="read-msg.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-envelope"></i>
              <p>
                Inquiries  <span class="right badge badge-danger"><?php echo $count2?></span>
              </p>
            </a>
          </li>
          
  
          <li class="nav-item">
            <a href="services.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-th"></i>
              <p>
                Services
              </p>
            </a>
          </li>

                              <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-calendar-o"></i>
              <p>
                Appointments
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


              <li class="nav-item">
                 <a href="book.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Book an Appointment
              </p>
            </a>
              </li>
            <li class="nav-item">
                <a href="transactions.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-calendar"></i>
              <p>
                On Going Appointments
              </p>
            </a>
              </li>
            <li class="nav-item">
                <a href="history.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-calendar-o"></i>
              <p>
                History
              </p>
            </a>
              </li>
              
            </ul>
          </li>
         
          <!--
          <li class="nav-item">
            <a href="inquiry.php" class="nav-link" style="color:#333;">
              <i class="nav-icon fa fa-plus"></i>
              <p>
                Send Inquiry
              </p>
            </a>
          </li>
          -->
<?php endif;?>
<?php if($_SESSION['UserRole'] == '1'):?>
  <?php 
  $query = $dbcon->query("SELECT * FROM inquiries WHERE doctor_id = '".$_SESSION['ID']."' AND inquiry_status = '0'") or die(mysqli_error());
  $count2 = mysqli_num_rows($query);
  ?>
  <li class="nav-item">
            <a href="inquiry.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-envelope"></i>
              <p>
                Inquiries <span class="right badge badge-danger"><?php echo $count2?></span>
              </p>
            </a>
          </li>
          
  <li class="nav-item">
            <a href="appointment.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-pencil"></i>
              <p>
                Pending Appointments
                
              </p>
            </a>
          </li>
          <!--
          <li class="nav-item">
            <a href="client-information.php" class="nav-link" style="color:#333;">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Client Information
                
              </p>
            </a>
          </li>
        -->

          <!--
          <li class="nav-item">
            <a href="#" class="nav-link" style="color:#333;" data-toggle="modal" data-target="#my-schedule">
              <i class="nav-icon fa fa-plus"></i>
              <p>
                Create Schedule
              </p>
            </a>
          </li>
        -->
          <li class="nav-item">
            <a href="history.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-calendar-o"></i>
              <p>
                History
              </p>
            </a>
          </li>
                    <li class="nav-item">
            <a href="payments.php" class="nav-link" style="color:white;">
              <i class="nav-icon fa fa-file"></i>
              <p>
                My Payments
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link" style="color:white;" data-toggle="modal" data-target="#earnings">
              <i class="nav-icon fa fa-calendar"></i>
              <p>
                Doctor Report
              </p>
            </a>
          </li>
<?php endif;?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

   <!-- Modals-->
     <div class="modal fade" id="sched-report" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i> Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <a href="per-client.php" class="btn btn-info">Per Client</a> <a href="approve-schedule.php" class="btn btn-danger">Per Status</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
<!-- End of Modal -->
<!-- Modals-->
     <div class="modal fade" id="earnings" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i> Doctor Service Reports</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <a href="earnings.php?option=1" class="btn btn-info">Daily</a> <a href="earnings.php?option=2" class="btn btn-danger">Monthly</a>
                <a href="earnings.php?option=3" class="btn btn-warning">Custom Date</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
<!-- End of Modal -->