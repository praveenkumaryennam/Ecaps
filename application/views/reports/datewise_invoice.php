<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('orders');?>" method="post" autocomplete="off">
          
<!--           <div class="col-md-3">
            <label>From Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>To Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>
 -->
          <div class="col-md-3">
            <label>By Clicent</label>
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

          <div class="col-md-12">
            <br />
            <input type="submit" class="btn btn-primary pull-right" value="GetOrders" />
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance Amount</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($rows as $r){
                      echo '<tr>
                        <td><input type="checkbox" value="'.$r->invoice_number.'" name="bulkorders[]" id="bulkorders"></td>
                        <td>'.$r->invoice_number.'</td>
                        <td>'.$r->invoice_date.'</td>
                        <td>'.$r->order_number.'</td>
                        <td>'.number_format($r->invoice_total, 2).'</td>
                        <td>'.number_format($r->paid_amount, 2).'</td>
                        <td>'.number_format(($r->invoice_total - $r->paid_amount), 2).'</td>
                      </tr>';
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