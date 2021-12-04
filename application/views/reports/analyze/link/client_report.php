<?php
  if(!empty($rows)){
      $i =1;
      $row2 = '';

    $ftd_jobs = 0;
    $ftd_units = 0;
    $ftd_amount = 0;
    $mtd_jobs = 0;
    $mtd_units = 0;
    $mtd_amount = 0;
    $ytd_jobs = 0;
    $ytd_units = 0;
    $ytd_amount = 0;

      foreach ($rows as $r) {
        $ftd_jobs += $r['ftd']->jobs;
        $ftd_units += $r['ftd']->units;
        $ftd_amount += $r['ftd']->amount;

        $mtd_jobs += $r['mtd']->jobs;
        $mtd_units += $r['mtd']->units;
        $mtd_amount += $r['mtd']->amount;

        $ytd_jobs += $r['ytd']->jobs;
        $ytd_units += $r['ytd']->units;
        $ytd_amount += $r['ytd']->amount;

        $row2 .= '<tr>
          <td>'.$i++.'</td>
          <td>'.$r['name'].'</td>
          <td>'.$r['code'].'</td>
          <td><a href="'.base_url('analysereports/clients/'.$r['station']).'">'.get_station_title($r['station']).'</a></td>
          <td><a href="'.base_url('analysereports/clients/'.$r['station']).'">'.get_zone_title_by_station($r['station']).'</a></td>
          <td><a href="'.base_url('analysereports/stations/'.$arr['city']).'">'.get_city_title($r['city']).'</a></td>
          <td><a href="'.base_url('analysereports/city/'.$arr['state']).'">'.get_state_title($r['state']).'</a></td>
          <td>India</td>
          
          <td>'.number_format($r['ftd']->jobs).'</td>
          <td>'.number_format($r['ftd']->units).'</td>
          <td>'.number_format($r['ftd']->amount,2).'</td>

          <td>'.number_format($r['mtd']->jobs).'</td>
          <td>'.number_format($r['mtd']->units).'</td>
          <td>'.number_format($r['mtd']->amount,2).'</td>

          <td>'.number_format($r['ytd']->jobs).'</td>
          <td>'.number_format($r['ytd']->units).'</td>
          <td>'.number_format($r['ytd']->amount,2).'</td>

        </tr>';
      }
    }
?>


<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn" border="1">
                <thead>
                  <tr style="text-align: center;">
                    <th colspan="6"></th>
                    <th colspan="3">FTD</th>
                    <th colspan="3">MTD</th>
                    <th colspan="3">YTD</th>
                  </tr>

                  <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Doctor Code</th>
                    <th>Station</th>
                    <th>Zone</th>
                    <th>City</th>
                    <th>State</th>
                    <th>India</th>

                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Values</th>
                    
                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Values</th>

                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Values</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    echo $row2;
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