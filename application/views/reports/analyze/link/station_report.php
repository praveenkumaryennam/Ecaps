<?php
	if(!empty($rows)){
    $i =1;
    $row2 = '';

    foreach ($rows as $r) {
      $row2 .= '<tr>
        <td>'.$i++.'</td>
        <td><a href="'.base_url('analysereports/clients/'.$r['station_id']).'" >'.$r['station'].'</a></td>
        <td><a href="'.base_url('analysereports/stations/'.$arr['city']).'" >'.$r['city'].'</a></td>
        <td><a href="'.base_url('analysereports/city/'.$arr['state']).'" >'.$r['state'].'</a></td>
        <td>'.$r['docs'].'</td>
        <td>'.$r['tdocs'].'</td>
        <td>'.number_format($r['ftd_jobs']).'</td>
        <td>'.number_format($r['ftd_units']).'</td>
        <td>'.number_format($r['ftd_amount'],2).'</td>
        <td>'.number_format($r['mtd_jobs']).'</td>
        <td>'.number_format($r['mtd_units']).'</td>
        <td>'.number_format($r['mtd_amount'],2).'</td>
        <td>'.number_format($r['ytd_jobs']).'</td>
        <td>'.number_format($r['ytd_units']).'</td>
        <td>'.number_format($r['ytd_amount'],2).'</td>
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
                    <th>Station</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Active Doctors</th>
                    <th>Total Doctors</th>
                    
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