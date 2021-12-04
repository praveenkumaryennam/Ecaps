<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header" style="border-bottom: 1px solid #f4f4f4;">
        <div class="row">
          <form action="<?= base_url('analysereports/benchmarkreport');?>" method="post">
            <div class="col-md-3">
              <label>Zone</label>
              <select class="form-control select2" name="zone">
                <option value=""> --- </option>
                <?php
                  foreach (loadoption('zones') as $p){
                    if(!empty($arr['zone'])){
                      $sel = ($arr['zone'] == $p->id)?"selected":"";
                      echo '<option value="'.$p->id.'" '.$sel.'>'.$p->zone.'</option>';
                    }
                    else
                      echo '<option value="'.$p->id.'">'.$p->zone.'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <br>
              <input type="submit" class="btn btn-success pull-left" style="margin-top: 5px;" value="Submit" />
            </div>
          </form>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Staion</th>
                    <th>Zone</th>
                    <th>Last 6 Months Business</th>
                    <th>Average Benchmark</th>
                    <th>Last Month</th>
                    <th>Current Month</th>
                    <th>CMAA</th>
                    <th>LMSD</th>
                    <th>Growth %age Against Benchmark</th>
                    <th>Growth %age Last Month</th>
                    <th>Growth %age Last Month</th>
                    <!-- <th>Growth %age Currant Month</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i = 1;
                      foreach ($rows as $r) {

                        $colora = ($r['growth_avg_six_months'] >= 0)?"green":"red";
                        $colorb1 = ($r['growth_avg_last_months'] >= 0)?"green":"red";
                        $colorb = ($r['growth_avg_last_months2'] >= 0)?"green":"red";

                        if($r['growth_avg_last_months'] < 16){
                          $colorb1 = 'red';
                        }else{
                          $colorb1 = 'green';
                        }

                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$r['client_id'].'</td>
                          <td>'.$r['clientname'].'</td>
                          <td>'.get_station_title($r['station']).'</td>
                          <td>'.get_zone_title_by_station($r['station']).'</td>
                          <td>'.$r['six_months'].'</td>
                          <td>'.$r['avg_six_months'].'</td>
                          <td>'.$r['last_month'].'</td>
                          <td>'.$r['current_month'].'</td>
                          <td>'.$r['cmaa'].'</td>
                          <td>'.$r['lmsd'].'</td>
                          <td style="color:'.$colora.'"><b>'.$r['growth_avg_six_months'].'</b></td>
                          <td style="color:'.$colorb1.'"><b>'.$r['growth_avg_last_months'].'</b></td>
                          <td style="color:'.$colorb.'"><b>'.$r['growth_avg_last_months2'].'</b></td>
                        </tr>';
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