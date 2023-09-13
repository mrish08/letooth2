<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <!--
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link"><i class="fa fa-home"></i> Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="change.php" class="nav-link"><i class="fa fa-wrench"></i> Change Password</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="logout.php" class="nav-link"><i class="fa fa-edit"></i> Logout</a>
      </li>
    </ul>
  -->
    <!-- Right navbar links -->
<?php if(isset($_SESSION['login_admin']) == 'login_admin'):?>
  <?php 
  $j = $dbcon->query("SELECT * FROM notifications WHERE notif_type = '0' AND notif_status = '0' ORDER BY notif_id DESC") or die(mysqli_error());

?>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-danger navbar-badge"><?php echo mysqli_num_rows($j);?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<?php while($row = $j->fetch_assoc()):?>
          <a href="view-notif.php?ID=<?php echo $row['notif_id'];?>" class="dropdown-item">
            <div class="media">
              
              <div class="media-body">
                
                <p class="text-sm"><?php echo $row['notif_desc']?></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> <?php echo $row['notif_date']?></p>
              </div>
            </div>
          </a>
<?php endwhile;?>
          <div class="dropdown-divider"></div>
          <a href="notifications.php" class="dropdown-item dropdown-footer">See All notifications</a>
        </div>
      </li>
  <!-- User Profile-->
  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="media">
              
              <div class="media-body" style="padding:10px;">
                
            <p class="text-sm">
              <center>
                Hello, <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?>
                <img src="../../images/<?php echo $_SESSION['UserPhoto']?>" class="img-circle" style="border: 2px solid #333;" width="50%">
              </center>
              
            </p>
            <hr>

            <ul style="list-style: none; padding:5px;font-size: 18px;">
              <li><a href="edit-profile.php?ID=<?php echo $_SESSION['ID']?>"><span class="fa fa-pencil"></span> Edit Profile</a></li>
              <li><a href="change.php"><span class="fa fa-wrench"></span> Change Password</a></li>
              <li><a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Logout?\') 
      ?window.location = \'logout.php\' : \'\';"'; ?>><span class="fa fa-sign-out"></span> Logout</a></li>
            </ul>
                    
              
              </div>
            </div>
         
        </div>
      </li>
    <!-- end user profile -->
    </ul>
<?php elseif(isset($_SESSION['login_client']) == 'login_client'):?>
<?php 
  $l = $dbcon->query("SELECT * FROM notifications WHERE notif_user = '".$_SESSION['ID']."' AND notif_status = '0' ORDER BY notif_id DESC") or die(mysqli_error());

?>
      <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-danger navbar-badge"><?php echo mysqli_num_rows($l);?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<?php while($row = $l->fetch_assoc()):?>
          <a href="view-notif.php?ID=<?php echo $row['notif_id'];?>" class="dropdown-item">
            <div class="media">
              
              <div class="media-body">
                
                <p class="text-sm"><?php echo $row['notif_desc']?></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> <?php echo $row['notif_date']?></p>
              </div>
            </div>
          </a>
<?php endwhile;?>
          <div class="dropdown-divider"></div>
          
        </div>
      </li>
        
        <!-- User Profile-->
  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="media">
              
              <div class="media-body" style="padding:10px;">
                
            <p class="text-sm">
              <center>
                Hello, <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?>
                <img src="../../images/<?php echo $_SESSION['UserPhoto']?>" class="img-circle" style="border: 2px solid #333;" width="50%">
              </center>
              
            </p>
            <hr>

            <ul style="list-style: none; padding:5px;font-size: 18px;">
              <li><a href="edit-profile.php?ID=<?php echo $_SESSION['ID']?>"><span class="fa fa-pencil"></span> Edit Profile</a></li>
              <li><a href="change.php"><span class="fa fa-wrench"></span> Change Password</a></li>
              <li>
                <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Logout?\') 
      ?window.location = \'logout.php\' : \'\';"'; ?>><span class="fa fa-sign-out"></span> Logout</a>
              </li>
            </ul>
                    
              
              </div>
            </div>
         
        </div>
      </li>
    <!-- end user profile -->

    </ul>
<?php elseif(isset($_SESSION['login_doctor']) == 'login_doctor'):?>
<?php 
  $k = $dbcon->query("SELECT * FROM notifications WHERE notif_user = '".$_SESSION['ID']."' AND notif_status = '0' ORDER BY notif_id DESC") or die(mysqli_error());

?>
      <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-danger navbar-badge"><?php echo mysqli_num_rows($k);?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<?php while($row = $k->fetch_assoc()):?>
          <a href="view-notif.php?ID=<?php echo $row['notif_id'];?>" class="dropdown-item">
            <div class="media">
              
              <div class="media-body">
                
                <p class="text-sm"><?php echo $row['notif_desc']?></p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> <?php echo $row['notif_date']?></p>
              </div>
            </div>
          </a>
<?php endwhile;?>
          <div class="dropdown-divider"></div>
          
        </div>
      </li>
        <!-- User Profile-->
  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="media">
              
              <div class="media-body" style="padding:10px;">
                
            <p class="text-sm">
              <center>
                Hello, <?php echo $_SESSION['FirstName']?> <?php echo $_SESSION['LastName']?>
                <img src="../../images/<?php echo $_SESSION['UserPhoto']?>" class="img-circle" style="border: 2px solid #333;" width="50%">
              </center>
              
            </p>
            <hr>

            <ul style="list-style: none; padding:5px;font-size: 18px;">
              <li><a href="update-account.php"><span class="fa fa-pencil"></span> Edit Profile</a></li>
              <li><a href="change.php"><span class="fa fa-wrench"></span> Change Password</a></li>
              <li>
                <a href="#" <?php echo 'onclick=" confirm(\'Are you sure you want to Logout?\') 
      ?window.location = \'logout.php\' : \'\';"'; ?>><span class="fa fa-sign-out"></span> Logout</a>
              </li>
            </ul>
                    
              
              </div>
            </div>
         
        </div>
      </li>
    <!-- end user profile -->

    </ul>
<?php endif;?>
    
  </nav>