<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Try Timeline</h3>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
         <div class="col-md-12">
            <ul class="timeline" style="height: 720px; overflow-y: scroll">
              <?php 
                $color = ['indigo', 'navy', 'purple', 'fuchsia', 'pink', 'maroon', 'orange', 'lime', 'teal', 'olive'];
                foreach ($logdata as $ld){
                if(isset($ld->out_datetime)){
                  $out = date('h:i a', strtotime($ld->out_datetime));
                }else{
                  $out = null;
                }
                $c = rand(9, 0);
                ?>
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-red"><?= date('d.m.Y', strtotime($ld->in_datetime));?></span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-calendar-minus-o bg-<?= $color[$c];?>"></i>
                    <div class="timeline-item">
                        <h3 class="timeline-header"><a href="#"><?= get_title($ld->department, 'labdepartment');?></a></h3>
                        <div class="timeline-body">
                          <table class="table table-bordered table-hover">
                            <tr>
                              <td>IN TIME</td>
                              <td><?= date('h:i a', strtotime($ld->in_datetime));?></td>
                            </tr>
                            <tr>
                              <td>OUT TIME</td>
                              <td><?= $out;?></td>
                            </tr>
                            <tr>
                              <td>Done By</td>
                              <td><?= get_emp_name($ld->done_by);?></td>
                            </tr>
                          </table>
                        </div>
                    </div>
                </li>
              <?php }?>
              <!-- END timeline item -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>