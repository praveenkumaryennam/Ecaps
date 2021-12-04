<style type="text/css">
  .info-box-content{
    margin-left: 0px !important;
  }
  .info-box{
    min-height: 60px !important;
    border: 1px solid #c1c1c1;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/daywise_target_arhive');?>" method="post" class="fomr-group">
            <div class="col-md-3">
              <label>Month</label>
              <select name="month" id="month" class="form-control months select2" required>
                <option value=""> --- </option>
                <?php
                  for($i=1;$i<=12;$i++){
                    $sel = ($mon == $i)?"selected":'';
                    echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-01'));
                  }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <label>Year</label>
              <select name="year" id="year" class="form-control years select2" required>
                <option value=""> --- </option>
                <?php
                  for($i=0;$i<3;$i++){
                    $sel = ($year == (date('Y')-$i))?"selected":'';
                    echo '<option value="'.(date('Y')-$i).'" '.$sel.'>'.(date('Y')-$i).'</option>';
                  }
                ?>
              </select>
            </div>
                    
            <div class="col-md-3">
              <label>Designation</label>
              <select name="designation" id="designation" class="form-control select2" required>
                  <option value=""> --- </option>
                  <?php 
                  foreach ($designation as $opt){
                    $sel = ($desig == $opt->code)?"selected":'';
                    echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                  }
                ?>
              </select>
            </div>

            <div class="col-md-3">
              <br>
              <input type="submit" style="margin-top: 5px;" class="btn btn-primary" name="btn_get" value="Get">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Day Wise Target Archive Report</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable_btn">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Month</th>
                    <th>Lab Department</th>
                    <th>Target</th>
                    <th>Incentive Per Unit</th>
                    <td>Total</td>
                    <?php 
                      for ($i=1; $i <= $month_total_days; $i++) { 
                        echo '<th>'.$i.'</th>';
                      }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i=1;
                      foreach ($rows as $r) {
                        $td = get_target_data($r['id'], $mon, $year);
                        $total = 0;
                        $td_html = '';
                        foreach ($r['data'] as $key => $value) {
                          $total += $value;
                          $td_html .= ($value > 0)?'<td style="color:green"><b>'.$value.'</b></td>':'<td>'.$value.'</td>';
                        }

                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$r['name'].'</td>
                          <td>'.$r['code'].'</td>
                          <td>'.date('F', strtotime(date($year.'-'.sprintf("%02d", $mon).'-t'))).'</td>
                          <td>'.get_title($td->demp, 'labdepartment').'</td>
                          <td>'.number_format($td->target).'</td>
                          <td>'.number_format($td->incentive).'</td>
                          <td><b>'.number_format($total).'</b></td>'.$td_html;
                        echo '</tr>';
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
<script type="text/javascript">
  var excel_title = 'Day_Wise_Target_archive_<?= date('Ymd');?>';
</script>