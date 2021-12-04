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
        <h3 class="box-title">Employee Targets</h3>
        <a href="<?= base_url('targets');?>" class="btn btn-primary add pull-right"><i class="fa fa-plus"></i> &nbsp;&nbsp; Set Target </a>
        <a href="<?= base_url('targets/init_target');?>" class="btn btn-primary add pull-right"><i class="fa fa-upload"></i> &nbsp;&nbsp; Update Target </a>
      
        <div class="row">
          <form action="<?= base_url('targets/view');?>" method="post" class="fomr-group">
            <div class="form-group col-md-3">
              <label>Department</label>
              <select name="department" id="department" class="form-control months select2" required>
                <option value=""> --- </option>
                <?php
                    foreach (loadoption('labdepartment') as $opt){
                      $sel = ($opt->code == $department)?"selected":"";
                      echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                    }
                  ?>
              </select>
            </div>

            <div class="col-md-3">
              <label>Month</label>
              <select name="month" id="vmonth" class="form-control months select2" required>
                <option value=""> --- </option>
                <?php
                  for($i=1;$i<=12;$i++){
                    $sel = ($mon == $i)?"selected":'';
                    echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-01'));
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
              <select name="designation" id="vdesignation" class="form-control select2" required>
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
    <div class="panel">
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
                    <th>Department</th>
                    <th>Incentive Type</th>
                    <th>Target</th>
                    <th>Incentive</th>
                    <th>Date&Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i = 1;
                      foreach ($rows as $r) {
                        $date = '---';
                        if($r['date'])
                          $date = date('d-m-Y', strtotime($r['date']));

                        $m = $mon;
                        if($r['month'])
                          $m = $r['month'];

                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$r['name'].'</td>
                          <td>'.$r['code'].'</td>
                          <td>'.date('F', strtotime('2020-'.$m.'-01')).'</td>
                          <td>'.lab_depaerment_title($r['dep']).'</td>
                          <td>'.$r['is_type'].'</td>
                          <td>'.number_format($r['target']).'</td>
                          <td>'.number_format($r['incentive']).'</td>
                          <td>'.$date.'</td>
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