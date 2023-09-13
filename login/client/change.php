<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
if(isset($_POST['change_btn'])){
    $old_pass = hash('sha256',$_POST['old_pass']);
    $new_pass = filter($_POST['new_pass']);
    $confirm_pass = filter($_POST['confirm_pass']);

    $g = getSingleRow("*","ID","accounts",filter($_SESSION['ID']));
    if($new_pass != $confirm_pass){
      $msg = 'Password do not matched.';
    }
    elseif($g['PassWord'] != $old_pass){
      $msg = 'Old password do no matched.';
    }
    else{
    
      $arr_where = array("ID"=>$_SESSION['ID']);//update where
      $arr_set = array("PassWord"=>hash('sha256',$new_pass));//set update
      $tbl_name = "accounts";
      $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);   
      $success = 'Password has been successfully updated.';
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
            <h1 class="m-0 text-dark"><i class="fa fa-wrench"></i> Change Password</h1>
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
                <?php if(isset($msg)):?>
              <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $msg;?>
              <br />
            </div>
            <?php endif;?>
            <?php if(isset($success)):?>
              <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $success;?>
              <br />
            </div>
            <?php endif;?>
             <form method="post">
             <table class="table table-bordered">
                <tr>
                  <td>Old Password:</td>
                  <td><input type="password" name="old_pass" class="form-control" placeholder="Old Password" required></td>
                </tr>
                 <tr>
                  <td>New Password:</td>
                  <td><input type="password" name="new_pass" class="form-control" placeholder="New Password" required></td>
                </tr>
                 <tr>
                  <td>Confirm Password:</td>
                  <td><input type="password" name="confirm_pass" class="form-control" placeholder="Confirm Password" required></td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                     <button class="btn btn-primary btn-large" name="change_btn"><i class="fa fa-save"></i> Change Password</button>
                <a href="index.php" class="btn btn-danger btn-large"><i class="fa fa-arrow-left"></i> Cancel</a>
                  </td>
                </tr>
              </table>
          </form>
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
