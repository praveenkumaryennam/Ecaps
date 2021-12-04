<style>
  .btn-group{
    margin-left: 90% !important;
    text-align: right !important;
  }  
  
  .buttons-excel{
    width: 100px;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <div class="col-md-3 pull-left">
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
              <table class="table table-bordered datatable_exl_repo">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Technicians</th>
                    <th>All Employees </th>
                    <th>Jobs Work For the Day  </th>
                    <th>Avg Of Job Work (Technician) </th>
                    <th>Avg Of Job WorkCompany </th>
                    <th>Units For Day </th>
                    <th>Avg Of Units (Technician)</th>
                    <th>Avg Of Units (Company)</th>
                  </tr>
                </thead>
                <tbody>

                  <?php 
                    if(!empty($rows)){
                      $technicians = 0;
                      $employees = 0;
                      $today_jobs = 0;
                      $tech_avg = 0;
                      $company_avg = 0;
                      $today_units = 0;
                      $tech_unit_avg = 0;
                      $company_unit_avg = 0;
                      $html = '';
                      $sizeof = count($rows);
                      
                      foreach($rows as $key => $d){
                        $a = $b = $c = $z = 0;

                        $technicians += $d['tech_emp'];
                        $employees += $d['all_emp'];
                        $today_jobs += $d['today_jobs'];
                        $today_units += $d['today_units'];

                        if($d['tech_emp'] > 0){
                          $a = ((float)$d['today_jobs']/$d['tech_emp']);
                          $c = ((float)$d['today_units']/$d['tech_emp']);
                        }else{
                          $a = 0;
                          $c = 0;
                        }

                        if($d['all_emp'] > 0){
                          $b = ((float)$d['today_jobs']/$d['all_emp']);
                          $z = ((float)$d['today_units']/$d['all_emp']);
                        }else{
                          $b = 0;
                          $z = 0;
                        }

                        $tech_avg += $a;
                        $company_avg += $b;
                        $tech_unit_avg += $c;
                        $company_unit_avg += $z;


                        $html .= '<tr>
                          <td>'.$key.'</td>
                          <td>'.$d['tech_emp'].'</td>
                          <td>'.$d['all_emp'].'</td>
                          <td>'.$d['today_jobs'].'</td>
                          <td>'.number_format($a, 3).'</td>
                          <td>'.number_format($b, 3).'</td>
                          <td>'.$d['today_units'].'</td>
                          <td>'.number_format($c, 3).'</td>
                          <td>'.number_format($z, 3).'</td>
                        </tr>';

                      }
                    }
                  ?>
                  <?php 
                      echo $html;
                      echo '<tr>
                        <td></td>
                        <td><b>'.number_format($technicians/$sizeof, 2).'</b></td>
                        <td><b>'.number_format($employees/$sizeof, 2).'</b></td>
                        <td><b>'.number_format($today_jobs/$sizeof, 2).'</b></td>
                        <td><b>'.number_format($tech_avg/$sizeof, 2).'</b></td>
                        <td><b>'.number_format($company_avg/$sizeof, 2).'</b></td>
                        <td><b>'.number_format($today_units, 2).'</b></td>
                        <td><b>'.number_format($tech_unit_avg/$sizeof, 2).'</b></td>
                        <td><b>'.number_format($company_unit_avg/$sizeof, 2).'</b></td>
                      </tr>';
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
      window.location.href = '<?= base_url();?>reports/dailyproductivitydata/'+$(this).val();
    });
</script>