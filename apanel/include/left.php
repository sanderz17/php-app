        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas background-color" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?php echo $_SESSION[SESS_PRE.'_ADMIN_SESS_NAME']; ?></span>
                  <span class="text-secondary text-small"><?php echo $_SESSION[SESS_PRE.'_ADMIN_ROLE_NAME']; ?></span>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo ADMINURL; ?>dashboard/">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-view-dashboard menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo ADMINURL; ?>homepage/">
                <span class="menu-title">Home Page</span>
                <i class="mdi mdi-home-modern menu-icon"></i>
              </a>
            </li>

            <?php
              include("left_var.php");   
              $arc = 0;
              foreach($left_main_array as $arr){
                //echo '====' . count($arr[2]);
                if( count($arr[2]) > 1 )    // multiple sub items
                {
            ?>
            <li class="nav-item <?php if($main_page==$arr[1]) echo ' active'; ?>">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic<?php echo $arc; ?>" aria-expanded="<?php echo ($main_page==$arr[1])?'true':'false';?>" aria-controls="ui-basic<?php echo $arc; ?>">
                <span class="menu-title"><?php echo $arr[0]; ?></span>
                <i class="menu-arrow"></i>
                <i class="mdi <?php echo $arr[3]; ?> menu-icon"></i>
              </a>
              <div class="collapse <?php if($main_page==$arr[1]) echo ' show'; ?>" id="ui-basic<?php echo $arc; ?>">
                <ul class="nav flex-column sub-menu">
                  <?php 
                  foreach($arr[2] as $trr){
                  ?>
                  <li class="nav-item"> <a class="nav-link <?php if($page==$trr[1]) echo ' active'; ?>" href="<?php echo ADMINURL.$trr[2]; ?>"><?php echo $trr[0]; ?></a></li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </li>
            <?php
                }
                else    // only one sub item, then display as main 
                {
                  foreach($arr[2] as $trr){
            ?>
            <li class="nav-item <?php if($page==$trr[1]) echo ' active'; ?>">
              <a class="nav-link" href="<?php echo ADMINURL.$trr[2]; ?>">
                <span class="menu-title"><?php echo $trr[0]; ?></span>
                <i class="mdi <?php echo $arr[3]; ?> menu-icon"></i>
              </a>
            </li>
            <?php
                  }
                }
              $arc++;
              }
            ?>
          </ul>
        </nav>
        <!-- partial -->
