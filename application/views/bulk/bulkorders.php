<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('orders/getorders');?>" method="post" autocomplete="off">
          <div class="col-md-3">
            <label>By Client</label>
            <div class="input-group input-group-sm">
              <select class="form-control select2" name="client">
                <option value=""> --- </option>
                <?php
                  foreach ($clients as $p){
                    if(!empty($client)){
                      $sel = ($client == $p->id)?"selected":"";
                      echo '<option value="'.$p->id.'" '.$sel.'>'.$p->clientname.'</option>';
                    }
                    else
                      echo '<option value="'.$p->id.'">'.$p->clientname.'</option>';
                  }
                ?>
              </select>
              <span class="input-group-btn">
                <button type="submit" style="height: 34px;" class="btn btn-info btn-flat">Go!</button>
              </span>
            </div>
          </div>
<!-- 
          <div class="col-md-12">
            <br />
            <input type="submit" class="btn btn-primary pull-right" value="GetOrders" />
          </div> -->
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <form action="<?= base_url('orders/invoicegenrate');?>" method="post">
            <div class="col-md-9">
              <div class="table-responsive">   
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="checkAll"></th>
                      <th>Order Number</th>
                      <th>Order Date</th>
                      <th>Order Type</th>
                      <th>Total Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if(!empty($rows)){
                        foreach ($rows as $r){
                          // if($r->ototal > 0){
                            echo '<tr>
                              <td><input type="checkbox" value="'.$r->id.'" name="bulkorders[]" id="bulkorders"></td>
                              <td>'.$r->order_number.'</td>
                              <td>'.$r->order_date.'</td>
                              <td>'.strtoupper($r->work_type).'</td>
                              <td>'.number_format($r->ototal, 2).'</td>
                            </tr>';
                          // }
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-3">
              <!-- <label>Invoice Date <span style="color: red">*</span></label> -->
              <input type="text" name="date" class="form-control datepicker" style="border-radius: 0;height: 40px;" placeholder="Invoice Date" required="required" />
              <br>

              <input type="hidden" name="client" value="<?= $client;?>" />
              <!-- <input type="hidden" name="type" value="<?= $type;?>" /> -->
              <button type="submit" class="btn btn-primary" style="width: 100%;">Generate</button>
            </div>
          </form>
        </div>        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  // // $('.btn-primary').click(function(){
  // //   $(this).attr('disabled', true);
  // // });

  // $(document).on('click', 'form button[type=submit]', function(e) {
  //     var isValid = $(e.target).parents('form').isValid();
  //     var v = $('#bulkorders').val();
  //     if(!v) {
  //       e.preventDefault(); //prevent the default action
  //     }
  // });
</script>