<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Make Payment</h3>
        <!-- <a href="<?= base_url('sales');?>" class="btn btn-primary add"><i class="fa fa-arrow-left"></i> Sales</a> -->
      </div>
      <?php 
      	$cname = get_clientname($in->client_id);
      ?>
      <!-- /.box-header -->
      	<div class="box-body">
	        <div class="row">
	          	<div class="col-md-6">
	          		<div class="table-responsive">
			            <table class="table table-bordered">
		          			<tr>
			                  <th>Client</th>
			                  <td><?= $cname;?></td>
			                </tr>
			                <tr>
			                  <th>Order No</th>
			                  <td><?= $in->order_number;?></td>
			                </tr>
			                <tr>
			                  <th>Order Date</th>
			                  <td><?= date('d-m-Y', strtotime($in->order_date));?></td>
			                </tr>
			                <tr>
			                  <th>Invoice Number</th>
			                  <td><?= $in->invoice_number?></td>
			                </tr>
			                <tr>
			                  <th>Invoice Date</th>
			                  <td><?= date('d-m-Y', strtotime($in->invoice_date));?></td>
			                </tr>
			                <tr>
			                  <th>Invoice Total</th>
			                  <td><b><?= $in->invoice_total;?></b></td>
			                </tr>
			                <input type="hidden" id="invoice_total" value="<?= $in->invoice_total;?>">
			                <input type="hidden" id="paid_total" value="<?= $paid_total;?>">
			                <input type="hidden" id="client" value="<?= $in->client_id;?>">
			            </table>
			        </div>
		        </div>
	           	<div class="col-md-6" id="blcshow">
	           		<div class="table-responsive">
			            <table class="table table-bordered">
			            	<tr>
			            		<th>Payment Date</th>
			            		<td><input id="pay_date" type="text" class="form-control datepicker" /></td>
			            	</tr>
			            	<tr>
			            		<th>Balance Amount</th>
			            		<td><b id="blc_show"></b></td>
			            	</tr>
			            	<tr>
			            		<th>Payment Mode</th>
			            		<td>
			            			<select id="payement_mode" class="form-control">
			            				<option value=""> --- </option>
			            				<option value="cash">Cash</option>
			            				<option value="cheque">Cheque</option>
			            				<option value="paytm">PayTM</option>
			            				<option value="gpay">GPay</option>
			            				<option value="bank_transfer">Bank Transfer</option>
			            			</select>
			            		</td>
			            	</tr>

			            	<tr id="gpay">
			            		<th>Referance Number</th>
			            		<td>
			            			<input type="text" id="reference_no" class="form-control" />
			            		</td>
			            	</tr>

			            	<tr class="cheque">
			            		<th>Cheque Number</th>
			            		<th>Cheque Date</th>
			            	</tr>

			            	<tr class="cheque">
			            		<td>
			            			<input type="text" class="form-control" id="check_no" />
			            		</td>
			            		<td>
			            			<input type="date" class="form-control" id="check_date" />
			            		</td>
			            	</tr>
			            	<tr class="cheque">
			            		<th>Bank Name</th>
			            		<th>IFSC Code</th>
			            	</tr>

			            	<tr class="cheque">
			            		<td>
			            			<input type="text" class="form-control" id="bankname" />
			            		</td>
			            		<td>
			            			<input type="text" class="form-control" id="ifsc_code" />
			            		</td>
			            	</tr>

			            	<tr>
			            		<th>Pay Amount</th>
			            		<td><input type="text" class="form-control" id="pay_amount"/></td>
			            	</tr>

			            	<tr>
			            		<td colspan="2">
			            			<input type="button" class="btn btn-primary pull-right" id="paybtn" value="Pay" data-in="<?= $in->invoice_number;?>">
			            			<p id="newblc"></p>
			            		</td>
			            	</tr>
			            </table>
		          	</div>
	          	</div>
	      	</div>

	      	<div class="row">
	      		<div class="col-md-12">
	      			<div class="table-responsive">
	      				<input type="hidden" id="pclientl" value="<?= 'PaymentCollection - '.str_replace(' ','_', $cname).'_'.date('YmdHis');?>">
		      			<table class="table table-bordered table-hover datatable_exl">
		      				<thead>
			      				<tr>
			      					<th>Sr.No</th>
			      					<th>Invoice #</th>
			      					<th>Payment Date</th>
			      					<th>Payment Mode</th>
			      					<th>Reference</th>
			      					<th>Cheque Number</th>
			      					<th>Cheque Date</th>
			      					<th>Paid Amount</th>
			      					<th>Balance Amount</th>
			      				</tr>
		      				</thead>

		      				<tbody>
		      					<?php 
		      						if(!empty($payment_rows)){
			      						$i = 1;
			      						foreach ($payment_rows as $r){
			      							$chkdate = ($r->check_date != '0000-00-00')?date('d-m-Y', strtotime($r->check_date)):'';
			      							echo '<tr>
			      								<td>'.$i++.'</td>
			      								<td>'.$r->invoice_number.'</td>
			      								<td>'.date('d-m-Y', strtotime($r->payment_date)).'</td>
			      								<td>'.strtoupper($r->payment_mode).'</td>
			      								<td>'.$r->reference_no.'</td>
			      								<td>'.$r->check_no.'</td>
			      								<td>'.$chkdate.'</td>
			      								<td>'.number_format($r->paid_amount, 2).'</td>
			      								<td>'.number_format(round($r->blc_amount), 2).'</td>
			      							</tr>';
			      						}
		      						}
		      					?>
		      				</tbody>
		      			</table>
		      		</div>
	      		</div>
	      	</div>
      	</div>
    </div>
  </div>
</div>

