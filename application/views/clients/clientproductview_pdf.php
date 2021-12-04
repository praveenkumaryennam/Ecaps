<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ecaps | Invoice</title>
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
    <div class="wrapper"  style="border: 2px solid #000; padding: 10px;">
      <section class="invoice">
        <div class="row">
          <div class="col-xs-6">
            <address style="text-align: left; font-size: 12px;">
              <strong>RPD DENTAL ART PVT.LTD.</strong> <br />
              UNIT NO. 102, ECO HIGHTS, SHRI NITYANAND CHS LTD.,<br />SWAMI NITYANAND MARG, ANDHERI EAST, <br />MUMBAI - 400 069. 
            </address>
          </div>

          <div class="col-md-6">
            <address style="text-align: right; font-size: 12px;">
              <strong>Contact:</strong> 9324902009/3924702010<br />
              <strong>Email:</strong> rpddental2016@gmail.com.<br />
              <strong>Web:</strong> www.rpddentalart.com<br />
              <strong>Date: </strong> <?= date('d-m-Y');?><br />
            </address>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6" style="text-align: left">
            <address style="word-wrap : break-word; width : 250px;">
              <b><?= client_info($id, 'clientname')?></b> <br />
              <?= client_info($id, 'address')?>
            </address>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="text-align: center; font-size: 16px;">
            <b style="font-weight: bold;">Price List</b>
          </div>
        </div>

        <br>

        <table border="1" width="100%">
          <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Discount(%)</th>
                <th>Price Band</th>
            </tr>
          </thead>
            <tbody>
              <?php $i = 1; 
               foreach($rows as $o){ ?>
                <tr id="cprow<?= $o->cpid;?>">
                    <td><?= $i++;?></td>
                    <td><?= ucfirst($o->title);?></td>
                    <td><?= number_format((float)$o->unit_price, 2);?></td>
                    <td><?= number_format((float)$o->discount);?></td>
                    <td><?= number_format(((float)$o->unit_price - ((float)$o->unit_price * (float)$o->discount)/100), 2);?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <div class="col-md-12" style="margin-top: 6%; text-align: right; font-size: 12px; font-weight: bold;">
            <p><b>Authorized Signature</b></p>
          </div>
      </section>
    </div>
  </body>
</html>
