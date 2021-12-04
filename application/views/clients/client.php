<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Clients</h3>
        <button class="btn btn-primary add" style="margin-left: 5px;" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Import</button>
        <a href="<?= base_url('clients/add');?>" class="btn btn-primary add"><i class="fa fa-plus"></i> Add</a>
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
                    <th>Mobile</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Station</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      $offer = false;
                      foreach($rows as $row){
                        if($row->status == 0){
                          $dbtn = '<a href="javascript:blockclient(\''.$row->id.'\')" title="Block Client"><i id="dbtns'.$row->id.'" data-sts="1" class="fa fa-unlock-alt btn btn-success"></i></a>';
                          $offer = '<a href="javascript:offerModal(\''.$row->id.'\')" title="Offer"><i id="offer_assign'.$row->id.'" class="fa fa-percent btn bg-purple-active"></i></a>';
                        }else{
                          $dbtn = '<a href="javascript:blockclient(\''.$row->id.'\')" title="Block Client"><i id="dbtns'.$row->id.'" data-sts="0" class="fa fa-lock btn btn-danger"></i></a>';
                        }
                        
                        if($row->is_gst == 0){
                          $gst_btn = '<a href="javascript:is_gst(\''.$row->id.'\', 1)" title="Client"><i class="fa fa-copyright btn btn-info"></i></a>';
                        }else{
                          $gst_btn = '<a href="javascript:is_gst(\''.$row->id.'\', 0)" title="Client"><i class="fa fa-copyright btn btn-danger"></i></a>';
                        }

                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->clientname.'</td>
                        <td>'.ucfirst($row->code).'</td>
                        <td>'.$row->mobile.'</td>
                        <td>'.$row->state.'</td>
                        <td>'.$row->city.'</td>
                        <td>'.$row->station.'</td>
                        <td>'.$dbtn.' '.$gst_btn.'
                        
                        <a href="'.base_url("clients/edit/").$row->id.'" title="Edit"><i class="fa fa-edit btn btn-warning"></i></a> </a> 
                        <a href="'.base_url("clients/clientproducts/").$row->id.'" title="Add Products"><i class="fa fa-plus btn btn-success"></i></a>
                        '.$offer.'
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="exampleModalLabel">Import Clinets</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('clients/import');?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">DataFile</label>
                <input type="file" name="importfile" class="form-control" required>
                <small> Download Export Format File <a href="<?= base_url('assets/files/Import_Clients.xlsx');?>"> <i class="fa fa-download"></i> click here</a></small>
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

<!-- Capping Modal -->
<div class="modal fade" id="cappingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="exampleModalLabel">Capping</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <b>Client Name: </b><span id="clientname"></span>
              <hr style="background: #f4f4f4; margin-top:2px;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">Value Limit</label>
                <input type="text" name="capping" id="capping_value" class="form-control" required/>
                <input type="hidden" name="cleint_id" id="cleint_id" class="form-control" required/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="setcapping">Set</button>
        </div>
    </div>
  </div>
</div>

<!-- Offer Modal -->
<div class="modal" id="modal_offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="exampleModalLabel">Apply Offer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <input type="hidden" name="client_id" id="client_id" class="form-control" required/>
            <input type="hidden" name="offerId" id="offerId" class="form-control" required/>
            <div class="form-group col-md-12">
                <label class="imp">Offer Type</label>
                <select name="offer_type" id="offer_type" class="form-control" required>
                  <option value="">---</option>
                  <option value="1">Product</option>
                  <option value="2">Billing</option>
                </select>
            </div>
            <div class="col-md-12 form-group fts" style="display:none">
                <label class="imp">Offer</label>
                <select class="form-control" id="offer" name="offer">
                  <?php 
                    if(!empty(getoffers())){
                      foreach(getoffers() as $o){
                        echo '<option value="'.$o->id.'">'.ucfirst($o->title).'</option>';
                      }
                    }
                  ?>
                </select>
            </div>
            <div class="form-group col-md-12 fts" style="display:none">
                <label class="imp">Offer Type</label>
                <select name="offeringtype" id="offeringtype" class="form-control">
                  <option value="amt">Amount</option>
                  <option value="per">Percentage</option>
                </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">Start Date</label>
                <input class="form-control datepicker" id="start_date" name="start_date" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">End Date</label>
                <input class="form-control datepicker" id="end_date" name="end_date" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="aplyoffer">Apply</button>
        </div>
    </div>
  </div>
</div>


<script>
  function blockclient(id){
    var sts = $('#dbtns'+id).data('sts');
    $.post(base_url+'clients/block_client/'+id+'/'+sts, function(res){
      if(sts == 1){
        $('#dbtns'+id).removeClass('fa fa-unlock-alt btn btn-success');
        $('#dbtns'+id).addClass('fa fa-lock btn btn-danger');
        $('#dbtns'+id).data('sts', '0');
      }else{
        $('#dbtns'+id).removeClass('fa fa-lock btn btn-danger');
        $('#dbtns'+id).addClass('fa fa-unlock-alt btn btn-success');
        $('#dbtns'+id).data('sts', '1');
      }
    })
  }

  function offerModal(id){
    $('#client_id').val(id);
    $.post(base_url+'offer/getoffer/'+id, function(res){
      if(res){
        res = JSON.parse(res);
        $('#offerId').val(res.id);
        $('#offer').val(res.offer_id);
        $('#offer_type').val(res.offer_type);
        $('#offeringtype').val(res.offeringtype);
        $('#start_date').val(res.start_date);
        $('#end_date').val(res.end_date);
      }
    });
    $('#modal_offer').modal('toggle');
  }

  $('#offer_type').change(function(){
    if($(this).val() == 2){
      $('.fts').show();
    }else{
      $('.fts').hide();
    }
  });

  function is_gst(id, sts){
    $.post(base_url+'clients/is_gst/'+id+'/'+sts, function(res){
      console.log(res);
    });
  }


  function capping(id, name){
    if(id){
      $('#clientname').text(name);
      $('#cleint_id').val(id);
      $('#cappingModal').modal('toggle');
    }
  }

  $('#setcapping').click(function(){
    var capping_value = $('#capping_value').val();
    var client_id = $('#cleint_id').val();

    if(capping_value > 0){
      $.post(base_url+'clients/capping', {capping:capping_value, client: client_id}, function(res){
        if(res == 1){
          $('#clientname').text('');
          $('#capping_value').val('');
          $('#cleint_id').val('');
          $('#cappingModal').modal('toggle');
        }else{
          alert('try again later');
        }
      });
    }
  });


  $('#aplyoffer').click(function(){
    var data = {
      'client_id': $('#client_id').val(),
      'offerId': $('#offerId').val(),
      'offer': $('#offer').val(),
      'offer_type': $('#offer_type').val(),
      'offeringtype': $('#offeringtype').val(),
      'start_date': $('#start_date').val(),
      'end_date': $('#end_date').val(),
    };

    $.post(base_url+'offer/apply_offer', data, function(res){
      if(res == 1){
        var msg = ($('#offerId').val())?'Offer Updated succeesfully.':'Offer applied successfully.';
        Toast.fire({
          type: 'success',
          title: msg
        }).then(function(){
          $('#modal_offer').modal('toggle');
        });
      }
    });
  });

</script>
