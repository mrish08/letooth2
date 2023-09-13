<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_doctor'])){
    header("Location: ../../index.php");
    exit;
  }
  $name = getSingleRow("*","ID","accounts",$_SESSION['ID']);

  $kweri = $dbcon->query("SELECT * FROM doctor_schedule 
  INNER JOIN accounts on accounts.ID = doctor_schedule.ID 
  WHERE ds_id = '".filter($_GET['ds_id'])."'") or die(mysqli_error());
  $getDoctor = $kweri->fetch_assoc();

  $kweri2 = $dbcon->query("SELECT * FROM doctor_schedule 
  INNER JOIN accounts on accounts.ID = doctor_schedule.customer_id 
  WHERE ds_id = '".filter($_GET['ds_id'])."'") or die(mysqli_error());
  $getCustomer = $kweri2->fetch_assoc();
  $getData = getSingleRow("*","ds_id","doctor_schedule",$_GET['ds_id']);

    if(isset($_POST['save_btn2'])){
    $arr_where = array("ds_id"=>$_GET['ds_id']);//update where
    $arr_set = array(
        "doc_rec"           =>$_POST['doc_rec'],
        "sched_status"      =>"3"
    );//set update
    $tbl_name = "doctor_schedule";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);

      $msg = 'Doctor has already set a recommendations / actions required for this service: '.$_POST['doc_rec'].'';
      $msg2 = 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.';
      $notification = array(
        "ds_id"             =>$_GET['ds_id'],
        "notif_status"      =>"0",
        "notif_type"        =>"2",
        "notif_user"        =>$getData['customer_id'],
        "notif_desc"        =>$msg,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      $notification2 = array(
        "ds_id"             =>$_GET['ds_id'],
        "notif_status"      =>"0",
        "notif_type"        =>"0",
        "notif_user"        =>"0",
        "notif_desc"        =>$msg2,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      SaveData("notifications",$notification);
      SaveData("notifications",$notification2);
    
    echo "<script>alert('You have updated your recommendations'); window.location = 'index.php';</script>";

  }
  
  if(isset($_POST['save_btn'])){
    $arr_where = array("ds_id"=>$_GET['ds_id']);//update where
    $arr_set = array("doc_rec"=>$_POST['doc_rec']);//set update
    $tbl_name = "doctor_schedule";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);

      $msg = 'Doctor has already set a recommendations / actions required for this service: '.$_POST['doc_rec'].'';
      $msg2 = 'PAYMENT REQUIRED: Please be informed that the doctor set a recommendations and actions required on the service. Please ask the customer regarding the payment.';
      $notification = array(
        "ds_id"             =>$_GET['ds_id'],
        "notif_status"      =>"0",
        "notif_type"        =>"2",
        "notif_user"        =>$getData['customer_id'],
        "notif_desc"        =>$msg,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      $notification2 = array(
        "ds_id"             =>$_GET['ds_id'],
        "notif_status"      =>"0",
        "notif_type"        =>"0",
        "notif_user"        =>"0",
        "notif_desc"        =>$msg2,
        "notif_date"        =>date("Y-m-d h:i a")
      );
      SaveData("notifications",$notification);
      SaveData("notifications",$notification2);

    echo "<script>alert('You have updated your recommendations'); window.location = 'index.php';</script>";

  }

  if(isset($_POST['pay_btn'])){
    $getPayment = getSingleRow("*","service_id","services",$getData['service_id']);
    $ds_id = filter($_GET['ds_id']);
    if($getPayment['service_price'] > $_POST['payment']){
      echo "<script>alert('Your payment is incomplete. Please pay ".$getPayment['service_price']."'); window.location = 'view-billing.php?ds_id=".$ds_id."';</script>";   
    }else{
      $arr_where = array("ds_id"=>$ds_id);//update where
      $arr_set = array("sched_status"=>"3");//set update
      $tbl_name = "doctor_schedule";
      $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);

      $query1 = array(
        "invoice_num"           =>$getData['invoice_num'],
        "transaction_amount"    =>$_POST['payment'],
        "doctor_id"             =>$getData['ID'],
        "customer_id"           =>$getData['customer_id'],
        "date_created"          =>date("Y-m-d h:i a")
      );
      SaveData("payment_transaction",$query1);
      echo "<script>alert('Your payment is now complete. Thank you'); window.location = 'index.php';</script>";
    }
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
        <section class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">

                          <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fa fa-calendar-o"></i> Appointment Information
                    <small class="float-right">Date: <?php echo date("m/d/Y");?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong><?php echo $getDoctor['FirstName']?> <?php echo $getDoctor['MiddleName']?> <?php echo $getDoctor['LastName']?></strong><br>
                    <?php echo $getDoctor['PermanentAddress']?><br>
                    Phone: <?php echo $getDoctor['ContactNumber']?><br>
                    Email: <?php echo $getDoctor['EmailAddress']?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php echo $getCustomer['FirstName']?> <?php echo $getCustomer['MiddleName']?> <?php echo $getCustomer['LastName']?></strong><br>
                    <?php echo $getCustomer['PermanentAddress']?><br>
                    Phone: <?php echo $getCustomer['ContactNumber']?><br>
                    Email: <?php echo $getCustomer['EmailAddress']?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice <?php echo $getData['invoice_num']?></b><br>
                  <br>
                  <b>Order ID:</b> <?php echo $getData['ds_id']?><br>
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th width="200">Service</th>
                      <th >Description</th>
                      <th>Date / Time</th>
                      <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
<?php 
  $query = $dbcon->query("SELECT * FROM doctor_schedule WHERE ds_id = '".$_GET['ds_id']."'") or die(mysqli_error());
  while($row = $query->fetch_assoc()):
    $getService = getSingleRow("*","service_id","services",$row['service_id']);
?>
                    <tr>
                      <td><?php echo $getService['service_name']?></td>
                      <td><?php echo $getService['service_desc']?></td>
                      <td>
                        <?php echo $row['available_date']?> / <?php echo date("h:i a",strtotime($row['start_time']))?> - <?php echo date("h:i a",strtotime($row['end_time']));?>
                      </td>
                      <td>&#8369; <?php echo number_format($getService['service_price'],2);?></td>
                      
                    </tr>
<?php endwhile;?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  

                  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
The following Terms and Conditions will placed on CASH or PAYPAL on the payment. There is no Cancellation of appointment once you pay via Paypal
                  </p>
              <?php if(empty($getData['doc_rec'])):?>
                  <form method="post">
                    <strong>My Recommendation:</strong>
                    <textarea class="form-control" placeholder="Please enter recommendations here...." name="doc_rec"></textarea>
                    <p></p>
                     <?php if($getData['sched_status'] == '2' AND $getData['paypal_status'] == '0'):?>
                    <button class="btn btn-success" name="save_btn"><i class="fa fa-save"></i> Save Data</button>
                    <?php endif;?>
                    <?php if($getData['sched_status'] == '2' AND $getData['paypal_status'] == '1'):?>
                    <button class="btn btn-primary" name="save_btn2"><i class="fa fa-save"></i> Done Transaction</button>
                    <?php endif;?>
                  </form>
              <?php else:?>
                <strong>My Recommendation:</strong>
                <p></p>
                <?php echo $getData['doc_rec']?>
              <?php endif;?>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Total Payment</p>

                  <div class="table-responsive">
                    <table class="table">
                      
                      <tr>
                        <th>Total:</th>
                        <td>&#8369; <?php echo number_format($getService['service_price'],2)?></td>
                      </tr>
                        <?php if($getData['sched_status'] == '3' AND $getData['paypal_status'] == '0'):?>
                      <tr>
                          <td><strong>Payment Status:</strong></td>
                          <td><span style="color:green;">PAID via CASH</span></td>
                      </tr>
                      <?php endif;?>
                      <?php if(($getData['sched_status'] == '2' OR $getData['sched_status'] == '3') AND $getData['paypal_status'] == '1'):?>
                      <tr>
                          <td><strong>Payment Status:</strong></td>
                          <td><span style="color:green;">PAID via Paypal</span></td>
                      </tr>
                      <?php endif;?>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
          
              <div class="row no-print">
                <div class="col-6">
                <?php if($getData['sched_status'] == '3'):?>
                  <a href="" onclick="print()" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <?php endif;?>
                  
                </div>
                <div class="col-6">
                <?php if($getData['sched_status'] == '3'):?>
                <?php elseif($getData['sched_status'] == '2'):?>
                <!--
                 <form method="post">
                  <div class="row">
                    <div class="col-md-8">
                      <input type="text" name="payment" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-md-4">
                      <button class="btn btn-success" name="pay_btn"><i class="fa fa-save"></i> Submit Payment</button>
                    </div>
                  </div>
                   
                   
                 </form>
                 -->
               <?php endif;?>
                  
                </div>
              
              </div>
            </div>

            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->

<?php include'../assets/footer.php';?>

</body>
</html>
