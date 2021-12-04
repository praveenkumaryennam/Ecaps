<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Orders</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <label>Start Date</label>
            <input type="text" class="form-control datepicker" id="fromdate" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>End Date</label>
            <input type="text" class="form-control datepicker" id="todate" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>

          <div class="col-md-3">
            <label>By Doctor</label>
            <select class="form-control select2" id="client" name="client">
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
        </div>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="shipmentdata">
                <thead>
                  <tr>
                    <th width="10">Sr.no</th>
                    <th width="150">Order No #</th>
                    <th width="350">Order Date</th>
                    <th width="350">Due Date</th>
                    <th>Client</th>
                    <th>Patient</th>
                    <th>Products</th>
                    <th>CaseNo</th>
                    <th>Status</th>
                    <th width="250">DueDate</th>
                    <th width="250">Time</th>
                    <th>Order Value</th>
                    <th width="250"></th>
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
