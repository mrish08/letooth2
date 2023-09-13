<?php 
if(isset($_POST['create_schedule'])){
  $available_date = filter($_POST['available_date']);
  //$start_time = filter($_POST['start_time']);
  //$end_time = filter($_POST['end_time']);
  $ID = filter($_SESSION['ID']);

  $check = $dbcon->query("SELECT * FROM doctor_schedule WHERE available_date='$available_date' AND ID = '$ID'") or die(mysqli_error());
  if(mysqli_num_rows($check) > 5){
    echo '<script>alert("Data you enter already exist. Please try other schedule");</script>';
  }else{
    $insert = array(
      "ID"            =>$_SESSION['ID'],
      //"start_time"    =>$start_time,
      //"end_time"      =>$end_time,
      "available_date"=>$available_date
    );
    SaveData("doctor_schedule",$insert);
    echo "<script>alert('You have successfully created a schedule. '); window.location = 'index.php';</script>";
  }
}
?>
<!-- Modals-->
     <div class="modal fade" id="my-schedule" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4><i class="fa fa-plus"></i> Create Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="post">
                <div class="row">
          <div class="col-md-12">
            <strong>Date:</strong><br>
            <input type="date" name="available_date" class="form-control" min="<?php echo date("Y-m-d");?>">
          </div>

        </div><br>
        <!--
        <div class="row">
          <div class="col-md-12">
            <strong>Start Time:</strong><br>
            <input type="time" name="start_time" class="form-control" required>
          </div>

        </div><br>
        <div class="row">
        <div class="col-md-12">
            <strong>End Time:</strong><br>
            <input type="time" name="end_time" class="form-control" required>
          </div>
        </div>
      -->
        <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button class="btn btn-primary" name="create_schedule"><i class="fa fa-save"></i> Create Schedule</button>
            
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
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 .</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!--
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
-->
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
<script src="../toast/js/jquery.toast.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="../plugins/fullcalendar/fullcalendar.min.js"></script>

<script>
 $(document).ready( function () {
    $('#example1').DataTable();
} );
</script>