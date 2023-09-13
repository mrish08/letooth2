<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  if(isset($_GET['ID'])){
    $arr_where = array("notif_id"=>$_GET['ID']);//update where
    $arr_set = array("notif_status"=>"1");//set update
    $tbl_name = "notifications";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
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
            <h1 class="m-0 text-dark"><i class="fa fa-th"></i> View Information</h1>
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
<?php   
$query2 = "SELECT * FROM notifications WHERE notif_id = '".$_GET['ID']."' ORDER BY notif_id DESC";
$notif = SQLJOIN($query2);
?>

<div class="row">
  <div class="col-md-12">
    <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
    <?php if(!empty($notif)):?>
      <?php 
      foreach ($notif as $key => $value):
        $getSched = getSingleRow("*","ds_id","doctor_schedule",$value->ds_id);
      ?>
                              <li>
                        <i class="fa fa-plus bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?php echo $value->notif_date;?></span>

                          <div class="timeline-body">
                            <?php echo $value->notif_desc;?> <br>
                  <?php if($getSched['sched_status'] == '1'):?>
                  <a href="booking-information.php?ds_id=<?php echo $value->ds_id?>" class="btn btn-warning">Click here to view</a>
                  <?php elseif($getSched['sched_status'] == '2'):?>
                  <a href="view-billing.php?ds_id=<?php echo $value->ds_id?>" class="btn btn-warning">Click here to view</a>
                  <?php endif;?>
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

  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>
</body>
</html>
