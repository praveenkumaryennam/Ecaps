<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Try Timeline</h3>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <form action="<?= base_url('process');?>" method="post" autocomplete="off">
              <div class="col-md-3">
                <label>From Date</label>
                <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
              </div>

              <div class="col-md-3">
                <label>To Date</label>
                <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
              </div>

              <div class="col-md-3">
                <label>Department</label>
                <select class="form-control select2" name="client">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoption('labdepartment') as $p){
                      if(!empty($arr['dep'])){
                        $sel = ($arr['dep'] == $p->code)?"selected":"";
                        echo '<option value="'.$p->code.'" '.$sel.'>'.$p->title.'</option>';
                      }
                      else
                        echo '<option value="'.$p->code.'">'.$p->title.'</option>';
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-12">
                <br />
                <input type="submit" class="btn btn-primary pull-right" value="Get Data" />
              </div>
          </form>
        </div>
      </div>


      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Sr.no</th>
                  <th>Try NO</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Department</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if(!empty($logs)){
                    $i = 1;
                    foreach($logs as $l){
                      echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$l->tryno.'</td>
                        <td>'.date('d-m-Y', strtotime($l->in_datetime)).'</td>
                        <td>'.date('h:i a', strtotime($l->in_datetime)).'</td>
                        <td>'.get_title($l->department, 'labdepartment').'</td>
                        <td><a href="'.base_url('process/trylog/'.$l->tryno).'" class="btn btn-success add">Track</a></td>
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