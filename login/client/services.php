<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  $services = fetchAll("*","services");
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
            <h1 class="m-0 text-dark"><i class="nav-icon fa fa-th"></i> Services</h1>
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
              <div class="card-body">
<?php if(!empty($services)):?>
<div class="table-responsive">
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead style="background:#ddd;">
                <tr>
                  <th>Photo</th>
                  <th>Service Name</th>
                  <th>Price</th>
                  <th width="250">Description</th>
                  <th>Date Created</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($services as $key => $value):?>
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
                  
                  <td><?php echo $value->date_created?></td>
                  
                </tr>
<?php endforeach;?>
              </tbody>
</table>
</div>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
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
  <!-- /.content-wrapper -->
<?php include'../assets/footer.php';?>
</body>
</html>
