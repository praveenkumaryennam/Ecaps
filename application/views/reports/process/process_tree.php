<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/processtree');?>" method="post" autocomplete="off">
           <div class="form-group col-md-3">
              <label>Case No</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="case_no">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">Get!</button>
                    </span>
              </div>
            </div>
          </form>
        </div>
      </div>

      <?php if(!empty($case_no)){ ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table>
                <tr>
                  <th>Case No : </th>
                  <td> &nbsp; <?= $case_no;?></td>
                </tr>
                  <?php 
                    if(empty($logs)){
                      echo '<span class="text-red">Sorry Case No not Found.!</span>';
                    }
                  ?>
              </table>
            </div>
          </div>
        </div>
      </div>

      <?php if(!empty($logs)){?>
      <div class="row">
        <div class="col-md-12">

          <ul class="timeline">
            <li class="time-label">
              <span class="bg-green"><?= date('d F, Y');?></span>
            </li>

            <?php foreach ($logs as $l) { 
              $out = ($l->out_datetime != null)?date('d-m-Y h:i:s a', strtotime($l->out_datetime)):'';
            ?>
            <li>
              <?php 
                if($l->out_datetime)
                  echo '<i class="fa fa-check bg-green"></i>';
                else
                  echo '<i class="fa fa-spinner fa-spin bg-red"></i>';
              ?>

              <div class="timeline-item">
                  <?php 
                    if($l->out_datetime)
                      echo "<span class='time bg-green '><i class='fa fa-clock-o'></i> <b>".time_diff(date('Y-m-d H:i:s', strtotime($l->out_datetime)), date('Y-m-d H:i:s', strtotime($l->in_datetime)))."</b></span>";
                    else  
                      echo '<span class="time text-red"><i class="fa fa fa-spinner fa-spin"></i><b> In - Process... </b></span>';
                  ?>

                  <h3 class="timeline-header"><a href="#"><?= lab_depaerment_title($l->department);?></a></h3>
                  <div class="timeline-body">
                    <table border="1" class="table table-bordered" width="100%">
                      <tr>
                        <th width="350">In-Time</th>
                        <th width="350">Out-Time</th>
                        <th>Done By</th>
                      </tr>

                      <tr>
                        <td><?= date('d-m-Y h:i:s a', strtotime($l->in_datetime));?></td>
                        <td><?= $out;?></td>
                        <td><?= get_emp_name($l->done_by, 'employee');?></td>
                      </tr>

                    </table>
                  </div>
              </div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>        
    <?php } } ?>
  </div>
</div>