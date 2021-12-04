<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/excel/zonewiseclients');?>" method="post" autocomplete="off">
            <div class="form-group col-md-3">
              <label>Zone</label>
              <select name="station1c" id="station" class="form-control stations select2">
                <option value=""> --- </option>
                    <?php 
                      echo '<option value="all">All</option>';
                    foreach ($zones as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->zone.'</option>';
                    }
                    ?>
              </select>
            </div>
            <div class="col-md-3">
              <br>
              <input type="submit" class="btn btn-primary all_zone_data" style="margin-top: 5px;" id="excel_btnq" value="Download Excel" />
            </div>
          </form>
        </div>
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
                    <th>Zone</th>
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