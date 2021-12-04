<?php
	if(!empty($rows)){
      $i =1;
      $row2 = '';

		// $ftd_jobs = 0;
		// $ftd_units = 0;
		// $ftd_amount = 0;
		$mtd_jobs = 0;
		$mtd_units = 0;
		$mtd_amount = 0;
		$ytd_jobs = 0;
		$ytd_units = 0;
		$ytd_amount = 0;


      foreach ($rows as $r) {

  //     	$ftd_jobs += $r['ftd']->jobs;
		// $ftd_units += $r['ftd']->units;
		// $ftd_amount += $r['ftd']->amount;

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
          <td>'.get_zone_title_by_station($r['station']).'</td>
          <td>'.get_station_title($r['station']).'</td>

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

<style type="text/css">
  .widget-user .widget-user-header{
    height: auto !important;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('analysereports/monthly_analyse_report');?>" method="post" autocomplete="off">
          
          <div class="form-group col-md-3">
              <label>Type</label>
              <select class="form-control selecct2 pull-right" id="rtype" name="rtype">
              <option value=""> --- </option>
              <option value="1" <?= ($arr['rtype'] == 1)?"selected":"";?>> Orders </option>
              <option value="2" <?= ($arr['rtype'] == 2)?"selected":"";?>> Sales </option>
              <option value="3" <?= ($arr['rtype'] == 3)?"selected":"";?>> Challans </option>
            </select>
          </div>
          <div class="form-group col-md-3">
              <label>Month</label>
              <select class="form-control selecct2 pull-right" id="date" name="date">
              <option value=""> --- </option>
              <?php 
                for($m=1; $m<=12; $m++){
                  $selm = ($arr['date'] == $m)?"selected":"";
                  echo '<option value="'.$m.'" '.$selm.'>'.date('F', strtotime(date('Y-'.$m.'-01'))).'</option>';
                }
              ?>
            </select>
          </div>

          <div class="form-group col-md-3">
              <label>Client</label>
              <select class="form-control select2" name="client">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('clients') as $p){
                  if(!empty($arr['client'])){
                    $sel = ($arr['client'] == $p->code)?"selected":"";
                    echo '<option value="'.$p->code.'" '.$sel.'>'.$p->clientname.'</option>';
                  }
                  else
                    echo '<option value="'.$p->code.'">'.$p->clientname.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="form-group col-md-3">
              <label>WorkType</label>
              <select name="worktype" id="worktype" class="form-control worktype">
                <option value="new" <?= ($arr['worktype'] == 'new')?"selected":"";?>>New</option>
                <option value="redo" <?= ($arr['worktype'] == 'redo')?"selected":"";?>>Redo</option>
                <option value="correction" <?= ($arr['worktype'] == 'correction')?"selected":"";?>>Correction</option>
              </select>
          </div>

          <div class="form-group col-md-3">
              <label>Country</label>
              <select name="country" id="country" class="form-control select2">
                  <option value=""> --- </option>
                  <?php 
                  foreach (loadoption('country') as $opt){
                    $sel = ($arr['country'] == $opt->id)?"selected":"";
                    echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->country.'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="form-group col-md-3">
              <label>State</label>
                <input type="hidden" id="state_val" value="<?= $arr['state'];?>"/>
              <select name="state" id="state" class="form-control states select2"></select>
          </div>
          <div class="form-group col-md-3">
              <label>City</label>
                <input type="hidden" id="city_val" value="<?= $arr['city'];?>"/>
              <select name="city" id="city" class="form-control cities select2"></select>
          </div>
          <div class="form-group col-md-3">
            <label>Station</label>
              <input type="hidden" id="station1_val" value="<?= $arr['station'];?>"/>
            <select name="station" id="station1" class="form-control stations select2">
              <option value=""> --- </option>
            </select>
          </div>


          <div class="form-group col-md-3">
            <label>Zone</label>
            <select class="form-control select2" id="zone" name="zone">
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

          <div class="form-group col-md-3">
            <label>Zone Wise Stations</label>
            <input type="hidden" id="zone_stations_val" value="<?= $arr['zone_stations']?>">
            <select class="form-control select2" id="zone_stations" name="zone_stations">
              <option value=""> --- </option>
            </select>
          </div>

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right sbtn"><i class="fa fa-spinner fa-spin" style="display: none; margin-right: 5px;"></i> Get Report </button>
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-sm-2"></div>
                <div class="col-md-4">
                  <div class="box box-widget widget-user" style="border: 2px solid #f4f4f4;padding: 5px;">
                    <div class="widget-user-header bg-purple">
                      <h3 class="widget-user-username">MTD</h3>
                    </div>
                    <div class="box-footer">
                      <div class="row">
                        <div class="col-sm-4 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?= number_format($mtd_jobs);?></h5>
                            <span class="description-text">JOBS</span>
                          </div>
                        </div>
                        <div class="col-sm-4 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?= number_format($mtd_units);?></h5>
                            <span class="description-text">UNITS</span>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="description-block">
                            <h5 class="description-header"><?= number_format($mtd_amount, 2);?></h5>
                            <span class="description-text">AMOUNT</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="box box-widget widget-user" style="border: 2px solid #f4f4f4;padding: 5px;">
                    <div class="widget-user-header bg-orange">
                      <h3 class="widget-user-username">YTD</h3>
                    </div>
                    <div class="box-footer">
                      <div class="row">
                        <div class="col-sm-4 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?= number_format($ytd_jobs);?></h5>
                            <span class="description-text">JOBS</span>
                          </div>
                        </div>
                        <div class="col-sm-4 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?= number_format($ytd_units);?></h5>
                            <span class="description-text">UNITS</span>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="description-block">
                            <h5 class="description-header"><?= number_format($ytd_amount, 2);?></h5>
                            <span class="description-text">AMOUNT</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="col-sm-2"></div>
            </div>

          </div>

          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn" border="1">
                <thead>
                  <tr>
                    <th colspan="5"></th>
                    <th colspan="3">MTD</th>
                    <th colspan="3">YTD</th>
                  </tr>

                  <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Doctor Code</th>
                    <th>Zone</th>
                    <th>Station</th>
                    
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

<script type="text/javascript">
  $('.sbtn').click(function(){
    $('.fa-spinner').show();
    $(this).attr('style', 'cursor:not-allowed;pointer-events:none');
  });
  $(function(){
    load_zone_stations($("#zone").val());
    load_states($('#country').val());
  });
</script>