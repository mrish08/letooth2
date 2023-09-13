<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $admin = getSingleRow("*","ID","accounts",filter($_GET['ID']));

  if(isset($_POST['update_button'])){
  $EmailAddress = filter($_POST['EmailAddress']);
  $FirstName = filter($_POST['FirstName']);
  $MiddleName = filter($_POST['MiddleName']);
  $LastName = filter($_POST['LastName']);
  $ContactNumber = filter($_POST['ContactNumber']);
  $PermanentAddress = filter($_POST['PermanentAddress']);
  /*
  if(checkName($FirstName,$MiddleName,$LastName)){
    $msg = 'This Name already exist.';
  }elseif(CheckUser($EmailAddress)){
    $msg = 'Email Address already exist. ';
  }else{
  */
  $arr_where = array("ID"=>$_GET['ID']);//update where
  $arr_set = array(
    "EmailAddress"      =>$EmailAddress,
    "FirstName"         =>$FirstName,
    "MiddleName"        =>$MiddleName,
    "LastName"          =>$LastName,
    "ContactNumber"     =>$ContactNumber,
    "PermanentAddress"  =>$PermanentAddress,
    "UserName"          =>$EmailAddress
  );//set update
  $tbl_name = "accounts";
  $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);   
  $msg = 'You have successfully update the account.';
  //}
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
            <h4 class="m-0 text-dark">Update Information</h4>
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

<form method="post">
                <div class="row">
          <div class="col-md-6">
            <strong>Email Address:</strong><br>
            <input type="email" name="EmailAddress" class="form-control" placeholder="Email Address / Username" value="<?php echo $admin['EmailAddress']; ?>">
          </div>
          <div class="col-md-6">
            <strong>Password:</strong><br>
             <input type="password" name="PassWord" class="form-control" placeholder="Password" readonly value="<?php echo $admin['PassWord']; ?>">
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-6">
            <strong>Confirm Password:</strong><br>
            <input type="password" name="ConfirmPass" class="form-control" placeholder="Confirm Password" value="<?php echo $admin['PassWord']; ?>" readonly>
          </div>
          <div class="col-md-6">
            <strong>First Name:</strong><br>
             <input type="text" name="FirstName" class="form-control" placeholder="First Name" required value="<?php echo $admin['FirstName']; ?>">
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-6">
            <strong>Middle Name:</strong><br>
            <input type="text" name="MiddleName" class="form-control" placeholder="Middle Name" required value="<?php echo $admin['MiddleName']; ?>">
          </div>
          <div class="col-md-6">
            <strong>Last Name:</strong><br>
             <input type="text" name="LastName" class="form-control" placeholder="Last Name" required value="<?php echo $admin['LastName']; ?>">
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-6">
            <strong>Contact Number:</strong><br>
            <input type="text" name="ContactNumber" class="form-control" placeholder="Contact Number" required value="<?php echo $admin['ContactNumber']; ?>">
          </div>
          <div class="col-md-6">
            <strong>Permanent Address:</strong><br>
             <input type="text" name="PermanentAddress" class="form-control" placeholder="Permanent Address" required value="<?php echo $admin['PermanentAddress']; ?>">
          </div>
        </div><br>
        <div class="row">
          <!-- /.col -->
          <div class="col-3">
            <button class="btn btn-primary" name="update_button"><i class="fa fa-edit"></i> Update</button>
            <a href="admin.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Return</a>
          </div>
          <div class="col-3">
            
          </div>
          <!-- /.col -->
        </div>
                </form>

               
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

<?php include'../assets/footer.php';?>

<?php if(isset($msg)):?>
<script type="text/javascript">
  alert("<?php echo $msg;?>");
  window.location.href = "admin.php";
</script>
<?php endif;?>
</body>
</html>
