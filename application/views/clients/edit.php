<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="box-header">
                <h3 class="box-title">Clients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="<?= base_url('clients/update');?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="clientid" value="<?= $data->id;?>"/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    Visiting Card
                                    <div style="text-align:center">
                                        <img src="http://localhost/rpd/assets/dist/img/rpdlogo.png" id="imgpri" style=" height: 110px;" class="btnFileUpload">
                                        <input type="file" name="image" value="" id="image" style="display:none;">
                                    </div>
                                </div>
                                <div class="form-group col-md-9">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="imp">Client Name</label>
                                            <input type="text" name="clientname" id="clientname" value="<?= $data->clientname;?>" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="imp">Client Code</label>
                                            <input type="text" name="code" id="code" value="<?= $data->code;?>" class="form-control">
                                        </div>
<!--                                         <div class="form-group col-md-4">
                                            <label>Legency Code</label>
                                            <input type="text" name="legencycode" id="legencycode" value="<?= $data->legencycode;?>" class="form-control">
                                        </div> -->

                                        <div class="form-group col-md-4">
                                            <label>Status</label>
                                            <select type="text" name="legencycode" id="legencycode" class="form-control">
                                                <option value="new" <?= ($data->legencycode == 'new')?:"selected"; ?> >New</option>
                                                <option value="updated" <?= ($data->legencycode == 'updated')?:"selected"; ?>>Updated</option>
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
                                                    $sel = ($data->parent == $opt->code)?'selected':'';
                                                  echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
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
                                                    $sel = ($data->source == $opt->id)?'selected':'';
                                                    echo '<option value=\''.$opt->id.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
                                                }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Refer by</label>
                                            <!-- <input type="text" id="referby" name="referby" value="<?= $data->referby;?>" class="form-control"> -->
                                            <select id="referby" name="referby" class="form-control select2">
                                                <option value=""> --- </option>
                                                <?php 
                                                    foreach (loadoption('refer_by') as $opt){
                                                        $sel = (str_replace(' ','',strtolower($data->referby)) == str_replace(' ','',strtolower($opt->title)))?"selected":"";
                                                        echo '<option value=\''.$opt->title.'\' '.$sel.'>'.$opt->title.'</option>';
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
                                            $sel = ($data->customercateory == $opt->code)?'selected':'';
                                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.ucfirst($opt->title).'</option>';
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
                                            $sel = ($data->language == $opt->id)?'selected':'';
                                          echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->title.'</option>';
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
                                            $sel = ($data->qualification == $opt->code)?'selected':'';
                                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
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
                                            $sel = ($data->currency == $opt->code)?'selected':'';
                                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.' ('.strtoupper($opt->code).') '.'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="imp">Mobile Number</label>
                                    <input type="text" id="mobile" name="mobile" value="<?= $data->mobile;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="imp">Whatsapp Number</label>
                                    <input type="text" id="whatsappno" name="whatsappno" value="<?= $data->whatsappno;?>" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Landline Number</label>
                                    <input type="text" id="landlineno" name="landlineno" value="<?= $data->landlineno;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Assistant Number</label>
                                    <input type="text" id="assistantno" name="assistantno" value="<?= $data->assistantno;?>" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="imp">Email</label>
                                    <input type="text" id="email" name="email" value="<?= $data->email;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="imp">DOJ</label>
                                    <input type="text" id="dob" name="dob" value="<?= date('d-m-Y', strtotime($data->dob));?>" class="form-control datepicker" placeholder="DD-MM-YYYY">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Anniversary Date</label>
                                    <input type="text" id="anniversarydate" name="anniversarydate" value="<?= date('d-m-Y', strtotime($data->anniversarydate));?>" class="form-control datepicker" placeholder="DD-MM-YYYY">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Practicing Since</label>
                                    <input type="text" id="practicingyear" name="practicingyear" value="<?= $data->practicingyear;?>" class="date-own form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Credit Days</label>
                                    <input type="text" id="creditdays" name="creditdays" value="<?= $data->creditdays;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Country</label>
                                    <select name="country" id="country" class="form-control select2">
                                        <option value=""> --- </option>
                                        <?php 
                                        foreach (loadoption('country') as $opt){
                                            $sel = ($opt->id == $data->country)?'selected':$data->country;
                                            echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->country.'</option>';
                                        }
                                        ?>
                                  </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>State</label>
                                    <select name="state" id="state" class="form-control states select2">
                                        <option value=""> --- </option>
                                        <?php 
                                            foreach (loadopts('states', 'country', $data->country) as $opt){
                                                $sel = ($opt->id == $data->state)?'selected="selected"':'';
                                                echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->state.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>City</label>
                                    <select name="city" id="city" class="form-control cities select2">
                                        <option value=""> --- </option>
                                        <?php 
                                            foreach (loadopts('cities', 'state', $data->state) as $opt){
                                                $sel = ($opt->id == $data->city)?'selected="selected"':'';
                                                echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->city.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Area</label>
                                    <input type="text" name="area" id="area" value="<?= $data->area;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Landmark</label>
                                    <input type="text" name="landmark" id="landmark" value="<?= $data->landmark;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" id="pincode" value="<?= $data->pincode;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Station</label>
                                    <select name="station" id="station" class="form-control stations select2">
                                        <option value=""> --- </option>
                                        <?php 
                                            foreach (loadopts('stations', 'city', $data->city) as $opt){
                                                $sel = ($opt->id == $data->station)?'selected="selected"':'';
                                                echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->station.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <textarea id="address" name="address" class="form-control"><?= $data->address;?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Standing INT</label>
                                    <textarea id="remark1" name="remark1" class="form-control"><?= $data->remark1;?></textarea>
                                </div>
                            </div>
                            <h3>Billing Information:</h3>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Company</label>
                                    <input type="text" id="bcompany" name="bcompany" value="<?= $badd->company;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Email Id</label>
                                    <input type="text" id="bemail" name="bemail" value="<?= $badd->email;?>" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Contact Number</label>
                                    <input type="text" id="bcontactno" name="bcontactno" value="<?= $badd->contactno;?>" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>GST Number</label>
                                    <input type="text" id="bgstno" name="bgstno" value="<?= $badd->gstno;?>" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>PAN No</label>
                                    <input type="text" id="bpanno" name="bpanno" value="<?= $badd->panno;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>CIN No</label>
                                    <input type="text" id="bcinno" name="bcinno" value="<?= $badd->cinno;?>" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Address</label>
                                    <textarea id="baddress" name="baddress" class="form-control"><?= $badd->address;?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right" style="width:120px;">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>