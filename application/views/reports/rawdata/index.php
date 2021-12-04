<style type="text/css">
  .info-box-content{
    margin-left: 0px !important;
  }
  .info-box{
    min-height: 60px !important;
    border: 1px solid #c1c1c1;
  }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('reports/rawdata');?>" method="post">
              <div class="form-group col-md-3">
                <label>From Date</label>
                <input name="fromdate" class="form-control datepicker" value="<?= date('d-m-Y', strtotime($fillters['fromdate']));?>"/>
              </div>
              <div class="form-group col-md-3">
                <label>To Date</label>
                <input name="todate" class="form-control datepicker" value="<?= date('d-m-Y', strtotime($fillters['todate']));?>"/>
              </div>
              <div class="form-group col-md-3">
                <label>Type</label>
                <select name="type" id="type" class="form-control" required>
                  <?php
                    $arr = ["orders","invoice","challan"];
                    foreach ($arr as $a) {
                      $sel = ($fillters['type'] == $a)?"selected":"";
                      echo '<option value="'.$a.'" '.$sel.'>'.ucfirst($a).'</option>';
                    }
                  ?>
                </select>
              </div>
            <div class="col-md-3" style="margin-top: 25px;">
              <button type="submit" class="btn btn-info btn-flat">Go!</button>
            </div>
          </form>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <?php $this->load->view('reports/rawdata/'.$_page, $data['rows'] = $rows)?>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>