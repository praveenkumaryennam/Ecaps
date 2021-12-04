<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Client's</h3>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th></th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Mobile</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      foreach($rows as $row){
                        $abtn = '';
                        $asty = 'style="background: #8d8d8d73;"';
                        if($row->status == 0){
                          $asty = '';
                          $abtn = '<b><a href="'.base_url('orders/neworder?client='). $row->id.'"><i class="fa fa-plus"></i></a></b>';
                        }

                        if($row->is_gst == 1){
                          $asty = 'style="background: #FFA500;"';
                          $abtn = '';
                        }

                        echo '<tr '.$asty.'>
                        <td>'.$abtn.'</td>

                        <td>'.strtoupper($row->clientname).'</td>
                        <td>'.strtoupper($row->code).'</td>
                        <td>'.$row->mobile.'</td>
                        <td>'.$row->email.'</td>
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