<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Orders</h3>
        <a href="<?= base_url('orders/clients');?>" class="btn btn-primary add"><i class="fa fa-plus"></i> Add</a>
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
                    <th>Order No</th>
                    <th width="80">Order Date</th>
                    <th>Client</th>
                    <th>Client Code</th>
                    <th width="150">Patient Name</th>
                    <th>CaseNo</th>
                    <th>OrderStatus</th>
                    <th width="100"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        $invoiceNumber = get_invoice_number($row->id);
                        if($invoiceNumber){
                          $furl = base_url('orders/viewinvoice/'.$invoiceNumber);
                          $is_s = 'display:none';
                          $is_s1 = '';
                        }else{
                          $furl = base_url('orders/invoice?_g='.$row->id.'&_qc='.$row->order_number);
                          $is_s = '';
                          $is_s1 = 'display:none';
                        }
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->order_number.'</td>
                        <td>'.date('d-m-Y', strtotime($row->date)).'</td>
                        <td>'.ucfirst($row->clientname).'</td>
                        <td>'.strtoupper($row->ccode).'</td>
                        <td>'.$row->patiant_name.'</td>
                        <td>'.$row->modal_no.'</td>
                        <td>'.get_title_id($row->order_status, 'status').'</td>
                        <td><a href="'.$furl.'" class="btn btn-primary add" style="margin-right: 5px;'.$is_s.' " target="_blank" style="margin-right: 5px;"><i class="fa fa-file-text"></i></a><a href="'.base_url('payment/paynow/'.$invoiceNumber).'" class="btn btn-success add" style="margin-right: 5px;'.$is_s1.' " target="_blank" style="margin-right: 5px;"><i class="fa fa-inr"></i>&nbsp;&nbsp;PayNow</a></td>
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