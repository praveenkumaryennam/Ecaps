<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Bulk Challan PDF</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
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
    td, th{
      padding: 5px;
    }
    @page {
      size: 8.5in 11in; /* <length>{1,2} | auto | portrait | landscape */
            /* 'em' 'ex' and % are not allowed; length values are width height */
      margin: 2%; /* <any of the usual CSS values for margins> */
                   /*(% of page-box width for LR, of height for TB) */
    }
  </style>
</head>
  <body>
    <div class="wrapper">
      <section class="invoice" style="border: 1px solid #000; padding: 10px;">
        <div class="row">
          <div class="col-md-12" style="text-align: center; font-size: 10px;">
            <b style="font-weight: bold; font-size: 14px;">DELIVERY CHALLAN</b>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <address style="text-align: left; font-size: 12px;">
              <strong><?= $this->config->item('title');?></strong> <br />
              <?= $this->config->item('address');?>
            </address>
          </div>
          <div class="col-md-6">
            <address style="text-align: right; font-size: 12px;">
               <?php
                if($this->config->item('contact'))
                  echo 'Contact: '.$this->config->item('contact').'<br />';

                if($this->config->item('a/c'))
                  echo 'Account: '.$this->config->item('a/c').'<br />';

                if(!empty($this->config->item('email')))
                  echo 'Email: '.$this->config->item('email').'<br />';
                
                if($this->config->item('url'))
                  echo 'Web: '.$this->config->item('url').'<br />';
              ?>
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" style="text-align: left">
            <b style="font-weight: bold;"><?= client_info($order[0]['order']->client_code, 'clientname')?></b> <br />
            <span style="word-wrap : break-word; width : 250px; font-size: 12px;">
              <?= client_info($order[0]['order']->client_code, 'address')?>
            </span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="text-align:right">
            <span style="font-size: 12px;">Challan Number: <b style="font-weight: bold; font-size: 12px;"><?= $challan[0]->challan_number;?></b></span><br />
            <span style="font-size: 12px;">Date: <b style="font-weight: bold; font-size: 12px;"><?= date('d-m-Y', strtotime($challan[0]->shipment_date))?> <?= date('h:i A', strtotime($challan[0]->added_at))?></b></span>
          </div>
        </div>
      <table border="1">
        <thead>
          <tr>
            <th>#</th>
            <th>Order</th>
            <th>Order Date</th>
            <th>Patient</th>
            <th>Sub Dr</th>
            <th>Case No</th>
            <th>Product</th>
            <th>Teeth</th>
            <th>Units</th>
            <th>Rate/Unit</th>
            <th>Total Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php $total = 0;$i = 0; 
          foreach($order as $r){
            foreach($r['pros'] as $pro){
            $total += (float)$pro['total_amount'];
          ?>
            <tr>
              <td><?= ++$i;?></td>
              <td><?= $r['order']->order_number;?></td>
              <td><?= date('d-m-Y', strtotime($r['order']->order_date));?></td>
              <td><?= $r['order']->patiant_name;?></td>
              <td><?= $r['order']->doctor;?></td>
              <td><?= $r['order']->modal_no;?></td>
              <td><?= get_title($pro['product_id'], 'product');?></td>
              <td><?= $pro['teeth'];?></td>
              <td><?= $pro['unit'];?></td>
              <td><?= number_format((float)$pro['unit_price'], 2)?></td>
              <td text-align="center"><?= number_format((float)$pro['total_amount'], 2)?></td>
            </tr>
          <?php } } ?>
          <tr>
            <td colspan="10" style="text-align: right">Total </td>
            <td><strong><?= number_format($total, 2);?></strong></td>
          </tr>
        </tbody>
      </table>
      <table width="100%" style="margin-top: 15px; font-size: 10px; font-weight: bold;">
        <tr>
          <td>Delivery By</td>
          <td style="text-align: right">Received By</td>
          <td style="text-align: right">Authorized Signatory</td>
        </tr>
      </table>
      <div class="row" style="margin-top: 40px; font-size: 8px; font-weight: bold;">
        <div class='col-md-12'>
          <b>Note : GST 12% will be charged extra in final invoice</b>
        </div>
      </div>
    </section>
  </div>
</body>
</html>
