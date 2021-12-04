<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Edit Employees</h3>
        <!-- <a href="<?= base_url('employee/add');?>" class="btn btn-primary add"><i class="fa fa-plus"></i> Add</a> -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <form action="<?= base_url('employee/updateemployee');?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-7">  
              <div class="row">
                <input type="hidden" name="emplyeeid" value="<?= $data->id;?>"/>
                <div class="col-md-2 form-group" style="margin-left: 15px">
                  <label>Image</label><br>
                  <img src="http://localhost/rpd/assets/dist/img/rpdlogo.png" id="imgpri" style="border:1px solid #808080; width:100px; height: 110px;" class="btnFileUpload">
                  <input type="file" name="image" value="" id="image" style="display:none;">
                </div>

                <div class="col-md-10" style="margin-left: -15px">
                  <div class="form-group col-md-4">
                    <label class="imp">First Name</label>
                    <input name="name" id="name" type="text" value="<?= $data->firstname;?>" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Middle Name</label>
                    <input name="mname" id="mname" type="text" value="<?= $data->middlename;?>" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Last Name</label>
                    <input name="lname" id="lname" type="text" value="<?= $data->lastname;?>" class="form-control">
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Genders</label>
                    <select name="gender" id="gender" class="form-control select2" style="width: 100%;">
                      <option value=""> --- </option>
                      <option value="male" <?= ($data->gender == 'male')?'selected':'';?>>Male</option>
                      <option value="female" <?= ($data->gender == 'female')?'selected':'';?>>Female</option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Contact Number</label>
                    <input name="mobile" id="mobile" type="text" value="<?= $data->mobile;?>"class="form-control">
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Email</label>
                    <input name="email" id="email" type="text" value="<?= $data->email;?>" class="form-control">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group col-md-4">
                    <label class="imp">Date Of Birth</label>
                    <input name="dob" id="dob" type="text" value="<?= date('d-m-Y', strtotime($data->dob));?>" class="form-control datepicker">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Emergency Contact No</label>
                    <input name="phone" id="phone" type="text" value="<?= $data->phone;?>" class="form-control">
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Role</label>
                    <select class="form-control select2" style="width: 100%;" name="role" id="role">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('role') as $opt){
                          $sel = ($data->role == $opt->code)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Employee Code</label>
                    <input name="code" id="code" type="text" value="<?= $data->code;?>" class="form-control"/ >
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Date Of Join</label>
                    <input name="doj" id="doj" type="text" value="<?= $data->doj;?>" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Designation</label>
                    <select class="form-control select2" style="width: 100%;" name="designation" id="designation">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('designation') as $opt){
                           $sel = ($data->designation == $opt->code)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Department</label>
                    <select name="department" id="department" class="form-control select2" style="width: 100%;">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('department') as $opt){
                          $sel = ($data->department == $opt->code)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Lab Department</label>
                    <select name="lab_department" id="labdepartment" type="text" class="form-control select2" style="width: 100%;">
                      <option value=""> --- </option>
                      <option value="NON"> None </option>
                      <?php
                        foreach (loadoption('labdepartment') as $opt){
                          $sel = ($data->lab_department == $opt->code)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Location</label>
                    <select name="location" id="location" type="text" class="form-control select2" style="width: 100%;">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('location') as $opt){
                          $sel = ($data->location == $opt->code)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>

                  </div>

                  <div class="form-group col-md-4">
                    <label>Shift</label>
                    <select name="shiftgroup" id="shiftgroup" type="text" class="form-control select2" style="width: 100%;">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('shiftgroup') as $opt){
                          $sel = ($data->shiftgroup == $opt->code)?'selected':'';
                          echo '<option value=\''.$opt->code.'\' '.$sel.'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>



                  <div class="form-group col-md-4">
                    <label class="imp">PAN Number</label>
                    <input name="pan" id="pan" type="text" value="<?= $data->pan;?>" class="form-control">
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">UID Number</label>
                    <input name="uid" id="uid" type="text" value="<?= $data->uid;?>" class="form-control">
                  </div>

                  <div class="form-group col-md-12">
                    <label class="imp">Residential Address</label>
                    <textarea class="form-control" name="address1" rows="4" id="address1"><?= $data->address1;?></textarea>
                  </div>

                  <div class="form-group col-md-12">
                    <label class="imp">Perment Address</label>
                    <textarea class="form-control" name="address2" rows="4" id="address2"><?= $data->address2;?></textarea>
                  </div>

                  <!-- <div class="form-group col-md-6">
                    <label class="imp">Username</label>
                    <input name="username" id="username" type="text" value="<?= $data->username;?>" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="imp">Password</label>
                    <input name="password" id="password" type="text" value="<?= $data->password;?>" class="form-control">
                  </div> -->
                </div>
              </div>
            </div>


            <?php
              $father = []; 
              $mother = []; 
              $spouse = []; 
              $child1 = []; 
              $child2 = []; 
              $count = sizeof($emp);
              $i = 0;
              foreach ($emp as $e){
                if($e->relation == 'father'){
                  $father = [
                    'name' => $e->name,
                    'dob' => date('d-m-Y', strtotime($e->dob)),
                    'gender' => $e->gender,
                    'relation' => $e->relation,
                    'id' => $e->id
                  ];
                }

                if($e->relation == 'mother'){
                  $mother = [
                    'name' => $e->name,
                    'dob' => date('d-m-Y', strtotime($e->dob)),
                    'gender' => $e->gender,
                    'relation' => $e->relation,
                    'id' => $e->id
                  ];
                }

                if($e->relation == 'spouse'){
                  $spouse = [
                    'name' => $e->name,
                    'dob' => date('d-m-Y', strtotime($e->dob)),
                    'gender' => $e->gender,
                    'relation' => $e->relation,
                    'id' => $e->id
                  ];
                }

                if($e->relation == 'child' && $i == 3){
                  $child1 = [
                    'name' => $e->name,
                    'dob' => date('d-m-Y', strtotime($e->dob)),
                    'gender' => $e->gender,
                    'relation' => $e->relation,
                    'id' => $e->id
                  ];
                }

                if($e->relation == 'child' && $i == 4){
                  $child2 = [
                    'name' => $e->name,
                    'dob' => date('d-m-Y', strtotime($e->dob)),
                    'gender' => $e->gender,
                    'relation' => $e->relation,
                    'id' => $e->id
                  ];
                }
                $i++;
              }
            ?>

            <div class="col-md-5">
              <div class="row">
                <div class="col-md-12">
                  <div>
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input name="fname[]" id="fname"  value="<?= (isset($father['name']))?$father['name']:'';?>" type="text" class="form-control">
                      <input name="lid[]" type="hidden" value="<?= (isset($father['id']))?$father['id']:''?>"
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob"  value="<?= $father['dob'];?>" class="form-control datepicker">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Gender</label>
                      <select name="fgender[]" id="fgender" type="text" class="form-control">
                        <option value=""> --- </option>
                        <option value="male" Selected>Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Relation</label>
                      <select name="relation[]" id="relation" class="form-control">
                        <option value=""> --- </option>
                        <option value="father" selected>Father</option>
                        <option value="mother">Mother</option>
                        <option value="mother">Spouse</option>
                        <option value="mother">Child</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input name="fname[]" id="fname"  value="<?= (isset($mother['name']))?$mother['name']:'';?>" type="text" class="form-control">
                      <input name="lid[]" type="hidden" value="<?= (isset($mother['id']))?$mother['id']:''?>"
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob"  value="<?= (isset($mother['dob']))?$mother['dob']:'';?>" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Gender</label>
                      <select name="fgender[]" id="fgender" type="text" class="form-control">
                        <option value=""> --- </option>
                        <option value="male">Male</option>
                        <option value="female" selected>Female</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Relation</label>
                      <select name="relation[]" id="relation" class="form-control" readonly>
                        <option value=""> --- </option>
                        <option value="mother" selected>Mother</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input name="fname[]" id="fname"  value="<?= (isset($spouse['name']))?$spouse['name']:'';?>" type="text" class="form-control">
                      <input name="lid[]" type="hidden" value="<?= (isset($spouse['id']))?$spouse['id']:''?>"
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob"  value="<?= (isset($spouse['dob']))?$spouse['dob']:'';?>" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Gender</label>
                      <select name="fgender[]" id="fgender" type="text" class="form-control">
                        <option value=""> --- </option>
                        <option value="male">Male</option>
                       <option value="female" selected>Female</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Relation</label>
                      <select name="relation[]" id="relation" class="form-control" readonly>
                        <option value=""> --- </option>
                        <option value="spouse" selected>Spouse</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input name="fname[]" id="fname"  value="<?= (isset($child1['name']))?$child1['name']:'';?>" type="text" class="form-control">
                      <input name="lid[]" type="hidden" value="<?= (isset($child1['id']))?$child1['id']:''?>"
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob"  value="<?= (isset($child1['dob']))?$child1['dob']:'';?>" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Gender</label>
                      <select name="fgender[]" id="fgender" type="text" class="form-control">
                        <option value=""> --- </option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Relation</label>
                      <select name="relation[]" id="relation" class="form-control" readonly>
                        <option value=""> --- </option>
                        <option value="child" selected>Child</option>
                      </select>
                    </div>
                  </div>
                  <div>
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input name="fname[]" id="fname"  value="<?= (isset($child2['name']))?$child2['name']:'';?>" type="text" class="form-control">
                      <input name="lid[]" type="hidden" value="<?= (isset($child2['id']))?$child2['id']:''?>"
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob"  value="<?= (isset($child2['dob']))?$child2['dob']:'';?>" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Gender</label>
                      <select name="fgender[]" id="fgender" type="text" class="form-control">
                        <option value=""> --- </option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Relation</label>
                      <select name="relation[]" id="relation" class="form-control" readonly>
                        <option value=""> --- </option>
                        <option value="child" selected>Child</option>
                      </select>
                    </div>
                  </div>

                </div>
              </div>
              <button type="submit" class="btn btn-primary pull-right" style="width:150px">Update</button>
            </div>
          </form>
        </div>        
      </div>
    </div>
  </div>
</div>