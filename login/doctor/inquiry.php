<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
    header("Location: ../../index.php");
    exit;
  }
  if(isset($_GET['i_id'])){
    $arr_where = array("i_id"=>$_GET['i_id']);//update where
    $arr_set = array("inquiry_status"=>"1");//set update
    $tbl_name = "inquiries";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
    header("location: inquiry.php");   
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
            <h1 class="m-0 text-dark"><i class="fa fa-envelope"></i> My Inquiries</h1>
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
          <?php 
  $query = 'SELECT * FROM inquiries WHERE doctor_id = "'.$_SESSION['ID'].'"';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Inquiry</th>
          <th>Customer</th>
          <th>Time and Date</th>
          <th>Option</th>
        </tr>
      </thead>
    <tbody>
  <?php 
  foreach ($g as $key => $value):
    $getCustomer = getSingleRow("*","ID","accounts",$value->client_id);
  ?>
    <tr>
      <td><?php echo $value->inquiry_desc?></td>
      
      <td>
        <?php echo $getCustomer['FirstName']?> <?php echo $getCustomer['MiddleName']?> <?php echo $getCustomer['LastName']?><br>
        <?php if($value->inquiry_status == '0'):?>
          <span style="color:red;">Unread Inquiry</span>
        <?php else:?>
          <span style="color:green;">Read Inquiry</span>
        <?php endif;?>
      </td>
      <td>
        <?php echo $value->date_created?>
      </td>
      <td>
        <a href="read-msg.php?i_id=<?php echo $value->i_id?>" class="btn btn-warning">View</a>
      <?php if($value->inquiry_status == '0'):?>
        <a href="inquiry.php?i_id=<?php echo $value->i_id?>" class="btn btn-info">Mark as Done</a>
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

  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>
</body>
</html>
