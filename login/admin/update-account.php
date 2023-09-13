<?php 
  include'../../config/db.php';
  include'../../config/functions.php';
  include'../../config/main_function.php';
  
  if(empty($_SESSION['login_admin'])){
    header("Location: ../../index.php");
    exit;
  }
  $accounts = fetchAll("*","accounts");
  switch (true) {
  case isset($_POST['save_button']):
      //$EmailAddress = filter($_POST['EmailAddress']);
      
      $FirstName = filter($_POST['FirstName']);
      //$MiddleName = filter($_POST['MiddleName']);
      $LastName = filter($_POST['LastName']);
      $ContactNumber = filter($_POST['ContactNumber']);
      $PermanentAddress = filter($_POST['PermanentAddress']);
      $user_age = filter($_POST['user_age']);
      $bday = filter($_POST['bday']);
      $sex = filter($_POST['sex']);
      $civil_status = filter($_POST['civil_status']);
      $occupation = filter($_POST['occupation']);

      if(ctype_alpha(str_replace(' ', '', $FirstName)) === false){
        $msg = 'We only accept letters only.';
      }elseif(ctype_alpha(str_replace(' ', '', $LastName)) === false){
        $msg = 'We only accept letters only.';
      }elseif(strlen($ContactNumber) != 11){
        $msg  = 'We only accept 11 numbers for your contact number.';
      }else{

        $arr_where = array("ID"=>$_GET['ID']);//update where
        $arr_set = array(
          "UserName"          =>$_POST['UserName'],
          "FirstName"         =>$FirstName,
          "MiddleName"        =>$MiddleName,
          "LastName"          =>$LastName,
          //"EmailAddress"      =>$EmailAddress,
          "ContactNumber"     =>$ContactNumber,
          "PermanentAddress"  =>$PermanentAddress,
          "surgical_type"     =>$_POST['surgical_type'],
          "user_age"          =>$user_age,
          "bday"              =>$bday,
          "sex"               =>$sex,
          "civil_status"      =>$civil_status,
          "occupation"        =>$occupation
        );//set update
        $tbl_name = "accounts";
        UpdateQuery($dbcon,$tbl_name,$arr_set,$arr_where);
        if($_GET['type'] == 'doctor'){
          header("location: doctor.php");
        }elseif($_GET['type'] == 'customer'){
          header("location: customer.php");
        }
      }
    break;
  }
  if(isset($_GET['ID'])){
    $ID = filter($_GET['ID']);
    $getInfo = getSingleRow("*","ID","accounts",$ID);
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
        <h1>Update Information<hr>
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
            

      <form method="post">
                <div class="row">
          <div class="col-md-6">
              <strong>First Name:</strong><br>
             <input type="text" name="FirstName" class="form-control" placeholder="First Name" required value="<?php if(isset($_POST['save_button'])): echo $_POST['FirstName']; elseif(isset($_GET['ID'])): echo $getInfo['FirstName'];endif;?>">
             
           
          </div>
          <div class="col-md-6">
              
              <strong>Middle Name:</strong><br>
             <input type="text" name="MiddleName" class="form-control" placeholder="Last Name" required value="<?php if(isset($_POST['save_button'])): echo $_POST['MiddleName']; elseif(isset($_GET['ID'])): echo $getInfo['MiddleName'];endif;?>">
             
            
          </div>
          
        </div><br>
        <div class="row">
                      <div class="col-md-6">
              
              <strong>Last Name:</strong><br>
             <input type="text" name="LastName" class="form-control" placeholder="Last Name" required value="<?php if(isset($_POST['save_button'])): echo $_POST['LastName']; elseif(isset($_GET['ID'])): echo $getInfo['LastName'];endif;?>">
             
            
          </div>
                    <div class="col-md-6">
             <strong>Username:</strong><br>
            <input type="email" name="UserName" class="form-control" placeholder="Email Address / Username" value="<?php if(isset($_POST['save_button'])): echo $_POST['UserName']; elseif(isset($_GET['ID'])): echo $getInfo['UserName'];endif;?>" readonly>
          </div>
        </div>
        <div class="row">

          <div class="col-md-6">
             <strong>Contact Number:</strong><br>
            <input type="number" name="ContactNumber" class="form-control" placeholder="Contact Number" required value="<?php if(isset($_POST['save_button'])): echo $_POST['ContactNumber']; elseif(isset($_GET['ID'])): echo $getInfo['ContactNumber'];endif;?>">
          </div>
                    <div class="col-md-6">
             <strong>Permanent Address:</strong><br>
             <input type="text" name="PermanentAddress" class="form-control" placeholder="Permanent Address" required value="<?php if(isset($_POST['save_button'])): echo $_POST['PermanentAddress']; elseif(isset($_GET['ID'])): echo $getInfo['PermanentAddress'];endif;?>">
          </div>
        </div><br>
        <div class="row">

          <div class="col-md-6">
           <strong>Birthday:</strong><br>
             <input type="date" name="bday" class="form-control" placeholder="Birthdate Address" required value="<?php if(isset($_POST['save_button'])): echo $bday; elseif(isset($_GET['ID'])): echo $getInfo['bday'];endif;?>">
          </div>
                    <div class="col-md-6">
            <input type="hidden" name="user_age" class="form-control" placeholder="Age" required value="<?php if(isset($_POST['save_button'])): echo $user_age;elseif(isset($_GET['ID'])): echo $getInfo['user_age']; endif;?>">
            <strong>Gender:</strong><br>
            <select class="form-control" name="sex">
              <option value="Male" <?php if(isset($_GET['ID'])){
                if($getInfo['sex'] == 'Male'){
                  echo 'selected';
                }
              }?>>Male</option>
              <option value="Female" <?php if(isset($_GET['ID'])){
                if($getInfo['sex'] == 'Female'){
                  echo 'selected';
                }
              }?>>Female</option>
            </select>
          </div>
        </div>
        <div class="row">

          <div class="col-md-6">
          <?php if($_GET['type'] == 'doctor'):?>
            <strong>Surgical Type:</strong><br>
            <select class="form-control" name="surgical_type">
              
              <option value="1" <?php if(isset($_GET['ID'])){
                if($getInfo['surgical_type'] == '1'){
                  echo 'selected';
                }
              }?>>Non Surgical</option>
              <option value="2" <?php if(isset($_GET['ID'])){
                if($getInfo['surgical_type'] == '2'){
                  echo 'selected';
                }
              }?>>Both Surgical Type</option>
            </select>
          <?php endif;?>
           <?php if($_GET['type'] != 'doctor'):?>
           <strong>Occupation:</strong><br>
            <input type="text" name="occupation" class="form-control" placeholder="Occupation" required value="<?php if(isset($_POST['save_button'])): echo $occupation; elseif(isset($_GET['ID'])): echo $getInfo['occupation']; endif;?>">
            <?php endif;?>
          </div>
          <?php if($_GET['type'] != 'doctor'):?>
                    <div class="col-md-6">
            <strong>Civil Status:</strong><br>
             <select class="form-control" name="civil_status">
              <option value="Single" <?php if(isset($_GET['ID'])){
                if($getInfo['civil_status'] == 'Single'){
                  echo 'selected';
                }
              }?>>Single</option>
              <option value="Married" <?php if(isset($_GET['ID'])){
                if($getInfo['civil_status'] == 'Married'){
                  echo 'selected';
                }
              }?>>Married</option>
              <option value="Widowed" <?php if(isset($_GET['ID'])){
                if($getInfo['civil_status'] == 'Widowed'){
                  echo 'selected';
                }
              }?>>Widowed</option>
              <option value="Devorce" <?php if(isset($_GET['ID'])){
                if($getInfo['civil_status'] == 'Devorce'){
                  echo 'selected';
                }
              }?>>Devorce</option>
            </select>
          </div>
          <?php endif;?>
          
        </div>
        

                <div class="row">
          

        </div>
    
        <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-3">
            <button class="btn btn-primary" name="save_button"><i class="fa fa-save"></i> Update Account</button>
            
          </div>
          <div class="col-3">
            
          </div>
          <!-- /.col -->
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
