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
          <form action="<?= base_url('reports/target_analyse');?>" method="post" class="fomr-group">
            <div class="col-md-3">
              <label>Month</label>
              <select name="month" id="month" class="form-control months select2" required>
                <option value=""> --- </option>
                <?php
                  for($i=1;$i<=12;$i++){
                    $sel = ($mon == $i)?"selected":'';
                    echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-01')).'</option>';
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
              <!-- <input type="submit" style="margin-top: 5px;" class="btn btn-primary" name="btn_get_dn" value="Excel"> -->
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
    								<th>Lab Department</th>
    								<th>Type</th>
    								<th>Archived Cases</th>
    								<th>New Archived Units</th>
                    <th>Redo Archived Units</th>
                    <th>Correction Archived Units</th>
    								<th>Target</th>
    								<th>Incentive</th>
    								<th style="background-color: #99EE99;">Incentive Total</th>
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

                        $total_incentive = 0;
                        foreach ($r['data'] as $a => $f){
                          $ex_w = ($f['new']['units'] - $f['target']->target);
                          
                          if($f['target'] == 'case'){  
                            $total = ($ex_w > 0)?($f['target']->incentive * $ex_w):0;
                          }else{
                            $total = ($ex_w > 0)?($f['target']->incentive * $ex_w):0;
                          }
                          
                          echo '<tr>
                            <td>'.$i++.'</td>
                            <td>'.$r['name'].'</td>
                            <td>'.$r['code'].'</td>
                            <td>'.date('F', strtotime('2020-'.$m.'-01')).'</td>
                            <td>'.lab_depaerment_title($a).'</td>
                            <td>'.strtoupper($f['target']->is_type).'</td>
                            <td>'.$f['case_id'].'</td>
                            <td>'.$f['new']['units'].'</td>
                            <td>'.$f['redo']['units'].'</td>
                            <td>'.$f['correction']['units'].'</td>
                            <td>'.$f['target']->target.'</td>
                            <td>'.$f['target']->incentive.'</td>
                            <td>'.$total.'</td>';
                          echo '</tr>';
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

<script type="text/javascript">
  var excel_title = 'Target_archive_<?= date('Ymd');?>';
</script>