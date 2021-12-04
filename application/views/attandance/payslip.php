<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Payslip</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    td, th{
      padding-left: 5px;
      padding-top: 5px;
    }
    @page {
      	size: 8.5in 11in;
      	/* <length>{1,2} | auto | portrait | landscape */
        /* 'em' 'ex' and % are not allowed; length values are width height */
      	margin: 2%; /* <any of the usual CSS values for margins> */
      	/*(% of page-box width for LR, of height for TB) */
    }

    .tbody td,.tbody th{
    	width: 250px;
    }
  </style>
</head>
  <body>
  		<div>
	    <section class="wrapper" style="border: 2px solid #000; padding: 10px;">
	        <div class="row">
	          <div class="col-md-12" style="text-align: center; font-size: 10px;">
	            <b style="font-weight: bold;">Pay Slip</b>
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
	          	<div class="col-md-6" style="text-align: left">
		            <b style="font-weight: bold;"><?= client_info($order[0]['order']->client_code, 'clientname')?></b> <br />
		            <span style="word-wrap : break-word; width : 250px; font-size: 12px;">
		              <?= client_info($order[0]['order']->client_code, 'address')?>
		            </span>
		        </div>
	        </div>

	        <div class="row">
	          	<div class="col-xs-8" style="display: inline-flex;">
	          		<table width="100%">
	          			<tr>
	          				<th>Employee ID</th>
	          				<td><b>:</b> <?= $data['rows']['attandance']->emp_id;?></td>
	          			</tr>

	          			<tr>
	          				<th>Department</th>
	          				<td><b>:</b> <?= get_title($data['rows']['employee']->department, 'department');?></td>
	          			</tr>

	          			<tr>
	          				<th>Paydate</th>
	          				<td><b>:</b> <?= $data['pay_date'];?></td>
	          			</tr>

	          			<tr>
	          				<th>PF A/C Number</th>
	          				<td><b>:</b> <?= $data['rows']['ac']->pf_ac;?></td>
	          			</tr>

	          		</table>
	          	<!-- </div>

	          	<div class="col-md-6"> -->
	          		<table width="100%">
	          			<tr>
	          				<th>Name</th>
	          				<td><b>:</b> <?= $data['rows']['employee']->firstname.' '.$data['rows']['employee']->lastname;?></td>
	          			</tr>

	          			<tr>
	          				<th>Designation</th>
	          				<td><b>:</b> <?= get_title($data['rows']['employee']->designation, 'designation');?></td>
	          			</tr>

	          			<tr>
	          				<th>Days Worked</th>
	          				<td><b>:</b> <?= $data['rows']['attandance']->present;?></td>
	          			</tr>
	          			<tr>
	          				<th>ESI A/C Number</th>
	          				<td><b>:</b> <?= $data['rows']['ac']->mis_ac;?></td>
	          			</tr>
	          		</table>
	          	</div>
	        </div>
	        <br>
	        <div class="row">
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-12">
								<table width="100%" class="tbody">
									<tr>
										<th>
											<table style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;">
												<tr>
							          				<th>Earning</th>
							          				<th>YTD</th>
							          				<th>Amount</th>
							          			</tr>
											</table>
										</th>
										<th>
											<table style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;">
												<tr>
							          				<th>Deductions</th>
							          				<th>YTD</th>
							          				<th>Amount</th>
							          			</tr>
											</table>
										</th>
									</tr>
								</table>
							
				          		<table width="100%" class="tbody">
				          			<tr>
				          				<td>
				          					<table style="border-left: 1px solid #000;border-right: 1px solid #000;">
				          						<?php echo $data['cr'];?>
				          					</table>
				          				</td>
				          				<td>
				          					<table style="border-left: 1px solid #000;border-right: 1px solid #000;">
				          						<?php echo $data['dr'];?>
				          					</table>
				          				</td>
				          			</tr>
				          		</table>


				          		<table width="100%" class="tbody">
				          			<tr>
				          				<td>
				          					<table style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;">
				          						<tr>
													<th>Total Earning (Rounded)</th>
													<th><?= number_format($data['total_earning_ytd'], 2);?></th>
													<th><?= number_format($data['total_earning'], 2);?></th>
				          						</tr>
				          					</table>
				          				</td>

				          				<td>
				          					<table style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;">
				          						<tr>
													<th>Total Deductions (Rounded)</th>
													<th><?= number_format($data['total_deduct_ytd'], 2);?></th>
													<th><?= number_format($data['total_deduct'], 2);?></th>
				          						</tr>
				          					</table>
				          				</td>
			  						</tr>
				          		</table>

				          		<table width="100%">
		  							<tr>
		  								<td>
				          					<table  width="100%" border="1">
				          						<tr>
													<td style="text-align: right;"><b>Total Deductions (Rounded) : <?= number_format(($data['total_earning'] - $data['total_deduct']), 2)?>&nbsp;&nbsp;</b></td>
				  								</tr>
				          					</table>
		  								</td>
		  							</tr>
				          		</table>
			          	</div>
					</div>
				</div>
	        </div>

	        <br><br><br>

	        <div class="row">
	        	<div class="col-xs-6">
					<div class="pull-left" style="margin-left: 10px;">
	        			<h4>Employer's Signature</h4><br>
	        			<p>_______________________</p>
	        		</div>
				</div>

				<div class="col-xs-6">
					<div class="pull-right" style="margin-right: 10px;">
	        			<h4>Employer's Signature</h4><br>
	        			<p>_______________________</p>
					</div>
	        	</div>
	        </div>
	    </section>
    </div>
    <br>
  </body>
</html>
