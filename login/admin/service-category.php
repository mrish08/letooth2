<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $services = fetchAll("*","service_category");
  if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
  $ar = array("cs_id"=>$delete);
  $tbl_name = "service_category";
  $del = Delete($dbcon,$tbl_name,$ar);
  if($del){
    header("location: service-category.php");
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
        <h1>Other Services - <a href="add-category.php" class="btn btn-success"><i class="fa fa-plus"></i> Add Data</a> </h1><hr>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      <div class="row" style="background:white; margin:10px;padding:10px;">        <!-- /.row -->
        <div class="col-md-12">

        <?php if(!empty($services)):?> 
<div class="table-responsive">
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Service Category</th>
                  <th>Details</th>
                  <th>Option</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($services as $key => $value):?>
                <tr>
                  
                  <td><?php echo $value->category_name?></td>
                  <td><?php echo $value->cat_details?></td>
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">       
      <li>
      <a href="add-category.php?cs_id=<?php echo $value->cs_id?>"><i class="fa fa-edit"></i> Update</a>
      
      </li>
      <li>
         <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Deactivate?\') 
      ?window.location = \'service-category.php?delete='.$value->cs_id.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Delete</a>
      </li>
  
                      

                    </ul>
                  </div>
                    
                  </td>
                </tr>
<?php endforeach;?>
              </tbody>
</table>
</div>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
<?php endif;?>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <!-- /.content-wrapper -->


<?php include'../assets/footer.php';?>
</body>
</html>
