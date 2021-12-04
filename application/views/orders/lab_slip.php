<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $page_title;?> | Lab Slip</title>
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
  </style>
</head>
  <body>
    <div class="wrapper">
      <section class="invoice">
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

                if(!empty($this->config->item('email')))
                  echo 'Email: '.$this->config->item('email').'<br />';
                
                if($this->config->item('url'))
                  echo 'Web: '.$this->config->item('url').'<br />';
              ?>
            </address>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="text-align: center; font-size: 10px;">
            <b style="font-weight: bold;">LAB SLIP</b>
          </div>
        </div>

        <div class="row">
        	<div class="col-md-12">
        		<table border="1" style="width: 100%">
        			<tr>
        				<td>
        					<span>Order <b>#</b></span>
        					<br><span><?= $order->order_number;?></span>
        				</td>
        				<td>
        					<span>Case No<b>#</b></span>
        					<br><span><?= $order->modal_no;?></span>
        				</td>
        				<td>
        					<span>Order Date</span>
        					<br><span><?= date('d-m-Y h:i a',strtotime($order->order_date));?></span>
        				</td>
        			</tr>
        			<tr>
        				<td>
        					<span>Due Date</span>
        					<br><span><?= date('d-m-Y h:i a',strtotime($order->due_date));?></span>
        				</td>
        				<td>
        					<span>Patient</span>
        					<br><span><?= $order->patiant_name;?></span>
        				</td>
        				<td>
        					<span>Printed</span>
        					<br><span><b><?= date('d M, h:i a', strtotime($info->datetime))?></b></span>
        				</td>
        			</tr>
        		</table>

        		<br>
                <?php 
                  $c = get_clientdata($order->client_code);
                ?>
        		<table style="width: 100%" border="1">
        			<tr>
        				<th><?= $c->name;?></th>
        				<td><?= $c->city;?></td>
        				<td><?= $c->mobile;?></td>
        			</tr>
        		</table>

        		<table style="width: 100%" border="1">
        			<tr>
        				<th>Product one</th>
        				<th>Product one</th>
        				<th>Product one</th>
        			</tr>
        		</table>

        		<table style="width: 100%" border="1">
        			<tr>
        				<td style="width: 90%">
                  <?php 
                    $op = get_order_products($order->id);
                    $teeth = [];
                    foreach ($op as $o){
                      foreach (explode(',', $o->teeth) as $t)
                      $teeth[] = $t;
                    }
                  ?>
        					<table class="table" id="teeth" style="text-align: center; margin-bottom: 0px;">
                  <tbody>
                    <tr>
                      <td class="btn_t1"><b id="t_18" <?= (in_array('18', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>8</b></td>
                      <td class="btn_t1"><b id="t_17" <?= (in_array('17', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>7</b></td>
                      <td class="btn_t1"><b id="t_16" <?= (in_array('16', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>6</b></td>
                      <td class="btn_t1"><b id="t_15" <?= (in_array('15', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>5</b></td>
                      <td class="btn_t1"><b id="t_14" <?= (in_array('14', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>4</b></td>
                      <td class="btn_t1"><b id="t_13" <?= (in_array('13', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>3</b></td>
                      <td class="btn_t1"><b id="t_12" <?= (in_array('12', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>2</b></td>
                      <td class="btn_t1" style="border-right: 1px solid #000;"><b id="t_11" <?= (in_array('11', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>1</b></td>

                      <td class="btn_t1"><b id="t_21" <?= (in_array('21', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>1</b></td>
                      <td class="btn_t1"><b id="t_22" <?= (in_array('22', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>2</b></td>
                      <td class="btn_t1"><b id="t_23" <?= (in_array('23', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>3</b></td>
                      <td class="btn_t1"><b id="t_24" <?= (in_array('24', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>4</b></td>
                      <td class="btn_t1"><b id="t_25" <?= (in_array('25', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>5</b></td>
                      <td class="btn_t1"><b id="t_26" <?= (in_array('26', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>6</b></td>
                      <td class="btn_t1"><b id="t_27" <?= (in_array('27', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>7</b></td>
                      <td class="btn_t1"><b id="t_28" <?= (in_array('28', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>8</b></td>
                    </tr>
                    <tr>
                      <td class="btn_t1"><b id="t_48" <?= (in_array('48', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>8</b></td>
                      <td class="btn_t1"><b id="t_47" <?= (in_array('47', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>7</b></td>
                      <td class="btn_t1"><b id="t_46" <?= (in_array('46', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>6</b></td>
                      <td class="btn_t1"><b id="t_45" <?= (in_array('45', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>5</b></td>
                      <td class="btn_t1"><b id="t_44" <?= (in_array('44', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>4</b></td>
                      <td class="btn_t1"><b id="t_43" <?= (in_array('43', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>3</b></td>
                      <td class="btn_t1"><b id="t_42" <?= (in_array('42', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>2</b></td>
                      <td class="btn_t1" style="border-right: 1px solid #000;"><b id="t_41" <?= (in_array('41', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>1</b></td>

                      <td class="btn_t1"><b id="t_31" <?= (in_array('31', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>1</b></td>
                      <td class="btn_t1"><b id="t_32" <?= (in_array('32', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>2</b></td>
                      <td class="btn_t1"><b id="t_33" <?= (in_array('33', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>3</b></td>
                      <td class="btn_t1"><b id="t_34" <?= (in_array('34', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>4</b></td>
                      <td class="btn_t1"><b id="t_35" <?= (in_array('35', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>5</b></td>
                      <td class="btn_t1"><b id="t_36" <?= (in_array('36', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>6</b></td>
                      <td class="btn_t1"><b id="t_37" <?= (in_array('37', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>7</b></td>
                      <td class="btn_t1"><b id="t_38" <?= (in_array('38', $teeth))?'style="border: 2px solid #000; border-radius: 50%; padding: 5px;"':'';?>>8</b></td>
                    </tr>
                  </tbody>
                </table>
        				</td>
        				<td style="text-align: center;">Units <?= $order->units;?></td>
        			</tr>
        		</table>
        	</div>
        </div>

        <div class="row">
        	<div class="col-xs-5">
<!-- 	        	<table style="width: 100%">
	    			<tr style="border-bottom: 1px solid #000;">
	    				<th>Enclosure</th>
	    				<th>#</th>
	    			</tr>
	    			<tr style="border-bottom: 1px solid #000;">
	    				<td colspan="2"><?= $order->enclosure;?></td>
	    			</tr>
	    		</table> -->
          <br>
	    		<table border="1" style="width: 100%">
	    			<tr>
	    				<th colspan="3">Shade</th>
	    			</tr>
	    			<tr>
	    				<td><?= get_shade($order->shade_one);?></td>
              <td><?= get_shade($order->shade_two);?></td>
              <td><?= get_shade($order->shade_three);?></td>
	    			</tr>
	    		</table>
        	</div>
       		
        	<div class="col-xs-5">
	       		<table>
	    			<tr style="border-bottom: 2px solid #000">
	    				<th colspan="2">Process</th>
	    			</tr>
            <?php 
              $ids = order_schadules($order->id);
              foreach ($ids as $id) {
                foreach (trails_process() as $k) {
                  if($id->title == $k['id']){
                    echo '<tr>
                      <td>'.$k['value'].'</td>
                    </tr>';  
                  }
                }
              }
            ?>
	    		</table>
        	</div>
        </div>
<!-- 
        <br>
        <div class="row">
        	<div class="col-md-12">
        		<table border="1" style="width: 100%">
        			<tr>
        				<th><b>Comment : </b></th>
        			</tr>
        		</table>
        	</div>
        </div> -->
      </section>
    </div>
  </body>
</html>
