<?php 
    $total_sales = 0;
    $table_data = '';
    if(!empty($rows)){
        $i=1;
        foreach($rows as $r){
            $amount = get_total_sales_by_month($r->id, $month, $year);
            $total_sales += $amount;
            $table_data .= '<tr>
              <td>'.$i++.'</td>
              <td>'.$r->clientname.'</td>
              <td>'.$r->code.'</td>
              <td>'.get_jobs_count($r->id, $month, $year).'</td>
              <td>'.get_jobs_units($r->id, $month, $year).'</td>
              <td>'.number_format($amount, 2).'</td>
            </tr>';
        }   
    }
?>

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
          <form action="<?= base_url('reports/citywisesalesreport');?>" method="post">
            <div class="form-group col-md-3">
                  <label>Country</label>
                  <select name="country" id="country" class="form-control select2" required>
                      <option value=""> --- </option>
                      <?php 
                      foreach (loadoption('country') as $opt){
                        echo '<option value=\''.$opt->id.'\'>'.$opt->country.'</option>';
                    }
                    ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                  <label>State</label>
                  <select name="state" id="state" class="form-control states select2" required></select>
              </div>
              <div class="form-group col-md-3">
                  <label>City</label>
                  <select name="city" id="city" class="form-control cities select2" required></select>
              </div>
              <div class="form-group col-md-3">
                <label>Month</label>
                <select name="month" id="month" class="form-control months select2" required>
                  <option value=""> --- </option>
                  <?php
                    for($i=1;$i<=12;$i++){
                      echo '<option value="'.$i.'">'.date('F', strtotime('2020-'.$i.'-01'));
                    }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label>Year</label>
                <select name="year" id="year" class="form-control years select2" required>
                  <?php
                    $pyear = (int) date('Y');
                    for($i=0;$i<2;$i++){
                      $sel = (isset($year) && $year == ($pyear-$i))?'selected':'';
                      echo '<option value="'.($pyear-$i).'" '.$sel.'>'.($pyear-$i).'</option>';
                    }
                  ?>
                </select>
              </div>
            <div class="col-md-12">
              <button type="submit" style="float:right" class="btn btn-info btn-flat">Go!</button>
            </div>

          </form>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        
        <div class="row">
          <div class="col-md-12" style="text-align: center;">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12"></div>
                
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <div class="info-box-content">
                    <span class="info-box-text">Total Clients</span>
                    <span class="info-box-number"><?= number_format((!empty($rows))?count($rows):0);?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <div class="info-box-content">
                    <span class="info-box-text">Total Sales</span>
                    <span class="info-box-number"><?= number_format($total_sales, 2);?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Total Jobs</th>
                    <th>Total Units</th>
                    <th>Total Sales</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      echo $table_data;
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