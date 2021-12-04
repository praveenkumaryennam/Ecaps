<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Job Entry Productivity Data</h3>
        <select class="form-control selecct2 pull-right" id="emp" style="width: 250px;">
          <option value=""> --- </option>
          <?php 
          	foreach ($users as $e){
          		$sel = ($e->username == $client)?"selected":'';
          		echo '<option value="'.$e->username.'" '.$sel.'>'.get_emp_name($e->username, 'employee').'</option>';
          	}
          ?>
        </select>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
              	<thead>
              		<tr>
              			<th></th>
              			<th></th>
              			<th colspan="3" style="text-align:center;">FTD <small>( <?= date('d M, Y');?> )</small></th>
              			<th colspan="3" style="text-align:center;">MTD <small>( <?= date('M, Y');?> )</small></th>
              			<th colspan="3" style="text-align:center;">YTD <small>( <?= date('Y');?> )</small></th>
              		</tr>
              		<tr>
              			<th>Sr.no</th>
              			<th>Employee</th>
              			<th>Orders</th>
              			<th>Challan</th>
              			<th>Invoice</th>
              			<th>Orders</th>
              			<th>Challan</th>
              			<th>Invoice</th>
              			<th>Orders</th>
              			<th>Challan</th>
              			<th>Invoice</th>
              		</tr>
              	</thead>
              	<tbody>

              		<?php $i=1; foreach ($rows as $key => $val){
              			if($key == 'admin')
              				$emp_name = $key;
              			else
              				$emp_name = get_emp_name($key, 'employee');

              			echo '<tr>
              				<td>'.$i++.'</td>
              				<td>'.strtoupper($emp_name).'</td>
              				<td>'.$val['ftd']['orders'].'</td>
              				<td>'.$val['ftd']['invoice'].'</td>
              				<td>'.$val['ftd']['challans'].'</td>
              				<td>'.$val['mtd']['orders'].'</td>
              				<td>'.$val['mtd']['invoice'].'</td>
              				<td>'.$val['mtd']['challans'].'</td>
              				<td>'.$val['ytd']['orders'].'</td>
              				<td>'.$val['ytd']['invoice'].'</td>
              				<td>'.$val['ytd']['challans'].'</td>
              			</tr>';
              		}?>
              	</tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
 $('#emp').change(function(){
 	window.location.href = '<?= base_url();?>reports/productivityreport/'+$(this).val();
 });
</script>