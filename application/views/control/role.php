<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Role</h3>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <span class="text-red"><?= $this->session->flashdata('msg');?></span>
            <div class="table-responsive">
              <table class="table table-bordered datatable table-hover">
                <thead>
                  <tr>
                    <th width="10">Sr.no</th>
                    <th>Role</th>
                    <th>Code</th>
                    <th width="10"></th>
                  </tr>
                </thead>
                <tbody> 
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->title.'</td>
                        <td>'.$row->code.'</td>
                        <td><a href=javascript:editrole('.$row->id.') class="btn btn-warning">Edit</a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="post" action="<?= base_url('privatization/role');?>" class="form-group">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label>Role</label>
              <input type="text" name="role" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Code</label>
              <input type="text" name="code" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  function editrole(role){
    alert(role);
  }
</script>