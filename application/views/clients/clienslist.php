<div class="row">
  <div class="col-md-12">
    <div class="panel">
      
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
                    <th>Email</th>
                    <th>City</th>
                    <th width="60"></th>
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
                        <td>'.$row->email.'</td>
                        <td>'.$row->city.'</td>
                        <td><a href="'.base_url('clients/dashboard/'.$row->id).'" class="btn btn-success add"><i class="fa fa-list"></i> &nbsp;Report</a></td>
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