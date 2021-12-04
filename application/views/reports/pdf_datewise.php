<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ecaps | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .n-bordered{
      border: none;
    }

    .bordered td, .n-bordered td{
      border: 1px solid black;
    }

    .n-bordered tr:first-child td{
      border-top: none;
    }

    .n-bordered tr:last-child td{
      border-bottom: none;
    }

    .n-bordered tr td:first-child{
      border-left: none;
    }

    .n-bordered tr td:last-child{
      border-right: none;
    }
  </style>
</head>
<body>
<!-- <body onload="window.print();"> -->
<div class="wrapper">
  <section class="invoice">
    <div class="row">
      <div class="col-md-8">
        <address>
          <strong>RPD DENTAL ART PVT.LTD.</strong> <br />
          UNIT NO. 102, ECO HIGHTS, SHRI NITYANAND CHS LTD.,<br />SWAMI NITYANAND MARG, ANDHERI EAST, <br />MUMBAI - 400 069. 
        </address>
        <strong style="margin-left : 75%">TAX INVOICE</strong>
        <address style="word-wrap : break-word; width : 250px;">
          <strong><?= client_info(47, 'clientname')?></strong> <br />
          <?= client_info(47, 'address')?>
        </address>
      </div>
      <div class="col-md-4">
        <address style="text-align: right">
          Contact: 9324902009/3924702010<br />
          Account: 9653346992.<br />
          Email: rpddental2016@gmail.com.<br />
          Web: www.rpddentalart.com<br />
          Web: www.rpddentalart.com<br />
          <strong>Invoice #.</strong> 200400195<br />
          <strong>Date</strong> 06/04/2020<br />
        </address>
      </div>
    </div>
    
    <div class="row invoice-info">
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table border="1" width="100%">
            <thead>
            <tr>
              <th>Sr.no</th>
              <th>Order #</th>
              <th>Order Date</th>
              <th>Invoice #</th>
              <th>Invoce Date</th>
              <th>Challan #</th>
              <th>Challan Date</th>
              <th>Patient</th>
              <th>Product</th>
              <th>Teeth</th>
              <th>Units</th>
              <th>Rate / Unit</th>
              <th>Total Amount</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="10" style="text-align: right;">Total:</th>
                <th></th>
                <th colspan="2"></th>
              </tr>
              <tr>
                <th colspan="9" style="text-align: left;">
                    <span>GSTIN : 142536587545<br />
                    HSN Number : 142536587545<br />
                    State : Maharashtra State Code: 27</span>
                </th>
                <th colspan="4">
                  <table border="1" width="100%" height="100%">
                    <tr>
                      <td>CGET @ 6.00 </td>
                    </tr>
                    <tr>
                      <td>SGET @ 6.00 </td>
                    </tr>
                    <tr>
                      <td>invoice Total </td>
                    </tr>
                  </table>
                </th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
          <div class="table-responsive">
            
          </div>
        </div>
      </div>
  </section>
</div>
</body>
</html>
