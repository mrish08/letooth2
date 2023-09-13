<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);
  $customer = fetchWhere("*","UserRole","accounts","2");
  
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
            <h1><i class="fa fa-users"></i> Client Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Client Information</li>
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
            <div class="card" style="padding: 15px;">
<?php if(!empty($customer)):?>   
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Contact Number</th>
                  <th>Address</th>
                  <th>Option</th>
                </tr>
                </thead>
                <tbody>
<?php 
foreach ($customer as $key => $value):
  $kweri = $dbcon->query("SELECT * FROM doctor_schedule WHERE customer_id = '".$value->ID."' AND ID = '".$_SESSION['ID']."'") or die(mysqli_error());
?>
                <tr>
                  <td>
                    <img src="../../images/<?php echo $value->UserPhoto?>" class="img-thumbnail" width="100">
                  </td>
                  <td><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?><br>
                  <?php if(mysqli_num_rows($kweri) == 0):?><span style="color:red;">No Records from my Account</span><?php else:?><span style="color:green;">Past / Existing Client</span><?php endif;?>
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
   <li><a href="" data-toggle="modal" data-target="#view-information<?php echo $value->ID?>"><i class="fa fa-file"></i> View Information</a></li>
                      <li>
  


                    </ul>
                  </div>
                    
                  </td>
                </tr>
                <!-- Modals-->
     <div class="modal fade" id="view-information<?php echo $value->ID?>" style="width:100%;">
    <?php
      $kweri = $dbcon->query("SELECT * FROM accounts WHERE ID = '".$value->ID."'") or die(mysqli_error());
  $getData = $kweri->fetch_assoc();
    ?>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-pencil"></i> My Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="post">
                <div class="row">
          <div class="col-md-12">
            <div class="row">

</div>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Client Name:</strong></div>
  <div class="col-md-4"><?php echo $getData['FirstName']?>  <?php echo $getData['MiddleName']?> <?php echo $getData['LastName']?></div>
  <div class="col-md-2"><strong>Contact #:</strong></div>
  <div class="col-md-4"><?php echo $getData['ContactNumber']?></div>
</div>
<p></p>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Email Address:</strong></div>
  <div class="col-md-4"><?php echo $getData['EmailAddress']?></div>
  <div class="col-md-2"><strong>Contact Number</strong></div>
  <div class="col-md-4"><?php echo $getData['EmailAddress']?></div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Permanent Address:</strong></div>
  <div class="col-md-4"><?php echo $getData['PermanentAddress']?></div>
  <div class="col-md-2"><strong>Age:</strong></div>
  <div class="col-md-4"><?php echo $getData['user_age']?></div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2"><strong>Birthday:</strong></div>
  <div class="col-md-4"><?php echo $getData['bday']?></div>
  <div class="col-md-2"><strong>Gender:</strong></div>
  <div class="col-md-4"><?php echo $getData['sex']?></div>
</div><p></p>
<div class="row">
  <div class="col-md-2"><strong>Occupation:</strong></div>
  <div class="col-md-4"><?php echo $getData['occupation']?></div>
  <div class="col-md-2"></div>
  <div class="col-md-4"></div>
</div>
          </div>
<div style="padding:5px;border-top:1px solid;width:100%;"></div>


  </div>
</div>
  



        </div><br>

        <br>

                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
<!-- End of Modal -->
<?php endforeach;?>
              </tbody>
</table>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
<?php endif;?>
            </div>
            <!-- /.nav-tabs-custom -->
          </div>

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
<?php include'../assets/footer.php';?>

</body>
</html>
