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
              <li class="breadcrumb-item active">User Profile</li>
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
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" href="#activity" data-toggle="tab"><i class="fa fa-calendar"></i> My Schedule</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#timeline" data-toggle="tab"><i class="fa fa-file"></i> Services</a>
                  </li>
                  
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  
                    <div id="calendar"></div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
<?php if(!empty($services)):?>
<?php foreach ($services as $key => $value):?>
                      <li>
                        <i class="fa fa-wrench bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?php echo $value->date_created;?></span>

                          <h3 class="timeline-header"><a href="#"><?php echo $value->service_name;?></a> <?php if($value->service_type == '0'): echo 'Surgical'; else: echo 'Non Surgical'; endif;?></h3>

                          <div class="timeline-body">
                          <div class="row">
                            <div class="col-md-6">
                              <img src="../../images/<?php echo $value->service_photo?>" class="img-thumbnail">
                            </div>
                            <div class="col-md-6">
                              <?php echo $value->service_desc;?>
                            </div>
                          </div>
                          </div>
                        </div>
                      </li>
<?php endforeach;?>
<?php else:?>
  <div class="alert alert-danger">There are no records on the database.</div>
<?php endif;?>
                      <!-- END timeline item -->                      
                    </ul>
                  </div>
                  <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
                    <div class="col-md-3">

            <!-- Profile Image -->

            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header" style="background:rgb(184, 90, 233);">
                <h3 class="card-title"><i class="fa fa-user"></i> My Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fa fa-book mr-1"></i> Contact Number</strong>

                <p class="text-muted">
                  <?php echo $name['ContactNumber']?>
                </p>

                <hr>

                <strong><i class="fa fa-map-marker mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $name['PermanentAddress']?></p>

                <hr>

                <strong><i class="fa fa-envelope mr-1"></i> Email Address</strong>

                <p class="text-muted">
                  <span class="tag tag-danger"><?php echo $name['EmailAddress']?></span>
                  
                </p>

                <hr>

                
              </div>
              <!-- /.card-body -->
            </div>
                        <div class="card card-primary">
              <div class="card-header" style="background:rgb(184, 90, 233);">
                <h3 class="card-title"><i class="fa fa-calendar"></i> Calendar Legend</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>Reserved</strong>
                <div style="background: red; height:20px; width:20px;"></div>
                <hr>

                <strong>Fullfilled</strong>
                <div style="background: green; height:20px; width:20px;"></div>              
              </div>
              <!-- /.card-body -->
            </div>
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
<script type="text/javascript">
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        defaultView: 'month',
        events: {
            url: 'getEvent-client.php',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching events.');
            }
           
        }

    });
});
</script>
</body>
</html>
