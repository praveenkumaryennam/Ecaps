<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Shade's</h3>
        <!-- <button class="btn btn-primary add m-l-5" data-toggle="modal" data-target="#excelModal"><i class="fa fa-upload"></i> Import</button> -->
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
                    <th>Shade</th>
                    <th>ShadeGuide</th>
                    <th>code</th>
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
                        <td>'.ucfirst($row->title).'</td>
                        <td>'.ucfirst($row->shadeguide).'</td>
                        <td>'.$row->code.'</td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Shade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="shade" class="form-add">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">ShadeGuide</label>
                <select id="shadeguide" name="shadeguide" class="form-control">
                  <option value=""></option>
                  <?php 
                    if(!empty($shadeguide)){
                      foreach($shadeguide as $sg){
                        echo '<option value="'.$sg->code.'">'.$sg->title.'</option>'; 
                      }
                    }
                  ?>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <label class="imp">Shade</label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="col-md-12 form-group">
                <label class="imp">Code</label>
                <input type="text" id="code" name="code" class="form-control">
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

<!-- Excel Modal -->
<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import ProductBrand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" class="form-import" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">File</label>
                <input type="text" id="file" name="file" class="form-control">
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