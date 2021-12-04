<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/excel/citywiseclients');?>" method="post" autocomplete="off">
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
            <select name="station1" id="station1" class="form-control stations select2">
              <option value=""> --- </option>
            </select>
          </div>

          <div class="col-md-12">
            <input type="submit" class="btn btn-primary pull-right add" id="excel_btnq" value="Download Excel" />
          </div>
        </div>
      </form>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered loaddata">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Contact No</th>
                    <th>Address</th>
                    <th>Station</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>