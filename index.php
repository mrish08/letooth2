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
$services = fetchAll("*","service_category");

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
                    <li style="padding-top: 20px;"><a href="#top" id="mycolor" class="page-scroll"><i class="fa fa-home"></i> HOME</a></li>
                    <!--
                    <li style="padding-top: 20px;"><a href="#about" id="mycolor"class="page-scroll">ABOUT</a></li>
                    <li style="padding-top: 20px;"><a href="#menu" id="mycolor" class="page-scroll">SERVICES</a></li>
                    -->
                    <li style="padding-top: 20px;"><a href="signup.php" id="mycolor" class="page-scroll"><i class="fa fa-pencil"></i> SIGN UP</a></li>
                    <li style="padding-top: 20px;"><a href="login/index.php" id="mycolor" class="page-scroll"><i class="fa fa-lock"></i> LOGIN</a></li>
                    
                    
                </ul>
            </div><!--/.nav-collapse -->
        </div><!-- / container -->
    </nav>

    <!-- slider -->
    <div id="slider" class="carousel slide has-top-menu dark-slider">  
        <div class="carousel-inner">

            <!-- slide 1 -->
            <div class="item active slide1">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="row">
                            <div class="col-md-12 slider-content">
                                <!--
                                <h2 class="slide-title fadeInUp animated second space-top-30">Welcome to Le Tooth Dental Clinic</h2>
                                <div class="separator-line-center-2x primary-bg-color animated fadeInDown third"></div>
                                <br>
                                <p style="line-height: 30px;color:white; font-size:30px;background:rgba(0,0,0,0.6);padding:10px;">Unit 609, BSA Twin Towers Condotel, Bank Drive Brgy. Wack Wack, Ortigas Center, Mandaluyong City, Philippines. </p>
                                <br>
                                <a href="login/" class="btn btn-warning btn-lg" style="background:rgb(184, 90, 233); color:white;"><i class="fa fa-lock"></i> Login Account</a>
                            -->
                            </div><!-- slider-content -->
                        </div><!-- / row -->
                    </div><!-- / carousel-caption -->
                </div><!-- / container -->
            </div><!-- / slide 1 -->

            <div class="item slide2">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="row">
  <div class="col-md-12 slider-content">
                                <!--
                                <h2 class="slide-title fadeInUp animated second space-top-30">Welcome to Le Tooth Dental Clinic</h2>
                                <div class="separator-line-center-2x primary-bg-color animated fadeInDown third"></div>
                                <br>
                                 <p style="line-height: 30px;color:white; font-size:30px;background:rgba(0,0,0,0.6);padding:10px;">Unit 609, BSA Twin Towers Condotel, Bank Drive Brgy. Wack Wack, Ortigas Center, Mandaluyong City, Philippines. </p>
                                <br>
                                <a href="login/" class="btn btn-warning btn-lg" style="background:rgb(184, 90, 233); color:white;"><i class="fa fa-lock"></i> Login Account</a>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- slide 3 -->


        </div><!-- /carousel-inner -->

        <!-- controls -->
        <a class="left carousel-control" href="#slider" data-slide="prev"><span class="fa fa-angle-left"></span></a>
        <a class="right carousel-control" href="#slider" data-slide="next"><span class="fa fa-angle-right"></span></a>
        <!-- / controls -->

    </div>
    <!-- / slider-->
</header>
<!-- / header -->
<section id="menu" style="background:rgb(184, 90, 233);">
    <div class="container">
    <h1 style="color:#333;">Services</h1>
        <hr>
        <div class="row">
<div class="col-md-12">
<?php
//Columns must be a factor of 12 (1,2,3,4,6,12)
$numOfCols = 4;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="row">

<?php if(!empty($services)){?>
<?php
foreach ($services as $row){
?>  
        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
             <img src="images/logo.png" class="img-circle">
             <h5 class="food-title">
                <center>
                    <a href="view-service.php?cs_id=<?php echo $row->cs_id?>" style="color:#333;"><?php echo $row->category_name;?> <span class="pull-right food-price text-primary"></span>
                </center>
                    </center></h5>
             <!--
              <p class="food-text" style="color:white;"><?php echo substr($row->service_desc,0,200);?></p>
          -->
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
</div>

    </div><!-- / container -->
</section>
<!-- content -->

<section id="about">
    <div class="container">
        <div class="row">
            <h2>About Us</h2>
            <hr>
            <div class="col-md-4 about-img wow fadeInLeft first">
               <img src="images/about1.PNG" class="img-circle">
               <br>
               <center>
               <h4>The Best Doctors!</h4>
               <p>We your SA19 Le Tooth team will make it possible for you to get that smile you always wanted.</p>
           </center>
            </div><!-- / about-img -->
            <div class="col-md-4 about-text wow fadeInRight first">
              <img src="images/about2.PNG" class="img-circle">
              <br>
               <center>
               <h4>We Smile as One</h4>
               <p>We your SA19 team ensures your safety while providing our best dental services for you. </p>
            </div>
            <div class="col-md-4 about-text wow fadeInRight first">
              <img src="images/about3.PNG" class="img-circle">
               <br>
               <center>
               <h4>Book your appointments now!</h4>
               <p>Experience quality service without spending premium</p>  
                
            </div>
        </div><!-- / row -->

    </div><!-- / container -->
</section>
<!-- / about -->


<!-- reservations -->



<section id="contact" style="background:rgb(184, 90, 233);">
    <!-- google-maps -->
    <div class="container" style="padding-top: 30px;">
        <div class="page-header dark text-center">
            <h2 style="color:#333;">Contact</h2>
            <div class="separator-line-center primary-bg-color medium-spacing">&nbsp;</div>
            <h4 class="sub-title" style="color:#333;">Unit 609, BSA Twin Towers Condotel, Bank Drive Brgy. Wack Wack, Ortigas Center, Mandaluyong City, Philippines. 

<a href="tel:0123456789"><i class="fa fa-phone"></i><span>+639277750918</span></a></h4>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.22873897701!2d121.05588951385398!3d14.58603788981175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8166e91136d%3A0xb1f615c0b7fe60f9!2sBSA%20Twin%20Towers%20Hotel!5e0!3m2!1sen!2sph!4v1649504385920!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <div class="space-50">&nbsp;</div>
        </div>
</section>

<!-- / contact -->

<!-- / content -->

<!-- scroll to top -->
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
<!-- / hide nav -->

<!-- / javascript -->

</body>


<!-- Mirrored from kingstudio.ro/demos/mr/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Oct 2017 15:09:40 GMT -->
</html>