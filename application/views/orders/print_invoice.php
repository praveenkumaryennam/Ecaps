<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Invoice</title>
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
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <?= strtoupper(profile('title'));?>
          <small class="pull-right">Date: <?= date('d/m/Y', strtotime($invoice['invoice_date']));?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-md-12" style="text-align: center;">
          <h5><strong>TAX INVOICE</strong></h5>
        </div>
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?= strtoupper(profile('title'));?></strong><br>
          <?= strtoupper(profile('address'));?><br>
            <strong>GST: <?= profile('gst');?></strong><br>
            <strong><?= profile('mobile');?></strong><br>
            <strong><?= profile('email');?></strong>
        </address>
      </div>
       <?php
          $c = get_clientdata($invoice['client_id']);
        ?>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?= strtoupper($c->name)?></strong><br>
          <?= $invoice['delivery_address'];?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
          <b>Invoice # <?= $invoice['invoice_number'];?></b><br>
          <br>
          <b>GST # <?= $invoice['gst_number'];?></b><br>
          <b>Order ID:</b> <?= $invoice['order_number'];?><br>
          <b>Invoice Date:</b> <?= date('d/m/Y', strtotime($invoice['invoice_date']));?><br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Sr.no</th>
            <th>Product</th>
            <th>Units</th>
            <th>UnitRate</th>
            <th>Discount (%)</th>
            <th>Teeth</th>
            <th>DiscountRate</th>
            <th>Subtotal</th>
            <!-- <th>IGTS % </th>
            <th>CGST % </th>
            <th>SGST % </th> -->
            <!-- <th>TotalAmount</th> -->
          </tr>
          </thead>
          <tbody>
            <?php $i = 0; for($x=0;$x<sizeof($pro['product']);$x++){ ?>
              <tr>
                <td><?= ++$i;?></td>
                <td><?= get_title($pro['product'][$x], 'product');?></td>
                <td><?= $pro['unit'][$x];?></td>
                <td><?= number_format($pro['base_price'][$x], 2);?></td>
                <td><?= number_format($pro['discount'][$x], 2);?></td>
                <td>
                    <?php $a = get_teeth_sides($p->teeth);?>
                    <table>
                      <tr>
                        <td><?= implode(',',$a['p1']);?> | </td>
                        <td><?= implode(',',$a['p2'])?></td>
                      </tr>
                      <tr>
                        <td><?= implode(',',$a['p3'])?> | </td>
                        <td><?= implode(',',$a['p4'])?></td>
                      </tr>
                    </table>
                  </td>
                
                <td><?= number_format($pro['unitprice'][$x], 2)?></td>
                <td><?= $pro['subtotal'][$x]?></td>
                <td><?= number_format($pro['igst'][$x], 2)?></td>
                <td><?= number_format($pro['cgst'][$x], 2)?></td>
                <td><?= number_format($pro['sgst'][$x], 2)?></td>
                <td><b"> <?= number_format($pro['total'][$x], 2)?> </b></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-8"></div>
      <!-- /.col -->
      <div class="col-xs-4">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td><?= $invoice['invoice_subtotal'];?></td>
            </tr>
            <tr>
              <th>GST (<?= $invoice['invoice_gst'];?>%)</th>
              <td><?= $invoice['invoice_gst_amount'];?></td>
            </tr>
            <tr>
              <th>Additinal Amount:</th>
              <td><?= number_format(($invoice['additionalamount'])?$invoice['additionalamount']:0, 2);?></td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><?= $invoice['invoice_total'];?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
