<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('payment/bulkpayment');?>" method="get" autocomplete="off">
          <div class="col-md-3">
            <label>By Client</label>
            <select class="form-control select2" name="client">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('clients', true) as $p){
                  if(!empty($client)){
                    $sel = ($client == $p->id)?"selected":"";
                    echo '<option value="'.$p->id.'" '.$sel.'>'.$p->clientname.' - '.$p->code.'</option>';
                  }
                  else
                    echo '<option value="'.$p->id.'">'.$p->clientname.' - '.$p->code.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="col-md-12">
            <br />
            <input type="submit" class="btn btn-primary pull-right" value="Make Payment" />
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>