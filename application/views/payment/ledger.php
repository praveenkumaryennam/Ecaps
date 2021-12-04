<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('payment/ledger');?>" method="post" autocomplete="off">
            <div class="col-md-3">
              <label>From Date</label>
              <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
            </div>

            <div class="col-md-3">
              <label>To Date</label>
              <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>" />
            </div>

            <div class="col-md-3">
              <label>By Clicent</label>
              <select class="form-control select2" name="client">
                <option value=""> --- </option>
                <?php
                  foreach (loadoption('clients') as $p){
                    if(!empty($arr['client'])){
                      $sel = ($arr['client'] == $p->id)?"selected":"";
                      echo '<option value="'.$p->id.'" '.$sel.'>'.$p->clientname.'</option>';
                    }
                    else
                      echo '<option value="'.$p->id.'">'.$p->clientname.'</option>';
                  }
                ?>
              </select>
            </div>

            <div class="col-md-12">
              <br />
              <input type="submit" class="btn btn-primary pull-right" value="Submit" />
            </div>
          </form>
        </div> 
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <table class="table table-bordered table-hover" style="background: #f4f4f4;">
              <tr>
                <th>Client Name</th>
                <td><?= getclientname($arr['client']); ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th></th>
                    <th>Paticular</th>
                    <th>Vch Type</th>
                    <th>Debit</th>
                    <th>Credit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $tdebit = 0;
                    $tcreadit = 0;
                    $op = 1;
                    foreach($ledger as $l => $v){ 
                  ?>
                    <tr>
                      <td><?= $l;?></td>
                      <td>
                        <table>
                          <?php foreach($v as $a => $m){ ?>
                          <?php $s = sizeof($m); for($k=0; $k<$s; $k++){ ?>
                            <tr>
                              <td><?= $a?></td>
                            </tr>
                          <?php } ?>
                          <?php } ?>
                        </table>
                      </td>
                      <td>
                        <table>
                          <?php foreach($v as $a => $m){ ?>
                            <tr>
                              <td><?php
                                if($a == "CR"){
                                  foreach($m as $in){
                                    echo $in->invoice_number.' - '.$in->payment_mode;
                                    echo '<br />';
                                  }
                                }

                                if($a == "DR"){
                                  foreach($m as $in){
                                    echo $in->invoice_number;
                                    echo '<br />';
                                  }
                                }

                              ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td>
                        <table>
                          <?php foreach($v as $a => $m){ ?>
                            <tr>
                              <td><?php
                                if($a == "CR"){
                                  foreach($m as $in){
                                    echo 'Receipt';
                                    echo '<br />';
                                  }
                                }

                                if($a == "DR"){
                                  foreach($m as $in){
                                    echo 'Sales';
                                    echo '<br />';
                                  }
                                }

                              ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>                    
                      <td>
                        <table>
                          <?php foreach($v as $a => $m){ ?>
                            <tr>
                              <td><?php
                                if($a == "CR"){
                                  foreach($m as $in){
                                    $tdebit += $in->paid_amount;
                                    echo number_format($in->paid_amount,2);
                                    echo '<br />';
                                  }
                                }

                                if($a == "DR"){
                                  foreach($m as $in){
                                    echo '---';
                                    echo '<br />';
                                  }
                                }

                              ?></td>
                            </tr>
                          <?php } ?>
                        </table>                      
                      </td>                    
                      <td>
                        <table>
                          <?php foreach($v as $a => $m){ ?>
                            <tr>
                              <td><?php
                                if($a == "CR"){
                                  foreach($m as $in){
                                    echo '---';
                                    echo '<br />';
                                  }
                                }

                                if($a == "DR"){ foreach($m as $in){
                                  $tcreadit += $in->invoice_total;
                                  echo number_format($in->invoice_total,2);
                                  echo '<br />'; 
                                } 
                              }
                              ?></td>
                            </tr>
                          <?php } ?>
                        </table>                      
                      </td>                    
                    </tr>
                  <?php } ?>

                  <tr>
                    <td colspan="4"></td>
                    <td><?= number_format($tdebit, 2);?></td>
                    <td><?= number_format($tcreadit, 2);?></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>
