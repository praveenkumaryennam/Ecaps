<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('Ordertransfer');?>" method="post" autocomplete="off">
            <div class="col-md-3">
              <label>Order Number</label>
              <input type="text" class="form-control" name="orderno" value="" />
            </div>
            <div class="col-md-12">
              <br />
              <input type="submit" class="btn btn-primary pull-right" value="Trasfer Order" />
            </div>
          </form>
          <?php 
            if($istrans){
              echo '<b class="text-green">Order Transferred</b>';
            }
          ?>
          <span></span>
        </div>
      </div>
    </div>
  </div>
</div>