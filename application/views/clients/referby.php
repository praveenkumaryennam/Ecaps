<div class="row">
 <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Referer</h3>
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
                    <th>Referer Name.</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        $sts = ($row->status == 1)?0:1;
                        $color = ($row->status == 0)?'fa-trash btn btn-danger':'fa-check btn btn-success';

                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->title.'</td>
                        <td>
                          <a href="javascript:_delete('.$row->id.', \'refer_by\', '.$sts.');"><i class="fa '.$color.'"></i></a> 
                          <a href="javascript:update('.$row->id.', \'refer_by\');"><i class="fa fa-edit btn btn-warning"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Referer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" class="form-add">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group col-md-12">
                  <label class="imp">Referer</label>
                  <input type="text" id="title" name="title" class="form-control">
              </div>
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


<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Referer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" class="form-update">
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-12">
                    <label class="imp">Referer</label>
                    <input type="text" id="etitle" name="title" class="form-control">
                    <input type="hidden" id="eid" name="eid" class="form-control">
                    <input type="hidden" name="master" value="refer_by" class="form-control">
                </div>
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


<script>
  var url = 'refer_by';
  function _delete(id, tbl, sts){
    $.post('<?= base_url('organization/delete')?>', {'eid':id,'sts':sts,'master':tbl}, function(res){
      location.reload();
    });
  }
</script>