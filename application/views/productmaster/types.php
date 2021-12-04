<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">ProductType</h3>
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
                    <th>Sr.no</th>
                    <th>Product Type</th>
                    <th>Product Category</th>
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
                        <td>'.$row->title.'</td>
                        <td>'.$row->product_category.'</td>
                        <td><a href="#"><i class="fa fa-trash btn btn-danger"></i></a> <a href="javascript:typeupdate('.$row->id.')"><i class="fa fa-edit btn btn-warning"></i></a></td>
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
  <div class="modal-dialog" role="document" style="width:750px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add ProductType</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" class="form-add">
          <div class="row">
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
                <input type="text" id="type" name="type" class="form-control">
            </div>
           <!--  <div class="col-md-4 form-group">
                <label class="imp">Code</label>
                <input type="text" id="code" name="code" class="form-control">
            </div> -->
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered">
            <?php 
              foreach (loadrxoptions() as $x){
                echo '<tr>
                  <td><input type="checkbox" name="label" value="'.$x['id'].'" onchange="mservices()" class="labelopt" /></td>
                  <td>'.$x['label'].'</td>
                  <td><select name="option[]" class="selopt" data-id ="'.$x['id'].'">';
                    echo '<option value=""> --- </option>';
                  foreach ($x['options'] as $y){
                    echo '<option value="'.$y['id'].'">'.$y['option'].'</option>';
                  }
                echo '</select></td></tr>';
              }
            ?>
          </table>
          <input type="hidden" name="rxlabel" id="rxlabel" />
          <input type="hidden" name="rxselabel" id="rxselabel" />
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

<!-- UpdateModal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:750px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update ProductType</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" class="form-typeupdate">
          <input type="hidden" name="id" id="eid">
          <input type="hidden" name="code" id="ecode">
          <div class="row">
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
                <input type="text" id="etype" name="type" class="form-control">
            </div>
           <!--  <div class="col-md-4 form-group">
                <label class="imp">Code</label>
                <input type="text" id="code" name="code" class="form-control">
            </div> -->
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered">
            <?php 
              foreach (loadrxoptions() as $x){
                echo '<tr>
                  <td><input type="checkbox" id="et'.$x['id'].'" name="label" value="'.$x['id'].'" onchange="mservices()" class="elabelopt" /></td>
                  <td>'.$x['label'].'</td>
                  <td><select name="option[]" id="eo'.$x['id'].'" class="selopt" data-id ="'.$x['id'].'">';
                    echo '<option value=""> --- </option>';
                  foreach ($x['options'] as $y){
                    echo '<option value="'.$y['id'].'">'.$y['option'].'</option>';
                  }
                echo '</select></td></tr>';
              }
            ?>
          </table>
          <input type="hidden" name="rxlabel" id="erxlabel" />
          <input type="hidden" name="rxselabel" id="erxselabel" />
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
  var url = "type";
</script>