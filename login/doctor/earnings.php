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
<style type="text/css">
  @media print {
  #printPageButton {
    display: none;
  }
}
</style>
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
            <h4 class="m-0 text-dark">Doctor Reports</h4>
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
<?php if($_GET['option'] == '1'): ?>
  
 <form method="post" id="printPageButton">
        
        <div class="row" id="printPageButton">
          <div class="col-md-8">
            <strong>Date:</strong>
            <input type="date" name="from" class="form-control" value="<?php if(isset($_POST['search_btn'])): echo $_POST['from']; endif;?>">
          </div>
          <!--
          <div class="col-md-4">
            <strong>Dentist Name:</strong>
            <select class="form-control" name="ID">
                <?php 
                $list = fetchWhere("*","UserRole","accounts","1");
                foreach ($list as $key => $value):
                ?>
                <option value="<?php echo $value->ID?>" <?php 
                if(isset($_POST['search_btn'])){
                  if($_SESSION['ID'] == $value->ID){
                    echo 'selected';
                  }
                
                }
                ?>><?php echo $value->FirstName?> <?php echo $value->LastName?></option>
                <?php endforeach;?>
              </select>
          </div>
          -->
          <div class="col-md-4">
            <br>
            <button class="btn btn-info" name="search_btn">Search</button>
            <a href="index.php" class="btn btn-danger">Return</a>
          </div>
        </div>
       </form>
<hr>
<?php if(isset($_POST['search_btn'])):?>
<?php $dentist = getSingleRow("*","ID","accounts",$_SESSION['ID']);?>
<div class="row">
  <div class="col-md-2">
    <strong>Dentist Name</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['FirstName']?> <?php echo $dentist['MiddleName']?> <?php echo $dentist['LastName']?></div>
  <div class="col-md-2">
    <strong>Email Address</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['EmailAddress']?></div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2">
    <strong>Contact Number</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['ContactNumber']?> </div>
  <div class="col-md-2">
    <strong>Permanent Address</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['PermanentAddress']?></div>
</div>
<hr>
  <?php 
  $query = 'SELECT * FROM doctor_schedule 
  INNER JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  INNER JOIN services on services.service_id = doctor_schedule.service_id
  WHERE doctor_schedule.ID = "'.$_SESSION['ID'].'" AND (sched_status = "3" OR sched_status = "2") AND available_date = "'.$_POST['from'].'"
  GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Invoice Number</th>
          <th>Date Requested</th>
          <th>Services</th>
          <th>Customer</th>
          <th>Total Fee</th>
          
          <th>Status</th>          
        </tr>
      </thead>
    <tbody>
  <?php 
  
  foreach ($g as $key => $value):
    
    
  ?>
    <tr>
      <td><?php echo $value->invoice_num;?></td>
      <td><?php echo $value->available_date?></td>
      <td>
       <?php echo $value->service_name?>
      </td>
      <td>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
      </td>
      <td>&#8369; <?php echo number_format($value->service_price,2);?></td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Fulfilled'; elseif($value->sched_status == '4'): echo 'Cancelled Appointment';endif; ?>
      </td>
      
    </tr>
  
  <?php endforeach;?>
</tbody>
</table>
<center><a href="" id="printPageButton" class="btn btn-warning" onclick="print()"><i class="fa fa-print"></i> Print</a></center>

  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>    
<?php endif;?>
<?php elseif($_GET['option'] == '2'): ?>
  <form method="post" id="printPageButton">
        
        <div class="row" id="printPageButton">
          <div class="col-md-4">
            <strong>Month:</strong>
            <select class="form-control" name="month">
              <?php
             $months = array("Jan", "Feb", "Mar", "Apr","May","Jun","Jul","Aug","Sept","Oct","Nov", "Dec");

             foreach ($months as $key => $month) 
             {
                $count = $key + 1;
                echo "<option value=\"" . $count . "\">" . $month . " </option>";
             }
             ?>
            </select>
          </div>
          <div class="col-md-4">
            <strong>Year:</strong>
            <select class="form-control" name="year">
           <?php for ($i=1991; $i < 2090; $i++):?>
            <option><?php echo $i;?></option>
           <?php endfor;?>
         </select>
          </div>
          <!--
          <div class="col-md-3">
            <strong>Dentist Name:</strong>
            <select class="form-control" name="ID">
                <?php 
                $list = fetchWhere("*","UserRole","accounts","1");
                foreach ($list as $key => $value):
                ?>
                <option value="<?php echo $value->ID?>" <?php 
                if(isset($_POST['search_btn'])){
                  if($_SESSION['ID'] == $value->ID){
                    echo 'selected';
                  }
                
                }
                ?>><?php echo $value->FirstName?> <?php echo $value->LastName?></option>
                <?php endforeach;?>
              </select>
          </div>
          -->
          <div class="col-md-2">
            <br>
            <button class="btn btn-info" name="search_btn">Search</button>
            <a href="index.php" class="btn btn-danger">Return</a>
          </div>
        </div>
       </form>
<hr>
<?php if(isset($_POST['search_btn'])):?>
  <?php $dentist = getSingleRow("*","ID","accounts",$_SESSION['ID']);?>
<div class="row">
  <div class="col-md-2">
    <strong>Dentist Name</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['FirstName']?> <?php echo $dentist['MiddleName']?> <?php echo $dentist['LastName']?></div>
  <div class="col-md-2">
    <strong>Email Address</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['EmailAddress']?></div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2">
    <strong>Contact Number</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['ContactNumber']?> </div>
  <div class="col-md-2">
    <strong>Permanent Address</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['PermanentAddress']?></div>
</div>
<hr>
<?php 
  $query = 'SELECT * FROM doctor_schedule 
  INNER JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  INNER JOIN services on services.service_id = doctor_schedule.service_id WHERE doctor_schedule.ID = "'.$_SESSION['ID'].'" AND MONTH(available_date) = "'.$_POST['month'].'" AND YEAR(available_date) = "'.$_POST['year'].'"
  GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Invoice Number</th>
          <th>Date Requested</th>
          <th>Services</th>
          <th>Customer</th>
          <th>Total Fee</th>
          
          <th>Status</th>          
        </tr>
      </thead>
    <tbody>
  <?php 
  foreach ($g as $key => $value):
  ?>
    <tr>
      <td><?php echo $value->invoice_num;?></td>
      <td><?php echo $value->available_date?></td>
      <td>
       <?php echo $value->service_name?>
      </td>
      <td>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
      </td>
      <td>&#8369; <?php echo number_format($value->service_price,2);?></td>
     
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Done Transaction'; elseif($value->sched_status == '4'): echo 'Cancelled Appointment';endif; ?>
      </td>
      
    </tr>
  
  <?php endforeach;?>
</tbody>
</table>

<center><a href="" id="printPageButton" class="btn btn-warning" onclick="print()"><i class="fa fa-print"></i> Print</a></center>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
<?php endif;?>
<?php elseif($_GET['option'] == '3'): ?>
  <form method="post" id="printPageButton">
        
        <div class="row" id="printPageButton">
          <div class="col-md-4">
            <strong>From:</strong>
 <input type="date" name="from" class="form-control" value="<?php if(isset($_POST['search_btn'])): echo $_POST['from']; endif;?>">
          </div>
          <div class="col-md-4">
            <strong>Until:</strong>
            <input type="date" name="until" class="form-control" value="<?php if(isset($_POST['search_btn'])): echo $_POST['until']; endif;?>">
          </div>
          <!--
          <div class="col-md-3">
            <strong>Dentist Name:</strong>
            <select class="form-control" name="ID">
                <?php 
                $list = fetchWhere("*","UserRole","accounts","1");
                foreach ($list as $key => $value):
                ?>
                <option value="<?php echo $value->ID?>" <?php 
                if(isset($_POST['search_btn'])){
                  if($_SESSION['ID'] == $value->ID){
                    echo 'selected';
                  }
                
                }
                ?>><?php echo $value->FirstName?> <?php echo $value->LastName?></option>
                <?php endforeach;?>
              </select>
          </div>
        -->
          
          <div class="col-md-2">
            <br>
            <button class="btn btn-info" name="search_btn">Search</button>
            <a href="index.php" class="btn btn-danger">Return</a>
          </div>
        </div>
       </form>
<hr>
<?php if(isset($_POST['search_btn'])):?>
<?php $dentist = getSingleRow("*","ID","accounts",$_SESSION['ID']);?>
<div class="row">
  <div class="col-md-2">
    <strong>Dentist Name</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['FirstName']?> <?php echo $dentist['MiddleName']?> <?php echo $dentist['LastName']?></div>
  <div class="col-md-2">
    <strong>Email Address</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['EmailAddress']?></div>
</div>
<p></p>
<div class="row">
  <div class="col-md-2">
    <strong>Contact Number</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['ContactNumber']?> </div>
  <div class="col-md-2">
    <strong>Permanent Address</strong>
  </div>
  <div class="col-md-4"><?php echo $dentist['PermanentAddress']?></div>
</div>
<hr>
<?php 
  $query = 'SELECT * FROM doctor_schedule 
  INNER JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  INNER JOIN services on services.service_id = doctor_schedule.service_id WHERE doctor_schedule.ID = "'.$_SESSION['ID'].'" AND (available_date BETWEEN "'.$_POST['from'].'" AND "'.$_POST['until'].'")
  GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Invoice Number</th>
          <th>Date Requested</th>
          <th>Services</th>
          <th>Customer</th>
          <th>Total Fee</th>
          
          <th>Status</th>          
        </tr>
      </thead>
    <tbody>
  <?php 
  foreach ($g as $key => $value):
  ?>
    <tr>
      <td><?php echo $value->invoice_num;?></td>
      <td><?php echo $value->available_date?></td>
      <td>
       <?php echo $value->service_name?>
      </td>
      <td>
        <?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
      </td>
      <td>&#8369; <?php echo number_format($value->service_price,2);?></td>
     
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval'; elseif($value->sched_status == '0'): echo 'Draft'; elseif($value->sched_status == '2'): echo 'Approved'; elseif($value->sched_status == '3'): echo 'Done Transaction'; elseif($value->sched_status == '4'): echo 'Cancelled Appointment';endif; ?>
      </td>
      
    </tr>
  
  <?php endforeach;?>
</tbody>
</table>
</tbody>
</table>
<hr>

<center><a href="" id="printPageButton" class="btn btn-warning" onclick="print()"><i class="fa fa-print"></i> Print</a></center>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
<?php endif;?>
<?php endif;?>

               
              </div>
            </div>


          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>


<?php include'../assets/footer.php';?>
</body>
</html>
