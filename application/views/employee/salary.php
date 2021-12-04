<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Employee Salarys</h3>
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
                    <th>Client Name</th>
                    <th>Code</th>
                    <th width="60"></th>
                  </tr>
                </thead>
                <tbody>
                  
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
        <form action="<?= base_url('clients/parent');?>" method="post">
          <div class="row">
            <div class="col-md-12">
              <table border=1 width="100%">
                <tr>
                  <th>Payment</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th></th>
                </tr>

                <tr>
                  <td>
                    <input type="text" name="payment" style="width: 100%" required>
                  </td>
                  <td>
                    <select  name="type" >
                      <option value="cr">CR</option>
                      <option value="dr">DR</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="payment" style="width: 100%" required>
                  </td>
                  <td>
                    <input class="fa fa-plus" />
                  </td>
                </tr>

              </table>
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