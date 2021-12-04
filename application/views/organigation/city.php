<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Cities</h3>
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
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->city.'</td>
                        <td>'.$row->state.'</td>
                        <td>'.$row->country.'</td>
                        <td><a href="#"><i class="fa fa-trash btn btn-danger"></i></a> <a href="#"><i class="fa fa-edit btn btn-warning"></i></a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add City</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" class="form-add">
          <div class="row">
            <div class="col-md-12">
                <label class="imp">Country</label>
                <select class="form-control countries" id="country" name="country"></select>
            </div>
            <div class="col-md-12">
                <label class="imp">State</label>
                <select name="state" id="state" class="form-control states">
                    <option value=''> --- </option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="imp">City</label>
                <input type="text" id="city" name="city" class="form-control">
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
  var url = "cities";
</script>