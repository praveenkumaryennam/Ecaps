<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Doctor Capping</h3>
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
                    <th>Mobile</th>
                    <th>WhatsApp No</th>
                    <th>Capping Limit</th>
                    <th>Left to use</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->clientname.'</td>
                        <td>'.ucfirst($row->code).'</td>
                        <td>'.$row->mobile.'</td>
                        <td>'.$row->whatsappno.'</td>
                        <td>'.number_format($row->capping_value, 2).'</td>
                        <td>'.number_format($row->capping_limit, 2).'</td>
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
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Doctor Capping</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="imp">Client</label><br> 
              <select class="form-control select2" style="width: 100%" id="cleint_id" name="client">
                <option value=""> --- </option>
                <?php
                  foreach (loadoption('clients') as $p){
                    if(!empty($arr['client'])){
                      $sel = ($arr['client'] == $p->code)?"selected":"";
                      echo '<option value="'.$p->id.'" '.$sel.'>'.$p->clientname.'</option>';
                    }
                    else
                      echo '<option value="'.$p->id.'">'.$p->clientname.'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="col-md-12 form-group">
                <label class="imp">Amount</label>
                <input type="text" id="capping_value" name="amt" class="form-control" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="setcapping">Save changes</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script>
  $('#setcapping').click(function(){
    var capping_value = $('#capping_value').val();
    var client_id = $('#cleint_id').val();

    if(capping_value){
      $.post(base_url+'clients/capping', {capping:capping_value, client: client_id}, function(res){
        if(res == 1){
          $('#clientname').text('');
          $('#capping_value').val('');
          $('#cleint_id').val('');
          $('#exampleModal').modal('toggle');
          window.location.reload();
        }else{
          alert('try again later');
        }
      });
    }
  });
</script>