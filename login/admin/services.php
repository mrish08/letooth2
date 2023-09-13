<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $services = fetchAll("*","services");
  if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
  $ar = array("service_id"=>$delete);
  $tbl_name = "services";
  $del = Delete($dbcon,$tbl_name,$ar);
  if($del){
    header("location: services.php");
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
        <h1>Services Offered - <a href="add-service.php" class="btn btn-success"><i class="fa fa-plus"></i> Add Data</a> </h1><hr>
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
                  <th>Photo</th>
                  <th>Service Name</th>
                  <th>Price</th>
                  <th width="250">Description</th>
                  <th>Service Category</th>
                  <th>Date Created</th>
                  <th>Option</th>
                </tr>
                </thead>
                <tbody>
<?php 
foreach ($services as $key => $value):
  $result = getSingleRow("*","cs_id","service_category",$value->category_name);
?>
                <tr>
                  <td>
                    <?php if(empty($value->service_photo)):?>
                      <img src="../../images/logo.png" class="img-thumbnail" style="width:200px; height:150px;">
                    <?php else:?>
                    <img src="../../images/<?php echo $value->service_photo?>" class="img-thumbnail" style="width:200px; height:150px;">
                  <?php endif;?>
                  </td>
                  <td><?php echo $value->service_name?></td>
                  <td><?php echo number_format($value->service_price,2)?></td>
                  <td><?php echo $value->service_desc?></td>
                  <td>
                      <?php echo $result['category_name']?>
                  </td>
                  <td><?php echo $value->date_created?></td>
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">       
      <li>
      <a href="add-service.php?service_id=<?php echo $value->service_id?>"><i class="fa fa-edit"></i> Update</a>
      
      </li>
      <li>
         <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Deactivate?\') 
      ?window.location = \'services.php?delete='.$value->service_id.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Delete</a>
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
