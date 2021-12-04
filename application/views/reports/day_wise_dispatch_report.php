<style>
  .btn-group{
    margin-left: 90% !important;
    text-align: right !important;
  }  
  
  .buttons-excel{
    width: 100px;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('analysereports/dispatchreport');?>" method="post">
            <div class="col-md-3 pull-left">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control datepicker" value="<?= date('d-m-Y', strtotime($date));?>" name="jobdate">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">Go!</button>
                    </span>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_exl_repo">
                <thead>
                  <tr>
                    <th colspan="3" style='text-align: center;'>Scheduled</th>
                    <th colspan="3" style='text-align: center;'>Pending</th>
                    <th colspan="3" style='text-align: center;'>Done</th>
                    <th colspan="3" style='text-align: center;'>MTD Pending</th>
                    <th colspan="3" style='text-align: center;'>YTD Pending</th>
                  </tr>
                  <tr>
                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Value</th>
                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Value</th>
                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Value</th>
                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Value</th>
                    <th>Jobs</th>
                    <th>Units</th>
                    <th>Value</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($count_jobs)){
                        echo '<tr>
                          <td>'.number_format($count_jobs['scadule']->jobs).'</td>
                          <td>'.number_format($count_jobs['scadule']->units).'</td>
                          <td>'.number_format($count_jobs['scadule']->amt, 2).'</td>
                          <td>'.number_format($count_jobs['pending']->jobs).'</td>
                          <td>'.number_format($count_jobs['pending']->units).'</td>
                          <td>'.number_format($count_jobs['pending']->amt, 2).'</td>
                          <td>'.number_format($count_jobs['done']->jobs).'</td>
                          <td>'.number_format($count_jobs['done']->units).'</td>
                          <td>'.number_format($count_jobs['done']->amt, 2).'</td>
                          <td>'.number_format($count_jobs['mtd']->jobs).'</td>
                          <td>'.number_format($count_jobs['mtd']->units).'</td>
                          <td>'.number_format($count_jobs['mtd']->amt, 2).'</td>
                          <td>'.number_format($count_jobs['ytd']->jobs).'</td>
                          <td>'.number_format($count_jobs['ytd']->units).'</td>
                          <td>'.number_format($count_jobs['ytd']->amt, 2).'</td>
                        </tr>';
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