<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_client'])){
    header("Location: ../../index.php");
    exit;
  }
  $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
  $paypal_id='sa19dentist@gmail.com'; 

  if(isset($_POST['cancel_btn'])){
    $cancel_reason = $_POST['cancel_reason'];
    $ds_id = filter($_POST['ds_id']);

    $arr_where = array("ds_id"=>$ds_id);//update where
    $arr_set = array(
      "cancel_reason"       =>$cancel_reason,
      "sched_status"        =>"4"
    );//set update
    $tbl_name = "doctor_schedule";
    $update = UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);

    $getData = getSingleRow("*","ds_id","doctor_schedule",$ds_id);
    if($getData['ID'] == '0'){
      $f = '0';
    }else{
      $f = $getData['ID'];
    }
    $msg = 'Please be informed that your appointment to this date: '.$getData['available_date'].': From: '.date("h:i a",strtotime($getData['start_time'])).' - '.date("h:i a",strtotime($getData['end_time'])).' has been cancelled by the customer.';

    $notif = array(
        "ds_id"             =>$ds_id,
        "notif_status"      =>"0",
        "notif_type"        =>"1",
        "notif_user"        =>$f,
        "notif_desc"        =>$msg,
        "notif_date"        =>date("Y-m-d h:i a")
    );
    SaveData("notifications",$notif);
    echo "<script>alert('Cancellation has been succssfully done.'); window.location = 'transactions.php';</script>";

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
            <h1 class="m-0 text-dark"><i class="fa fa-calendar-o"></i> On going Appointments</h1>
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
                <?php 
  $query = 'SELECT * FROM doctor_schedule 
  WHERE doctor_schedule.customer_id = "'.$_SESSION['ID'].'" AND sched_status != "3" GROUP BY doctor_schedule.ds_id';
  $g = SQLJoin($query);
  ?>
  <?php if(!empty($g)):?>
  <div class="table-responsive">
    <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
      <thead style="background:#ddd;">
        <tr>
          <th>Date / Time Requested</th>
          <th>Service Type</th>
         
          <th>Dentist Incharge</th>
          <th>Status</th>
          <th>Action</th>
          
        </tr>
      </thead>
    <tbody>
  <?php 
  foreach ($g as $key => $value):
    $getName = getSingleRow("*","ID","accounts",$value->ID);
    $getAmount  = getSingleRow("*","service_id","services",$value->service_id);
  ?>
    <tr>
      <td><?php echo $value->available_date?> / <?php echo date("h:i a",strtotime($value->start_time))?> - <?php echo date("h:i a",strtotime($value->end_time))?> </td>
      <td>
        <?php 
        $query = "SELECT * FROM services WHERE service_id = '".$value->service_id."'";
        $getService = SQLJoin($query);
        if( !empty($getService)){
          foreach ($getService as $key => $row) {
            echo '<span style="background:#e26c78; color:white;padding:5px;">'.$row->service_name.'</span> &nbsp;';
            echo '<br><strong>Service Price: &#x20B1; '.$row->service_price.'</strong>';
          }
        }else{  
          echo 'Empty';
        }
        ?>
        <br>

      </td>
      <td>
        <?php if($value->ID == '0'):?>
          No Dentist Incharge
        <?php else:?>
        <?php echo $getName['FirstName']?> <?php echo $getName['MiddleName']?> <?php echo $getName['LastName']?>
      <?php endif;?>
      </td>
      <td>
        <?php if($value->sched_status == '1'): echo 'Pending for Approval';elseif($value->sched_status == '2'): echo 'Reserved'; elseif($value->sched_status == '3'): echo 'Fulfilled'; elseif($value->sched_status == '4'): echo 'Cancelled Transaction'; endif; ?>
        <br>
        <?php 
          if($value->sched_status == '2' AND $value->paypal_status == '0'):
        ?>
        <strong>Pay with:</strong>
        <form action='<?php echo $paypal_url; ?>' method='post' name='frmPayPal1'>
          <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
          <input type='hidden' name='cmd' value='_xclick'>
          <input type='hidden' name='item_name' value='<?php echo $getAmount['service_name']?>'>
                    
          <input type='hidden' name='item_number' value='<?php echo $value->invoice_num;?>'>
          <input type='hidden' name='amount' value='<?php echo $getAmount['service_price'];?>'>
          <input type='hidden' name='no_shipping' value='1'>
          <input type='hidden' name='currency_code' value='PHP'>
          <input type='hidden' name='handling' value='0'>
          <input type='hidden' name='cancel_return' value='http://tratskitchenette.tk/user/cancel.php'>
          <input type='hidden' name='return' value='http://letooth.study-call.ph/login/client/success.php?invoice_num=<?php echo $value->invoice_num?>'>

           <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        <?php 
          endif;
        ?>
      </td>
      <td>
        <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="padding:8px;">       
 <?php if($value->sched_status == '3'):?>
  <li>
      <a href="view-billing.php?ds_id=<?php echo $value->ds_id?>"><i class="fa fa-calendar"></i> View Transactions</a>
  </li>
 <?php elseif($value->sched_status == '1'):?>
  <li>
      <a href="" data-toggle="modal" data-target="#cancel<?php echo $value->ds_id?>" >Cancel Appointment</a>
  </li>
  <li>
      <a href="re-schedule.php?ds_id=<?php echo $value->ds_id?>"> Re Schedule</a>
  </li>
 <?php elseif($value->sched_status == '2'):?>
  <li>
      <a href="view-billing.php?ds_id=<?php echo $value->ds_id?>"><i class="fa fa-calendar"></i> View Transactions</a>
  </li>
 <?php else:?>
  No Transaction
 <?php endif;?>
      
  
                      

                    </ul>
                  </div>
      </td>
    </tr>
  <!-- Modals-->
     <div class="modal fade" id="cancel<?php echo $value->ds_id?>" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i> Cancel Appointment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="post">
                <div class="row">
          <div class="col-md-12">
            <strong>Reason:</strong><br>
            <input type="hidden" name="ds_id" value="<?php echo $value->ds_id?>">
            <textarea class="form-control" name="cancel_reason" placeholder="Please enter the reason of cancellation"></textarea>
          </div>

        </div>
       
        <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button class="btn btn-primary" name="cancel_btn"><i class="fa fa-save"></i> Cancel Appointment</button>
            
          </div>
          <div class="col-3">
            
          </div>
          <!-- /.col -->
        </div>
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
</div>
  <?php else:?>
    <div class="alert alert-danger">No Records on database.</div>
  <?php endif;?>
              </div>

             
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
<?php include'../assets/footer.php';?>
</body>
</html>
