<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">No Order Clients</h3>
      </div>

      <div class="row">
          <form action="<?= base_url('reports/clientslastorders');?>" method="post" autocomplete="off">
           <!-- <div class="form-group col-md-3">
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
          </div> -->

          <div class="col-md-3">
            <label>From Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>To Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>

          <div class="col-md-2">
            <input type="submit" style="margin-top: 25px" class="btn btn-primary pull-left" value="Submit" />
          </div>
        <!-- </div> -->
      </form>
    </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Client Name</th>
                    <th>Code</th>
                    <th>Last Orderdate</th>
                    <th>Mobile</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Station</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->clientname.'</td>
                        <td>'.ucfirst($row->code).'</td>
                        <td><b>'.date('d-m-Y H:i', strtotime(get_last_order($row->id))).'<b></td>
                        <td>'.$row->mobile.'</td>
                        <td>'.$row->state.'</td>
                        <td>'.$row->city.'</td>
                        <td>'.$row->station.'</td>
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