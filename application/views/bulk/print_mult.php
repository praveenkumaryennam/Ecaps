<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Invoice</title>
  <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
  
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
    <div class="wrapper" style="border: 2px solid #000; padding: 10px;">
      <section class="invoice">
        <div class="row">
          <div class="col-md-12" style="text-align: center; font-size: 10px;">
            <b style="font-weight: bold;">TAX INVOICE</b>
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
              <strong>Invoice #.</strong> <?= $invoice[0]->invoice_number;?><br />
              <strong>Date</strong> <?= date('d-m-Y', strtotime($invoice[0]->invoice_date));?><br />
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" style="text-align: left">
            <address style="word-wrap : break-word; width : 250px;">
              <b><?= client_info($invoice[0]->client_id, 'clientname')?></b> <br />
              <?= client_info($invoice[0]->client_id, 'address')?>
            </address>
          </div>
        </div>
        <table border="1" style="width: 100%">
          <thead>
            <tr>
              <th>Sr.no</th>
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
              $z = 1;
              $tunits = 0;
              foreach($invoice as $i){
                $challan = get_challan($i->order_number);
                foreach($pros as $p){
                  if($p->order_id == $i->order_id){
                    
                    $a = get_teeth_sides($p->order_id, $p->product);
                    
                    echo '<tr>
                    <td>&nbsp;<b>'.$z++.'</b></td>
                    <td>&nbsp;<b>'.$i->order_number.'</b></td>
                    <td>&nbsp;'.date('d-m-Y', strtotime($i->order_date)).'</td>
                    <td>&nbsp;<b>'.$challan->challan_number.'</b></td>
                    <td>&nbsp;'.date('d-m-Y', strtotime($challan->shipment_date)).'</td>
                    <td>&nbsp;'.$i->patiant.'</td>
                      <td><b>&nbsp;'.get_title($p->product, 'product').'</b></td>
                      <td>
                        <table width="100%" border="1">
                          <tr>
                            <td width="50%" style="text-align:center;"><b>'.implode(',',$a['p1']).'</b></td>
                            <td width="50%" style="text-align:center;"><b>'.implode(',',$a['p2']).'</b></td>
                          </tr><tr>
                            <td width="50%" style="text-align:center;"><b>'.implode(',',$a['p3']).'</b></td>
                            <td width="50%" style="text-align:center;"><b>'.implode(',',$a['p4']).'</b></td>
                          </tr>
                        </table>
                      </td>
                      <td>&nbsp;'.$p->unit.'</td>
                      <td>&nbsp;<b>'.number_format($p->unitprice, 2).'</b></td>
                      <td>&nbsp;<b>'.$p->subtotal.'</b></td>
                    </tr>';
                    $tunits += $p->unit;
                  }
                }
              }
            ?>
            <tr>
              <td colspan="8" style="text-align:right"></td>
              <td>&nbsp;<?= number_format($tunits);?> &nbsp; </td>
              <td>&nbsp;Sub Total &nbsp; </td>
              <th>&nbsp;<?= number_format($i->invoice_subtotal, 2);?></th>
            </tr>
            <tr>
              <th colspan="7" style="text-align: left;">
                <span>GSTIN : 27AAFCV4718A1ZJ<br />
                  HSN Number : 90212100<br />
                  State : Maharashtra State Code: 27</span>
              </th>
              <th colspan='1'>
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
              </th>
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
         
        <div class="row">
          <div class="col-xs-4" style="margin-top:5%; line-height: 5px; font-size: 10px; font-weight: bold;">
            <table class="table table-bordered">
              <tr><td style="font-size: 8px; font-weight: bold">BANK NAME</td> <td style="font-size: 8px; font-weight: bold"> ICICI BANK</td></tr>
              <tr><td style="font-size: 8px; font-weight: bold">BRANCH</td> <td style="font-size: 8px; font-weight: bold"> JOGESHWARI (E)</td></tr>
              <tr><td style="font-size: 8px; font-weight: bold">A/C NO</td> <td style="font-size: 8px; font-weight: bold"> 123605001442</td></tr>
              <tr><td style="font-size: 8px; font-weight: bold">IFS CODE</td> <td style="font-size: 8px; font-weight: bold"> ICIC0001236</td></tr>
            </table>
          </div>
          <div class="col-md-8" style="margin-top: 8%; text-align: right; font-size: 8px; font-weight: bold;">
            <p><b>Authorized Signature</b></p>
          </div>
        </div>
      </section>
    </div>
  </body>
</html>