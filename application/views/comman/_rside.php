<style type="text/css">
  .main-sidebar::-webkit-scrollbar {
    width: 0px;
  }
</style>

<aside class="main-sidebar" style="position: fixed;overflow-y: scroll;top: 0;bottom: 0;">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?= base_url();?>assets/dist/img/user.jpeg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?= aemp_name($this->session->userdata['username']);?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <?php if($info->is_search_in_bar){?>
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn"><button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button></span>
        </div>
      </form>
    <?php } ?>


    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <?= get_menu();?>
    </ul>
  </section>
</aside>