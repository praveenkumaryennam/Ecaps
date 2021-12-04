<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/invoicesummary');?>" method="post" autocomplete="off">
          
          <div class="col-md-3">
            <label>From Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>To Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>
          
          <div class="col-md-3">
            <label>By Client</label>
            <select class="form-control select2" name="client">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('clients') as $p){
                  if(!empty($client)){
                    $sel = ($client == $p->id)?"selected":"";
                    echo '<option value="'.$p->id.'" '.$sel.'>'.$p->clientname.'</option>';
                  }
                  else
                    echo '<option value="'.$p->id.'">'.$p->clientname.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="col-md-3">
            <br />
            <input type="submit" class="btn btn-primary pull-left" style="margin-top: 5px;" value="Genrate" />
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>