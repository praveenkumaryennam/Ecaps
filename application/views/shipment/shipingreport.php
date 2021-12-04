<?php
    $html_data = '';
    $total_challans = 0;
    $total_units = 0;
    $total_amt = 0;

    if(!empty($rows)){
      $i = 1;
      function dateDiffInDays($date1, $date2) {
          $diff = strtotime($date2) - strtotime($date1); 
          // 1 day = 24 hours 
          // 24 * 60 * 60 = 86400 seconds 
          return abs(round($diff / 86400)); 
      }
      foreach($rows as $row){
        $total_challans += 1;
        $product = get_order_product($row->id);
        // $otitle = get_title_id($row->order_status, 'status');
        $ototal = get_order_total($row->id);

        $total_units += $row->units;
        $total_amt += $ototal; 
        
        $cDate = strtotime(date('Y-m-d', strtotime($row->added_at)));
        $dDate = strtotime(date('Y-m-d', strtotime($row->due_date)));

        if($cDate > $dDate){
          $df = dateDiffInDays(date('Y-m-d', strtotime($row->due_date)), date('Y-m-d', strtotime($row->added_at)));
        }else{
          $df = 0;
        }

        $bg = 'red';
        $csts = "Pending";
        if($df == 0){
          $bg = 'green';
          $csts = "Generated";
        }

        $html_data .= '<tr>
        <td>'.$i++.'</td>
        <td>'.$row->order_number.'</td>';
        if($_SESSION['role'] == 'master'){
          $html_data .= '<td>'.date('d-m-Y', strtotime($row->date)).'</td><td>'.date('d-m-Y', strtotime($row->due_date)).'</td>';
        }else{
          $html_data .= '<td>'.date('d-m-Y h:i A', strtotime($row->date)).'</td><td>'.date('d-m-Y', strtotime($row->due_date)).' '.$row->duetime.'</td>';
        }
        $html_data .= '<td>'.ucfirst($row->clientname).'</td>
        <td>'.$row->patiant_name.'</td>
        <td>'.strtoupper($row->work_type).'</td>
        <td>'.$product.'</td>
        <td>'.get_title_priority($row->order_priority).'</td>
        <td>'.$row->modal_no.'</td>
        <td>'.$row->challan_number.'</td>
        <td>'.date('d-m-Y h:i A', strtotime($row->added_at)).'</td>
        <td style="color: '.$bg.'; font-weight: bold;">'.$csts.'</td>
        <td style="background: '.$bg.'; color: white; font-weight: bold;">'.$df.'</td>';
        
        if($this->session->userdata('role') == 'master')
          $html_data .= '<td>'.number_format($ototal, 2).'</td>';
        
        $html_data .= '<td>'.get_zone_by_client($row->client_code).'</td><input type="hidden" id="duedate" value="'.date('d-m-Y', strtotime($row->due_date)).'">
        <input type="hidden" id="odate" value="'.date('d-m-Y', strtotime($row->date)).'">
        <input type="hidden" id="client" value="'.ucfirst($row->clientname).'">
        <input type="hidden" id="patiant" value="'.$row->patiant_name.'">
        <input type="hidden" id="product" value="'.$product.'">
        <input type="hidden" id="modalno" value="'.$row->modal_no.'">
        <input type="hidden" id="otitle" value="'.$otitle.'">
        <input type="hidden" id="onumber" value="'.$row->order_number.'">
        <input type="hidden" id="ototal" value="'.$ototal.'"><td>';
        if($row->bulk == 1){
          $html_data .= '<a href="'.base_url('shipment/viewchallan/'.$row->challan_number).'" target="_blank" class="btn btn-flat btn-primary add" style="margin-left: 5px;"><i class="fa fa-print"></i></a>';
        }else{
          $html_data .= '<a href="'.base_url('shipment/printchallan/'.$row->order_number).'" target="_blank" class="btn btn-flat btn-primary add" style="margin-left: 5px;"><i class="fa fa-print"></i></a>';
        }
        $html_data .= '</td></tr>';
      }
    }
?>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('shipment/shipingreport');?>" method="post" autocomplete="off">
            <div class="col-md-3">
              <label>From Date</label>
              <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
            </div>

            <div class="col-md-3">
              <label>To Date</label>
              <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
            </div>
            <div class="col-md-12">
              <br />
              <input type="submit" class="btn btn-primary pull-right" value="Get Orders" />
            </div>
          </div>
        </form>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
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
              <?php
               if($this->session->userdata('role') == 'master')
                  echo '<div class="col-md-3"></div>';
                else
                  echo '<div class="col-md-4"></div>';
              ?>

              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <div class="info-box-content">
                    <span class="info-box-text">Total Units</span>
                    <span class="info-box-number"><?= number_format($total_units);?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="info-box">
                  <div class="info-box-content">
                    <span class="info-box-text">Challans Genrated</span>
                    <span class="info-box-number"><?= number_format($total_challans);?></span>
                  </div>
                </div>
              </div>
              <?php if($this->session->userdata('role') == 'master'){ ?>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <div class="info-box-content">
                        <span class="info-box-text">Total Value</span>
                        <span class="info-box-number"><?= number_format($total_amt, 2);?></span>
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
              <table class="table table-bordered datatable_btn table-hover">
                <thead>
                  <tr>
                    <th width="10">Sr.no</th>
                    <th width="150">Order No #</th>
                    <th width="350">Order Date</th>
                    <th width="250">Due Date</th>
                    <th>Client</th>
                    <th>Patient</th>
                    <th>Order Status</th>
                    <th>Products</th>
                    <th>Priority</th>
                    <th width="150">Case No #</th>
                    <th width="350">Challan No #</th>
                    <th width="350">Challan Date</th>
                    <th width="350">Challan Status</th>
                    <th width="250">Delay Days</th>
                    <?php
                     if($this->session->userdata('role') == 'master')
                     echo '<th>Order Value</th>';
                     ?>
                    <th width="250">Zone</th>
                    <th width="250"></th>
                  </tr>
                </thead>
                <tbody>
                  <?= $html_data;?>
                </tbody>
              </table>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>
