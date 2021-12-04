<header class="main-header" style="position: fixed; width: 100%">
    <!-- Logo -->
    <a href="<?= base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?= $info->logo_mini_txt;?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?= $info->logo_txt;?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <?php if(!$info->btn_logout) { ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?= base_url('assets/');?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?= $this->session->userdata['username'];?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="<?= base_url('assets/');?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                  <p>
                    <?= $this->session->userdata['username']. ' - '. $this->session->userdata['role']?>
                    <small><?= Date('d-m-Y H:i:s');?></small>
                  </p>
                </li>

                <?php if(($info->profile_btn) || ($info->is_lock)) { ?>
                  <li class="user-body">
                    <div class="row">
                      <?php if($info->profile_btn) { ?>
                      <div class="col-xs-8">
                        <a href="#"><b>Change Password</b></a>
                      </div>
                      <?php } ?>
                      <?php if($info->is_lock) { ?>
                        <div class="col-xs-4 text-right">
                          <a href="#" style="color:red !important">Lock</a>
                        </div>
                      <?php } ?>
                    </div>
                  </li>
                <?php } ?>
                <li class="user-footer">
                  <?php if($info->profile_btn){ ?>
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                  <?php } ?>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            <?php } else{ ?>
              <a href="<?= base_url('login/logout')?>" id="logout_btn" class="swalDefaultSuccess">
                <span class="hidden-xs"><?= aemp_name($this->session->userdata['username']);?> <i class="fa fa-sign-out"></i></span>
              </a>
            <?php }?>
          </li>

          <?php if($info->is_setting_side_bar){ ?>
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          <?php } ?>

        </ul>
      </div>

    </nav>
  </header>