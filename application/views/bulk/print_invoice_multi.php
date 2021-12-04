<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('orders/printinvoices');?>" method="post" autocomplete="off">
          <div class="col-md-3">
            <label>From Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>To Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>
          <div class="col-md-3">
            <label>Doctor</label>
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
            <input type="submit" class="btn btn-primary pull-right" value="Get Invoices" />
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <form action="<?= base_url('orders/print');?>" method="post">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="checkAll"></th>
                      <th>Client</th>
                      <th>Invoice Number</th>
                      <th>Invoice Date</th>
                      <th>Invoice Amount</th>
                      <th>Units</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(!empty($rows)){
                        foreach ($rows as $r) {
                          echo '<tr>
                            <td><input type="checkbox" name="invoice[]" value="'.$r->invoice_number.'" /></td>
                            <td>'.$r->clientname.'</td>
                            <td>'.$r->invoice_number.'</td>
                            <td>'.$r->invoice_date.'</td>
                            <td>'.$r->units.'</td>
                            <td>'.$r->invoice_total.'</td>
                          </tr>';
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" class="btn btn-primary pull-right" style="width: 120px;" value='Print'/>
                </div>
              </div>
            </form>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>