<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="box-header">
                <h3 class="box-title">Clients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="<?= base_url('clients/addclients');?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    Visiting Card
                                    <div style="text-align:center">
                                        <img src="<?= base_url();?>assets/dist/img/rpdlogo.png" id="imgpri" style=" height: 110px;" class="btnFileUpload">
                                        <input type="file" name="image" value="" id="image" style="display:none;">
                                    </div>
                                </div>
                                <div class="form-group col-md-9">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="imp">Client Name</label>
                                            <input type="text" name="clientname" id="clientname" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="imp">Client Code</label>
                                            <input type="text" name="code" id="code" class="form-control">
                                        </div>
                                        <!-- <div class="form-group col-md-4">
                                            <label>Legency Code</label>
                                            <input type="text" name="legencycode" id="legencycode" class="form-control">
                                        </div> -->
                                        
                                        <div class="form-group col-md-4">
                                            <label>Status</label>
                                            <select type="text" name="legencycode" id="legencycode" class="form-control">
                                                <option value="new" >New</option>
                                                <option value="updated">Updated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="imp">Parent Client</label>
                                            <select id="parentname" name="parentname" class="form-control select2">
                                                <option value=""> --- </option>
                                                <?php 
                                                foreach (loadoption('parent_client') as $opt){
                                                  echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
                                              }
                                              ?>
                                            </select>
                                        </div>
                                      
                                        <div class="form-group col-md-4">
                                            <label>Source</label>
                                            <select id="source" name="source" class="form-control select2">
                                                <option value=""> --- </option>
                                                <?php 
                                                foreach (loadoption('source') as $opt){
                                                  echo '<option value=\''.$opt->id.'\'>'.ucfirst($opt->title).'</option>';
                                                }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Refer by</label>
                                            <!-- <input type="text" id="referby" name="referby" class="form-control"> -->
                                             <select id="referby" name="referby" class="form-control select2">
                                                <option value=""> --- </option>
                                                <?php 
                                                foreach (loadoption('refer_by') as $opt){
                                                  echo '<option value=\''.$opt->title.'\'>'.$opt->title.'</option>';
                                              }
                                              ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="emp">Client Category</label>
                                    <select id="customercateory" name="customercateory" class="form-control select2">
                                        <option value=""> --- </option>
                                        <?php 
                                        foreach (loadoption('client_category') as $opt){
                                          echo '<option value=\''.$opt->code.'\'>'.ucfirst($opt->title).'</option>';
                                      }
                                      ?>
                                  </select>
                              </div>
                                <div class="form-group col-md-3">
                                    <label>Language</label>
                                    <select id="language" name="language" class="form-control select2">
                                        <option value="">--Select--</option>
                                        <?php 
                                        foreach (loadoption('language') as $opt){
                                          echo '<option value=\''.$opt->id.'\'>'.$opt->title.'</option>';
                                      }
                                      ?>
                                  </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Qualification</label>
                                    <select name="qualification" id="qualification" class="form-control select2">
                                        <option value=""> --- </option>
                                        <?php 
                                        foreach (loadoption('qualification') as $opt){
                                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
                                      }
                                      ?>
                                  </select>
                                </div>
                
                                <div class="form-group col-md-3">
                                    <label>Currency</label>
                                    <select id="currency" name="currency" class="form-control select2">
                                        <option value="">---</option>
                                        <?php 
                                        foreach (loadoption('currency') as $opt){
                                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.' ('.strtoupper($opt->code).') '.'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="imp">Mobile Number</label>
                                    <input type="text" id="mobile" name="mobile" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="imp">Whatsapp Number</label>
                                    <input type="text" id="whatsappno" name="whatsappno" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Landline Number</label>
                                    <input type="text" id="landlineno" name="landlineno" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Assistant Number</label>
                                    <input type="text" id="assistantno" name="assistantno" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="imp">Email</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="imp">DOJ</label>
                                    <input type="date" id="dob" name="dob" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Anniversary Date</label>
                                    <input type="date" id="anniversarydate" name="anniversarydate" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Practicing Since</label>
                                    <input type="text" id="practicingyear" name="practicingyear" class="date-own form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Credit Days</label>
                                    <input type="text" id="creditdays" name="creditdays" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Country</label>
                                    <select name="country" id="country" class="form-control select2">
                                        <option value=""> --- </option>
                                        <?php 
                                        foreach (loadoption('country') as $opt){
                                          echo '<option value=\''.$opt->id.'\'>'.$opt->country.'</option>';
                                      }
                                      ?>
                                  </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>State</label>
                                    <select name="state" id="state" class="form-control states select2"></select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>City</label>
                                    <select name="city" id="city" class="form-control cities select2"></select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Area</label>
                                    <input type="text" name="area" id="area" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Landmark</label>
                                    <input type="text" name="landmark" id="landmark" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Station</label>
                                    <select name="station" id="station" class="form-control stations select2">
                                        <option value=""> --- </option>
                                        <!--  <?php 
                                            foreach (loadoption('stations') as $opt){
                                              echo '<option value=\''.$opt->id.'\'>'.$opt->station.'</option>';
                                            }
                                            ?> -->
                                       </select>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <textarea id="address" name="address" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Standing INT</label>
                                    <textarea id="remark1" name="remark1" class="form-control"></textarea>
                                </div>
                            </div>
                            <h3>Billing Information:</h3>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Company</label>
                                    <input type="text" id="bcompany" name="bcompany" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Email Id</label>
                                    <input type="text" id="bemail" name="bemail" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Contact Number</label>
                                    <input type="text" id="bcontactno" name="bcontactno" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>GST Number</label>
                                    <input type="text" id="bgstno" name="bgstno" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>PAN No</label>
                                    <input type="text" id="bpanno" name="bpanno" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>CIN No</label>
                                    <input type="text" id="bcinno" name="bcinno" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Address</label>
                                    <textarea id="baddress" name="baddress" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right" style="width:120px;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>