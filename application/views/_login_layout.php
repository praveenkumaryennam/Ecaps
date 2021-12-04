<html><head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Login</title>
  <link rel="icon" href="<?= base_url();?>assets/dist/img/favicon.png" type="image/x-icon">
  <meta name="theme-color">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/bootstrap.min.css?v=<?= time();?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/font-awesome.min.css?v=<?= time();?>">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css?v=<?= time();?>">
  <!-- <link rel="manifest" href="<?= base_url();?>assets/manifest.json"> -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    .login-box, .register-box{
       width: 420px !important; 
       margin: 0px !important;
       padding-left: 50px !important;
    }
    .login-box-body, .register-box-body{
        padding-top: 120px;
        background : none !important; 
    }
  </style>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179407961-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-179407961-1');
</script>
    <script>
        //if browser support service worker
        if('serviceWorker' in navigator) {
          // navigator.serviceWorker.register('sw.js');
        };
      </script>

</head>
<body class="hold-transition login-page" cz-shortcut-listen="true" style="background-image: url(<?= base_url('assets/dist/img/loginbg.jpg');?>); height: 100%;background-position: center;  background-repeat: no-repeat;background-size: cover; overflow: hidden;">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body" style="height: 100%;">
    <div style="text-align: center;">
      <img src="<?= base_url('/assets/dist/img/rpdlogo.png');?>" style="width: 250px;">
    </div>
    <br />
    <p class="login-box-msg">Sign in to start your session</p>
      <form action="<?= base_url('login');?>" method="post" pb-autologin="true" autocomplete="off">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" placeholder="Username" pb-role="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" pb-role="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
 <div class="col-xs-8">
          <a href="<?= $this->config->item('process_url');?>" target="_blank" style="color: #000">Process Panel</a></b>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" pb-role="submit">Login</button>
        </div>
      </div>
      <div style="text-align: center; margin-top: 15%;">
        <small><b>Powerd by <a href="https://reputabletechnologies.com" target="_blank" style="color: #000">Reputable Technologies Pvt.Ltd.</a></b></small>
      </div><br /> 
    </form>
    <!-- /.social-auth-links -->
    <!-- <a href="#">I forgot my password</a> -->
  </div>
  <!-- /.login-box-body -->
</div>
</body>
</html>