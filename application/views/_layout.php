<!DOCTYPE html>
<html style="height: auto; min-height: 100%;">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title') .' | '.strtoupper($this->uri->segment(1));?> </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="<?= base_url();?>assets/dist/img/favicon.png" type="image/x-icon">

  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/bootstrap.min.css?v=<?= time();?>" />
  <!-- <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/font-awesome.min.css?v=<?= time();?>" /> -->
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/ionicons.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/dataTables.bootstrap.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/jquery-jvectormap.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/select2.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/AdminLTE.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/bootstrap-datepicker.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/buttons.dataTables.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/sweetalert.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/datatables.min.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/daterangepicker.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/sweetalert.css?v=<?= time();?>" />
  <!-- <link rel="manifest" href="<?= base_url();?>assets/manifest.json"> -->
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/style.css?v=<?= time();?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/skins/_all-skins.min.css?v=<?= time();?>" />
  <style>
    .table th, .table td { 
      max-width: 250px;
      min-width: 20px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .table th{
      text-transform:capitalize;
    }
  </style>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/jquery.min.js?v=<?= time();?>"></script>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script type="text/javascript">
    var excel_title = '<?= $this->uri->segment(1).'_'.date('Ymd')?>';
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179407961-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-179407961-1');
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="centered" style="display: none;">
    <img src="<?= base_url('assets/dist/img/loader.gif');?>"/>
  </div>
  <div class="wrapper">
    <!-- header -->
    <?php $this->load->view("comman/_header");?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php
      if(isset($rside))
        $this->load->view("user/rsidebar");
      else
        $this->load->view("comman/_rside");
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= $header_content->title;?>
          <small><?= $header_content->sub_title;?></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <?php 
            $path = explode('/', $header_content->path);
            // $size = sizeof($path);
            foreach ($path as $key) {
              if($key == 'index')
                continue;
              echo '<li>'.ucfirst(str_replace('_', ' ', $key)).'</li>';
            }
          ?>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php $this->load->view($randerPage);?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("comman/_footer");?>
    <!-- Control Sidebar -->
    <?php $this->load->view("comman/_side2");?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <script type="text/javascript">
    var base_url = '<?= base_url();?>';
  </script>
<script type="text/javascript" src="<?= base_url('assets/');?>dist/js/select2.full.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/jquery-ui-git.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/bootstrap.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/jquery.dataTables.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/dataTables.bootstrap.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/fastclick.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/adminlte.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/bootstrap-datepicker.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/moment.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/daterangepicker.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/demo.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/sweetalert.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/validation.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/axios.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/datatables.min.js?v=<?= time();?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/main.js?v=<?= time();?>"></script> 
  <!-- <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/script.js"></script> -->
  <?php if(!empty($script)){
    echo '<script type="text/javascript" src="'.base_url("assets/").'dist/js/pages/'.$script.'.js?v='.time().'"></script>';
  }?>
<script>
  $('#reservation').daterangepicker();
</script>
</body>
</html>