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
        <h3 class="box-title">Set Employee Target</h3>
      
        <div class="row" style="border:1px solid #f4f4f4; margin: 2px;">
          <div class="form-group col-md-3">
            <label>Department</label>
            <select name="department" id="department" class="form-control months select2" required>
              <option value=""> --- </option>
              <?php
                  foreach (loadoption('labdepartment') as $opt){
                    echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
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
                  echo '<option value="'.$i.'">'.date('F', strtotime('2020-'.$i.'-01'));
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
                  
          <div class="form-group col-md-3">
            <label>Designation</label>
            <select name="designation" id="designation" class="form-control select2" required>
                <option value=""> --- </option>
                <?php 
                foreach ($designation as $opt){
                  echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
              }
              ?>
            </select>
          </div>

          <div class="col-md-3">
              <br>
              <input type="button" style="margin-top: 5px;" class="btn btn-primary" name="btn_get" id="btn_set_add" value="Get">
            </div>
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
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Month</th>
                    <th>Type</th>
                    <th>Target</th>
                    <th>Incentive</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="data"></tbody>
              </table>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>