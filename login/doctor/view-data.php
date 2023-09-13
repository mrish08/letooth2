<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
    header("Location: ../../index.php");
    exit;
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
            <h1 class="m-0 text-dark"><i class="fa fa-th"></i> View Information</h1>
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
<br>
<?php   
$query2 = "SELECT * FROM  reservation 
INNER JOIN services on services.service_id = reservation.service_id 
WHERE ds_id = '".$_GET['ds_id']."' AND customer_id = '".$_GET['ID']."'";
$service_taken = SQLJOIN($query2);
?>

<div class="row">
  <div class="col-md-7">
    <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
    <?php if(!empty($service_taken)):?>
      <?php foreach ($service_taken as $key => $value):?>
                              <li>
                        <i class="fa fa-plus bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?php echo $value->date_created;?></span>

                          <h3 class="timeline-header"><a href="#"><?php echo $value->service_name;?></a> <?php if($value->service_type == '0'): echo 'Surgical'; else: echo 'Non Surgical'; endif;?></h3>

                          <div class="timeline-body">
                            <?php echo $value->service_desc;?>
                          </div>
                        </div>
                      </li>
      <?php endforeach;?>
    </ul>
  </div>
    <?php else:?>
      <div class="alert alert-danger">There are no records on the database.</div>
    <?php endif;?>
  </div>
  <?php 
  $query = "SELECT * FROM reservation_description WHERE ds_id = '".$_GET['ds_id']."' AND customer_id = '".$_GET['ID']."'";
  $getData = fetchRow($query);

  $getD = getSingleRow("*","ds_id","doctor_schedule",$_GET['ds_id']);
  ?>
  <div class="col-md-5">
    <h3><i class="fa fa-pencil"></i> Recommendations:</h3>
    <strong>Description:</strong>
  <blockquote><?php echo $getData['reserve_desc']?></blockquote>
  <br>
  <strong>Doctor Recommendation:</strong>
  <blockquote><?php echo $getD['doc_rec']?></blockquote>

  </div>

</div>
<div class="col-md-3">
<a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Return</a>
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

  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>
</body>
</html>
