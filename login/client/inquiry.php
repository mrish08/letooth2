<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $services = fetchAll("*","services");
  
  
  if(isset($_POST['one'])){
  $user = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $msg = $_POST['inquiry'];
  $insert = array(
    "client_id"       =>$_SESSION['ID'],
    "doctor_id"       =>$_POST['ID'],
    "available_date"  =>$_POST['mydate'],
    "date_created"    =>date("Y-m-d h:i a"),
    "inquiry_desc"    =>$msg
  );
  SaveData("inquiries",$insert);

  echo '<script>alert("You have successfully send inquiry to Doctor.");window.location="index.php";</script>';
  }
  

  $query = $dbcon->query("SELECT * FROM inquiries WHERE client_id = '".$_SESSION['ID']."'") or die(mysqli_error());
  $count = mysqli_num_rows($query);
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
        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Welcome! <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><a href="" style="color:#333;">Messages <span class="right badge badge-danger"><?php echo $count?></span></a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card" style="padding:10px;">

            <h4>Inquiry</h4>
            <hr>
            <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <strong>Doctor Name:</strong>
                    <select name="ID" class="form-control">
                <?php $g = $dbcon->query("SELECT * FROM accounts WHERE UserRole = '1'") or die(mysqli_error());
                while($fetch = $g->fetch_assoc()){
                ?>
                <option value="<?php echo $fetch['ID']?>"><?php echo $fetch['FirstName']?> <?php echo $fetch['LastName']?></option>
                <?php
                }
                ?>
                
            </select>
            
            <strong>Inquiry:</strong>
               <textarea class="form-control" name="inquiry" placeholder="Please enter your inquiry"></textarea>
                </div>
                <div class="col-md-6">
                 
                </div>
            </div>
            <br>
            <button class="btn btn-info" name="one">Send Inquiry</button>
            </form>
        
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
                    <div class="col-md-3">

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
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
