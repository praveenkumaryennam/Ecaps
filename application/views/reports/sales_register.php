<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/sales');?>" method="post" autocomplete="off">
          <div class="col-md-3">
            <label>From Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>To Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
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
                    <th>Date</th>
                    <th>Particulars</th>
                    <th>Address</th>
                    <th>Voucher No.</th>
                    <th>GSTIN/UIN</th>
                    <th>Gross Total</th>
                    <th>Local Sales (GST)</th>
                    <th>Central Tax (CGST)</th>
                    <th>State Tax (SGST)</th>
                    <th>ROUND OFF</th>
                    <th>Intergrated Tax (IGST)</th>
                    <th>OMS Sales (GST)</th>
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