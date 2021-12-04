<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Invoice</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/bootstrap-datepicker.min.css" />
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
      	<form action="<?= base_url('payment/genratecreditnote');?>" method="post">
        <div class="row">
          <div class="col-md-12" style="text-align: center; font-size: 10px;">
            <b style="font-weight: bold;">CREDIT NOTE</b>
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
              <div class="row">
	              <div class="col-md-6 pull-right">
	              	<div class="input-group">
		                <span class="input-group-addon"><b>Credit Note Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>
		                <input type="text" name="cdate" class="form-control datepicker" value="<?= date('d-m-Y');?>" placeholder="Credit Date" required>
		            </div>
	              	<div class="input-group">
		                <span class="input-group-addon"><b>Credit Note Number</b></span>
		                <input type="text" name="cno" class="form-control" placeholder="Credit Note Number" required>
		            </div>
	              </div>
              </div>
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
        <div class="row">
        	<div class="col-xs-12">
		        <table border="1" width="100%">
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
		                    $teeth = get_teeth_sides($p->order_id, $p->product);
		                   	
		                    echo '<tr>
		                    <td>&nbsp;<b>'.$z.'</b></td>
		                    <td>
		                    	&nbsp;<b>'.$i->order_number.'</b>
		                    	<input type="hidden" name="order_id[]" id="order_id'.$z.'" value="'.$i->order_number.'" />
		                    	<input type="hidden" name="product_id[]" value="'.$p->id.'" />
		                    	<input type="hidden" name="bprice[]" value="'.$p->base_price.'" />
		                    	<input type="hidden" name="old_unitprice[]" value="'.$p->unitprice.'" />
		                    </td>
		                    <td>&nbsp;'.date('d-m-Y', strtotime($i->order_date)).'</td>
		                    <td>&nbsp;<b>'.$challan->challan_number.'</b></td>
		                    <td>&nbsp;'.date('d-m-Y', strtotime($challan->shipment_date)).'</td>
		                    <td>&nbsp;'.$i->patiant.'</td>
		                      <td><b>&nbsp;'.get_title($p->product, 'product').'</b></td>
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
		                      <td>
		                      	&nbsp;'.$p->unit.'
		                      	<input type="hidden" name="unit[]" id="unit'.$z.'" value="'.$p->unit.'">
		                      </td>
		                      <td>
		                      	<input type="text" name="price[]" id="unitprice'.$z.'" value="'.$p->unitprice.'" class="form-control unitprice" />
		                      	<input type="hidden" name="invoice" id="invoice" value="'.$invoice[0]->invoice_number.'">
		                      	<input type="hidden" name="igst" id="igst" value="'.$i->igst.'">
		                      	<input type="hidden" name="sgst" id="sgst" value="'.$i->sgst.'">
		                      	<input type="hidden" name="cgst" id="cgst" value="'.$i->cgst.'">
		                      </td>
		                      <td>&nbsp;<b id="subtotal'.$z.'">'.$p->subtotal.'</b></td>
		                    </tr>';
		                    $z++;
		                    $tunits += $p->unit;
		                  }
		                }
		              }
		              echo '<input type="hidden" name="tunits" value="'.$tunits.'">';
		              echo '<input type="hidden" name="subtotal" id="fsubtotal">';
		            ?>
		            <tr>
		              <td colspan="8" style="text-align:right">
		              	<span class="pull-left">Remark : </span><input type="text" name="remark" style="width: 94%" />
		              </td>
		              <td>&nbsp;<?= number_format($tunits);?> &nbsp; </td>
		              <td>&nbsp;Sub Total &nbsp; </td>
		              <th>&nbsp;<span id="subtotal"><?= number_format($i->invoice_subtotal, 2);?></span></th>
		            </tr>
		            <tr>
		              <th colspan="7" style="text-align: left;">
		                <span>GSTIN : 142536587545<br />
		                  HSN Number : 142536587545<br />
		                  State : Maharashtra State Code: 27</span>
		              </th>
		              <th colspan='1'>
		                <table border="1" width="100%">
		                  <?php if($i->invoice_gst_amount > 0) {?>
		                    <tr style="height:44.8px;">
		                      <td>IGST@<?= number_format($i->igst, 2);?></td>
		                    </tr>
		                    <tr style="height:44.8px;">
		                      <td>CGST@<?= number_format($i->cgst, 2);?></td>
		                    </tr>
		                    <tr style="height:44.8px;">
		                      <td>SGST@<?= number_format($i->sgst, 2);?></td>
		                    </tr>
		                  <?php } ?>
		                  <tr>
		                    <td width="50%" style="height:44.8px;">invoice Total </td>
		                  </tr>
		                </table>
		              </th>
		              <td colspan='3'>
		                <table border="1" width="100%">
		                  <?php if($i->invoice_gst_amount > 0) {?>
		                    <tr>
		                      <td colspan="3"><input type="text" id="igstv" value="<?= number_format((($i->invoice_subtotal*$i->igst)/100), 2);?>" readonly="readonly" class="form-control"/></td>
		                    </tr>
		                    <tr>
		                      <td colspan="3"><input type="text" id="cgstv" value="<?= number_format((($i->invoice_subtotal*$i->cgst)/100), 2);?>" readonly="readonly" class="form-control"/></td>
		                    </tr>
		                    <tr>
		                      <td colspan="3"><input type="text" id="sgstv" value="<?= number_format((($i->invoice_subtotal*$i->sgst)/100), 2);?>" readonly="readonly" class="form-control"/></td>
		                    </tr>
		                  <?php } ?>
		                  <tr>
		                    <td colspan="3"><input type="text" class="form-control" id="totalv" name="total" value="<?= $i->invoice_total;?>" readonly="readonly"/></td>
		                  </tr>
		                </table>
		              </td>
		            </tr>
		          </tbody>
		        </table>
        	</div>
        </div>
        <br>
        <div class="row">
        	<div class="col-md-12">
        		<button class="btn btn-primary pull-right">Submit</button>
        	</div>
        </div>
       </form>
      </section>
    </div>
    <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/jquery.min.js?v=<?= time();?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/');?>dist/js/bootstrap-datepicker.min.js"></script>
    <script>
      $('.unitprice').change(function() {
        var za = '<?= $z-1;?>';
      	var newdata = [];
      	var subtotal = 0;
      	var total = 0;
		var cgst = $('#cgst').val();
		var sgst = $('#sgst').val();
		var igst = $('#igst').val();
        for(var k=1; k<=za; k++){
          var order_no = $('#order_id'+k).val();
          var units = $('#unit'+k).val();
          var price = $('#unitprice'+k).val();          
          $('#subtotal'+k).text((units * price).toFixed(2));
          subtotal += (units * price);
          $('#subtotal').text(subtotal.toFixed(2));
        }
        $('#fsubtotal').val(subtotal);
        if(igst > 0){
        	$('#igstv').val(((subtotal*igst)/100).toFixed(2));
        	$('#cgstv').val(0);
        	$('#sgstv').val(0);
        	total = (subtotal + ((subtotal*igst)/100)).toFixed(2);
        }else{
        	$('#igstv').val(0);
        	$('#cgstv').val(((subtotal*sgst)/100).toFixed(2));
        	$('#sgstv').val(((subtotal*cgst)/100).toFixed(2));
        	total = subtotal + (((subtotal*cgst)/100) + ((subtotal*sgst)/100));
        }
        $('#totalv').val(total);
      })

          //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      "maxDate": new Date()
    })
    </script>
  </body>
</html>
