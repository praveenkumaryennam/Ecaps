<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ecaps | Invoice Summary</title>
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
          <div class="col-md-12" style="text-align: center; font-size: 10px;">
            <b style="font-weight: bold;">INVOICE SUMMARY</b>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <strong style="font-weight: bold"><?= $this->config->item('title');?></strong> <br />
            <address style="text-align: left; font-size: 12px;">
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
              <strong>Date</strong> <?= date('d-m-Y');?><br />
            </address>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6" style="text-align: left">
            <b style="font-weight: bold"><?= client_info($client, 'clientname')?></b> <br />
            <address style="word-wrap : break-word; max-width : 150px; font-size:  12px;">
              <?= client_info($client, 'address')?>
            </address>
          </div>
        </div>

        <!-- Table Start -->

        <table border="1">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice #</th>
              <th>Invoice Date</th>
              <th>Order #</th>
              <th>Order Date</th>
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
            <?php 
              $z=1;
              $tunits = 0;
              $fsubtotal = 0;
              asort($invoices);
              foreach($invoices as $i){
                $challan = get_challan($i->order_number);
                $v=1; 
                foreach($product as $pp){
                  foreach($pp as $p){
                    if($p->invoice_number == $i->invoice_number && $p->order_id == $i->order_id){
                      $teeth = get_teeth_sides($p->order_id, $p->product);

                      echo '<tr>
                      <td>&nbsp;'.$z++.'</td>
                      <td>&nbsp;<b>'.$i->invoice_number.'</b></td>
                      <td>&nbsp;'.date('d-m-Y', strtotime($i->invoice_date)).'</td>
                      <td>&nbsp;<b>'.$i->order_number.'</b></td>
                      <td>&nbsp;'.date('d-m-Y', strtotime($i->order_date)).'</td>
                      <td>&nbsp;<b>'.$challan->challan_number.'</b></td>
                      <td>&nbsp;'.date('d-m-Y', strtotime($challan->shipment_date)).'</td>
                      <td>&nbsp;'.$i->patiant.'</td>';
                      echo '<td><b>&nbsp;'.get_title($p->product, 'product').'</b></td>
                        <td>
                          <table width="100%" border="1">
                            <tr>
                              <td width="50%" style="text-align:center;"><b>'.implode(',',$teeth['p1']).'</b></td>
                              <td width="50%" style="text-align:center;"><b>'.implode(',',$teeth['p2']).'</b></td>
                            </tr><tr>
                              <td width="50%" style="text-align:center;"><b>'.implode(',',$teeth['p3']).'</b></td>
                              <td width="50%" style="text-align:center;"><b>'.implode(',',$teeth['p4']).'</b></td>
                            </tr>
                          </table>
                        </td>
                        <td>&nbsp;'.$p->unit.'</td>
                        <td>&nbsp;<b>'.number_format($p->unitprice, 2).'</b></td>
                        <td>&nbsp;<b>'.$p->subtotal.'</b></td>
                      </tr>';
                      $fsubtotal += (float) str_replace(',', '', $p->subtotal); $tunits += $p->unit;
                    }
                  }
                }
              }
            ?>

            <tr>
              <td colspan="9" style="text-align:right"></td>
              <td>&nbsp;Total Units&nbsp; </td>
              <td>&nbsp;<?= number_format($tunits);?> &nbsp; </td>
              <td>&nbsp;Sub Total &nbsp; </td>
              <th colspan="1">&nbsp;<?= number_format($fsubtotal, 2);?></th>
            </tr>
            <tr>
              <td colspan="9" style="text-align: left;">
                <?= $this->config->item('gst');?>
              </td>
              <td colspan="1">
                <table border="1" width="100%">
                  <?php if($i->invoice_gst_amount > 0) {?>
                    <tr>
                      <td>IGST@<?= number_format($i->igst, 2);?></td>
                    </tr>
                    <tr>
                      <td>CGST@<?= number_format($i->cgst, 2);?></td>
                    </tr>
                    <tr>
                      <td>SGST@<?= number_format($i->sgst, 2);?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td width="50%">invoice Total </td>
                  </tr>
                </table>
              </td>
              <td colspan='3'>
                <table border="1" width="100%">
                  <?php if($i->invoice_gst_amount > 0) {?>
                    <tr>
                      <td colspan="3">&nbsp;<?= number_format((($i->invoice_subtotal*$i->igst)/100), 2);?>./-</td>
                    </tr>
                    <tr>
                      <td colspan="3">&nbsp;<?= number_format((($i->invoice_subtotal*$i->cgst)/100), 2);?>./-</td>
                    </tr>
                    <tr>
                      <td colspan="3">&nbsp;<?= number_format((($i->invoice_subtotal*$i->sgst)/100), 2);?>./-</td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="3">&nbsp;<?= number_format(($i->invoice_total), 2);?>./-</td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Table END -->



        <div class="col-md-8" style="margin-top: 8%; text-align: right; font-size: 12px; font-weight: bold;">
          <p><b>Authorized Signature</b></p>
        </div>
      </div>
    </section>
  </body>
</html>
