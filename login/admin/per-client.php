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
    <br>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row" style="background:white; padding:10px;">
        <h3><i class="fa fa-calendar-o"></i> Schedule Report per Client</h3>
        <hr>
<div class="col-lg-12">
<form method="post">
<div class="row">
<form method="post">
  <div class="col-md-6">
     <strong>Client Name:</strong>
     <select class="form-control" name="ID">
       <?php 
        $list = fetchWhere("*","UserRole","accounts","2");
       ?>
       <?php if(!empty($list)):?>
        <?php foreach ($list as $key => $value):?>
           <option value="<?php echo $value->ID?>"><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?></option>
        <?php endforeach;?>
        <?php else:?>
          <option>No Records</option>
      <?php endif;?>
     </select>
  </div>
  <div class="col-md-4">
    <br>
    <button class="btn btn-info" name="search_data"><i class="fa fa-search"></i> Search</button>
  </div>
</div>
</form>
<hr>
<?php 
if(isset($_POST['search_data'])){
  header("location: client-sched.php?ID=".$_POST['ID']."");
}
?>
</div>
          
      </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </div>
  </div>
<?php include'../assets/footer.php';?>
</body>
</html>
