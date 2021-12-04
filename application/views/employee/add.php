<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Employees</h3>
        <a href="<?= base_url('employee');?>" class="btn btn-danger add"><i class="fa fa-arrow-circle-left"></i>&nbsp;back</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <form action="<?= base_url('employee/addemployee');?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-7">  
              <div class="row">
                <div class="col-md-2 form-group" style="margin-left: 15px">
                  <label>Image</label><br>
                  <img src="http://localhost/rpd/assets/dist/img/rpdlogo.png" id="imgpri" style="border:1px solid #808080; width:100px; height: 110px;" class="btnFileUpload">
                  <input type="file" name="image" value="" id="image" style="display:none;">
                </div>

                <div class="col-md-10" style="margin-left: -15px">
                  <div class="form-group col-md-4">
                    <label class="imp">First Name</label>
                    <input name="name" id="name" type="text" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Middle Name</label>
                    <input name="mname" id="mname" type="text" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Last Name</label>
                    <input name="lname" id="lname" type="text" class="form-control">
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">Genders</label>
                    <select name="gender" id="gender" type="text" class="form-control select2" style="width: 100%;">
                      <option value=""> --- </option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>

                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Contact Number</label>
                    <input name="mobile" id="mobile" type="text" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Email</label>
                    <input name="email" id="email" type="text" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group col-md-4">
                    <label class="imp">Date Of Birth</label>
                    <input name="dob" id="dob" type="text" class="form-control datepicker">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Emergency Contact No</label>
                    <input name="phone" id="phone" type="text" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Role</label>
                    <select class="form-control select2" style="width: 100%;" name="role" id="role">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('role') as $opt){
                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Employee Code</label>
                    <input name="code" id="code" type="text" class="form-control"/ >
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Date Of Join</label>
                    <input name="doj" id="doj" type="text" class="form-control datepicker">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="imp">Designation</label>
                    <select class="form-control select2" style="width: 100%;" name="designation" id="designation">
                      <option value=""> --- </option>
                      <?php
                        foreach (loadoption('designation') as $opt){
                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
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
                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
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
                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
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
                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
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
                          echo '<option value=\''.$opt->code.'\'>'.$opt->title.'</option>';
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">PAN Number</label>
                    <input name="pan" id="pan" type="text" class="form-control">
                  </div>

                  <div class="form-group col-md-4">
                    <label class="imp">UID Number</label>
                    <input name="uid" id="uid" type="text" class="form-control">
                  </div>

                  <div class="form-group col-md-12">
                    <label class="imp">Residential Address</label>
                    <textarea class="form-control" name="address1" rows="4" id="address1"></textarea>
                  </div>
                  <div class="form-group col-md-12">
                    <label class="imp">Perment Address</label>
                    <textarea class="form-control" name="address2" rows="4" id="address2"></textarea>
                  </div>

                  <div class="form-group col-md-6">
                    <label class="imp">Username</label>
                    <input name="username" id="username" type="text" class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label class="imp">Password</label>
                    <input name="password" id="password" type="text" class="form-control">
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="row">
                <div class="col-md-12">

                  <div>
                    <div class="form-group col-md-12">
                      <label>Name</label>
                      <input name="fname[]" id="fname" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob" class="form-control datepicker">
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
                      <input name="fname[]" id="fname" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob" class="form-control datepicker">
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
                      <input name="fname[]" id="fname" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob" class="form-control datepicker">
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
                      <input name="fname[]" id="fname" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob" class="form-control datepicker">
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
                      <input name="fname[]" id="fname" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>DOB</label>
                      <input name="fdob[]" id="fdob" class="form-control datepicker">
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
              <button type="submit" class="btn btn-primary pull-right" style="width:150px">Submit</button>
            </div>
          </form>
        </div>        
      </div>
    </div>
  </div>
</div>