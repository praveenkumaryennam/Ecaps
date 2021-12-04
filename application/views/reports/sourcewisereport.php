<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header" style="border-bottom: 1px solid #f4f4f4;">
        <div class="row">
          <form action="<?= base_url('analysereports/sourcewisereport');?>" method="post">
            <div class="col-md-3">
              <label>Source</label>
              <select class="form-control select2" name="source">
                <option value=""> --- </option>
                <?php
                  foreach (loadoption('source') as $p){
                    if(!empty($arr['source'])){
                      $sel = ($arr['source'] == $p->code)?"selected":"";
                      echo '<option value="'.$p->id.'" '.$sel.'>'.$p->title.'</option>';
                    }
                    else
                      echo '<option value="'.$p->id.'">'.$p->title.'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <label>From Date</label>
              <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
            </div>
            <div class="col-md-3">
              <label>To Date</label>
              <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
            </div>
            <div class="col-md-3">
              <br>
              <input type="submit" class="btn btn-success pull-left" style="margin-top: 5px;" value="Submit" />
            </div>
          </form>
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
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Contact</th>
                    <th>Whatsapp Number</th>
                    <th>DOJ</th>
                    <th>Month</th>
                    <th>Source</th>
                    <th>Refer By</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i = 1;
                      foreach ($rows as $r) {
                        $doj = (isset($r->dob) && $r->dob != '0000-00-00 00:00:00')?date('d/m/Y', strtotime($r->dob)):'---';
                        $mon = (isset($r->dob) && $r->dob != '0000-00-00 00:00:00')?date('F', strtotime($r->dob)):'---';
                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$r->clientname.'</td>
                          <td>'.$r->code.'</td>
                          <td>'.$r->mobile.'</td>
                          <td>'.$r->whatsappno.'</td>
                          <td>'.$doj.'</td>
                          <td>'.$mon.'</td>
                          <td>'.$r->title.'</td>
                          <td>'.$r->referby.'</td>
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