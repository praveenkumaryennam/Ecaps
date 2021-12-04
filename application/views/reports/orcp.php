<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">OVER ALL REDO AND CORRECTION PERCENTAGE</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Client Name</th>
                    <th>Code</th>
                    <th>Mobile</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Station</th>
                    <th>New</th>
                    <th>Redo</th>
                    <th>Correction</th>
                    <th>Redo %</th>
                    <th>Correction %</th>
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
                        <td>'.$row->state.'</td>
                        <td>'.$row->city.'</td>
                        <td>'.$row->station.'</td>
                        <td>'.get_orders_total($row->id, 'NEW').'</td>
                        <td>'.get_orders_total($row->id, 'REDO').'</td>
                        <td>'.get_orders_total($row->id, 'CURRECTION').'</td>
                        <td>'.get_orders_percentage($row->id, 'REDO').'</td>
                        <td>'.get_orders_percentage($row->id, 'CURRECTION').'</td>
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
