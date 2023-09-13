<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
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
<body>
  <div class="container">
<center>
  <img src="../../images/277855546_399124208329516_5361779838833002494_n.png" width="200"> 
  <?php 
    if($_GET['option'] == '1'): $title = 'Client Report'; elseif($_GET['option'] == '2'): $title = 'Doctor Report'; else: $title = 'Services Report'; endif;
  ?>
  <h1><?php echo $title?></h1>
</center>
<?php
if($_GET['option'] == '1'):
    $customer = fetchWhere("*","UserRole","accounts","2");
?>
<?php if(!empty($customer)):?>   
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Contact Number</th>
                  <th>Address</th>
                  <th>Gender</th>
                  <th>Age</th>
                  <th>Civil Status</th>
                  <th>Occupation</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($customer as $key => $value):?>
                <tr>
                  <td>
                    <img src="../../images/<?php echo $value->UserPhoto?>"  style="width:150px; height:100px;">
                  </td>
                  <td><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
                  <?php if($value->UserStatus == '1'):?>
                    <p class="text-success">Activated</p>
                  <?php else:?>
                    <div class="text-danger">Deactivated</div>
                  <?php endif;?>
                  </td>
                  <td><?php echo $value->EmailAddress?></td>
                  <td><?php echo $value->ContactNumber?></td>
                  <td><?php echo $value->PermanentAddress?></td>
                  <td><?php echo $value->sex?></td>
                  <td><?php echo $value->user_age?></td>
                  <td><?php echo $value->civil_status?></td>
                  <td><?php echo $value->occupation?></td>
                </tr>
<?php endforeach;?>
              </tbody>
</table>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
<?php endif;?>
<?php 
elseif($_GET['option'] == '2'):
  $doctor = fetchWhere("*","UserRole","accounts","1");
?>
<?php if(!empty($doctor)):?>   
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Contact Number</th>
                  <th>Address</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($doctor as $key => $value):?>
                <tr>
                  <td>
                    <img src="../../images/<?php echo $value->UserPhoto?>" class="img-thumbnail" width="100">
                  </td>
                  <td><?php echo $value->FirstName?> <?php echo $value->MiddleName?> <?php echo $value->LastName?>
                  <?php if($value->UserStatus == '1'):?>
                    <p class="text-success">Activated</p>
                  <?php else:?>
                    <div class="text-danger">Deactivated</div>
                  <?php endif;?>
                  </td>
                  <td><?php echo $value->EmailAddress?></td>
                  <td><?php echo $value->ContactNumber?></td>
                  <td><?php echo $value->PermanentAddress?></td>
                  
                </tr>
<?php endforeach;?>
              </tbody>
</table>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
<?php endif;?>
<?php 
else:
  $services = fetchAll("*","services");
?>
<?php if(!empty($services)):?>   
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Service Name</th>
                  <th width="300">Description</th>
                  <th>Date Created</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($services as $key => $value):?>
                <tr>
                  <td>
                    <?php if($value->service_photo == ""):?>
                      <img src="../../images/logo.png" class="img-thumbnail" style="width:200px;">
                    <?php else:?>
                    <img src="../../images/<?php echo $value->service_photo?>" class="img-thumbnail" style="width:200px; height:150px;">
                  <?php endif;?>
                  </td>
                  <td><?php echo $value->service_name?></td>
                  <td><?php echo $value->service_desc?></td>
                  <td><?php echo $value->date_created?></td>

                </tr>
<?php endforeach;?>
              </tbody>
</table>
<?php else:?>
  <div class="alert alert-danger">No Records on database.</div>
<?php endif;?>
<?php endif;?>
<center>
    <a href="" class="btn btn-primary" id="printPageButton" onClick="window.print();">Print Preview</a>
    <a href="index.php" class="btn btn-danger" id="printPageButton">Return</a>
  </center>
  </div>
</body>