<style>
  hr{
    margin-top: 0px !important;
    margin-bottom: 15px !important;
  }

  .modal-title{
    float: left;
  }

  .btn_r{
  	    border: 2px solid #000;
	    border-radius: 50%;
	    padding: 2px;
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
            <td><?= ucfirst($order->work_type);?> Order</td>
            <td><?= $order->order_number;?></td>
          </tr>
        </table>
        <table class="table table-bordered pull-right" style="margin-bottom: 0px; width: 350px;background: #f4f4f4; font-weight: bold;">
          <tr>
            <td>Order Taken : <?= aemp_name($order->added_by);?></td>
            <td>Order Updated : <?= aemp_name($order->updated_by);?></td>
          </tr>          
        </table>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
          <!-- Client Informarion -->
          <div class="row">
            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr><td>Client Name</td><td colspan=2><?= ucfirst(getclientname($order->client_code))?></td></tr>
              </table>
              <table class="table table-bordered mbt">
                <tr>
                  <td><?= ucfirst($order->work_type);?> <input type="radio" class="worktype" id="worktype" name="worktype" value="<?= $order->work_type;?>" checked/></td>
                </tr>
              </table>
              <table class="table table-bordered mbt">
                <tr><td>Case No</td><th><input type="text" id="modalno" name="modalno" class="form-control" value="<?= $order->modal_no;?>" readonly></th></tr>

                <tr><td width="110">Patient Name</td><th style="display: inline-flex"><input type="text" style="width: 80%;" id="patientname" name="patientname" class="form-control" placeholder="Patient Name" value="<?= $order->patiant_name;?>"> &nbsp;<input type="text" id="age" name="age" class="form-control" placeholder="Age" style="width: 20%;" value="<?= $order->patient_age;?>"></th></tr>
                <tr>
                  <th>Priority</th>
                  <td>
                    <select id="priority" name="priority" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (loadoption('priority') as $opt){
                            $sel = ($opt->id == $order->order_priority)?'selected':'';
                            echo '<option value=\''.$opt->id.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr><td>Order Date</td><th width="300"><input type="text" id="orderdate" name="orderdate" class="form-control datepicker" value="<?= date('d-m-Y h:i A', strtotime($order->order_date));?>"></th></tr>
                <tr>
                  <td>Due Date</td>
                  <th style="display: inline-flex">
                    <input type="text" id="duedate" name="duedate" class="form-control" value="<?= date('d-m-Y', strtotime($order->due_date));?>" style="width: 50%" required> &nbsp;

                    <?php 
                      if(strlen($order->duetime) > 1){
                        echo '<input type="text" id="duedate" name="duedate" class="form-control datepicker" value="'.date('h:i A', strtotime($order->duetime)).'" style="width: 50%" required>';
                      }else{
                    ?>
                      <select id="duetime" name="duetime" class="form-control" style="width: 50%" required>
                        <option value="M" <?= (strtoupper($order->duetime) == strtoupper('M'))?'selected':'';?>>Morning</option>   
                        <option value="A" <?= (strtoupper($order->duetime) == strtoupper('A'))?'selected':'';?>>Afternoon</option>   
                        <option value="E" <?= (strtoupper($order->duetime) == strtoupper('E'))?'selected':'';?>>Evening</option> 
                      </select>
                    <?php 
                      }
                    ?>
                  </th>
                </tr>
                <tr>
                  <td>In Date</td>
                  <th style="display: inline-flex">
                    <input type="text" id="indate" name="indate" class="form-control datepicker" value="<?= date('d-m-Y', strtotime($order->in_date));?>" style="width: 64%" required> &nbsp;
                    <?php 
                      if(strlen($order->intime) > 1){
                        echo '<input type="text" id="intime" name="intime" class="form-control" value="'.date('h:i A', strtotime($order->intime)).'" style="width: 64%" required>';
                      }else{
                    ?>
                      <select id="intime" name="intime" class="form-control" style="width: 50%" required>
                        <option value="M" <?= (strtoupper($order->intime) == strtoupper('M'))?'selected':'';?>>Morning</option>   
                        <option value="A" <?= (strtoupper($order->intime) == strtoupper('A'))?'selected':'';?>>Afternoon</option>   
                        <option value="E" <?= (strtoupper($order->intime) == strtoupper('E'))?'selected':'';?>>Evening</option>  
                      </select>
                     <?php 
                      }
                    ?>
                  </th>
                </tr>
                <tr>
                  <th>Enclosure</th>
                  <th width="60"></th>
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
                    <input type="hidden" id="finalenclosure" name="finalenclosure" value="<?= json_encode($order->enclosure);?>" class="form-control" />
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-md-4">
              <table class="table table-bordered">
                <tr>
                  <th>Additional Amount</th>
                  <td><input type="text" id="additionalamount" name="additionalamount" class="form-control" value="<?= $order->add_amount;?>"></td>
                </tr>
<!--                 <tr>
                  <th>Delivery Method</th>
                  <td>
                    <select id="delivery" name="delivery" class="form-control select2" style="width:100%;">
                        <option value=""> --- </option>
                        <?php 
                            foreach (loadoption('delivery_method') as $opt){
                              $sel = ($opt->id == $order->delivery_method)?'selected':'';
                                echo '<option value=\''.$opt->id.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                            }
                        ?>
                    </select>
                  </td>
                </tr> -->
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
          <hr />

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
                  <th>Assign To</th>
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
                  <th>Department</th>
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
                    <select id="dept" name="dept" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (getlabdepartment('labdepartment') as $opt){
                            echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
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
                <tbody>
                <?php 
                    $os = get_order_shadules($order->oid);
                    

                    $osarry = [];

					foreach (trails_process() as $k) {
                    	$chk = false;
                    	foreach ($os as $a) {
	                      	$chk = ($k['id'] == $a->title)?"checked":"";
	                    }
                      	echo '<tr>
                          <td>'.$k['id'].' '.$k['value'].'</td>
                          <td><input type="checkbox" '.$chk.' /></td>
                        </tr>';
                    }
                   ?>
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
                    <td><b class="<?= (in_array(18, $teeth))?"btn_r":'';?>" id="t_18">18</b></td>
                    <td><b class="<?= (in_array(17, $teeth))?"btn_r":'';?>" id="t_17">17</b></td>
                    <td><b class="<?= (in_array(16, $teeth))?"btn_r":'';?>" id="t_16">16</b></td>
                    <td><b class="<?= (in_array(15, $teeth))?"btn_r":'';?>" id="t_15">15</b></td>
                    <td><b class="<?= (in_array(14, $teeth))?"btn_r":'';?>" id="t_14">14</b></td>
                    <td><b class="<?= (in_array(13, $teeth))?"btn_r":'';?>" id="t_13">13</b></td>
                    <td><b class="<?= (in_array(12, $teeth))?"btn_r":'';?>" id="t_12">12</b></td>
                    <td><b class="<?= (in_array(11, $teeth))?"btn_r":'';?>" id="t_11">11</b></td>
                    <td><b class="<?= (in_array(21, $teeth))?"btn_r":'';?>" id="t_21">21</b></td>
                    <td><b class="<?= (in_array(22, $teeth))?"btn_r":'';?>" id="t_22">22</b></td>
                    <td><b class="<?= (in_array(23, $teeth))?"btn_r":'';?>" id="t_23">23</b></td>
                    <td><b class="<?= (in_array(24, $teeth))?"btn_r":'';?>" id="t_24">24</b></td>
                    <td><b class="<?= (in_array(25, $teeth))?"btn_r":'';?>" id="t_25">25</b></td>
                    <td><b class="<?= (in_array(26, $teeth))?"btn_r":'';?>" id="t_26">26</b></td>
                    <td><b class="<?= (in_array(27, $teeth))?"btn_r":'';?>" id="t_27">27</b></td>
                    <td><b class="<?= (in_array(28, $teeth))?"btn_r":'';?>" id="t_28">28</b></td>
                  </tr>
                  <tr>
                    <td><b class="<?= (in_array(48, $teeth))?"btn_r":'';?>" id="t_48">48</b></td>
                    <td><b class="<?= (in_array(47, $teeth))?"btn_r":'';?>" id="t_47">47</b></td>
                    <td><b class="<?= (in_array(46, $teeth))?"btn_r":'';?>" id="t_46">46</b></td>
                    <td><b class="<?= (in_array(45, $teeth))?"btn_r":'';?>" id="t_45">45</b></td>
                    <td><b class="<?= (in_array(44, $teeth))?"btn_r":'';?>" id="t_44">44</b></td>
                    <td><b class="<?= (in_array(43, $teeth))?"btn_r":'';?>" id="t_43">43</b></td>
                    <td><b class="<?= (in_array(42, $teeth))?"btn_r":'';?>" id="t_42">42</b></td>
                    <td><b class="<?= (in_array(41, $teeth))?"btn_r":'';?>" id="t_41">41</b></td>
                    <td><b class="<?= (in_array(31, $teeth))?"btn_r":'';?>" id="t_31">31</b></td>
                    <td><b class="<?= (in_array(32, $teeth))?"btn_r":'';?>" id="t_32">32</b></td>
                    <td><b class="<?= (in_array(33, $teeth))?"btn_r":'';?>" id="t_33">33</b></td>
                    <td><b class="<?= (in_array(34, $teeth))?"btn_r":'';?>" id="t_34">34</b></td>
                    <td><b class="<?= (in_array(35, $teeth))?"btn_r":'';?>" id="t_35">35</b></td>
                    <td><b class="<?= (in_array(36, $teeth))?"btn_r":'';?>" id="t_36">36</b></td>
                    <td><b class="<?= (in_array(37, $teeth))?"btn_r":'';?>" id="t_37">37</b></td>
                    <td><b class="<?= (in_array(38, $teeth))?"btn_r":'';?>" id="t_38">38</b></td>
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
                        <td><?= get_title($o->product_category, 'productcategory');?></td>
                        <td><?= get_title($o->product_type, 'producttype');?></td>
                        <td><?= get_title($o->product_id, 'product');?></td>
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

      </div>
    </div>
  </div>
</div>

<script>
  $('input').attr('disabled', true);
  $('select').attr('disabled', true);
</script>