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
    <div class="box">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/target_arhive');?>" method="post" class="fomr-group">
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
        <h3 class="box-title">Target Archive Report</h3>
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
                    <th>Archive Cases</th>
                    <th>Target Case</th>

                    <th>Archive Units</th>
                    <th>Target Unit</th>
                    
                    <th>Total Units Incentive</th>
                    <th>Total Cases Incentive</th>
                    <th>Incentive Per Case</th>
                    <th>Incentive Per Unit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i = 1;
                      foreach ($rows as $r) {

                        $m = $mon;
                        if($r['month'])
                          $m = $r['month'];

                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$r['name'].'</td>
                          <td>'.$r['code'].'</td>
                          <td>'.date('F', strtotime('2020-'.$m.'-01')).'</td>
                          <td>'.number_format($r['cases']) .'</td>
                          <td>'.number_format($r['ctarget']) .'</td>
                          <td>'.number_format($r['units']) .'</td>
                          <td>'.number_format($r['utarget']) .'</td>
                          <td><b>'.number_format(($r['cases'] * $r['cincentive'])).'</b></td>
                          <td><b>'.number_format(($r['units'] * $r['uincentive'])).'</b></td>
                          <td>'.number_format($r['cincentive']).'</td>
                          <td>'.number_format($r['uincentive']).'</td>
                        </tr>';
                      }
                    }
                  ?>
                          <!-- <td>'.number_format($r['units']).'</td> -->
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
  var excel_title = 'Target_archive_<?= date('Ymd');?>';
</script>