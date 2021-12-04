<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title'); ?> | Chnage Password</title>
  <link rel="icon" href="<?= base_url(); ?>assets/dist/img/favicon.png" type="image/x-icon">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>/dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179407961-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];







    function gtag() {
      dataLayer.push(arguments);
    }


    gtag('js', new Date());

    gtag('config', 'UA-179407961-1');
  </script>

</head>

<body class="hold-transition lockscreen">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
      <a href="<?= base_url(); ?>"><b><?= $this->config->item('page_title'); ?></a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name"><?= get_user_details($this->session->userdata('username')); ?></div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
      <!-- lockscreen image -->
      <div class="lockscreen-image">
        <img src="<?= base_url('/assets/dist/img/rpdlogomini.png'); ?>" alt="User Image">
      </div>
      <!-- /.lockscreen-image -->

      <!-- lockscreen credentials (contains the form) -->
      <form class="lockscreen-credentials" action="<?= base_url('/newpassword'); ?>" method="post">
        <div class="input-group">
          <input type="password" class="form-control" name="password" placeholder="password">
          <div class="input-group-btn">
            <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
          </div>
        </div>
      </form>
      <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
      Change password to continue your session
    </div>
    <div class="text-center">
      <a href="<?= base_url('logout') ?>">Or sign in as a different user</a>
    </div>
    <!-- <div class="lockscreen-footer text-center">
    Copyright &copy; 2014-2016 <b><a href="https://adminlte.io" class="text-black">Almsaeed Studio</a></b><br>
    All rights reserved
  </div> -->
  </div>
  <!-- /.center -->

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
