<div class="rowsw">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <div class="col-md-3 pull-left">
            <h3>Attendance</h3>
          </div>
          <div class="col-md-3 pull-right">
            <button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-upload"></i> &nbsp;&nbsp; Import</button>
          </div>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>Sr.No</th>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Pracent</th>
                    <th>Absent</th>
                    <th>Week Off</th>
                    <th>Holiday</th>
                    <th>LWP</th>
                    <th>Total Leave</th>
                    <th>Paid Days</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                  
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i=0;
                      foreach ($rows as $key) {
                        echo "<tr>
                        <td>".$i++."</td>
                        <td>".$key->emp_id."</td>
                        <td>".get_emp_name($key->emp_id, 'employee')."</td>
                        <td>".$key->present."</td>
                        <td>".$key->absent."</td>
                        <td>".$key->week_off."</td>
                        <td>".$key->holiday."</td>
                        <td>".$key->LWP."</td>
                        <td>".$key->total_leave."</td>
                        <td>".$key->paid_days."</td>
                        <td>".$key->total."</td>
                        <td><a href='#'>View</a></td>
                        </tr>";
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


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url("Attendance/import");?>" method="post" class="form-group" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <select class="form-control" name="month">
                <?php 
                  for ($i=1; $i <= 12 ; $i++) {
                    $sel = (date('m') == $i)?"selected":"";
                    echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-1')).'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="col-md-6">
                <input type="file" name="importdata" class="form-control" />
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Import</button>
      </div>
        </form>
    </div>
  </div>
</div>


<script>
  $('#crrmonth').change(function(){
    window.location.href = '<?= base_url();?>attendance/'+$(this).val();
  });
</script>