<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $query = "SELECT * FROM accounts WHERE UserRole = '0' AND ID != '1'";
  $admin = SQLJoin($query);
  if(isset($_GET['activate'])){
    $arr_where = array("ID"=>filter($_GET['activate']));//update where
    $arr_set = array("UserStatus"=>"1");
    $tbl_name = "accounts";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE SQL
    header("location: admin.php");
  }
  if(isset($_GET['deactivate'])){
    $arr_where = array("ID"=>filter($_GET['deactivate']));//update where
    $arr_set = array("UserStatus"=>"0");
    $tbl_name = "accounts";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE SQL
    header("location: admin.php");
  }
  if(isset($_POST['save_button'])){
  $EmailAddress = filter($_POST['EmailAddress']);
  $PassWord = filter($_POST['PassWord']);
  $ConfirmPass = filter($_POST['ConfirmPass']);
  $FirstName = filter($_POST['FirstName']);
  $MiddleName = "";
  $LastName = filter($_POST['LastName']);
  $ContactNumber = filter($_POST['ContactNumber']);
  $PermanentAddress = filter($_POST['PermanentAddress']);
  

  if(checkName($FirstName,$MiddleName,$LastName)){
    $msg = 'This Name already exist.';
  }elseif(CheckUser($EmailAddress)){
    $msg = 'Email Address already exist. ';
  }elseif($PassWord != $ConfirmPass){
    $msg = 'Password do not matched.';
  }else{
    $array_insert = array(
    "EmailAddress"      =>$EmailAddress,
    "Password"          =>hash('sha256',$PassWord),
    "FirstName"         =>$FirstName,
    //"MiddleName"        =>$MiddleName,
    "LastName"          =>$LastName,
    "ContactNumber"     =>$ContactNumber,
    "PermanentAddress"  =>$PermanentAddress,
    "UserRole"          =>"0",
    "UserStatus"        =>"1",
    "UserName"          =>$EmailAddress
  );
  SaveData('accounts',$array_insert);
  $msg = 'You have successfully added staff account.';
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Staff Account - <a href="#" class="btn btn-success" data-toggle="modal" data-target="#add-data"><i class="fa fa-plus"></i> Add Account</a> </h4>
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

<?php if(!empty($admin)):?>   
<div class="table-responsive">
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Contact Number</th>
                  <th>Address</th>
                  <th>Option</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($admin as $key => $value):?>
                <tr>
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
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">       
  <?php if($value->UserStatus == '1' AND $value->ID != '1'):?>
      <li>
      <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Deactivate?\') 
      ?window.location = \'admin.php?deactivate='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Deactivate</a><br>
      <a href="admin-update.php?ID=<?php echo $value->ID?>"><i class="fa fa-edit"></i> Update</a>
      </li>
  <?php elseif($value->UserStatus == '0' AND $value->ID != '1'):?>
    <li>
    <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Activate?\') 
      ?window.location = \'admin.php?activate='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-check"></i> Activate</a><br>
      <a href="admin-update.php?ID=<?php echo $value->ID?>"><i class="fa fa-edit"></i> Update</a>
    </li>
  <?php else:?>
    No Option
  <?php endif;?>
                      

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
    <!-- Modals-->
     <div class="modal fade" id="add-data" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="post">
                    
                <div class="row">
                    <div class="col-md-6">
            <strong>First Name:</strong><br>
             <input type="text" name="FirstName" class="form-control" placeholder="First Name" required <?php if(isset($_POST['save_button'])): echo $FirstName; endif;?>>
          </div>
                    <div class="col-md-6">
            <strong>Last Name:</strong><br>
             <input type="text" name="LastName" class="form-control" placeholder="Last Name" required <?php if(isset($_POST['save_button'])): echo $LastName; endif;?>>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <strong>Username:</strong><br>
            <input type="email" name="EmailAddress" class="form-control" placeholder="Email Address / Username" <?php if(isset($_POST['save_button'])): echo $_POST['EmailAddress']; endif;?>>
          </div>
                    <div class="col-md-6">
            <strong>Contact Number:</strong><br>
            <input type="text" name="ContactNumber" class="form-control" placeholder="Contact Number" required <?php if(isset($_POST['save_button'])): echo $ContactNumber; endif;?>>
          </div>
         </div>
                 <div class="row">

          <div class="col-md-6">
            <strong>Permanent Address:</strong><br>
             <input type="text" name="PermanentAddress" class="form-control" placeholder="Permanent Address" required <?php if(isset($_POST['save_button'])): echo $PermanentAddress; endif;?>>
          </div>
          <div class="col-md-6">
            <strong>Password:</strong><br>
             <input type="password" name="PassWord" class="form-control" placeholder="Password" required>
          </div>
        </div>
        <div class="row">
          
                    <div class="col-md-6">
            <strong>Confirm Password:</strong><br>
            <input type="password" name="ConfirmPass" class="form-control" placeholder="Confirm Password" required>
          </div>
          </div>
       <br>
                    <div class="col-3">
            <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Create Account</button>
            
          </div>
        </div>
        </div>
        
        <div class="row">
          <!-- /.col -->

          
          <!-- /.col -->
        </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
<!-- End of Modal -->
<?php if(isset($msg)):?>
<script type="text/javascript">
  alert("<?php echo $msg;?>"); window.location="admin.php";
</script>
<?php endif;?>
</body>
</html>
