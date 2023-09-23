<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';

  $db_server = "localhost"; // server 127.0.0.1
  $db_user = "root"; // studycal
  $db_pass = "";// h88a6Z6eMt
  $db_name = "letooth"; //studycal_letooth

  if ($dbcon->connect_error) 
  {
    die("Connection failed: " . $dbcon->connect_error);
  }

  $dbcon = new mysqli($db_server,$db_user,$db_pass,$db_name);

  $query = "SELECT * FROM asset WHERE ASSET_TYPE = '1'";

  $result = $dbcon->query($query);

  if ($result->num_rows > 0) {
    $data = array(); // Initialize an empty array to store the rows

    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Append each row to the $data array
    }

    // Close the result set
    $result->close();
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
            <h4 class="m-0 text-dark">View Equipment</h4>
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
<button class="btn btn-primary mb-2" id="addEquipmentBtn" data-toggle="modal" data-target="#addEquipment">Add Equipment</button>
<?php if(!empty($data)):?>
<div class="table-responsive">
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Name of Equipment</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($data as $key => $value):?>
                <tr row-id="<?php echo $value['ASSET_ID']; ?>">
                <td style="width: 20%">
                        <?php
                        // Check if the ASSET_IMAGE column contains image data
                        if (!empty($value['ASSET_PICTURE'])) {
                            $imageData = base64_encode($value['ASSET_PICTURE']);
                            $src = 'data:image/jpeg;base64,' . $imageData;
                            echo '<img src="' . $src . '" alt="Asset Image" width="100" height="100">';
                        } else {
                            echo 'No Image';
                        }
                        ?>
                    </td>
                <td><?php echo $value['ASSET_NAME'] ?></td>
                <td><?php echo $value['ASSET_QUANTITY'] ?></td>
                <td style="width: 10%">
                  <div>
                                    <button type="button" id="viewBtn" class="btn btn-success" data-toggle="modal" data-target="#viewEquipment">View</button>

                                    <button type="submit" id="updateBtn" name="updateBtn" data-toggle="modal" data-target="#updateEquipment" class="btn btn-warning">Update</button>
                  </div>
                </td>
                </tr>
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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
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


<div class="modal fade" id="addEquipment" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4>Add Equipment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data"> 
                  <div class="mb-3">
                  <label for="fileToUpload">Equipment Image</label><br>
                  <input type="file" id="fileToUpload" name="fileToUpload">
                  </div>
                  <div class="mb-2">
                  <label for="equipmentName">Name</label>
                  <input class="form-control" type="text" name="equipmentName" id="equipmentName">
                  </div>
                  <div class="mb-2">
                  <label for="equipmentDesc">Description</label>
                  <input class="form-control" type="text" name="equipmentDesc" id="equipmentDesc">
                  </div>
                  <div class="mb-3">
                  <label for="equipmentQty">Quantity</label>
                  <input class="form-control" type="number" name="equipmentQty" id="equipmentQty">
                  </div>
                  <div>
                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                    <button class="btn btn-primary" data-dismiss="modal" id="submitBtn" type="button">Submit</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="viewEquipment" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4>View Equipment Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <div class="table-reponsive">
                    <table id="viewTable" class="table table-bordered table-striped">

                    </table>
                  </div>
                  <div class="d-flex justify-content-end">
                  <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                  </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>



      
      <div class="modal fade" id="updateEquipment" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4>Update Equipment Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                  <div id="updateFields">
                    
                  </div>
                  <div class="d-flex justify-content-end gap-2">
                  <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                  <button class="btn btn-primary" data-dismiss="modal" id="updateSubmitBtn" type="button">Submit</button>
                  </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>


</body>
<script>
$(document).ready(function () {

  $('#updateSubmitBtn').click(function () {
    var updatedQty = $('#updateEquipmentQty').val();
    var equipmentId = $('#updateAssetId').val();

    $.ajax({
        url: 'insert-updated-equipment.php',
        method: 'POST',
        data: {
            newQty: updatedQty,
            equipId: equipmentId
        },
        success: function (result) {
            alert(result);
            location.reload();
        }
    });
});


    $('#submitBtn').click(function (){

      var formData = new FormData();
      formData.append('fileToUpload', $('#fileToUpload')[0].files[0]); // Add the file object to FormData
      formData.append('name', $('#equipmentName').val());
      formData.append('desc', $('#equipmentDesc').val());
      formData.append('qty', $('#equipmentQty').val());

      $.ajax({
        url: 'create-equipment.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
          alert(result);
          location.reload();
        }
      });

    });

    $('#example1').on('click', '#viewBtn', function (e) {
      let assetId = $(this).closest('tr').attr('row-id');

      console.log(assetId);

      $.ajax({url: 'view-equipment.php',
        method: 'POST', // URL of your PHP script
        data: { asset_id: assetId }, // Correctly specify key and value
        success: function (result) {
        $("#viewTable").html(result);
      }
      });
    });


    $('#example1').on('click', '#updateBtn', function (e) {
      let assetId = $(this).closest('tr').attr('row-id');

      console.log(assetId);

      $.ajax({url: 'update-equipment.php',
        method: 'POST', // URL of your PHP script
        data: { asset_id: assetId }, // Correctly specify key and value
        success: function (result) {
        console.log('success');
        $('#updateFields').html(result);
      }
      });
    });
});
</script>
</html>