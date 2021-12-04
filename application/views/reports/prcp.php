<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">OVER ALL PRODUCT REDO AND CORRECTION PERCENTAGE</h3>
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
                    <th>Product Title</th>
                    <th>Product Code</th>
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
                        $redo = ($row['redo'] * 100)/$row['new'];
                        $currection = ($row['correction'] * 100)/$row['new'];
						
						$redo = ($redo > 0)?round($redo, 2):0;
						$currection = ($currection > 0)?round($currection, 2):0;
                        $anew = ($row['new'] > 0)?$row['new']:"0";
                        $aredo = ($row['redo'] > 0)?$row['redo']:"0";
                        $acorrection = ($row['correction'] > 0)?$row['correction']:"0";

                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.get_title($row['data']['id'], 'product').'</td>
                        <td>'.ucfirst($row['data']['id']).'</td>
                        <td>'.$anew.'</td>
                        <td>'.$aredo.'</td>
                        <td>'.$acorrection.'</td>
                        <td>'.$redo.'%</td>
                        <td>'.$currection.'%</td>
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
