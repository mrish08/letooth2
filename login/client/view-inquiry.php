<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  $getInquiry = getSingleRow("*","i_id","inquiries",$_GET['i_id']);

  if(isset($_POST['reply_btn'])){
    $reply_txt = $_POST['reply_txt'];
    $doctor_id = $_SESSION['ID'];
    $i_id = $_GET['i_id'];

    $query = array(
      "inquiry_msg"     =>$reply_txt,
      "reply_user"      =>$doctor_id,
      "i_id"            =>$i_id,
      "date_created"    =>date("Y-m-d h:i a")
    );
    SaveData("reply",$query);
    header("location: view-inquiry.php?i_id=".$_GET['i_id']."");
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
      <?php echo $getInquiry['inquiry_desc']?>
      <hr>
      <?php 
  $query1 = $dbcon->query("SELECT * FROM reply WHERE i_id = '".$_GET['i_id']."'") or die(mysqli_error());
  while($row = $query1->fetch_assoc()){
    $getCustomer = getSingleRow("*","ID","accounts",$row['reply_user']);
    
     if($getCustomer['UserRole'] == '1'){
        $r = 'info';
    }elseif($getCustomer['UserRole'] == '2'){
        $r = 'success';
    }
?>
<div class="callout callout-<?php echo $r;?>">
  <h5 style="font-size:18px;">
    <?php echo $getCustomer['FirstName']?> <?php echo $getCustomer['MiddleName']?> <?php echo $getCustomer['LastName']?> - <?php echo $row['date_created']?>
  </h5>

  <p style="color:#828080;"><?php echo $row['inquiry_msg']?></p>
                 
  </div>
<?php
  }
?>
      <form method="post">
        <textarea class="form-control" name="reply_txt" placeholder="Please enter your reply..." required></textarea>
        <p></p>
        <button class="btn btn-info" name="reply_btn"><i class="fa fa-ok"></i> Reply</button>
        <a href="inquiry.php" class="btn btn-danger"><i class="fa fa-arro-left"></i> Return</a>
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

  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>
</body>
</html>
