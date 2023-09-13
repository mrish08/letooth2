<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  if(isset($_GET['delete'])){
  $delete = filter($_GET['delete']);
  $ar = array("ID"=>$delete);
  $tbl_name = "accounts";
  $del = Delete($dbcon,$tbl_name,$ar);
  if($del){
    header("location: customer.php");
  }
}
  $act = "SELECT * FROM accounts WHERE UserRole = '2' AND UserStatus = '0'";
  $customer = SQLJoin($act);


  if(isset($_GET['activate'])){
    $arr_where = array("ID"=>filter($_GET['activate']));//update where
    $arr_set = array("UserStatus"=>"1");
    $tbl_name = "accounts";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE SQL
    header("location: customer.php");
  }
  if(isset($_GET['deactivate'])){
    $arr_where = array("ID"=>filter($_GET['deactivate']));//update where
    $arr_set = array("UserStatus"=>"0");
    $tbl_name = "accounts";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE SQL
    header("location: customer.php");
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
            <h4 class="m-0 text-dark">Customer Account</h4>
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
<a href="customer.php" class="btn btn-success"><i class="fa fa-check"></i> Activated Account</a>
<a href="customer_deactivated.php" class="btn btn-danger"><i class="fa fa-remove"></i> Deactivated Account</a>
<br><br>
<?php if(!empty($customer)):?>   
<div class="table-responsive">
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Contact Number</th>
                  <th>Address</th>
                  <?php if($_SESSION['ID'] == '1'):?>
                  <th>Option</th>
                  <?php endif;?>
                </tr>
                </thead>
                <tbody>
<?php foreach ($customer as $key => $value):?>
                <tr>
                  <td>
                    <img src="../../images/<?php echo $value->UserPhoto?>" class="img-thumbnail" width="100">
                  </td>
                  <td><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
                  <?php if($value->UserStatus == '1'):?>
                    <p class="text-success">Activated</p>
                  <?php else:?>
                    <div class="text-danger">Deactivated</div>
                  <?php endif;?>
                  </td>
                  <td><?php echo $value->EmailAddress?></td>
                  <td><?php echo $value->ContactNumber?></td>
                  <td><?php echo $value->PermanentAddress?></td>
                  <?php if($_SESSION['ID'] == '1'):?>
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">
  <!--
   <li><a href="update-account.php?ID=<?php echo $value->ID?>&type=customer"><i class="fa fa-pencil"></i> Update</a></li>
   <li>

         <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'customer.php?delete='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Delete</a>
      </li>
  -->
                      <li>
  <?php if($value->UserStatus == '1'):?>
      <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Deactivate?\') 
      ?window.location = \'customer.php?deactivate='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Deactivate</a>
  <?php else:?>
    <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Activate?\') 
      ?window.location = \'customer.php?activate='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-check"></i> Activate</a>
  <?php endif;?>
                      </li>


                    </ul>
                  </div>
                    
                  </td>
                  <?php endif;?>
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
