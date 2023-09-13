<?php
include 'config/db.php';
include 'config/functions.php';
include 'config/main_function.php';

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
if(isset($_POST['save_button'])){
  $EmailAddress = filter($_POST['EmailAddress']);
  $PassWord = filter($_POST['PassWord']);
  $ConfirmPass = filter($_POST['ConfirmPass']);
  $FirstName = filter($_POST['FirstName']);
  //$MiddleName = filter($_POST['MiddleName']);
  $LastName = filter($_POST['LastName']);
  $ContactNumber = filter($_POST['ContactNumber']);
  $PermanentAddress = filter($_POST['PermanentAddress']);
  //$user_age = $_POST['user_age'];
  $bday = $_POST['bday'];
  $sex = $_POST['sex'];
  //$civil_status = $_POST['civil_status'];
  //$occupation = $_POST['occupation'];

  if(checkName($FirstName,$LastName)){
    $msg = 'This Name already exist.';
  }elseif(CheckUser($EmailAddress)){
    $msg1 = 'Email Address already exist. ';
  }elseif($PassWord != $ConfirmPass){
    $msg2 = 'Password do not matched.';
  }elseif(!is_numeric($ContactNumber)){
    $msg4 = 'Please enter number.';
  }
  /*
  elseif(ctype_alpha(str_replace(' ', '', $FirstName)) === false){
    $msg = 'We only accept letters.';
  }elseif(ctype_alpha(str_replace(' ', '', $MiddleName)) === false){
    $msg = 'We only accept letters.';
  }elseif(ctype_alpha(str_replace(' ', '', $LastName)) === false){
    $msg = 'We only accept letters.';
  }
  */
  
  elseif(strlen($ContactNumber) != 11){
    $msg3  = 'We only accept 11 numbers for your contact number.';
  }
  
  else{
    $array_insert = array(
    "EmailAddress"      =>$EmailAddress,
    "Password"          =>hash('sha256',$PassWord),
    "FirstName"         =>$FirstName,
    //"MiddleName"        =>$MiddleName,
    "LastName"          =>$LastName,
    "ContactNumber"     =>$ContactNumber,
    "PermanentAddress"  =>$PermanentAddress,
    "UserRole"          =>"2",
    "UserStatus"        =>"1",
    "UserName"          =>$EmailAddress,
    "UserPhoto"         =>"avatar.png",
    "user_age"          =>$user_age,
    "bday"              =>$bday,
    "sex"               =>$sex,
    //"civil_status"      =>$civil_status,
    //"occupation"        =>$occupation
  );
  SaveData('accounts',$array_insert);

  $subject = "Le Tooth Dental Clinic Website Registration";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "From: support@jancen-costmetics.online" . "\r\n";
  $to = ''.$EmailAddress.'';
  //
  $message = 'Good day!<br>
  <p>Please be informed that you have successfully registered to our website. To verify your account please click the link below.</p>
  <ul>
    <li>Username: '.$EmailAddress.'</li>
    <li>Password: '.$ConfirmPass.'</li>
  </ul>
  <br>
  <strong>For Gmail Account:</strong>
  <a href="www.jancen-cosmetics.com/verify.php?email='.$EmailAddress.'" target="_blank">Click here to verify</a>
  <br>
  <strong>For Yahoo account and others</strong>
  <p>Copy this link to your browser</p>
  https://jancen-cosmetics.com/verify.php?email='.$EmailAddress.'
  <br>
  <p>For more inquiries please visit our website: www.jancen.online</p>

  <strong>Thank you!</strong>';
  $mailme = mail($to,$subject,$message,$headers);
  
  $msg = 'You have successfully registered to our site. Please verify to your email to have access.';
  }
}
?>


<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from kingstudio.ro/demos/mr/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Oct 2017 15:07:08 GMT -->
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Minimal Restaurant Template">
<meta name="keywords" content="responsive, retina ready, html5, css3, restaurant, food, bar, events" />
<meta name="author" content="KingStudio.ro">

<!-- favicon -->
<link rel="icon" href="images/277855546_399124208329516_5361779838833002494_n.ico">
<!-- page title -->
<title>Le Tooth Dental Clinic</title>
<!-- bootstrap css -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- css -->
<link href="css/style.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link href="css/magnific-popup.css" rel="stylesheet">
<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
<!-- fonts -->
<link href="https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='fonts/FontAwesome.otf' rel='stylesheet' type='text/css'>
</head>

<body>

<!-- preloader -->
<div id="preloader">
    <div class="spinner spinner-round"></div>
</div>
<!-- / preloader -->

<div id="top"></div>

<!-- header -->
<header>
    <nav class="navbar navbar-default dark-bg navbar-fixed-top" style="background:rgba(1,1,1,0.6);">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="images/277855546_399124208329516_5361779838833002494_n.png" alt="logo"  width="100" style="border-radius:8px;"></a>
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav" >
                    <li style="padding-top: 20px;"><a href="index.php#top" id="mycolor" class="page-scroll">HOME</a></li>
                     <li style="padding-top: 20px;"><a href="signup.php" id="mycolor" class="page-scroll"><i class="fa fa-pencil"></i> SIGN UP</a></li>
                    <li style="padding-top: 20px;"><a href="login/index.php" id="mycolor" class="page-scroll">LOGIN</a></li>
                    
                </ul>
            </div><!--/.nav-collapse -->
        </div><!-- / container -->
    </nav>
</header>
<section id="signup" style="">
        <div id="contact-form" class="wow fadeIn first">
            <div class="page-header dark text-left">
              
                <div class="">&nbsp;</div>
                <br><br>
            </div>
          
      <?php if(isset($success)):?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif;?>
      <form method="post" autocomplete="off">
        <div class="row">
            <div class=""
              <h2 style="color:#333;font-family:arial;font-size:40px;"><center>Create Account</center> </h2>
            </div>
            <br>
            <div class="col-md-6">
                <strong>First Name:</strong><br>
             <input type="text" name="FirstName" class="form-control" placeholder="First Name" required value="<?php if(isset($_POST['save_button'])): echo $FirstName; endif;?>">
             <?php if(isset($msg)):?>
        <span style="color:red;"><?php echo $msg; ?></span>
      <?php endif;?>
             
            </div>
            <div class="col-md-6">
                <strong>Last Name:</strong><br>
             <input type="text" name="LastName" class="form-control" placeholder="Last Name" required value="<?php if(isset($_POST['save_button'])): echo $LastName; endif;?>">
              <?php if(isset($msg)):?>
        <span style="color:red;"><?php echo $msg; ?></span>
      <?php endif;?>
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-md-12">
                 <strong>Email Address:</strong><br>
            <input type="email" name="EmailAddress" class="form-control" placeholder="Email Address / Username" value="<?php if(isset($_POST['save_button'])): echo $_POST['EmailAddress']; endif;?>">
            <?php if(isset($msg1)):?>
        <span style="color:red;"><?php echo $msg1; ?></span>
      <?php endif;?>
            </div>
        </div>
         <p></p>
    <div class="row">
          <div class="col-md-12">
            <strong>Contact Number:</strong><br>
            <input type="text" name="ContactNumber" class="form-control" placeholder="Contact Number" required value="<?php if(isset($_POST['save_button'])): echo $ContactNumber; endif;?>" >
            <?php if(isset($msg4)):?>
        <span style="color:red;"><?php echo $msg4; ?></span>
      <?php endif;?>
          </div>
          <div class="col-md-12">
            <strong>Permanent Address:</strong><br>
             <input type="text" name="PermanentAddress" class="form-control" placeholder="Permanent Address" required value="<?php if(isset($_POST['save_button'])): echo $PermanentAddress; endif;?>">
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <strong>Password:</strong><br>
             <input type="password" name="PassWord" class="form-control" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
               <?php if(isset($msg2)):?>
        <span style="color:red;"><?php echo $msg2; ?></span>
      <?php endif;?>
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-md-12">
                 <strong>Confirm Password:</strong><br>
            <input type="password" name="ConfirmPass" class="form-control" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            <?php if(isset($msg2)):?>
        <span style="color:red;"><?php echo $msg2; ?></span>
      <?php endif;?>
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-md-6">
            <strong>Birthday:</strong><br>
             <input type="date" name="bday" class="form-control" placeholder="Birthdate Address" required value="<?php if(isset($_POST['save_button'])): echo $bday; endif;?>">
            </div>
            <div class="col-md-6">
                <strong>Gender:</strong><br>
            <select class="form-control" name="sex">
              <option>Male</option>
              <option>Female</option>
             </select>
            </div>
        </div>

         <p></p>
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <button class="btn btn-info" style="background:#069; color:white; margin:0px;" name="save_button"><i class="fa fa-save"></i> Signup</button>
            <a href="index.php" class="btn btn-danger" style="background:red; color:white; margin:0px;"><i class="fa fa-arrow-left"></i> Back</a>
            
          </div>
          
          <!-- /.col -->
        </div>
      </form>
        </div><!-- contact-form -->
    </div><!-- / container -->
</section>
<!-- / contact -->

<!-- / content -->

<!-- scroll to top -->
<a href="#top" class="scroll-to-top page-scroll is-hidden" data-nav-status="toggle"><i class="fa fa-angle-up"></i></a>
<!-- / scroll to top -->

<!-- footer -->
<footer style="background:#333;">
    <div class="container">
        <p class="footer-info">© 2022 - Le Tooth Dental Clinic.
            <span class="social pull-right">
                <a href="https://m.facebook.com/Jancenangeles2017/?tsid=0.7777216089785313&source=result"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="https://instagram.com/jancenangeles?igshid=cqdyrvv6y5mn"><i class="fa fa-instagram"></i></a>
            </span>
        </p>
    </div><!-- / container -->
</footer>
<!-- / footer -->

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- sticky nav -->
<script src="js/jquery.easing.min.js"></script>
<script src="js/scrolling-nav-sticky.js"></script>
<!-- / sticky nav -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- wow -->
<script src="js/wow.min.js"></script>
<script>
new WOW().init();
</script>
<!-- / wow -->

<!-- gallery script -->
<script src="js/custom.js"></script>
<script src="js/jquery.shuffle.min.js"></script>
<!-- lightbox -->
<script src="js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
// This will create a single gallery from all elements that have class "lightbox"
$('.lightbox').each(function() {
    $(this).magnificPopup({
        delegate: 'a.open-gallery', // the selector for gallery item
        type: 'image',
        gallery: {
          enabled:true
        }
    });
});
</script>
<!-- / lightbox -->
<!-- / gallery script -->

<!-- date-time picker -->
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script>
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>
<?php if(isset($msg)):?>
<script type="text/javascript">
  alert("<?php echo $msg;?>");
</script>
<?php endif;?>
<!-- / date-time picker -->

<!-- contact-form -->
<script src="js/validator.min.js" type="text/javascript"></script>
<script src="js/form-scripts.js" type="text/javascript"></script>
<!-- / contact-form -->

<!-- google-maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBA40uewXP25u1A4o9u8ueBimZZwIdNLkY"></script>
<script src="js/map.js"></script>

<script src="js/hide-nav.js"></script>


</body>
</html>