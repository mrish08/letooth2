<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
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
        <h1>Welcome! <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?></h1><hr>
        <?php if(isset($msg)): echo $msg; endif;?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row" style="background:white; padding:10px;">
          <div class="col-md-12">
            <h4>Notifications</h4><br>
<?php 
    $query = "SELECT * FROM notifications WHERE notif_user = '".$_SESSION['ID']."' AND notif_type = '0'";
    $admin = SQLJoin($query);
?>
<?php if(!empty($admin)):?>   
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Description</th>
                  <th>Date</th>
                  
                </tr>
                </thead>
                <tbody>
<?php foreach ($admin as $key => $value):?>
                <tr>
                  
                  <td><?php echo $value->notif_desc?></td>
                  <td><?php echo $value->notif_date?></td>
                  
                </tr>
<?php endforeach;?>
              </tbody>
</table>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
<?php endif;?>

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


<?php include'../assets/footer.php';?>


</body>
</html>
