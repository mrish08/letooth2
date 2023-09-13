<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $services = fetchAll("*","services");
  switch (true) {
    case isset($_POST['save_button']):
      $service_name = filter($_POST['service_name']);
      $service_desc = $_POST['service_desc'];
      $checkService = getSingleRow("service_name","service_name","services",$service_name);
      $allowedExts = array("jpeg", "png", "jpg");
      $temp = explode(".", $_FILES["photo"]["name"]);
      $photo =$_FILES['photo'] ["name"];
      $extension = end($temp);
      if(isset($_GET['service_id'])){
        $checkPhoto = getSingleRow("*","service_id","services",$_GET['service_id']);

        if(empty($photo)): $photo2 = $checkPhoto['service_photo']; else: $photo2 = $photo; endif;

        $arr_where = array("service_id"=>$_GET['service_id']);//update where
        $arr_set = array(
          "service_photo"   =>$photo2,
          "service_name"    =>$service_name,
          "date_created"    =>date("Y-m-d h:i a"),
          "service_desc"    =>$service_desc,
          "service_price"   =>$_POST['service_price'],
          "category_name"   =>$_POST['category_name']
        );//set update
        $tbl_name = "services";
        UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
        move_uploaded_file($_FILES["photo"]["tmp_name"],"../../images/". $_FILES["photo"]["name"]);
        header("location: services.php");
      }else{
      if(!empty($checkService)){
        $msg = 'Service name: '.$service_name.' already exist.';
      }else{
        $SQL = array(
        "service_photo"   =>$photo,
        "service_name"    =>$service_name,
        "date_created"    =>date("Y-m-d h:i a"),
        "service_desc"    =>$service_desc,
        "service_price"   =>$_POST['service_price'],
        "category_name"   =>$_POST['category_name']
        );
        SaveData("services",$SQL);
        move_uploaded_file($_FILES["photo"]["tmp_name"],"../../images/". $_FILES["photo"]["name"]);
        header("location: services.php");
      }
      
      }
      
    break;

    case isset($_GET['service_id']):
      $service_id = filter($_GET['service_id']);
      $getService = getSingleRow("*","service_id","services",$service_id);
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
        <h1>Service Information <hr>
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
            <td style="background:#f4f6f9;">Photo</td>
            <td>
              <input type="file" name="photo">
            </td>
          </tr>
          <tr>
            <td style="background:#f4f6f9;">Service Name:</td>
            <td>
              <input type="text" name="service_name" class="form-control" placeholder="Service Name" value="<?php if(isset($_POST['save_button'])): echo $service_name; elseif(isset($_GET['service_id'])): echo $getService['service_name']; endif;?>">
            </td>
          </tr>
                    <tr>
            <td style="background:#f4f6f9;">Price:</td>
            <td>
              <input type="text" name="service_price" class="form-control" placeholder="Price" value="<?php if(isset($_POST['save_button'])): echo $service_name; elseif(isset($_GET['service_id'])): echo $getService['service_price']; endif;?>">
            </td>
          </tr>
          <tr>
            <td style="background:#f4f6f9;">Category:</td>
            <td>
             <select class="form-control" name="category_name">
            <?php 
            $j = $dbcon->query("SELECT * FROM service_category") or die();
            while($result = $j->fetch_assoc()){
            ?>
             <option value="<?php echo $result['cs_id']?>" <?php if(isset($_GET['service_id'])){ 
                if($result['category_name'] == "0"){ 
                  echo 'selected';}
                }elseif(isset($_POST['save_button'])){ 
                  echo $_POST['category_name']; 
                }?>><?php echo $result['category_name']?></option>
            <?php 
            }
            ?>
            </td>
          </tr>
          <tr>
            <td style="background:#f4f6f9;">Service Description:</td>
            <td>
              <textarea class="form-control" name="service_desc"><?php if(isset($_POST['save_button'])): echo $service_desc; elseif(isset($_GET['service_id'])): echo $getService['service_desc']; endif;?></textarea>
            </td>
          </tr>
          <tr>
            <td style="background:#f4f6f9;"></td>
            <td>
               <button class="btn btn-primary btn-large" name="save_button"><i class="fa fa-save"></i> <?php if(isset($_GET['service_id'])): echo "Update"; else: echo 'Save'; endif;?></button>
                <a href="services.php" class="btn btn-danger btn-large"><i class="fa fa-arrow-left"></i> Return</a>
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
