<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Bulk Payment</h3>
      </div>
      <?php
      	$cname = get_clientname($client);
      ?>
      <!-- /.box-header -->
      	<div class="box-body">
	        <div class="row">
	          	<div class="col-md-6">
		            <table class="table table-bordered">
		                <tr>
		                  <th>Client</th>
		                  <th colspan="4"><?= $cname;?></th>
		                </tr>
						<tr>
				        	<th>Invoice Number</th>
				        	<th>Invoice Date</th>
				        	<th>Invoice Total</th>
				        	<th>Paid Total</th>
				        	<th>Balance Total</th>
						</tr>
		                
		                <?php 
		                $total_blc = 0;
		                $total_paid = 0;
		                $total_invoice = 0;
		                foreach ($invoices as $i){ 
		                	$total_blc += ($i->invoice_total - $i->paid);
		                	$total_paid += $i->paid;
		                	$total_invoice += $i->invoice_total;
		                ?>
			                <tr>
			                  <td><?= $i->invoice_number?></td>
			                  <td><?= date('d-m-Y', strtotime($i->invoice_date));?></td>
			                  <td><?= number_format(abs($i->invoice_total), 2);?></td>
			                  <td><b><?= number_format(abs($i->paid), 2);?></b></td>
			                  <td><b><?= number_format(abs(($i->invoice_total - $i->paid)), 2);?></b></td>
				            </tr>
		                <?php } ?>
		                	<tr>
			                  <td></td>
			                  <td></td>
			                  <td><b><?= number_format(abs($total_invoice), 2);?></b></td>
			                  <td><b><?= number_format(abs($total_paid), 2);?></b></td>
			                  <td><b><?= number_format(abs($total_blc), 2);?></b></td>
				            </tr>
		                <input type="hidden" id="invoice_total" value="<?= $total_invoice;?>">
		                <input type="hidden" id="paid_total" value="<?= $total_paid;?>">
		                <input type="hidden" id="client" value="<?= $client;?>">
		            </table>
		        </div>
	           	<div class="col-md-6" id="blcshow">
		            <table class="table table-bordered">
		            	<tr>
		            		<th>Payment Date</th>
		            		<td><input id="pay_date" type="text" class="form-control datepicker" placeholder="DD-MM-YYYY" /></td>
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
		            			<input type="button" class="btn btn-primary pull-right" id="paybtn2" value="Pay">
		            			<p id="newblc"></p>
		            		</td>
		            	</tr>
		            </table>
	          	</div>
	      	</div>

	      	<div class="row">
	      		<div class="col-md-12">
	      			<input type="hidden" id="pclientl" value="<?= 'PaymentCollection - '.str_replace(' ','_', $cname).'_'.date('YmdHis');?>">
	      			<div class="table-responsive">
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