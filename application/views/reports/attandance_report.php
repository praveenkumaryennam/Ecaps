<div class="rowsw">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <div class="col-md-3 pull-left">
            <h3 style="margin-top: 0px !important;">Attendance</h3>
          </div>
          <div class="col-md-3 pull-right">
            <form action="<?= base_url("reports/attendance");?>" method="post" class="form-group" enctype="multipart/form-data">
              <div class="input-group input-group-sm">
                <select class="form-control" name="month">
                <?php 
                  for ($i=1; $i <= 12 ; $i++) {
                    $sel = ($smonth == $i)?"selected":"";
                    echo '<option value="'.$i.'" '.$sel.'>'.date('F', strtotime('2020-'.$i.'-1')).'</option>';
                  }
                ?>
              </select>
                <span class="input-group-btn"><button type="submit" class="btn btn-info btn-flat">Get Report</button></span>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">

        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th>Sr.No</th>
                    <th>Month</th>
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
                    <!-- <th></th> -->
                  </tr>
                </thead>
                  
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i=0;
                      foreach ($rows as $key) {
                        echo "<tr>
                        <td>".$i++."</td>
                        <td>".date('F', strtotime('2020-'.$key->_month.'-01'))."</td>
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

<script>
  $('#crrmonth').change(function(){
    window.location.href = '<?= base_url();?>attendance/'+$(this).val();
  });
</script>