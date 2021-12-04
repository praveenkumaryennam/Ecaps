<?php
      $row2 = '';
	if(!empty($rows)){
      $i =1;

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

  //     	$ftd_jobs += $r['ftd']->jobs;
		// $ftd_units += $r['ftd']->units;
		// $ftd_amount += $r['ftd']->amount;

  //     	$mtd_jobs += $r['mtd']->jobs;
		// $mtd_units += $r['mtd']->units;
		// $mtd_amount += $r['mtd']->amount;

  //     	$ytd_jobs += $r['ytd']->jobs;
		// $ytd_units += $r['ytd']->units;
		// $ytd_amount += $r['ytd']->amount;


          // <td>'.number_format($r['ftd']->jobs).'</td>
          // <td>'.number_format($r['mtd']->jobs).'</td>
          // <td>'.number_format($r['ytd']->jobs).'</td>

        $row2 .= '<tr>
          <td>'.$i++.'</td>
          <td>'.$r['product'].'</td>
          <td>'.$r['code'].'</td>
          
          <td>'.number_format($r['ftd']->units).'</td>
          <td>'.number_format($r['ftd']->amount,2).'</td>

          <td>'.number_format($r['mtd']->units).'</td>
          <td>'.number_format($r['mtd']->amount,2).'</td>

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
          <form action="<?= base_url('analysereports/productanalyzereport');?>" method="post" autocomplete="off">
          
          <div class="form-group col-md-3">
              <label>Date</label>
              <input name="date" id="date" class="form-control datepicker" value="<?= date('d-m-Y');?>" />
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
                <option value="new">New</option>
                <option value="redo">Redo</option>
                <option value="correction">Correction</option>
              </select>
          </div>

          <div class="form-group col-md-3">
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

          <div class="form-group col-md-3">
              <label>Country</label>
              <select name="country" id="country" class="form-control select2">
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
              <select name="state" id="state" class="form-control states select2"></select>
          </div>
          <div class="form-group col-md-3">
              <label>City</label>
              <select name="city" id="city" class="form-control cities select2"></select>
          </div>
          <div class="form-group col-md-3">
            <label>Station</label>
            <select name="station" id="station1" class="form-control stations select2">
              <option value=""> --- </option>
            </select>
          </div>

          <div class="col-md-12">
            <input type="submit" class="btn btn-primary pull-right" value="Get Report" />
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">

          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn" border="1">
                <thead>
                  <tr>
                    <th colspan="3"></th>
                    <th colspan="2">FTD</th>
                    <th colspan="2">MTD</th>
                    <th colspan="2">YTD</th>
                  </tr>

                  <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Product Code</th>
                    
                    <!-- <th>Jobs</th> -->
                    <th>Units</th>
                    <th>Value</th>
                    
                    <!-- <th>Jobs</th> -->
                    <th>Units</th>
                    <th>Value</th>

                    <!-- <th>Jobs</th> -->
                    <th>Units</th>
                    <th>Value</th>
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
