<?php
  include'../config/db.php';
  include'../config/functions.php';
  include'../config/main_function.php';
  
if(!empty($_SESSION['login_admin']))
{
    header("location: admin/");
}
if(!empty($_SESSION['login_client']))
{
    header("Location: client/");
}
if(!empty($_SESSION['login_doctor']))
{
    header("Location: doctor/");
}

if(isset($_POST['forgot_btn'])){
  $EmailAddress = filter($_POST['EmailAddress']);
  $FirstName = filter($_POST['FirstName']);
  $MiddleName = filter($_POST['MiddleName']);
  $LastName = filter($_POST['LastName']);
  $rand = rand();
  if(ForgotPassword($FirstName,$LastName,$EmailAddress,$MiddleName)){


    $arr_where = array("EmailAddress"=>$EmailAddress);//update where
    $arr_set = array("PassWord" =>hash('sha256',$rand));
    $tbl_name = "accounts";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);// UPDATE
    
    $success = 'You have successfully change your password. Please see your email address. If you didnt see on your inbox please check your spam message.'; 
  
  $subject = "Jancen Cosmetics Forgot Password";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: admin@jancen-cosmetics.com" . "\r\n";
  $to = ''.$EmailAddress.'';
  //
  $message = 'Good day!<br>
  <p>Please be informed that you have successfully change your password.</p>
  <ul>
    <li>Username: '.$EmailAddress.'</li>
    <li>New Password: '.$rand.'</li>
  </ul>
  <br>
  
  <br>
  <p>For more inquiries please visit our website: www.jancen-cosmetics.com</p>

  <strong>Thank you!</strong>';
  $mailme = mail($to,$subject,$message,$headers);
  }else{
    
    $msg = 'Invalid Credentials';


  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="icon" href="../images/277855546_399124208329516_5361779838833002494_n.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<style type="text/css">
  #register_page{
    width:65%; margin: 0 auto; background:white;padding:10px;margin-top:20px;
  }
  #logo{
    margin-top:50px;
  }
</style>
<body class="hold-transition login-page">
  <div id="logo" class="login-logo">
    <img src="../images/277855546_399124208329516_5361779838833002494_n.png" width="20%" class="img-circle">
  </div>
<div id="register_page">
   <?php if(isset($msg)):?>
        <div class="alert alert-danger"><?php echo $msg; ?></div>
      <?php endif;?>
      <?php if(isset($success)):?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif;?>
      <form method="post" autocomplete="on">
        <div class="row">
          <div class="col-md-6">
            <strong>Email Address:</strong><br>
            <input type="email" name="EmailAddress" class="form-control" placeholder="Email Address / Username" value="<?php if(isset($_POST['save_button'])): echo $_POST['EmailAddress']; endif;?>">
          </div>
          <div class="col-md-6">
            <strong>First Name:</strong><br>
             <input type="text" name="FirstName" class="form-control" placeholder="First Name" required value="<?php if(isset($_POST['save_button'])): echo $FirstName; endif;?>">
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-6">
            <strong>Middle Name:</strong><br>
            <input type="text" name="MiddleName" class="form-control" placeholder="Middle Name" value="<?php if(isset($_POST['save_button'])): echo $MiddleName; endif;?>">
          </div>
          <div class="col-md-6">
             <strong>Last Name:</strong><br>
             <input type="text" name="LastName" class="form-control" placeholder="Last Name" required value="<?php if(isset($_POST['save_button'])): echo $LastName; endif;?>">
          </div>
        </div><br>
        <div class="row">
          <!-- /.col -->
          <div class="col-3">
            <button class="btn btn-primary btn-block btn-flat" name="forgot_btn"><i class="fa fa-save"></i> Forgot Password</button>
            
          </div>
          <div class="col-3">
            <a href="index.php" class="btn btn-danger btn-block btn-flat"><i class="fa fa-arrow-left"></i> Return</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
</div>

<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>
</body>
</html>
