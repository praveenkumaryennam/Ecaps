<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Orders</h3>
        <button type="button" class="btn btn-danger add" data-toggle="modal" data-target="#redoModal" style="margin-left: 5px;">Redo</button>
        <button type="button" class="btn btn-warning add" data-toggle="modal" data-target="#redoModal1" style="margin-left: 5px;">Correction</button>
        <a href="<?= base_url('orders/clients');?>" class="btn btn-success add"> New</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered" id="loaddata">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Order No</th>
                    <th width="80">Order Date</th>
                    <th>Client</th>
                    <th width="150">Patient Name</th>
                    <th>Case No</th>
                    <th>Work Type</th>
                    <th>RX Files</th>
                    <th width="50"></th>
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
        <h5 class="modal-title pull-left" id="exampleModalLabel">Upload RX</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('orders/rxupload');?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">Upload File</label>
                <input type="file" name="rxfile[]" multiple="multiple" class="form-control" required>
                <input type="hidden" name="order_id" id="rxorderid" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group" id="rxview"></div>
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

<!-- Modal -->
<div class="modal fade" id="redoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Get Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('orders/redo');?>" method="post">
        <div class="modal-body">
            <label>Enter Case Number</label>
            <input type="text" name="case_no" class="form-control" id="validate_case_no" required="required">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary redo_btn">Process</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="redoModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Get Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('orders/correction');?>" method="post">
        <div class="modal-body">
            <label>Enter Case Number</label>
            <input type="text" name="case_no" class="form-control" id="validate_case_no" required="required">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary redo_btn">Process</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  function rxupload(id){
    $.post(base_url+'orders/rxfiles/'+id, function(res){
      res = JSON.parse(res);
      if(res.sts == 1){
        html = '<table><tr>';
        $.each(res.data, function(i, v){
          html += '<td><a href="'+v.filepath+'" target="_blank" style="padding:2px; border:1px solid #f4f4f4; cursor: zoom-in;"><img src="'+v.filepath+'" width="90" height="90" /></a></td>';
        });
        html += '</tr></table>';
        $('#rxview').html(html);
      }
    });

    $('#rxview').html('');
    $('#rxorderid').val(id);
    $('#exampleModal').modal('toggle');
  }
  function gotourl(id){
    var url = $('#urlid'+id).val();
      if (url) {
        window.location = url;
      }
      return false;
  }

</script>