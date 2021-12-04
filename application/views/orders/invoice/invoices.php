<style type="text/css">
	.e {
		padding: 3px 10px;
	}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Invoices</h3>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered" id="loadinvoices">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>InvoiceNumber</th>
                    <th>InvoiceDate</th>
                    <th>Patiant</th>
                    <th>OrderNumber</th>
                    <th>Invoice Total</th>
                    <th></th>
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="exampleModalLabel">Import Invoices</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('orders/import');?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">DataFile</label>
                <input type="file" name="importfile" class="form-control" required>

                <small> Download Export Format File <a href="<?= base_url('assets/files/Import_Invoices.xlsx');?>"> <i class="fa fa-download"></i> click here</a></small>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
        </form>
    </div>
  </div>
</div>