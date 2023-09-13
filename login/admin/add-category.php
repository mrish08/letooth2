<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $service_category = fetchAll("*","service_category");
  switch (true) {
    case isset($_POST['save_button']):
      $category_name = filter($_POST['category_name']);
      $cat_details = $_POST['cat_details'];
      $checkService = getSingleRow("category_name","category_name","service_category",$category_name);
      
      if(isset($_GET['cs_id'])){
        $checkPhoto = getSingleRow("*","cs_id","service_category",$_GET['cs_id']);

        $arr_where = array("cs_id"=>$_GET['cs_id']);//update where
        $arr_set = array(
          "category_name"    =>$category_name,
          "date_created"     =>date("Y-m-d h:i a"),
          "cat_details"      =>$cat_details
        );//set update
        $tbl_name = "service_category";
        UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
        header("location: service-category.php");
      }else{
      if(!empty($checkService)){
        $msg = 'Category name: '.$category_name.' already exist.';
      }else{
        $SQL = array(
        "category_name"    =>$category_name,
        "date_created"    =>date("Y-m-d h:i a"),
        "cat_details"      =>$cat_details
        );
        SaveData("service_category",$SQL);
        header("location: service-category.php");
      }
      
      }
      
    break;

    case isset($_GET['cs_id']):
      $cs_id = filter($_GET['cs_id']);
      $getService = getSingleRow("*","cs_id","service_category",$cs_id);
    break;
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
        <h1>Category Information <hr>
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
                <?php if(isset($msg)):?>
              <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $msg;?>
              <br />
            </div>
            <?php endif;?>
            

      <form method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="table-responsive">
        <table class="table table-bordered">
          
          <tr>
            <td style="background:#f4f6f9;">Category Name:</td>
            <td>
              <input type="text" name="category_name" class="form-control" placeholder="Category Name" value="<?php if(isset($_POST['save_button'])): echo $category_name; elseif(isset($_GET['cs_id'])): echo $getService['category_name']; endif;?>">
            </td>
          </tr>
          <tr>
            <td style="background:#f4f6f9;">Category Details:</td>
            <td>
              <input type="text" name="cat_details" class="form-control" placeholder="Category Details" value="<?php if(isset($_POST['save_button'])): echo $cat_details; elseif(isset($_GET['cs_id'])): echo $getService['cat_details']; endif;?>">
            </td>
          </tr>
                  

                    
          <tr>
            <td style="background:#f4f6f9;"></td>
            <td>
               <button class="btn btn-primary btn-large" name="save_button"><i class="fa fa-save"></i> <?php if(isset($_GET['cs_id'])): echo "Update"; else: echo 'Save'; endif;?></button>
                <a href="service-category.php" class="btn btn-danger btn-large"><i class="fa fa-arrow-left"></i> Return</a>
            </td>
          </tr>
        </table>
        </div>
       

      </form>
              </div>
            </div>


          </div>
          <!-- /.col-md-6 -->

          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
      </div><!-- /.container-fluid -->
    </div>
<?php include'../assets/footer.php';?>
</body>
</html>
