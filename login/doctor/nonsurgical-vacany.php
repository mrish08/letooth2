<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
    header("Location: ../../index.php");
    exit;
  }
if(isset($_GET['transfer'])){
    $ID = $_GET['ID'];
    $reservation_id = $_GET['reservation_id'];
    $ds_id = $_GET['ds_id'];
    
    $customer_id = getSingleRow("*","reservation_id","reservation",$reservation_id);
    
    
    $arr_where = array("reservation_id"=>$_GET['reservation_id']);//update where
    $arr_set = array("ds_id"=>$ds_id);//set update
    $tbl_name = "reservation";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
    
    
    $arr_where2 = array("ds_id"=>$_GET['ds_id']);//update where
    $arr_set2 = array(
        "customer_id"=>$customer_id['customer_id'],
        "sched_status"=>"2"
    );//set update
    $tbl_name2 = "doctor_schedule";
    $update = UpdateQuery($dbcon,$tbl_name2,$arr_set2,$arr_where2);
    

    echo '<script>alert("You have successfully transfer service."); window.location="index.php"</script>';
    
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
            <h1 class="m-0 text-dark"><i class="fa fa-calendar-o"></i> Available Date </h1>
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
  $query = "SELECT * FROM doctor_schedule INNER JOIN accounts on accounts.ID = doctor_schedule.ID WHERE doctor_schedule.ID = '".$_GET['ID']."' AND customer_id = '0'";
  $fetch = SQLJoin($query);
  ?>
  <?php
  if(!empty($fetch)):
  ?>
  <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead>
        <tr>
          <th>Doctor Name</th>
          <th>Availability</th>
         
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
      <td><?php echo $value->available_date?></td>

      <td>
        <a href="nonsurgical-vacany.php?ID=<?php echo $_GET['ID']?>&reservation_id=<?php echo $_GET['reservation_id']?>&ds_id=<?php echo $value->ds_id?>&transfer=true" class="btn btn-info"><i class="fa fa-arrow-right"></i>Transfer</a>
      </td>
  </tr>

  <?php endforeach;?>
</table>
  <?php else:?>
    <div class="alert alert-danger">No Records on the database</div>
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
