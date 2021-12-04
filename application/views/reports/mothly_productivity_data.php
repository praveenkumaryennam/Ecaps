<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <select class="form-control selecct2 pull-right" id="emp" style="width: 250px;">
          <option value=""> --- </option>
          <?php 
            for($i=1; $i<=12; $i++){
          		echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('1970-'.$i.'-20')).'</option>';
            }
          ?>
        </select>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_exl">
              	<thead>
                  <tr>
                    <td colspan="2"></td>
                  <?php
                    $d = cal_days_in_month(CAL_GREGORIAN,$m,date('Y'));
                    for($i=1; $i<=$d; $i++){
                      echo '<th colspan="2" style="text-align: center;">'.$i.'</th>';
                    }
                  ?>
                    <th colspan="2">Total</th>
                  </tr>
              		<tr>
              			<th>Sr.no</th>
              			<th>Employee</th>
              			<?php
                    for($i=1; $i<=$d+1; $i++){
                      echo '<th>Jobs</th><th>Units</th>';
                      }
                    ?>
              		</tr>
              	</thead>
              	
                <tbody>
                  <?php $i = 1; foreach ($rows as $r => $v){
                    $tj = 0;
                    $tu = 0;
                    echo '<tr>
                      <td>'.$i++.'</td>
                      <td>'.get_emp_name($r, 'employee').'</td>';

                      foreach($v as $a){
                        $tj += $a['jobs'];
                        $tu += $a['units'];
                        echo '<td>'.$a['jobs'].'</td>';
                        echo '<td>'.$a['units'].'</td>';
                      }
                      echo '<td>'.$tj.'</td>';
                      echo '<td>'.$tu.'</td>';
                    echo '</tr>';   
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
 	window.location.href = '<?= base_url();?>analysereports/monthlyproductivitydata/'+$(this).val();
 });
</script>