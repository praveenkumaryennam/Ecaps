<style>
  $("a.active").parents('li').css("property", "value");
  .txtcen{
    text-align:center !important;
  }
  .txtp{
    padding:2px 10px; 
    text-align:center;
  }

</style>
  <section class="content">
      <div class="row">
        <div class="col-md-5">
          <div class="panel">
            <table class="table table-bordered table-hover">
              <tr>
                <th>Name</th>
                <td><?= strtoupper(client_info($clientid, 'clientname'));?></td>
              </tr>
              <tr>
                <th>DOB :  <?php
                  $d = client_info($clientid, 'dob');
                  echo ($d == '0000-00-00')?"---":date('d-m-Y', strtotime($d));
                 ?></th>
                <th>Anniversary : <?php
                  $d = client_info($clientid, 'anniversarydate');
                  echo ($d == '0000-00-00')?"---":date('d-m-Y', strtotime($d));
                 ?></th>
              </tr>
              <tr>
                <!-- <th>Date of Incorporation :  <?php
                  $d = client_info($clientid, 'anniversarydate');
                  echo ($d == '0000-00-00')?"---":date('d-m-Y', strtotime($d));
                 ?></th> -->
                 <th>Category :  <?php
                  $d = client_info($clientid, 'customercateory');
                 ?></th>
                <th>Practicing since :  <?php
                  $d = client_info($clientid, 'practicingyear');
                  echo ($d == '0000-00-00')?"---":date('Y', strtotime($d));
                 ?></th>
              </tr>
              <tr>
                <th>Address</th>
                <th>Zone : <?php if(client_info($clientid, 'station') > 0){echo strtoupper(get_station_title(client_info($clientid, 'station')));}?></th>
              </tr>
              <tr>
                <th colspan="2"><?= strtoupper(client_info($clientid, 'address'));?></th>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-7">
          <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-first-order"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Orders</span>
              <span class="info-box-number"><?= get_total_orders($clientid);?></span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Sales</span>
              <span class="info-box-number"><?= get_total_sales($clientid);?></span>
            </div>
          </div>
        </div>
        
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-inr"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Collection</span>
              <span class="info-box-number"><?= get_total_collection($clientid);?></span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-handshake-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Correction</span>
              <span class="info-box-number">0</span>
            </div>
          </div>
        </div>
      </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Orders</a></li>
              <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Sales</a></li>
              <li><a href="#tab_3" data-toggle="tab">Correction</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <div class="row">
                  <div class="col-md-12">
                    <div class="panel">
                      <div class="panel-header">
                        <h3 class="panel-title">Order Dashboard</h3>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="datatable_btn display compact" border='1'>
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th colspan="2" class="txtcen">Total</th>
                                    <th colspan="2" class="txtcen">January</th>
                                    <th colspan="2" class="txtcen">February</th>
                                    <th colspan="2" class="txtcen">March</th>
                                    <th colspan="2" class="txtcen">April</th>
                                    <th colspan="2" class="txtcen">May</th>
                                    <th colspan="2" class="txtcen">June</th>
                                    <th colspan="2" class="txtcen">July</th>
                                    <th colspan="2" class="txtcen">August</th>
                                    <th colspan="2" class="txtcen">September</th>
                                    <th colspan="2" class="txtcen">October</th>
                                    <th colspan="2" class="txtcen">November</th>
                                    <th colspan="2" class="txtcen">December</th>
                                  </tr>
                                  <tr>
                                    <th class="txtp">Product</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $produts = get_products();
                                    $cproducts = client_order_report($clientid);
                                    $cpdata = [];
                                    foreach($cproducts as $cp){
                                      if(!empty($cp)){
                                        foreach($cp as $r){
                                          $cpdata[] = $r;
                                        }
                                      }
                                    }
                                    $fp = [];
                                    foreach($produts as $p){
                                      foreach($cpdata as $c){
                                        if($c->pcode == $p->code){
                                          $fp[$p->code]['title'] = $p->title;
                                          $fp[$p->code]['code'] = $p->code;
                                          $fp[$p->code][$c->month] = $c;
                                          $fp[$p->code]['color'] = 'style="background:#bdbdbd;"';
                                        }
                                      }
                                    }

                                    foreach($fp as $g){
                                      echo '<tr>';
                                      echo '<td style="width:160px;">'.$g['title'].' ('.$g['code'].')'.'</td>';
                                      $tu = 0;
                                      $tv = 0;
                                      for($r=1;$r<=12;$r++){
                                        $tu += ((isset($g[$r]))?get_v($g[$r]):0);
                                        $tv += ((isset($g[$r]))?get_v($g[$r], true):0);
                                      }
                                      echo '<td class="txtp">'.$tu.'</td>';
                                      echo '<td class="txtp">'.number_format($tv, 2).'</td>';
                                      for($r=1;$r<=12;$r++){
                                        $u = ((isset($g[$r]))?get_v($g[$r]):0);
                                        $t = ((isset($g[$r]))?get_v($g[$r], true):0);
                                        echo '<td class="txtp">'.$u.'</td>';
                                        echo '<td class="txtp">'.number_format($t, 2).'</td>';
                                      }
                                      echo '</tr>';
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
              </div>
              <div class="tab-pane" id="tab_2">
                <div class="row">
                  <div class="col-md-12">
                    <div class="panel">
                      <div class="panel-header">
                        <h3 class="panel-title">Sales Dashboard</h3>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="datatable_btn display compact" border='1'>
                                <thead>
                                 <tr>
                                    <th></th>
                                    <th colspan="2" class="txtcen">Total</th>
                                    <th colspan="2" class="txtcen">January</th>
                                    <th colspan="2" class="txtcen">February</th>
                                    <th colspan="2" class="txtcen">March</th>
                                    <th colspan="2" class="txtcen">April</th>
                                    <th colspan="2" class="txtcen">May</th>
                                    <th colspan="2" class="txtcen">June</th>
                                    <th colspan="2" class="txtcen">July</th>
                                    <th colspan="2" class="txtcen">August</th>
                                    <th colspan="2" class="txtcen">September</th>
                                    <th colspan="2" class="txtcen">October</th>
                                    <th colspan="2" class="txtcen">November</th>
                                    <th colspan="2" class="txtcen">December</th>
                                  </tr>
                                  <tr>
                                    <th class="txtp">Product</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                    <th class="txtp">Unit</th>
                                    <th class="txtp">Volume</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $aproduts = get_products();
                                    $acproducts = client_report($clientid);
                                    $acpdata = [];
                                    foreach($acproducts as $cp){
                                      if(!empty($cp)){
                                        foreach($cp as $r){
                                          $acpdata[] = $r;
                                        }
                                      }
                                    }
                                    $afp = [];
                                    foreach($aproduts as $p){
                                      foreach($acpdata as $c){
                                        if($c->pcode == $p->code){
                                          $afp[$p->code]['title'] = $p->title;
                                          $afp[$p->code]['code'] = $p->code;
                                          $afp[$p->code][$c->month] = $c;
                                          $fp[$p->code]['color'] = 'style="background:#bdbdbd;"';
                                        }else{
                                          $fp[$p->code]['title'] = $p->title;
                                          $fp[$p->code]['code'] = $p->code;
                                        }
                                      }
                                    }

                                    foreach($fp as $g){
                                      echo '<tr>';
                                      echo '<td style="width:160px;">'.$g['title'].'</td>';
                                     $tu = 0;
                                      $tv = 0;
                                      for($r=1;$r<=12;$r++){
                                        $tu += ((isset($g[$r]))?get_v($g[$r]):0);
                                        $tv += ((isset($g[$r]))?get_v($g[$r], true):0);
                                      }
                                      echo '<td class="txtp">'.$tu.'</td>';
                                      echo '<td class="txtp">'.number_format($tv, 2).'</td>';
                                      for($r=1;$r<=12;$r++){
                                        $u = ((isset($g[$r]))?get_v($g[$r]):0);
                                        $t = ((isset($g[$r]))?get_v($g[$r], true):0);
                                        echo '<td class="txtp">'.$u.'</td>';
                                        echo '<td class="txtp">'.number_format($t, 2).'</td>';
                                      }
                                      echo '</tr>';
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
              </div>
              <div class="tab-pane" id="tab_3">
                <div class="row">
                  <div class="col-md-12">
                    <div class="panel">
                      <div class="panel-header">
                        <h3 class="panel-title">Correction Dashboard</h3>
                      </div>
                      <div class="panel-body"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>