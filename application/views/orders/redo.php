<style>
  hr{
    margin-top: 0px !Important;
    margin-bottom: 15px !Important;
  }

  .modal-title{
    float: left;
  }

  .btn_t_s{
    border: 2px solid green !important;
    border-radius: 50% !important; 
    padding: 5px !important;
  }

  .btn_t{
    cursor: pointer;
  }

  .mbt{
    margin-bottom: 0px !important;
  }

</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <table class="table table-bordered pull-left" style="margin-bottom: 0px; width: 350px;background: #f4f4f4; font-weight: bold;">
          <tr>
            <td><?= ucfirst($wt);?> Order</td>
            <td><?= $order->order_number;?></td>
          </tr>
        </table>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Select Product</button>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <form action="#" method="post" class="" autocomplete="off">
          <input type="hidden" name="clientid" id="clientid" value="<?= $order->client_code;?>">
          <input type="hidden" id="order_number" name="order_number" value="<?= $order->order_number;?>" />
          <!-- <input type="hidden" id="order_id" name="order_id" value="<?= $order->oid;?>" /> -->
          <!-- Client Informarion -->
          <div class="row">
            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr><td>Client Name</td><td colspan=2><?= ucfirst(getclientname($order->client_code))?></td></tr>
              </table>
              <table class="table table-bordered mbt">
                <tr>
                  <td><?= ucfirst($wt);?> <input type="radio" name="worktype" id="worktype" value="<?= $wt;?>" checked/></td>
                </tr>
              </table>
              <table class="table table-bordered mbt">
                <tr><td>Case No</td><th><input type="text" id="modalno" name="modalno" class="form-control" value="<?= $order->modal_no;?>" readonly></th></tr>

                <tr><td width="110">Patient Name</td><th style="display: inline-flex"><input type="text" style="width: 80%;" id="patientname" name="patientname" class="form-control" placeholder="Patient Name" value="<?= $order->patiant_name;?>"> &nbsp;<input type="text" id="age" name="age" class="form-control" placeholder="Age" style="width: 20%;" value="<?= $order->patient_age;?>"></th></tr>
              </table>
            </div>

            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr>
                    
                  <td colspan="2">
                    <div style="display:inline-flex">
                      <label>FULL Mouth <input type="checkbox" name="fm" id="fm" value="1" /></label>
                      <table  style="margin-left:100px; display:none;" id="loc_tbl">
                          <tr>
                            <td>
                              Local <input type="radio" name="location" class="rlocation" id="location" value="10" />
                              | Pan India <input type="radio" name="location" class="rlocation" id="location" value="15" />
                            </td>
                          </tr>
                      </table>
                    </div>
                  </td>
                </tr>

                <tr>
                  <th class="imp">Priority</th>
                  <td>
                    <select id="priority" name="priority" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (loadoption('priority') as $opt){
                            $sel = ($opt->id == $order->order_priority)?'selected':'';
                            echo '<option value=\''.$opt->id.'\' data-days="'.$opt->days.'" '.$sel.'>'.ucfirst($opt->title).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>

                <tr><td class="imp">Order Date</td>
                  <th style="display: inline-flex">
                    <input type="text" class="form-control" style="width: 50%" placeholder="DD-MM-YYYY"  value="<?= date('d-m-Y')?>" disabled/>&nbsp;
                    <input type="text" id="duetime" name="duetime" class="form-control" style="width: 50%" value="<?= date('H:i')?>" disabled/>
                    <input type="hidden" id="orderdate" name="orderdate" class="form-control" value="<?= date('d-m-Y H:i')?>" readonly>
                  </th>
                </tr>
                <tr>
                  <td class="imp">Due Date</td>
                  <th style="display: inline-flex">
                    <input type="text" id="duedate" name="duedate" class="form-control" style="width: 50%" placeholder="DD-MM-YYYY"  value="<?= date('d-m-Y')?>" readonly required >
                    &nbsp;
                    <input type="text" id="duetime" name="duetime" class="form-control" style="width: 50%" placeholder="HH:MM"  value="<?= date('H:i')?>" readonly required >
                    <!-- <select id="duetime" name="duetime" class="form-control" style="width: 50%" required>
                      <option value='M'>Morning</option>   
                      <option value='A'>Afternoon</option>   
                      <option value='E'>Evening</option>   
                    </select> -->
                  </th>
                </tr>
                <tr>
                  <td class="imp">In Date</td>
                  <th style="display: inline-flex">
                    <input type="text" id="indate" name="indate" class="form-control" style="width: 50%" value="<?= date('d-m-Y')?>" placeholder="DD-MM-YYYY" readonly required>
                    &nbsp;
                    <input type="text" id="intime" name="intime" class="form-control" style="width: 50%" value="<?= date('H:i')?>" placeholder="HH:MM" readonly required>
                  <!--  <select id="intime" name="intime" class="form-control" style="width: 50%" required>
                      <option value='M'>Morning</option>   
                      <option value='A'>Afternoon</option>   
                      <option value='E'>Evening</option>   
                    </select> -->
                  </th>
                </tr>
              </table>
            </div>

            <div class="col-md-4">
              <table class="table table-bordered">
                <tr>
                  <th>Additional Amount</th>
                  <td><input type="text" id="additionalamount" name="additionalamount" class="form-control" value="<?= $order->add_amount;?>"></td>
                </tr>
                <tr>
                  <th>Jaw Type</th>
                  <td>
                    <select id="delivery" name="delivery" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <option value="Anterior" <?= ($order->delivery_method == 'Anterior')?'selected':'';?>> Anterior </option>
                      <option value="Posterior" <?= ($order->delivery_method == 'Posterior')?'selected':'';?>> Posterior </option>
                      <option value="Ant&Post" <?= ($order->delivery_method == 'Ant&Post')?'selected':'';?>> Anterior + Posterior </option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>
                    <select id="status" name="status" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (loadoption('status') as $opt){
                              $sel = ($opt->id == $order->order_status)?'selected':'';
                              echo '<option value=\''.$opt->id.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                            }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Pan/Tray#</th>
                  <td>
                    <select id="pan_tray" name="pan_tray" class="form-control">
                      <option value="Partial Tray" <?= ($order->pan_try=="Partial Tray")?"selected":"";?>>Partial Tray</option>
                      <option value="Full Tray" <?= ($order->pan_try=="Full tray")?"selected":"";?>>Full tray </option>
                      <option value="Triple Tray" <?= ($order->pan_try=="Triple tray")?"selected":"";?>>Triple tray</option>
                    </select>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <br>

          <!-- Row 2 -->
          <div class="row">
            <!-- Col One -->
            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr>
                  <th>Shade1</th>
                  <th>Shade2</th>
                  <th>Shade3</th>
                </tr>
                <tr>
                  <td>
                    <select id="shade1" name="shade1" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                        foreach (getshades('shade') as $opt){
                          $sel = ($opt->code == $order->shade_one)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select id="shade2" name="shade2" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                        foreach (getshades('shade') as $opt){
                          $sel = ($opt->code == $order->shade_two)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select id="shade3" name="shade3" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                        foreach (getshades('shade') as $opt){
                          $sel = ($opt->code == $order->shade_three)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                </tr>
              </table>
              <table class="table table-bordered mbt">
                <tr>
                  <th>Shade Note</th>
                  <td>
                    <input type="text" id="shadenote" name="shadenote" class="form-control" placeholder="Shade Notes" value="<?= $order->shade_note;?>">
                  </td>
                </tr>
                <tr>
                  <th>Articulator Tag</th>
                  <td>
                    <select id="articulatortag" name="articulatortag" class="form-control">
                      <option value=""> --- </option>
                      <option value="1" <?= ($order->articulary_tag == 1)?'selected':''?>>By RPD</option>
                      <option value="2" <?= ($order->articulary_tag == 2)?'selected':''?>>By Doctor</option>
                      <option value="3" <?= ($order->articulary_tag == 3)?'selected':''?>>None</option>
                    </select>
                  </td>
                </tr>
              </table>
              <table class="table table-bordered mbt">
                <tr>
                  <th>SubDoctor</th>
                  <th width="60">
                    <i class="fa fa-search" data-toggle="modal" data-target="#modal-default4" style="cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;
                    <i class="fa fa-plus" data-toggle="modal" data-target="#modal-default2" style="cursor: pointer;"></i>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <input type="text" name="docname" id="docname" value="<?= $order->doctor  ;?>" class="form-control">
                  </td>
                </tr>
              </table>
            </div>

            <!-- Col Two -->
            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr>
                  <th colspan="2">Correction Tamplate</th>
                </tr>
                <tr>
                  <td colspan="2">
                    <select id="correction_tamp" name="correction_tamp" class="form-control select2">
                      <option value=""> --- </option>
                      <?php 
                        foreach (correction_tamp() as $opt){
                          $sel = ($opt->code == $order->correction_tamp)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <label>Note</label>
                    <textarea id="anote" name="anote" class="form-control"><?= $order->note;?></textarea>
                  </td>
                </tr>
                <tr>
                  <th>Drop Location</th>
                  <th width="60">
                    <i class="fa fa-search" data-toggle="modal" data-target="#modal-default5" style="cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;
                    <i class="fa fa-plus" data-toggle="modal" data-target="#modal-default3" style="cursor: pointer;"></i>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <input type="text" name="paddress" id="paddress" value="Primary location" class="form-control">
                  </td>
                </tr>
              </table>
            </div>

            <!-- Col Three -->
            <div class="col-md-4">
              <table class="table table-bordered">

                <tr>
                  <th>Enclosure</th>
                  <th width="60">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus" data-toggle="modal" data-target="#modal-default1" style="cursor: pointer;"></i></th>
                </tr>
                <tr>
                  <td colspan="2">
                    <p id="enclosure" name="enclosure" value="" class="drp">
                      <?php
                        $en = json_decode($order->enclosure, true);
                        if(!empty($en)){
                          foreach($en as $e => $v){
                            $key = explode(':', $v);
                            echo $key[0].':'.$key[1].', ';
                          }
                        }
                      ?>
                    </p>
                    <input type="hidden" id="finalenclosure" name="finalenclosure" value='<?= $order->enclosure;?>' class="form-control" />
                  </td>
                </tr>
                <tr>
                  <th>Manufacturer</th>
                  <td>
                    <select id="manufacturer" name="manufacturer" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (loadoption('manufacturer') as $opt){
                            $sel = ($opt->id == $order->manufacture)?'selected':'';
                            echo '<option value=\''.$opt->id.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Lab Department</th>
                  <td>
                    <select id="dept" name="dept" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (getlabdepartment('labdepartment') as $opt){
                            $sel = ($opt->code == $order->department)?'selected':'';
                            echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Employee</th>
                  <td>
                    <select id="assignto" name="assignto" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (emplyeesopt('employee') as $opt){
                            $sel = ($opt->code == $order->assign)?'selected':'';
                            echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->name).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          
          <br />

          <!-- Row 3 -->
          <div class="row">
            
            <!-- Product Table -->
            <div class="col-md-2">
              <table class="table table-bordered">
                <?php
                    $os = get_order_shadules($order->oid);
                    $osarry = [];
                    foreach ($os as $a){
                      $osarry[] = [
                        'id' => $a->title,
                        'date'=> $a->sch_date, 
                        'sts' => $a->status 
                      ];
                    }
                  ?>
                  <tbody>
                    <tr>
                      <td>1 Wax Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 1){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="1" class="form-control datepicker schedules" data-id="1" name="schedules[]" value="'.$date.'">';
                        ?>
                         <input id="ssts1" type="checkbox" value="1" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>2 Metal Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 2){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="2" class="form-control datepicker schedules" data-id="2" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts2" type="checkbox" value="2" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>3 Coping Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 3){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="3" class="form-control datepicker schedules" data-id="3" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts3" type="checkbox" value="3" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>4 Bisque Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 4){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="4" class="form-control datepicker schedules" data-id="4" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts4" type="checkbox" value="4" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>5 Jig Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 5){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="5" class="form-control datepicker schedules" data-id="5" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts5" type="checkbox" value="5" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>

                    <tr>
                      <td>6 Final</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 6){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="6" class="form-control datepicker schedules" data-id="6" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts6" type="checkbox" value="6" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>7 Setting Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 7){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="7" class="form-control datepicker schedules" data-id="7" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts7" type="checkbox" value="7" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>8 Special Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 8){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="8" class="form-control datepicker schedules" data-id="8" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts8" type="checkbox" value="8" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>
                    <tr>
                      <td>9 Bite Trial</td>
                      <td>
                        <?php
                          $date = '';
                          $sts = 0;
                          foreach ($os as $a){
                            if($a->title == 9){
                              // $date = date('d-m-Y', strtotime($a->sch_date));
                              $sts = true;//$a->status;
                            }
                          }
                          echo '<input type="hidden" value="9" class="form-control datepicker schedules" data-id="9" name="schedules[]" value="'.$date.'">';
                        ?>
                        <input id="ssts9" type="checkbox" value="9" <?= ($sts)?"checked=\"checked=\"":""?>/>
                      </td>
                    </tr>

                  </tbody>
              </table>
            </div>

            <?php 
                $op = get_order_products($order->oid);
                $teeth = [];
                foreach ($op as $o){
                  foreach (explode(',', $o->teeth) as $t)
                  $teeth[] = $t;
                }
              ?>
            <div class="col-md-10">
              <table class="table table-bordered" id="teeth" style="text-align: center;">
                <tbody>
                  <tr>
                    <td class="btn_t1"><b id="t_18">18</b></td>
                    <td class="btn_t1"><b id="t_17">17</b></td>
                    <td class="btn_t1"><b id="t_16">16</b></td>
                    <td class="btn_t1"><b id="t_15">15</b></td>
                    <td class="btn_t1"><b id="t_14">14</b></td>
                    <td class="btn_t1"><b id="t_13">13</b></td>
                    <td class="btn_t1"><b id="t_12">12</b></td>
                    <td class="btn_t1"><b id="t_11">11</b></td>
                    <td class="btn_t1"><b id="t_21">21</b></td>
                    <td class="btn_t1"><b id="t_22">22</b></td>
                    <td class="btn_t1"><b id="t_23">23</b></td>
                    <td class="btn_t1"><b id="t_24">24</b></td>
                    <td class="btn_t1"><b id="t_25">25</b></td>
                    <td class="btn_t1"><b id="t_26">26</b></td>
                    <td class="btn_t1"><b id="t_27">27</b></td>
                    <td class="btn_t1"><b id="t_28">28</b></td>
                  </tr>
                  <tr>
                    <td class="btn_t1"><b id="t_48">48</b></td>
                    <td class="btn_t1"><b id="t_47">47</b></td>
                    <td class="btn_t1"><b id="t_46">46</b></td>
                    <td class="btn_t1"><b id="t_45">45</b></td>
                    <td class="btn_t1"><b id="t_44">44</b></td>
                    <td class="btn_t1"><b id="t_43">43</b></td>
                    <td class="btn_t1"><b id="t_42">42</b></td>
                    <td class="btn_t1"><b id="t_41">41</b></td>
                    <td class="btn_t1"><b id="t_31">31</b></td>
                    <td class="btn_t1"><b id="t_32">32</b></td>
                    <td class="btn_t1"><b id="t_33">33</b></td>
                    <td class="btn_t1"><b id="t_34">34</b></td>
                    <td class="btn_t1"><b id="t_35">35</b></td>
                    <td class="btn_t1"><b id="t_36">36</b></td>
                    <td class="btn_t1"><b id="t_37">37</b></td>
                    <td class="btn_t1"><b id="t_38">38</b></td>
                  </tr>
                </tbody>
              </table>

              <label>Products</label>
              <div class="row">
                <div class="col-md-12">
                  <div id="addedproducts">
                      
                    <table class="table table-bordered">
                    <tbody>
                      <?php foreach ($op as $o){
                        $ab[] = [
                          'cdiscount' => $o->discount,
                          'product' => ['id' => $o->product_id, 'title' => get_title($o->product_id, 'product')],
                          'productcategory' => ['id' => $o->product_category, 'title' => get_title($o->product_category, 'productcategory')],
                          'producttype' => ['id' => $o->product_type, 'title' => get_title($o->product_type, 'producttype')],
                          'rx' => json_decode($o->options, true),
                          'teethcount' => $o->teeth,
                          'total' => $o->total_amount,
                          'unit' => $o->unit,
                          'unitrate' => $o->unit_price,
                        ];
                      ?>


                      <tr>
                        <th>Product Category</th>
                        <th>Product Type</th>
                        <th>Product</th>
                        <th>Teeth</th>
                        <th>Units</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th></th>
                      </tr>
                      <tr>
                        <td><?= $o->product_category;?></td>
                        <td><?= $o->product_type;?></td>
                        <td><?= $o->product_id;?></td>
                        <td><?= $o->teeth;?></td>
                        <td><?= $o->unit;?></td>
                        <td><?= $o->unit_price;?></td>
                        <td><?= $o->total_amount;?></td>
                        <td><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></td>
                      </tr>
                      <tr>
                        <td colspan="8">
                          <?php 
                            $opt = json_decode($o->options);
                            foreach ($opt as $p){
                              echo '<label>'.$p->title.'</label> : '.$p->sel.', ';
                            }
                          ?>
                          </td>
                      </tr>
                      
                      <?php } ?>
                    
                    </tbody>
                  </table>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Row 4 -->
          <div class="row">
            <div class="col-md-12">
              <input type="button" class="btn btn-primary pull-right redu_order" value="Submit" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade-in" id="modal-default">
  <div class="modal-dialog p" style="width: 750px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body m1">
        <div class="row">
          <div class="form-group col-md-4">
            <label>Product Category</label>
            <select id="productcategory" name="productcategory" class="form-control">
              <option value=""> --- </option>
              <?php 
                foreach (loadoption('productcategory') as $pc){
                  echo '<option value="'.$pc->code.'">'.$pc->title.'</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label>Product Type</label>
            <select id="producttype" name="producttype" class="form-control ptyps"></select>
          </div>
          <div class="form-group col-md-4">
            <label>Product List</label>
            <select id="product" name="product" class="form-control products">
            </select>
          </div>
          <input type="hidden" name="poption" id="poption">
        </div>

        <div class="row">
          <div class="col-md-12">
            <b>Select Teeth</b>
            <table class="table table-bordered" id="teeth" style="text-align: center;">
              <tbody>
                <tr>
                  <td><b class="btn_t">18</b></td>
                  <td><b class="btn_t">17</b></td>
                  <td><b class="btn_t">16</b></td>
                  <td><b class="btn_t">15</b></td>
                  <td><b class="btn_t">14</b></td>
                  <td><b class="btn_t">13</b></td>
                  <td><b class="btn_t">12</b></td>
                  <td><b class="btn_t">11</b></td>
                  <td><b class="btn_t">21</b></td>
                  <td><b class="btn_t">22</b></td>
                  <td><b class="btn_t">23</b></td>
                  <td><b class="btn_t">24</b></td>
                  <td><b class="btn_t">25</b></td>
                  <td><b class="btn_t">26</b></td>
                  <td><b class="btn_t">27</b></td>
                  <td><b class="btn_t">28</b></td>
                </tr>
                <tr>
                  <td><b class="btn_t">48</b></td>
                  <td><b class="btn_t">47</b></td>
                  <td><b class="btn_t">46</b></td>
                  <td><b class="btn_t">45</b></td>
                  <td><b class="btn_t">44</b></td>
                  <td><b class="btn_t">43</b></td>
                  <td><b class="btn_t">42</b></td>
                  <td><b class="btn_t">41</b></td>
                  <td><b class="btn_t">31</b></td>
                  <td><b class="btn_t">32</b></td>
                  <td><b class="btn_t">33</b></td>
                  <td><b class="btn_t">34</b></td>
                  <td><b class="btn_t">35</b></td>
                  <td><b class="btn_t">36</b></td>
                  <td><b class="btn_t">37</b></td>
                  <td><b class="btn_t">38</b></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="col-md-3">
            <label>Teeth</label>
            <input type="text" id="teethcount" name="teethcount" class="form-control" readonly="true">
          </div>
          <div class="col-md-3">
            <label>Units</label>
            <input type="text" id="unit" name="unit" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Unit Rate</label>
            <input type="text" id="unitrate" name="unitrate" class="form-control" />
            <input type="hidden" id="cdiscount" name="cdiscount" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Total</label>
            <input type="text" id="total" name="total" class="form-control" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <br /><hr />
            <b>Product Option</b>
            <p></p> <hr />
            <div class="row">
              <?php 
                foreach (loadrxoptions() as $x){
                  echo '<div class="col-md-4 form-group" class="rxall" id="rx'.$x['id'].'" style="display:none">
                    <label id="rxl'.$x['id'].'">'.$x['label'].'</label>
                    <select name="option[]" class="form-control selopt" id="rxs'.$x['id'].'" data-id ="'.$x['id'].'">';
                      echo '<option value=""> --- </option>';
                    foreach ($x['options'] as $y){
                      echo '<option value="'.$y['id'].'">'.$y['option'].'</option>';
                    }
                  echo '</select></div>';
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" id="btnproduct" class="btn btn-primary">Save &amp; Add New</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade-in" id="modal-default1">
  <div class="modal-dialog">
      <div id="adden" class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Select Enclosures</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <?php 
                  $enc = ['Abutments', 'Bite', 'CAD CAM Files', 'Facebow Articulator', 'Imp Post', 'Impression Lower','Impression Upper','Lab Analogue','Model Lower','Model Upper', 'Photos', 'Crown Received'];
                ?>
                <table class="table table-bordered">
                  <?php 
                    $en = json_decode($order->enclosure, true);
                    $tmp = 0;
                    for($q=0; $q < sizeof($enc); $q++){
                      if(!empty($en)){
                        foreach($en as $e => $v){
                          $key = explode(':', $v);
                          // $key = array_keys($v);
                          if($enc[$q] == $key[0]){
                            $s = "checked";
                            $t = $key[1];
                            echo '<tr>
                                <td><input '.$s.' type="checkbox" name="type" data-value="'.$enc[$q].'" data-id="'.($q+1).'" ></td>
                                <td>'.$enc[$q].'</td>
                                <td><input type="text" id="en'.($q+1).'" value="'.$t.'"/></td>
                              </tr>';
                              $tmp = 1;
                          }
                        }

                        if($tmp == 1){
                          $tmp =0;
                          continue;
                        }

                      }
                      echo '<tr>
                          <td><input type="checkbox" name="type" data-value="'.$enc[$q].'" data-id="'.($q+1).'" ></td>
                          <td>'.$enc[$q].'</td>
                          <td><input type="text" id="en'.($q+1).'" value=""/></td>
                        </tr>';
                    }
                  ?>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <a href="#" id="btnAdd" class="btn btn-primary">Add Selected Enclosure</a>
          </div>

      </div>
      <div id="storeen" class="modal-content" style="display: none;">
          <div class="modal-header">

              <h5 class="modal-title">Edit Enclosures</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="tab-content">
                    <thead>
                      <tr>
                        <th>Sr.no</th>
                        <th>Name</th>
                        <th>Count</th>                                            
                      </tr>
                    </thead>
                    <tbody id="addedenclosure"></tbody>
                  </table>
                </div>
              </div>
              <div></div>
          </div>
          <div class="modal-footer">
              <a href="#" id="btnstore" class="btn btn-primary">Add Enclosure</a>

          </div>

      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade-in" id="modal-default2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Name</label>
            <input type="text" name="adoctorname" id="adoctorname" class="form-control">
          </div>
          <div class="col-md-12">
            <label>Contact</label>
            <input type="text" name="adcontact" id="adcontact" class="form-control">
          </div>
          <div class="col-md-12">
            <label>Design Preferences</label>
            <input type="text" name="adp" id="adp" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="addsubdoc" class="btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade-in" id="modal-default3">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Client Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
              <label>Name</label>
              <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Contact Person</label>
              <input type="text" name="contactperson" id="contactperson" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Office Conatct No</label>
              <input type="text" name="officecontact" id="officecontact" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Conatct No</label>
              <input type="text" name="contactno" id="contactno" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Address</label>
              <input type="text" name="address" id="address" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Country</label>
              <select name="country" id="country" class="form-control"><option value=""> -- Select -- </option><option value="1">India</option><option value="2">United States</option></select>
              </div>
            <div class="col-md-6">
              <label>State</label>
              <select name="state" id="state" class="form-control"></select>
            </div>
            <div class="col-md-6">
              <label>City</label>
              <select name="city" id="city" class="form-control"></select>
            </div>
            <div class="col-md-6">
              <label>Area</label>
              <input type="text" name="area" id="area" class="form-control">
            </div>
            <div class="col-md-6">
              <label>Pincode</label>
              <input type="text" name="pincode" id="pincode" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnaddress" class="btn btn-primary">Add</button>
      </div>
    </div>
    </div>
</div>

<div class="modal fade-in" id="modal-default4">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <select id="doctorlist" name="doctorlist" class="form-control">
              <option value=""> --- </option>
              <?php
                foreach ($docs as $d){
                  echo '<option value="'.$d->name.'">'.$d->name.'</option>';
                }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" data-toggle="modal" data-target="#modal-default2"><i class="btn btn-danger fa fa-plus"> Add New Doctor</i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade-in" id="modal-default5">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left">Select Primary Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <select id="clientaddress" name="clientaddress" class="form-control">
              <option value=""> -- Select -- </option>
              <option value="1">test</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" data-toggle="modal" data-target="#modal-default3"><i class="btn btn-danger fa fa-plus"> Add New address</i></a>
      </div>
    </div>
  </div>
</div>

<script>
  var abc = <?php echo json_encode($ab);?>;
  var osar = <?php echo json_encode($osarry);?>;
</script>
