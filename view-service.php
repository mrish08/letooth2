<?php
include 'config/db.php';
include 'config/functions.php';
include 'config/main_function.php';

if(!empty($_SESSION['login_admin']))
{
    header("location: ../login/admin/");
}
if(!empty($_SESSION['login_client']))
{
    header("Location: ../login/client/");
}
if(!empty($_SESSION['login_doctor']))
{
    header("Location: ../login/doctor/");
}
$services = fetchWhere("*","category_name","services",$_GET['cs_id']);
$getCat = getSingleRow("*","cs_id","service_category",$_GET['cs_id']);
?>


<!DOCTYPE html>
<html lang="en">

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
<style>
    #mycolor{
        color:white;
    }
</style>
<body>

<!-- preloader -->

<!-- / preloader -->

<div id="top"></div>

<!-- header -->
<header>
    
    <nav class="navbar navbar-default dark-bg navbar-fixed-top" style="background:rgba(1,1,1,0.6);width:100%;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="images/277855546_399124208329516_5361779838833002494_n.png" alt="logo"  width="200" style="border-radius:8px;"></a>
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav" >
                    <li style="padding-top: 20px;"><a href="index.php" id="mycolor" class="page-scroll">HOME</a></li>
                    <!--
                    <li style="padding-top: 20px;"><a href="index.php#about" id="mycolor"class="page-scroll">ABOUT</a></li>
                    <li style="padding-top: 20px;"><a href="index.php#menu" id="mycolor" class="page-scroll">SERVICES</a></li>
                    
                    <li style="padding-top: 20px;"><a href="index.php#contact" id="mycolor" class="page-scroll">CONTACT</a></li>
                    <li style="padding-top: 20px;"><a href="signup.php" id="mycolor" class="page-scroll">SIGNUP</a></li>
                -->
                   <li style="padding-top: 20px;"><a href="signup.php" id="mycolor" class="page-scroll"><i class="fa fa-pencil"></i> SIGN UP</a></li>
                   <li style="padding-top: 20px;"><a href="login/index.php" id="mycolor" class="page-scroll">LOGIN</a></li>
                    
                </ul>
            </div><!--/.nav-collapse -->
        </div><!-- / container -->
    </nav>

    <!-- / slider-->
</header>
<section id="about" >
    <div class="container" style="padding-top:7%;">
        <div class="row">
            <h2>Service: <?php echo $getCat['category_name']?></h2>
            <hr>

            <?php
//Columns must be a factor of 12 (1,2,3,4,6,12)
$numOfCols = 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="row">

<?php if(!empty($services)){?>
<?php
foreach ($services as $row){
?>  
        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
        <?php if($row->service_photo == ""):?>
             <img src="images/logo.png" class="img-circle">
        <?php else:?>
            <img src="images/<?php echo $row->service_photo ?>" class="img-circle">
        <?php endif;?>
             <h5 class="food-title">
                <center>
                    <?php echo $row->service_name;?> <span class="pull-right food-price text-primary"></span>
                </center>
                    </h5>
             
              <p class="food-text" style="color:#333; font-size: 16px; line-height: 25px;"><?php echo substr($row->service_desc,0,200);?></p>
          
        </div>
<?php
    $rowCount++;
    if($rowCount % $numOfCols == 0) echo '</div>';
?>
    <div class="row">

<?php 
  }
}else{
?>
<div class="alert alert-danger">No Records on the database.</div>
<?php }?>
        </div><!-- / row -->

    </div><!-- / container -->
</section>
<!-- / about -->


<!-- reservations -->

<a href="#top" class="scroll-to-top page-scroll is-hidden" data-nav-status="toggle" style="right:600px;"><i class="fa fa-angle-up"></i></a>
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
<!-- / google-maps -->

<!-- hide nav -->
<script src="js/hide-nav.js"></script>


</body>
</html>