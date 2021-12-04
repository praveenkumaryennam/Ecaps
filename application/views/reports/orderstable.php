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
      $challan = ($row->is_challan == 1)?"<b class='text-green'>Genrated</b>":"<b class='text-red'>Pending</b>";
      $invoice = ($row->is_invoice == 1)?"<b class='text-green'>Genrated</b>":"<b class='text-red'>Pending</b>";
      if(!in_array($row->client_code, $tclients))
        $tclients[] = $row->client_code;

      $tamount += $row->ototal;
      $tinvoice += $row->is_invoice;
      $tchallans += $row->is_challan;
      $ounits += $row->ounits;

      $invoiceNumber = get_invoice_number($row->id);

      // $osts = '';
      // if($row->order_status)
      //   $osts = get_title_id($row->order_status, 'status');

      if($invoiceNumber)
        $furl = "<a href=".base_url('orders/bulkinvoice/'.$invoiceNumber)." class='btn btn-success add' target='_blank'><i class='fa fa-file-text'></i></a>";
      else
        $furl = '';//"<a href=".base_url('orders/invoice?_g='.$row->id.'&_qc='.$row->order_number)." class='btn btn-warning add' target='_blank'><i class='fa fa-eye'></i></a>";

      $os = get_order_shadules($row->id);

      $osarry = [];
      foreach ($os as $a){
        $osarry[] = trails_process($a->title);
      }

      $duetime = (strlen($row->duetime) == 1)?$row->duetime:date('h:i A', strtotime($row->duetime));

      $tdata .='<tr>
      <td>'.$i++.'</td>
      <td>'.$row->order_number.'</td>
      <td>'.date('d-m-Y', strtotime($row->date)).'</td>
      <td>'.date('d-m-Y', strtotime($row->duedate)).'</td>
      <td>'.ucfirst($row->clientname).'</td>
      <td>'.get_parent_client($row->parent).'</td>
      <td>'.$row->patiant_name.'</td>
      <td>'.$row->modal_no.'</td>
      <td>'.strtoupper($row->work_type).'</td>
      <td>'.implode(',', $osarry).'</td>
      <td>'.$challan.'</td>
      <td>'.$invoice.'</td>
      <td>'.$row->note.'</td>
      <td>'.get_zone_by_client($row->client_code).'</td>';
      if($this->session->userdata('role') == 'master')
        $tdata .= '<td>'.number_format($row->ototal, 2).'</td>';
      
      $tdata .= '<td width="50">'.$furl.'</td>
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
  <div class="col-md-12" style="text-align: center;">
    <div class="row">
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Clients</span>
            <span class="info-box-number"><?= number_format(sizeof($tclients));?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Jobs</span>
            <span class="info-box-number"><?= number_format($torders);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Units</span>
            <span class="info-box-number"><?= number_format($ounits);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Invoices Genrated</span>
            <span class="info-box-number"><?= number_format($tinvoice);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Challans Genrated</span>
            <span class="info-box-number"><?= number_format($tchallans);?></span>
          </div>
        </div>
      </div>
      <?php if($this->session->userdata('role') == 'master'){?>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <div class="info-box-content">
              <span class="info-box-text">Total Value</span>
              <span class="info-box-number"><?= number_format($tamount, 2);?></span>
            </div>
          </div>
        </div>
      <?php }?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-bordered datatable_btn">
        <thead>
          <tr>
            <th>Sr.no</th>
            <th>Order No</th>
            <th width="100">Order Date</th>
            <th width="100">Due Date</th>
            <th>Client</th>
            <th>Parent Client</th>
            <th>Patient Name</th>
            <th>Case No</th>
            <th>Order Status</th>
            <th>LabSlip</th>
            <th>Challan</th>
            <th>Invoice</th>
            <th>Note</th>
            <th>Zone</th>
            <?php 
              if($this->session->userdata('role') == 'master')
                echo '<th>Order Value</th>';
            ?>
            <th></th>
          </tr>
        </thead>
        <tbody><?= $tdata;?></tbody>
      </table>
    </div>
  </div>
</div>