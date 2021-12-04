<?php
  $tdata = '';
  $tinvoices = sizeof($rows);
  $tclients = [];
  $tbilling = 0;
  $tpaid = 0;
  $tunits = 0;
  if(!empty($rows)){
    $i = 1;
    foreach($rows as $row){
      if(!in_array($row->clientname, $tclients))
        $tclients[] = $row->clientname;
      
      $res = $this->db->where('invoice_number', $row->invoice_number)->get('duplicate_invoice');
      
      $_in = 0; 
      if($res->num_rows() > 0){
        $_in += $res->row()->invoice_total;
      }else{
        $_in += $row->invoice_total;
      }
        $tbilling += $_in;

      $tpaid += $row->paid;
      $tunits += $row->units;
      $tdata .= '<tr>
      <td>'.$i++.'</td> 
      <td>'.get_zone_by_client($row->client_id).'</td>
      <td>'.ucfirst($row->clientname).'</td>
      <td>'.get_parent_client($row->parent).'</td>
      <td>'.$row->invoice_number.'</td>
      <td>'.date('d/m/Y', strtotime($row->invoice_date)).'</td>
      <td>'.number_format($row->units).'</td>
      <td>'.number_format($_in, 2).'</td>
      <td>'.number_format($row->paid, 2).'</td>
      <td>'.number_format(($_in - $row->paid), 2).'</td>
      <td><a href="'.base_url('orders/bulkinvoice/'.$row->invoice_number).'" target="_blank"><i class="fa fa-eye btn btn-warning"></i></a></td>
      </tr>';
    }
    $tdata .= '<tr>
      <td></td> 
      <td></td> 
      <td></td>
      <td></td>
      <td></td>
      <td><b>'.number_format($tunits).'</b></td>
      <td><b>'.number_format($tbilling, 2).'</b></td>
      <td><b>'.number_format($tpaid, 2).'</b></td>
      <td><b>'.number_format(($tbilling - $tpaid), 2).'</b></td>
      <td></td>
      </tr>';
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
            <span class="info-box-text">Total Invoices</span>
            <span class="info-box-number"><?= number_format($tinvoices);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Units</span>
            <span class="info-box-number"><?= number_format($tunits);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Billing</span>
            <span class="info-box-number"><?= number_format($tbilling, 2);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Paid</span>
            <span class="info-box-number"><?= number_format($tpaid, 2);?></span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <div class="info-box-content">
            <span class="info-box-text">Total Balance</span>
            <span class="info-box-number"><?= number_format(($tbilling - $tpaid), 2);?></span>
          </div>
        </div>
      </div>
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
            <th>Zone</th>
            <th>Client</th>
            <th>Parent Client</th>
            <th>Invoice Number</th>
            <th>Invoice Date</th>
            <th>Units</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Balance Amount</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?= $tdata;?>
        </tbody>
      </table>
    </div>
  </div>
</div>