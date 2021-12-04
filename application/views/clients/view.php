<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="box-header">
                <h3 class="box-title">Clients View / Update</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <form action="<?= base_url('clients/updateclients');?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
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
                                            <input type="text" name="clientname" id="clientname" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="imp">Client Code</label>
                                            <input type="text" name="code" id="code" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Legency Code</label>
                                            <input type="text" name="legencycode" id="legencycode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="imp">Parent Client</label>
                                            <select id="parentname" name="parentname" class="form-control">
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
                                            <select id="source" name="source" class="form-control">
                                                <option value="0">--Select--</option>
                                                <option value="1">Management</option>
                                                <option value="2">Marketing</option>
                                                <option value="3">Conference</option>
                                                <option value="4">Doctor Reference</option>
                                                <option value="5">Employee Reference</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Refer by</label>
                                            <input type="text" id="referby" name="referby" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="emp">Customer Category</label>
                                    <select id="customercateory" name="customercateory" class="form-control">
                                        <option value=""> -- Select -- </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Language</label>
                                    <select id="language" name="language" class="form-control">
                                        <option value="0">--Select--</option>
                                        <option value="1">English</option>
                                        <option value="2">Hindi</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Qualification</label>
                                    <select name="qualification" id="qualification" class="form-control">
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
                                    <select id="currency" name="currency" class="form-control">
                                        <option value="inr">INR</option>
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
                                    <label class="imp">DOB</label>
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
                                    <select name="country" id="country" class="form-control">
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
                                    <select name="state" id="state" class="form-control states"></select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>City</label>
                                    <select name="city" id="city" class="form-control cities"></select>
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
                                    <select name="station" id="station" class="form-control">
                                        <option value=""> --- </option>
                                        <?php 
                                            foreach (loadoption('stations') as $opt){
                                              echo '<option value=\''.$opt->id.'\'>'.$opt->station.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <textarea id="address" name="address" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Remark</label>
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