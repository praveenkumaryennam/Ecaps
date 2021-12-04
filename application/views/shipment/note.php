<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Orders</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable table-hover">
                <thead>
                  <tr>
                    <th width="10">Sr.no</th>
                    <th width="150">Order#</th>
                    <th width="300">Order Date</th>
                    <th width="">Client</th>
                    <th width="">Patient</th>
                    <th width="">Products</th>
                    <th width="">CaseNo</th>
                    <th width="">Status</th>
                    <th width="">DueDate</th>
                    <th>OrderAmount</th>
                    <th width="250"></th>
                  </tr>
                </thead>
                <tbody> 
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        $product = get_order_product($row->id);
                        $otitle = get_title_id($row->order_status, 'status');
                        $ototal = get_order_total($row->id);

                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->order_number.'</td>
                        <input type="hidden" id="onumber" value="'.$row->order_number.'">
                        <td>'.date('d-m-Y', strtotime($row->date)).'</td>
                        <input type="hidden" id="odate" value="'.date('d-m-Y', strtotime($row->date)).'">
                        <td>'.ucfirst($row->clientname).'</td>
                        <input type="hidden" id="client" value="'.ucfirst($row->clientname).'">
                        <td>'.$row->patiant_name.'</td>
                        <input type="hidden" id="patiant" value="'.$row->patiant_name.'">
                        <td>'.$product.'</td>
                        <input type="hidden" id="product" value="'.$product.'">
                        <td>'.$row->modal_no.'</td>
                        <input type="hidden" id="modalno" value="'.$row->modal_no.'">
                        <td>'.$otitle.'</td>
                        <input type="hidden" id="otitle" value="'.$otitle.'">
                        <td>'.date('d-m-Y', strtotime($row->due_date)).'</td>
                        <input type="hidden" id="duedate" value="'.date('d-m-Y', strtotime($row->due_date)).'">
                        <td>'.$ototal.'</td>
                        <input type="hidden" id="ototal" value="'.$ototal.'">
                        <td><a href="'.base_url('orders/view/'.$row->id).'" taget="_blank" class="btn btn-flat btn-info add" style="margin-left: 5px;"><i class="fa fa-info"></i></a><a href="javascript:gen('.$row->id.')" class="btn btn-flat btn-primary add"><i class="fa fa-road"></i></a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Confirm Shipment Notes to be generated</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" id="tbl"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-primary" href="javascript:addshipment();">Save Shipment Note</a>
      </div>
    </div>
  </div>
</div>
