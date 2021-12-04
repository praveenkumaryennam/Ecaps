<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Credit Notes</h3>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button>
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
                    <th>Client #</th>
                    <th>Credit Note #</th>
                    <th>Credit Note Date</th>
                    <th>Invoice #</th>
                    <th>Invoice Date</th>
                    <th style="width:20px;"></th>
                  </tr> 
                </thead>
                <tbody>
                  <?php
                    $z = 1;
                    foreach ($rows as $row) {
                      echo '<tr>
                        <td>'.$z++.'</td>
                        <td>'.strtoupper(getclientname($row->client_id)).'</td>
                        <td>'.$row->cradit_no.'</td>
                        <td>'.$row->cradit_date.'</td>
                        <td>'.$row->invoice_number.'</td>
                        <td>'.$row->invoice_date.'</td>
                        <td>
                          <a href="'.base_url('payment/printinvoice/'.$row->invoice_number).'" target="_blank" class="fa fa-print btn btn-success"></a>
                          <a href="'.base_url('payment/printcreaditnot/'.$row->invoice_number).'" target="_blank" class="fa fa-inr btn btn-info"></a>
                        </td>
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



<!-- Cradit Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="exampleModalLabel">Isuue Credit Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('payment/makecreditnote');?>" method="post">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">Invoice Number</label>
                <input type="text" class="form-control" id="invoice" name="invoice" required />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group" id="rxview"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  $('form').submit(function(e){
    var invoice = $.trim($('#invoice').val());

    if(invoice === ''){
      alert('Text-field is empty.');
      return false;
    }
    
    if(invoice !== ''){
      var a = check_invoice(invoice);
      console.log(a);
      if(a)
        return false;
    }
  });

  function check_invoice(invoice){
    $.post(base_url+'/payment/makecreditnote', {invoice: invoice}, function(res){
      if(res == 1){
        alert('Cradit Note Already Created.!.');
        return 'false';
      }else{
        return 'true';
      }
    });
  }
</script>