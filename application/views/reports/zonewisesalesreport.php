<?php 

              // <td>'.challan_get_jobs_count($r->id, $month, $year).'</td>
              // <td>'.challan_get_jobs_units($r->id, $month, $year).'</td>

    $total_sales = 0;
    $nosales = 0;
    $table_data = '';
    if(!empty($rows)){
        $i=1;
        if($type == 'challan'){
          foreach($rows as $r){
            $cd = challan_data($r->id, $month, $year);
            $r->cd = (object) $cd;
            // $amount = challan_get_total_sales_by_month($r->id, $month, $year);
            $amount = $cd['amt'];
            $total_sales += $amount;
            if($amount <= 0)
              $nosales += 1; 
            $table_data .= '<tr>
              <td>'.$i++.'</td>
              <td>'.$r->clientname.'</td>
              <td>'.$r->code.'</td>
              <td>'.$cd['total'].'</td>
              <td>'.$cd['units'].'</td>
              <td>'.number_format($amount, 2).'</td>
            </tr>';
          }
        }else{
          foreach($rows as $r){
            $amount = get_total_sales_by_month($r->id, $month, $year);
            $total_sales += $amount;
            if($amount <= 0)
              $nosales += 1; 
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
          <form action="<?= base_url('reports/zonewisesalesreport');?>" method="post">
            <div class="form-group col-md-3">
                <label>Zone</label>
                <select name="station" id="station" class="form-control stations select2">
                  <option value=""> --- </option>
                      <?php
                      foreach ($zones as $opt){
                        $sel = (isset($zone) && $zone == $opt->id)?'selected':'';
                        echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->zone.'</option>';
                      }
                      ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label>Month</label>
                <select name="month" id="month" class="form-control months select2" required>
                  <option value=""> --- </option>
                  <?php
                    for($i=1;$i<=12;$i++){
                      $sel = (isset($month) && $month == $i)?'selected':'';
                      echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-01')).'</option>';
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
              <div class="form-group col-md-3">
                <label>Type</label>
                <select name="type" id="type" class="form-control" required>
                  <?php
                    $sel = ($type == 'challan')?'selected':'';
                    echo '<option value="invoice">Invoice</option>';
                    echo '<option value="challan" '.$sel.'>Challan</option>';
                  ?>
                </select>
              </div>
            <div class="col-md-3" style="margin-top: 25px;">
              <button type="submit" class="btn btn-info btn-flat">Go!</button>
            </div>
          </form>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
          
          <div class="row">
          <div class="col-md-12" style="text-align: center;">
            <div class="row">
              <div class="col-md-2 col-sm-6 col-xs-12"></div>
                
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
                    <span class="info-box-text">In-Active Clients</span>
                    <span class="info-box-number"><?= number_format($nosales);?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <div class="info-box-content">
                    <span class="info-box-text">Active Clients</span>
                    <span class="info-box-number"><?= number_format(((!empty($rows))?count($rows):0) - $nosales);?></span>
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
                    <th>Zone</th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Client Mobile</th>
                    <th>Total Jobs</th>
                    <th>Total Units</th>
                    <th>Total Sales</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                        $i=1;
                        if($type == "challan"){
                          foreach($rows as $r){
                            $total = ($r->cd->total > 0)?$r->cd->total:'0';
                            $units = ($r->cd->units > 0)?$r->cd->units:'0';

                            echo '<tr>
                              <td>'.$i++.'</td>
                              <td>'.get_zone_title_by_station($r->station).'</td>
                              <td>'.$r->clientname.'</td>
                              <td>'.$r->code.'</td>
                              <td>'.$r->mobile.'</td>
                              <td>'.$total.'</td>
                              <td>'.$units.'</td>
                              <td>'.number_format(challan_get_total_sales_by_month($r->id, $month, $year), 2).'</td>
                            </tr>';
                          }
                        }else{
                          foreach($rows as $r){
                              echo '<tr>
                                <td>'.$i++.'</td>
	                              <td>'.get_zone_title_by_station($r->station).'</td>
                                <td>'.$r->clientname.'</td>
                                <td>'.$r->code.'</td>
                                <td>'.$r->mobile.'</td>
                                <td>'.get_jobs_count($r->id, $month, $year).'</td>
                                <td>'.get_jobs_units($r->id, $month, $year).'</td>
                                <td>'.number_format(get_total_sales_by_month($r->id, $month, $year), 2).'</td>
                              </tr>';
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