<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
          <div class="row">
          <form action="<?= base_url('reports/payments');?>" method="post" autocomplete="off">
          <div class="col-md-3">
            <label>From Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>To Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>

          <div class="col-md-3">
            <label>Invoice / Order Number</label>
            <input type="text" class="form-control" name="order_number" placeholder="INxxxxxxxxxx" value="<?= $arr['order_number'];?>"/>
          </div>

          <div class="col-md-3">
            <label>By Doctor</label>
            <select class="form-control select2" name="client">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('clients') as $p){
                  if(!empty($arr['client'])){
                    $sel = ($arr['client'] == $p->id)?"selected":"";
                    echo '<option value="'.$p->id.'" '.$sel.'>'.$p->clientname.'</option>';
                  }
                  else
                    echo '<option value="'.$p->id.'">'.$p->clientname.'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-md-12">
            <br />
            <input type="submit" class="btn btn-primary pull-right" value="Submit" />
          </div>
        </div>
      </form>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_exl">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Client</th>
                    <th>Payment Date</th>
                    <th>OrderNumber</th>
                    <th>InvoiceNumber</th>
                    <th>InvoiceDate</th>
                    <th>Invoice Total</th>
                    <th>Amount</th>
                    <th>Remaining Balence Amount</th>
                    <th>Total Paid Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td> 
                        <td>'.ucfirst(get_clientname($row->client_code)).'</td>
                        <td>'.date('d/m/Y', strtotime($row->payment_date)).'</td>
                        <td>'.$row->order_id.'</td>
                        <td>'.$row->invoice_number.'</td>
                        <td>'.date('d/m/Y', strtotime(getinvoicedate($row->invoice_number))).'</td>
                        <td>'.$row->total_amount.'</td>
                        <td>'.number_format($row->paid_amount, 2).'</td>
                        <td>'.number_format($row->blc_amount, 2).'</td>
                        <td>'.number_format(($row->total_amount - $row->blc_amount), 2).'</td>
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