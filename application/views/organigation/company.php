<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Company</h3>
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
                    <th>Company</th>
                    <th>Mobile</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Address</th>
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
                        <td>'.$row->mobile.'</td>
                        <td>'.$row->tel.'</td>
                        <td>'.$row->email.'</td>
                        <td>'.$row->website.'</td>
                        <td>'.$row->address.'</td>
                        <td><a href="#"><i class="fa fa-trash btn btn-danger"></i></a> <a href="javascript:update('.$row->id.', \'company\')"><i class="fa fa-edit btn btn-warning"></i></a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" enctype="multipart/form-data" class="form-add">
          <div class="row">
            <div class="col-md-2">
              <label>Image</label>
              <img src="<?= base_url();?>assets/dist/img/rpdlogo.png" id="imgpri" style="border:1px solid #808080; width:100px; height: 110px;" class="btnFileUpload"/>
              <input type="file" name="image" value="" id="image" style="display:none;" />
            </div>
            <div class="col-md-10">
              <div class="form-group col-md-12">
                <label class="imp">Company Name</label>
                <input name="name" id="name" type="text" class="form-control">
              </div>
              <div class="form-group col-md-6">
                  <label class="imp">MobileNumber</label>
                  <input type="text" id="mobile" name="mobile" class="form-control">
              </div>
              <div class="form-group col-md-6">
                  <label>TelephoneNumber</label>
                  <input type="text" name="tel" id="tel" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label class="imp">EmailId</label>
                <input name="email" id="email" type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">FaxNumber</label>
                <input type="text" id="fax" name="fax" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">PanNumber</label>
                <input type="text" name="pan" id="pan" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">GSTNumber</label>
                <input type="text" name="gst" id="gst" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">CINNumber</label>
                <input type="text" name="cin" id="cin" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Website</label>
                <input type="text" name="website" id="website" class="form-control">
            </div>
            <div class="form-group col-md-12">
                <label class="imp">Address</label>
                <input type="text" name="address" id="address" class="form-control">
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
        <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" enctype="multipart/form-data" class="form-update">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-2">
              <label>Image</label>
              <img src="<?= base_url();?>assets/dist/img/rpdlogo.png" id="imgpri" style="border:1px solid #808080; width:100px; height: 110px;" class="btnFileUpload"/>
              <input type="hidden" name="eid" id="eid" />
              <input type="file" name="image" value="" id="eimage" style="display:none;" />
            </div>
            <div class="col-md-10">
              <div class="form-group col-md-12">
                <label class="imp">Company Name</label>
                <input name="name" id="ename" type="text" class="form-control">
              </div>
              <div class="form-group col-md-6">
                  <label class="imp">MobileNumber</label>
                  <input type="text" id="emobile" name="mobile" class="form-control">
              </div>
              <div class="form-group col-md-6">
                  <label>TelephoneNumber</label>
                  <input type="text" name="tel" id="etel" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label class="imp">EmailId</label>
                <input name="email" id="eemail" type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">FaxNumber</label>
                <input type="text" id="efax" name="fax" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">PanNumber</label>
                <input type="text" name="pan" id="epan" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">GSTNumber</label>
                <input type="text" name="gst" id="egst" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label class="imp">CINNumber</label>
                <input type="text" name="cin" id="ecin" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Website</label>
                <input type="text" name="website" id="ewebsite" class="form-control">
            </div>
            <div class="form-group col-md-12">
                <label class="imp">Address</label>
                <input type="text" name="address" id="eaddress" class="form-control">
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