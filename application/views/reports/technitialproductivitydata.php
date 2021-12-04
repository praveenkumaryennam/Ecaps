<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">    
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class=" table-responsive">
              <table class="table table-bordered">
              	<thead>
              		<tr>
                    <th colspan="3"></th>
                    <?php 
                      for($i=1; $i<=12;$i++){
                        echo '<th colspan="4" style="text-align:center;">'.date("F", mktime(0, 0, 0, $i, 10)).'</th>';
                      }
                    ?>
                    <th colspan="4">Total</th>
              		</tr>
              		<tr>
              			<th>Sr.no</th>
                    <th>Employee</th>
                    <th>Department</th>
                    <!-- jan -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- feb -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- mar -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- apr -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- may -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- jun -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- jul -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- aug -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- sep -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- oct -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- nov -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- dec -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
                    <!-- Total -->
                    <th>Job</th>
                    <th>Unit</th>
                    <th>Avg Job</th>
                    <th>Avg unit</th>
              		</tr>
              	</thead>
              	<tbody>
              	</tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>