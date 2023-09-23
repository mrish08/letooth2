<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
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
            <h4 class="m-0 text-dark">View Supplies</h4>
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
<button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addSupplies">Add Supplies</button>
<div class="table-responsive">
 <table id="example1" class="table table-bordered table-hover" style="font-size:13px;">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Name of Supplies</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <td><img src="images/2.jpg" alt="picture"></td>
                <td>Guy</td>
                <td>1</td>
                <td style="width: 10%">
                  <div>
                    <button class="btn btn-success">View</button>
                    <button class="btn btn-warning">Update</button>
                  </div>
                </td>

              </tbody>
</table>
</div>


               
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
</body>

<div class="modal fade" id="addInventory" style="width:100%;">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4>Add Supplies</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form method="POST" action=""> 
                  <div class="mb-3">
                  <label for="fileToUpload">InImage</label><br>
                  <input type="file" id="fileToUpload" name="fileToUpload">
                  </div>
                  <div class="mb-2">
                  <label for="asset_name">Name</label>
                  <input class="form-control" type="text" name="asset_name" id="asset_name">
                  </div>
                  <div class="mb-3">
                  <label for="asset_quantity">Quantity</label>
                  <input class="form-control" type="number" name="asset_quantity" id="asset_quantity">
                  </div>
                  <div>
                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

</html>