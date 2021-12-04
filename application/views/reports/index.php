<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="#" method="post" class="form-group" autocomplete="off">
          <div class="col-md-3">
            <label>Genrate Report For</label>
            <select class="form-control" id="reportsfor" name="reportsfor" required>
              <option value=""> --- </option>
              <option value="orders" <?= ($arr['reportsfor'] == "orders")?"selected":""; ?>>Orders</option>
              <?php if($this->session->userdata('role') == 'master'){?>        
                <option value="sales" <?php ($arr['reportsfor'] == "sales")?"selected":"";?>>Sales</option>
              <?php }?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Start Date</label>
            <input type="text" class="form-control datepicker" name="fromdate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['fromdate']));?>" />
          </div>

          <div class="col-md-3">
            <label>End Date</label>
            <input type="text" class="form-control datepicker" name="todate" placeholder="DD/MM/YYYY" value="<?= date('d-m-Y', strtotime($arr['todate']));?>"/>
          </div>

          <div class="col-md-3">
            <label>By Doctor</label>
            <select class="form-control select2" name="client">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('clients') as $p){
                  if(!empty($arr['client'])){
                    $sel = ($arr['client'] == $p->code)?"selected":"";
                    echo '<option value="'.$p->code.'" '.$sel.'>'.$p->clientname.'</option>';
                  }
                  else
                    echo '<option value="'.$p->code.'">'.$p->clientname.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="col-md-3">
            <label>Product Category</label>
            <select class="form-control select2" name="pcat">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('productcategory') as $p){
                  if(!empty($arr['pcat'])){
                    $sel = ($arr['pcat'] == $p->code)?"selected":"";
                    echo '<option value="'.$p->code.'" '.$sel.'>'.$p->title.'</option>';
                  }
                  else
                    echo '<option value="'.$p->code.'">'.$p->title.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="col-md-3">
            <label>Product Type</label>
            <select class="form-control select2" name="ptype">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('producttype') as $p){
                  if(!empty($arr['ptype'])){
                    $sel = ($arr['ptype'] == $p->code)?"selected":"";
                    echo '<option value="'.$p->code.'" '.$sel.'>'.$p->title.'</option>';
                  }
                  else
                    echo '<option value="'.$p->code.'">'.$p->title.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="col-md-3">
            <label>Products</label>
            <select class="form-control select2" name="product">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('product') as $p){
                  if(!empty($arr['product'])){
                    $sel = ($arr['product'] == $p->code)?"selected":"";
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
            <input type="submit" class="btn btn-primary pull-right" value="Submit" />
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <?php 
          if(!empty($rows)){
            $data['rows'] = $rows; 
            $this->load->view($tableview, $data);
          }
        ?>        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#reportsfor').change(function(){
    $('form').attr('action', base_url+'reports');
  })
</script>