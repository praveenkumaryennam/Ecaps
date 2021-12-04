<?php

  if(!empty($rows)){
    $i = 1;
    $tdata = '';
    $torders = sizeof($rows);
    $tclients = [];
    $tamount = 0;
    $tinvoice = 0;
    $ounits = 0;
    $tchallans = 0;

    foreach($rows as $row){
      if(!in_array($row->client_code, $tclients))
        $tclients[] = $row->client_code;

      $invoiceNumber = get_invoice_number($row->id);

      if($invoiceNumber)
        $furl = "<a href=".base_url('orders/bulkinvoice/'.$invoiceNumber)." class='btn btn-success add' target='_blank'><i class='fa fa-file-text'></i></a>";
      else
        $furl = "<a href=".base_url('orders/invoice?_g='.$row->id.'&_qc='.$row->order_number)." class='btn btn-warning add' target='_blank'><i class='fa fa-eye'></i></a>";
      
      $trail = '';
      $ids = order_schadules($row->id);
      foreach ($ids as $id) {
        foreach (trails_process() as $k) {
          if($id->title == $k['id']){
            $trail .= $k['value'].', ';  
          }
        }
      }


      $tdata .='<tr>
      <td>'.$i++.'</td>
      <td>'.get_lab_slip_status($row->order_number).'</td>
      <td>'.$row->order_number.'</td>
      <td>'.date('d-m-Y', strtotime($row->date)).'</td>
      <td>'.ucfirst($row->clientname).'</td>
      <td>'.$row->patiant_name.'</td>
      <td>'.$row->modal_no.'</td>
      <td>'.$trail.'</td>
      <td width="50">'.$furl.'</td>
      <td width="50"><a href=\''.base_url('shipment/labslip/'.$row->order_number).'\' class="btn btn-info add" target="_blank"><i class="fa fa-file-o"></i></a></td>
      </tr>';
    }
  }
?>


<style type="text/css">
  .info-box-content{
    margin-left: 0px !important;
  }
  .info-box{
    min-height: 60px !important;
    border: 1px solid #c1c1c1;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-bordered datatable_btn">
        <thead>
          <tr>
            <th>Sr.no</th>
            <th>Is Return</th>
            <th>Order No</th>
            <th width="100">Order Date</th>
            <th>Client</th>
            <th>Patient Name</th>
            <th>Case No</th>
            <th>Trail</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody><?= $tdata;?></tbody>
      </table>
    </div>
  </div>
</div>