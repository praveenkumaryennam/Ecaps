<style>
  hr{
    margin-top: 0px !Important;
    margin-bottom: 15px !Important;
  }

  .modal-title{
    float: left;
  }

  .btn_t_s{
    background: green !important;
    border-radius: 50% !important; 
    padding: 5px 6px 4px 5px !important;
    color: #fff !important;
  }
  .btn_t{
    cursor: pointer;
  }
  .mbt{
    margin-bottom: 0px !important;
  }
  .imp::after{
    content: '*';
    color: red;
    font-weight: bold;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Orders</h3>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Select Product</button>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <form action="#" method="post" class="" autocomplete="off">
          <input type="hidden" name="clientid" id="clientid" value="<?= $clientid?>">
          <!-- Client Informarion -->
          <!-- Row One -->
          <div class="row">
            <!-- Col One -->
            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr><td>Client Name</td><td colspan=2><?= ucfirst(getclientname($clientid))?></td></tr>
              </table>
              <table class="table table-bordered mbt">
                <tr>
                  <td>New <input type="radio" name="worktype" id="worktype" class="worktype" value="new" checked="checked" required="required" /></td>
<!--                   <td>Redo <input type="radio" name="worktype" id="worktype" class="worktype" value="redo" required="required" /></td>
                  <td>Correction <input type="radio" name="worktype" id="worktype" class="worktype" value="correction" required="required" /></td> -->
                </tr>
              </table>
              <table class="table table-bordered mbt">
                <tr>
                  <td class="imp">Case No</td><th><input type="text" id="modalno" name="modalno" class="form-control" value="<?= case_no();?>" readonly>
                    <span id="err_new" style="color:red; font-size: 10px;"></span></th>
                </tr>
                <tr><td  class="imp" width="110">Patient Name</td><th style="display: inline-flex"><input type="text" style="width: 80%;" id="patientname" name="patientname" class="form-control" placeholder="Patient Name"> &nbsp;<input type="text" id="age" name="age" class="form-control" placeholder="Age" style="width: 20%;"></th></tr>
              </table>
            </div>

            <!-- Col Two -->
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
                            echo '<option value=\''.$opt->id.'\' data-days="'.$opt->days.'">'.ucfirst($opt->title).'</option>';
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
            
            <!-- Col Three -->
            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr>
                  <th>Additional Amount</th>
                  <td><input type="text" id="additionalamount" name="additionalamount" class="form-control"></td>
                </tr>
                <!-- <tr>
                  <th>Delivery Method</th>
                  <td>
                    <select id="delivery" name="delivery" class="form-control select2" style="width:100%;">
                        <option value=""> --- </option>
                        <?php 
                            foreach (loadoption('delivery_method') as $opt){
                              echo '<option value=\''.$opt->id.'\'>'.ucfirst($opt->title).'</option>';
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
                      <option value="Anterior"> Anterior </option>
                      <option value="Posterior"> Posterior </option>
                      <option value="Ant&Post"> Anterior + Posterior </option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th class="imp">Status</th>
                  <td>
                    <select id="status" name="status" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (loadoption('status') as $opt){
                            echo '<option value=\''.$opt->id.'\'>'.ucfirst($opt->title).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Pan/Tray#</th>
                  <td>
                    <select id="pan_tray" name="pan_tray" class="form-control">
                      <option value="Partial Tray">Partial Tray</option>
                      <option value="Full Tray">Full tray </option>
                      <option value="Triple Tray">Triple tray</option>
                    </select>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <br>

          <!-- Row 2 -->
          <div class="row">
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
                          echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select id="shade2" name="shade2" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                        foreach (getshades('shade') as $opt){
                          echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select id="shade3" name="shade3" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                        foreach (getshades('shade') as $opt){
                          echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
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
                    <input type="text" id="shadenote" name="shadenote" class="form-control" placeholder="Shade Notes">
                  </td>
                </tr>
                <tr>
                  <th>Articulator Tag</th>
                  <td>
                    <select id="articulatortag" name="articulatortag" class="form-control">
                      <option value="0">--select--</option>
                      <option value="1">By RPD</option>
                      <option value="2">By Doctor</option>
                      <option value="3">None</option>
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
                    <input type="text" name="docname" id="docname" value="" class="form-control">
                    <!-- <input type="text" name="docname" id="docname" value="<?= $pdoc->name;?>" class="form-control"> -->
                  </td>
                </tr>
              </table>
            </div>

            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr>
                  <th colspan="2">Correction Template</th>
                </tr>
                <tr>
                  <td colspan="2">
                    <select id="correction_tamp" name="correction_tamp" class="form-control select2">
                      <option value=""> --- </option>
                      <?php 
                        foreach (correction_tamp() as $opt){
                          echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <label>Remark</label>
                    <textarea id="anote" name="anote" class="form-control"></textarea>
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

            <div class="col-md-4">
              <table class="table table-bordered mbt">
                <tr>
                  <th>Enclosure</th>
                  <th width="60">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus" data-toggle="modal" data-target="#modal-default1" style="cursor: pointer;"></i></th>
                </tr>
                <tr>
                  <td colspan="2">
                    <p id="enclosure" name="enclosure" value="" class="drp"></p>
                    <input type="hidden" id="finalenclosure" name="finalenclosure" class="form-control" />
                  </td>
                </tr>
                <tr>
                  <th>Manufacturer</th>
                  <td>
                    <select id="manufacturer" name="manufacturer" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (loadoption('manufacturer') as $opt){
                            echo '<option value=\''.$opt->id.'\'>'.ucfirst($opt->title).'</option>';
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
                            echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
                          }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Employee</th>
                  <td width="250">
                    <select id="assignto" name="assignto" class="form-control select2" style="width:100%;">
                      <option value=""> --- </option>
                      <?php 
                          foreach (emplyeesopt('employee') as $opt){
                            echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->name).'</option>';
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
                      foreach (trails_process() as $k) {
                        echo '<tr>
                                <td>'.$k['id'].' '.$k['value'].'</td>
                                <td><input id="ssts'.$k['id'].'" type="checkbox" data-id="'.$k['id'].'" class="schedules"/></td>
                                <input type="hidden" class="form-control schedulesv" value="'.$k['id'].'" data-id="'.$k['id'].'" name="schedules[]">
                              </tr>';  
                      }
                    ?>
                   <!--  <tr>
                      <td>1 Wax Trial</td>
                      <td><input id="ssts1" type="checkbox" data-id="1" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="1" data-id="1" name="schedules[]">
                    </tr>
                    <tr>
                      <td>2 Metal Trial</td>
                      <td><input id="ssts2" type="checkbox" data-id="2" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="2" data-id="2" name="schedules[]">
                    </tr>
                    <tr>
                      <td>3 Coping Trial</td>
                      <td><input id="ssts3" type="checkbox" data-id="3" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="2" data-id="2" name="schedules[]">
                    </tr>
                    <tr>
                      <td>4 Bisque Trial</td>
                      <td><input id="ssts4" type="checkbox" data-id="4" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="2" data-id="2" name="schedules[]">
                    </tr>
                    <tr>
                      <td>5 Jig Trial</td>
                      <td><input id="ssts5" type="checkbox" data-id="5" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="2" data-id="2" name="schedules[]">
                    </tr>
                    <tr>
                      <td>6 Final</td>
                      <td><input id="ssts6" type="checkbox" data-id="6" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="6" data-id="6" name="schedules[]">
                    </tr>
                    <tr>
                      <td>7 Setting Trial</td>
                      <td><input id="ssts7" type="checkbox" data-id="7" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="7" data-id="7" name="schedules[]">
                    </tr>
                    <tr>
                      <td>8 Special Trial</td>
                      <td><input id="ssts8" type="checkbox" data-id="8" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="8" data-id="8" name="schedules[]">
                    </tr>
                    <tr>
                      <td>9 Bite Trial</td>
                      <td><input id="ssts9" type="checkbox" data-id="9" class="schedules"/></td>
                      <input type="hidden" class="form-control schedulesv" value="9" data-id="9" name="schedules[]">
                    </tr> -->
                  </tbody>
              </table>
            </div>


            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-bordered" id="teeth" style="text-align: center;">
                        <tbody>
                      <!-- //border: 2px solid red; border-radius: 50%; padding:  5px; -->
                      <tr>
                        <td class="btn_t1"><b class="tb" id="t_18">18</b></td>
                        <td class="btn_t1"><b class="tb" id="t_17">17</b></td>
                        <td class="btn_t1"><b class="tb" id="t_16">16</b></td>
                        <td class="btn_t1"><b class="tb" id="t_15">15</b></td>
                        <td class="btn_t1"><b class="tb" id="t_14">14</b></td>
                        <td class="btn_t1"><b class="tb" id="t_13">13</b></td>
                        <td class="btn_t1"><b class="tb" id="t_12">12</b></td>
                        <td class="btn_t1"><b class="tb" id="t_11">11</b></td>
                        <td class="btn_t1"><b class="tb" id="t_21">21</b></td>
                        <td class="btn_t1"><b class="tb" id="t_22">22</b></td>
                        <td class="btn_t1"><b class="tb" id="t_23">23</b></td>
                        <td class="btn_t1"><b class="tb" id="t_24">24</b></td>
                        <td class="btn_t1"><b class="tb" id="t_25">25</b></td>
                        <td class="btn_t1"><b class="tb" id="t_26">26</b></td>
                        <td class="btn_t1"><b class="tb" id="t_27">27</b></td>
                        <td class="btn_t1"><b class="tb" id="t_28">28</b></td>
                      </tr>
                      <tr>
                        <td class="btn_t1"><b class="tb" id="t_48">48</b></td>
                        <td class="btn_t1"><b class="tb" id="t_47">47</b></td>
                        <td class="btn_t1"><b class="tb" id="t_46">46</b></td>
                        <td class="btn_t1"><b class="tb" id="t_45">45</b></td>
                        <td class="btn_t1"><b class="tb" id="t_44">44</b></td>
                        <td class="btn_t1"><b class="tb" id="t_43">43</b></td>
                        <td class="btn_t1"><b class="tb" id="t_42">42</b></td>
                        <td class="btn_t1"><b class="tb" id="t_41">41</b></td>
                        <td class="btn_t1"><b class="tb" id="t_31">31</b></td>
                        <td class="btn_t1"><b class="tb" id="t_32">32</b></td>
                        <td class="btn_t1"><b class="tb" id="t_33">33</b></td>
                        <td class="btn_t1"><b class="tb" id="t_34">34</b></td>
                        <td class="btn_t1"><b class="tb" id="t_35">35</b></td>
                        <td class="btn_t1"><b class="tb" id="t_36">36</b></td>
                        <td class="btn_t1"><b class="tb" id="t_37">37</b></td>
                        <td class="btn_t1"><b class="tb" id="t_38">38</b></td>
                      </tr>
                    </tbody>
                    </table>
                </div>
                
              <label>Products</label>
              <div class="row">
                <div class="col-md-12">
                  <div id="addedproducts" class="table-responsive"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Row 4 -->
          <div class="row">
            <div class="col-md-12">
              <p class="pull-right">Remaing Capping Amount : <span id="capping_amt"><?= get_cap_amt($clientid);?></span></p><br><br>
              <input type="hidden" id="cap_value" value="<?= get_cap_value($clientid);?>" />
              <input type="button" class="btn btn-primary pull-right placeorder" value="Submit" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade-in" id="modal-default" style="overflow: scroll">
  <div class="modal-dialog p" style="width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body m1">
        <div class="row">
          <div class="form-group col-md-4 col-sm-4 col-xs-4">
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
          <div class="form-group col-md-4 col-sm-4 col-xs-4">
            <label>Product Type</label>
            <select id="producttype" name="producttype" class="form-control ptyps"></select>
          </div>
          <div class="form-group col-md-4 col-sm-4 col-xs-4">
            <label>Product List</label>
            <select id="product" name="product" class="form-control products">
            </select>
          </div>
          <input type="hidden" name="poption" id="poption">
        </div>

        <div class="row">
          <div class="col-md-12">
            <b>Select Teeth &nbsp;&nbsp;<input type="checkbox" id="sel_all_teeth" style="display: none" /></b>
              <div class="table-responsive">
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
          </div>

          <div class="col-md-3 col-sm-3 col-xs-3">
            <label>Teeth</label>
            <input type="text" id="teethcount" name="teethcount" class="form-control" readonly="true">
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3">
            <label>Units</label>
            <input type="text" id="unit" name="unit" class="form-control" readonly="true">
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3">
            <label>Unit Rate</label>
            <input type="text" id="unitrate" name="unitrate" class="form-control" readonly="true">
            <input type="hidden" id="cdiscount" name="cdiscount" class="form-control" readonly="true">
          </div>
          <div class="col-md-3 col-sm-3 col-xs-3">
            <label>Total</label>
            <input type="text" id="total" name="total" class="form-control" readonly="true">
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
                  echo '<div class="col-md-4 col-sm-4 col-xs-4 form-group" class="rxall" id="rx'.$x['id'].'" style="display:none">
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
                <table class="table table-bordered">
                  <?php echo order_form_encloser();?>
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
                  <tbody id="addedenclosure">
                      
                  </tbody>
                      </table>
                  </div>
              </div>
              <div>

              </div>

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

<!-- Modal -->
<div class="modal fade" id="redoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Get Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="redo_form" action="" method="post">
        <div class="modal-body">
            <label>Enter Case Number</label>
            <input type="text" name="case_no" class="form-control" id="validate_case_no" required="required">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary redo_btn">Process</button>
        </div>
      </form>
    </div>
  </div>
</div>