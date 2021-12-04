<style type="text/css">
  .info-box-content{
    margin-left: 0px !important;
  }
  .info-box{
    min-height: 60px !important;
    border: 1px solid #c1c1c1;
  }
     
  #DataTables_Table_0_filter{
    margin-right: 140px;
    float: right;
    margin-top: -30px;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/monthly_target_arhive');?>" method="post" class="fomr-group">
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
        <h3 class="box-title">Monthly Target Archive Report</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <form action="<?= base_url('reports/monthly_target_arhive_export');?>" method="post" class="fomr-group">
                <!-- <input type="hidden" name="month_e" value="<?= $mon;?>"> -->
                <input type="hidden" name="designation_e" value="<?= $desig;?>">
                <input type="submit" style="float: right; margin-left: 15px;padding: 4px 30px;" class="btn btn-primary" name="btn_get" value="Excel">
              </form>
              
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr>
                    <th colspan="3"></th>
                    <?php 
                      for ($i=1; $i <= 12; $i++) { 
                        echo '<th style="text-align: center">'.$month_arr[$i-1].'</th>';
                        // echo '<th colspan=3 style="text-align: center">'.$month_arr[$i-1].'</th>';
                      }
                    ?>
                    <th style="text-align: center">Total</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <?php 
                      for ($i=1; $i <= 13; $i++) { 
                        echo '<th>Archive</th>';
                        // echo '<th>Target</th><th>Incentive Per Unit</th><th>Archive</th>';
                      }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $j = 1;

                      foreach ($rows as $r) {
                        $total = 0;
                        echo '<tr>
                          <td>'.$j++.'</td>
                          <td>'.$r['name'].'</td>
                          <td>'.$r['code'].'</td>';
                          
                          for ($k=1; $k <= 12; $k++) {
                            echo '<td>'.$r['data'][$k].'</td>';
                            $total += $r['data'][$k];
                          }
                          echo '<td>'.$total.'</td>';
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