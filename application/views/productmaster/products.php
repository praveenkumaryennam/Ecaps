<style>
  .modal-title{
    float: left;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Products</h3>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable ">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>ProductName</th>
                    <th>Code</th>
                    <th>Group</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Warranty</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;

                    foreach($rows as $row){
                        if($row->status == 0){
                          $btn = '<a href="javascript:_delete('.$row->id.')"><i id="isbtn'.$row->id.'" data-sts="1" class="fa fa-trash btn btn-danger"></i></a>';
                        }else{
                          $btn = '<a href="javascript:_delete('.$row->id.')"><i id="isbtn'.$row->id.'" data-sts="0" class="fa fa-check btn btn-success"></i></a>';
                        }


                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->title.'<input type="hidden" id="vtitle'.$row->id.'" value="'.$row->title.'" /></td>
                        <td>'.$row->code.'<input type="hidden" id="vcode'.$row->id.'" value="'.$row->code.'" /></td>
                        <td>'.$row->agroup.'<input type="hidden" id="vgroup'.$row->id.'" value="'.$row->group.'" /></td>
                        <td>'.$row->acategory.'<input type="hidden" id="vcategory'.$row->id.'" value="'.$row->category.'" /></td>
                        <td>'.$row->abrand.'<input type="hidden" id="vbrand'.$row->id.'" value="'.$row->brand.'" /></td>
                        <td>'.$row->awarranty.'<input type="hidden" id="vwarranty'.$row->id.'" value="'.$row->warranty.'" /></td>
                        <td>'.$row->atype.'<input type="hidden" id="vtype'.$row->id.'" value="'.$row->type.'" /></td>
                        <td>'.$row->unit_price.'<input type="hidden" id="vunit_price'.$row->id.'" value="'.$row->unit_price.'" /></td>
                        <td>
                          '.$btn.'
                          <a href="javascript:update('.$row->id.')"><i class="fa fa-edit btn btn-warning"></i></a>
                          <a href="javascript:offermodal('.$row->id.')"><i class="fa fa-percent btn bg-purple-active"></i></a>
                        </td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" class="form-add">
          <div class="row">
            <div class="col-md-6 form-group">
                <label class="imp">Product Name</label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label class="imp">Code</label>
                <input type="text" id="code" name="code" class="form-control">
            </div>

           <!--  <div class="col-md-6 form-group">
                <label class="imp">LagancyCode</label>
                <input type="text" id="legancy_code" name="legancy_code" class="form-control">
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Desciption(Other Lan..)</label>
                <input type="text" id="desc" name="desc" class="form-control">
            </div>
 -->
            <div class="col-md-6 form-group">
                <label class="imp">Group</label>
                <select class="form-control select2" style="width:100%;" id="group" name="group">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('group') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->group.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Brand</label>
                <select class="form-control select2" style="width:100%;" id="brand" name="brand">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('brand') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->brand.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Warranty</label>
                <select class="form-control select2" style="width:100%;" id="warranty" name="warranty">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('warranty') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->warranty.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Category</label>
                <select class="form-control select2" style="width:100%;" id="category" name="category">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('category') as $opt){
                      echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Type</label>
                <select class="form-control types select2" style="width:100%;" id="type" name="type">
                  <option value=""> --- </option>
                  <!-- <?php
                    foreach (loadoptions('type') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->title.'</option>';
                    }
                  ?> -->
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Unit xPrice</label>
                <input type="text" id="price" name="price" class="form-control">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
        </form>
    </div>
  </div>
</div>


<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" class="form-update">
          <input type="hidden" name="eproduct_id" id="eproduct_id"/>
          <div class="row">
            <div class="col-md-6 form-group">
                <label class="imp">Product Name</label>
                <input type="text" id="etitle" name="title" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label class="imp">Code</label>
                <input type="text" id="ecode" name="code" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label class="imp">Group</label>
                <select class="form-control select2" style="width:100%;" id="egroup" name="group">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('group') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->group.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Brand</label>
                <select class="form-control select2" style="width:100%;" id="ebrand" name="brand">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('brand') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->brand.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Warranty</label>
                <select class="form-control select2" style="width:100%;" id="ewarranty" name="warranty">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('warranty') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->warranty.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Category</label>
                <select class="form-control select2" style="width:100%;" id="ecategory" name="category">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('category') as $opt){
                      echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
                    }
                  ?>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Type</label>
                <select class="form-control types select2" style="width:100%;" id="etype" name="type">
                  <option value=""> --- </option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label class="imp">Unit xPrice</label>
                <input type="text" id="eprice" name="price" class="form-control">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update">Update changes</button>
      </div>
        </form>
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
            <div class="col-md-12 form-group">
                <input type="hidden" name="product_id" id="product_id" class="form-control" required/>
                <input type="hidden" name="offerpid" id="offerpid" class="form-control" required/>
                <label class="imp">Offer</label>
                <select class="form-control" id="offer" name="offer">
                  <?php 
                    $getoffers = getoffers(true);
                    if(!empty($getoffers)){
                      foreach($getoffers as $o){
                        echo '<option value="'.$o->id.'">'.ucfirst($o->title).'</option>';
                      }
                    }
                  ?>
                </select>
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
  var url = "product";

  function _delete(id){
    var sts = $('#isbtn'+id).data('sts');
    $.post(base_url+'productmaster/is_status/'+id+'/'+sts, function(res){
      if(res == true){
        if(sts == 1){
          $('#isbtn'+id).removeClass('fa fa-trash btn btn-danger');
          $('#isbtn'+id).addClass('fa fa-check btn btn-success');
          $('#isbtn'+id).data('sts', 0);
        }else{
          $('#isbtn'+id).removeClass('fa fa-check btn btn-success');
          $('#isbtn'+id).addClass('fa fa-trash btn btn-danger');
          $('#isbtn'+id).data('sts', 1);
        }
      }
    });
  }

  function offermodal(id){
    $.post(base_url+'offer/getproductoffer/'+id, function(res){
      if(res){
        res = JSON.parse(res);
        $('#offer').val(res.offer_id);
        $('#offerpid').val(res.id);
      }
    });
    $('#product_id').val(id);
    $('#modal_offer').modal('toggle');
  }

  $('#aplyoffer').click(function(){
    var data = {
      'offer': $('#offer').val(),
      'offerpid': $('#offerpid').val(),
      'product_id': $('#product_id').val(),
    };

    $.post(base_url+'offer/product_offer', data, function(res){
      if(res){
        var msg = ($('#product_id').val())?'Offer updated successfully.':'Offer applied successfully.'; 
        Toast.fire({
          type: 'success',
          title: msg
        }).then(() => {
          $('#modal_offer').modal('toggle');
        });
      }
    });
  });

</script>
