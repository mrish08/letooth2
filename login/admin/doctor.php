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
    header("location: doctor.php");
  }
}
  $customer = fetchWhere("*","UserRole","accounts","1");
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
if(isset($_POST['save_button'])){
  $EmailAddress = filter($_POST['EmailAddress']);
  $PassWord = filter($_POST['PassWord']);
  $ConfirmPass = filter($_POST['ConfirmPass']);
  $FirstName = filter($_POST['FirstName']);
  $MiddleName = filter($_POST['MiddleName']);
  $LastName = filter($_POST['LastName']);
  $ContactNumber = filter($_POST['ContactNumber']);
  $PermanentAddress = filter($_POST['PermanentAddress']);

  if(checkName($FirstName,$MiddleName,$LastName)){
    $msg = 'This Name already exist.';
  }elseif(CheckUser($EmailAddress)){
    $msg = 'Email Address already exist. ';
  }elseif($PassWord != $ConfirmPass){
    $msg = 'Password do not matched.';
  }
  /*
  elseif(ctype_alpha(str_replace(' ', '', $FirstName)) === false){
    $msg = 'We only accept letters only.';
  }elseif(ctype_alpha(str_replace(' ', '', $MiddleName)) === false){
    $msg = 'We only accept letters only.';
  }elseif(ctype_alpha(str_replace(' ', '', $LastName)) === false){
    $msg = 'We only accept letters only.';
  }
  */
  elseif(strlen($ContactNumber) != 11){
    $msg  = 'We only accept 11 numbers for your contact number.';
  }else{
    $array_insert = array(
    "EmailAddress"      =>$EmailAddress,
    "Password"          =>hash('sha256',$PassWord),
    "FirstName"         =>$FirstName,
    "MiddleName"        =>$MiddleName,
    "LastName"          =>$LastName,
    "ContactNumber"     =>$ContactNumber,
    "PermanentAddress"  =>$PermanentAddress,
    "UserRole"          =>"1",
    "UserStatus"        =>"1",
    "UserName"          =>$EmailAddress,
    "surgical_type"     =>$_POST['surgical_type']
  );
  SaveData('accounts',$array_insert);
  header("location: doctor.php");
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
            <h4 class="m-0 text-dark">Doctor Account 
            <?php if($_SESSION['ID'] == '1'):?>- <a href="#" class="btn btn-success" data-toggle="modal" data-target="#add-data"><i class="fa fa-plus"></i> Add Account</a>
            <?php endif;?></h4>
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
                  <th>Surgical Type</th>
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
                  <td>
                    <?php 
                    if($value->surgical_type == '1'){
                      echo 'Non Surgical';
                    }elseif($value->surgical_type == '2'){
                      echo 'Both Surgical and Non Surgical';
                    }
                    ?>
                  </td>
                  <?php if($_SESSION['ID'] == '1'):?>
                  <td>
                    <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">
  <li><a href="update-account.php?ID=<?php echo $value->ID?>&type=doctor"><i class="fa fa-pencil"></i> Update</a></li>
    <li>
         <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to delete?\') 
      ?window.location = \'doctor.php?delete='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Delete</a>
      </li>
                      <li>
  <?php if($value->UserStatus == '1'):?>
      <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Deactivate?\') 
      ?window.location = \'doctor.php?deactivate='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-remove"></i> Deactivate</a>
  <?php else:?>
    <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Activate?\') 
      ?window.location = \'doctor.php?activate='.$value->ID.'\' : \'\';"'; ?>><i class="fa fa-check"></i> Activate</a>
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
<?php if(isset($msg)):?>
<script type="text/javascript">
  alert("<?php echo $msg;?>");
</script>
<?php endif;?>
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
                <form method="post" autocomplete="off">
          <div class="row">
         
          <div class="col-md-6">
              <strong>First Name:</strong><br>
             <input type="text" name="FirstName" class="form-control" placeholder="First Name" required value="<?php if(isset($_POST['save_button'])): echo $FirstName; endif;?>">
            
          </div>
          <div class="col-md-6">
            <strong>Last Name:</strong><br>
             <input type="text" name="LastName" class="form-control" placeholder="Last Name" required value="<?php if(isset($_POST['save_button'])): echo $LastName; endif;?>" >
          </div>
        </div>
         
                <div class="row">
          <div class="col-md-6">
            <strong>Username:</strong><br>
            <input type="email" name="EmailAddress" class="form-control" placeholder="Email Address / Username" value="<?php if(isset($_POST['save_button'])): echo $_POST['EmailAddress']; endif;?>">
          </div>
          <div class="col-md-6">
            <strong>Contact Number:</strong><br>
            <input type="number" name="ContactNumber" class="form-control" placeholder="Contact Number" required value="<?php if(isset($_POST['save_button'])): echo $ContactNumber; endif;?>"  pattern="[0-9]{11}" >
          </div>

        </div>
        <div class="row">
          
          <div class="col-md-6">
            <strong>Permanent Address:</strong><br>
             <input type="text" name="PermanentAddress" class="form-control" placeholder="Permanent Address" required value="<?php if(isset($_POST['save_button'])): echo $PermanentAddress; endif;?>">
          </div>
         <div class="col-md-6">
            <strong>Password:</strong><br>
             <input type="password" name="PassWord" class="form-control" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
          </div>
        </div>
        
        <div class="row">

          <div class="col-md-6">
            <strong>Confirm Password:</strong><br>
            <input type="password" name="ConfirmPass" class="form-control" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
          </div>
                    <div class="col-md-6">
            <strong>Surgical Type:</strong><br>
            <select class="form-control" name="surgical_type">
              <option value="1">Non Surgical</option>
              <option value="2">Both Surgical / Non Surgical</option>
            </select>
          </div>
          
        </div>

        <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-3">
            <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Create Account</button>
            
          </div>
          <div class="col-3">
            
          </div>
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
</body>
</html>
