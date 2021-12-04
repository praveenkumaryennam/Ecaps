<div class="rowsw">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <div class="col-md-3 pull-left">
            <h3>Attendance</h3>
          </div>
          <div class="col-md-3 pull-right">
            <select class="form-control select2" id="crrmonth" name="month">
              <option value=""> --- </option>
              <?php for($i=1;$i<=12;$i++){
                $sel = ($mon == $i)?'selected="selected"':'';
                echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-01')).'</option>';
              }?>
            </select>
          </div>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>Sr.No</th>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Clock In [Device]</th>
                    <th>Clock Out [Device]</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      foreach ($rows as $k => $val) {
                        foreach ($val as $key) {
                          if(!empty($key["intime"]) && !empty($key["outtime"])){
                            echo "<tr>
                            <td>".$i++."</td>
                            <td>".$key["code"]."</td>
                            <td>".$key["name"]."</td>
                            <td>".$k."</td>
                            <td>".$key["intime"].' ['.$key["indevice_id"].'] '."</td>
                            <td>".$key["outtime"].' ['.$key["outdevice_id"].'] '."</td>
                            </tr>";
                          }
                        }
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

<script>
  $('#crrmonth').change(function(){
    window.location.href = '<?= base_url();?>attendance/'+$(this).val();
  });
</script>