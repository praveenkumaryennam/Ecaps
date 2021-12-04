<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Employees</h3>
        <button class="btn btn-primary add" style="margin-left: 5px;" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Import</button>
        <a href="<?= base_url('employee/add');?>" class="btn btn-primary add"><i class="fa fa-plus"></i> Add</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Month</th>
                    <th>is_genrated</th>
                    <th>Designation</th>
                    <th>Location</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->firstname.' '.$row->lastname.'</td>
                        <td>'.$row->code.'</td>
                        <td>'.date('M').'</td>
                        <td>1</td>
                        <td>'.$row->designation.'</td>
                        <td>'.$row->location.'</td>
                        <td><a href="'.base_url('attendance/salaryslip/'.$row->code).'" class="btn btn-info add" alt="File Upload"><i class="fa fa-inr"></i></a></td>
                        </tr>';
                      }
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