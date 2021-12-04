<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Delivery Challan</title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="wrapper">
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <?= strtoupper(profile('title'));?>
          <!-- <small class="pull-right">Date: <?= date('d/m/Y', strtotime($order['order_date']));?></small> -->
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?= strtoupper(profile('title'));?></strong><br>
          <?= strtoupper(profile('address'));?><br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>GST: <?= profile('gst');?></strong><br>
          <strong><?= profile('mobile');?></strong><br>
          <strong><?= profile('email');?></strong>
        </address>
      </div>
      <div class="col-md-12" style="text-align: center;">
          <h5><strong>DELIVERY CHALLAN</strong></h5>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <h4><?= getclientname($order['client_code'])?></h4>
      </div>
      <div class="col-md-6" style="text-align:right">
        <strong>Doc: <?= $shipment['challan_number'];?></strong><br />
        <strong>Date: <?= date('d-m-Y', strtotime($shipment['shipment_date']))?></strong>
      </div>
    </div>

    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12">
        <h4>Patiant: </h4>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Order</th>
              <th>Order Date</th>
              <th>Patient</th>
              <th>Sub Dr</th>
              <th>Modal</th>
              <th>Product</th>
              <th>Teeth</th>
              <th>Units</th>
              <th>Rate/Unit</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0;$i = 0; foreach($pros as $pro){ $total += $pro['total_amount'];?>
              <tr>
                <td><?= ++$i;?></td>
                <td><?= $order['order_number'];?></td>
                <td><?= date('d-m-Y', strtotime($order['order_date']));?></td>
                <td><?= $order['patiant_name'];?></td>
                <td><?= $order['doctor'];?></td>
                <td><?= $order['modal_no'];?></td>
                <td><?= get_title($pro['product_id'], 'product');?></td>
                <td>
                  <?php $a = get_teeth_sides($pro['teeth']);?>
                  <table class="n-bordered">
                    <tr>
                      <td><?= implode(',',$a['p1']);?></td>
                      <td><?= implode(',',$a['p2'])?></td>
                    </tr>
                    <tr>
                      <td><?= implode(',',$a['p3'])?></td>
                      <td><?= implode(',',$a['p4'])?></td>
                    </tr>
                  </table>
                </td>
                <td><?= $pro['unit'];?></td>
                <td><?= number_format($pro['unit_price'], 2)?></td>
                <td><?= $pro['total_amount']?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <div class="row">
      <div class="col-xs-8"></div>
      <div class="col-xs-4" style="text-align: right">
        <strong>Total : <?= $total;?></strong>
      </div>
    </div>

    <div class="row" style="margin-top: 15px;">
      <div class="col-xs-8">
        <strong>Delivery By</strong>
      </div>
      <div class="col-xs-2" style="text-align: right">
        <strong>Received By</strong>
      </div>
      <div class="col-xs-2" style="text-align: right">
        <strong>Authorized Signatory</strong>
      </div>
    </div>

    <div class="row" style="margin-top: 80px;">
      <div class='col-md-12'>
        <b>Note : GST 12% will be charged extra in final invoice</b>
      </div>
    </div>

  </section>
</div>
</body>
</html>
