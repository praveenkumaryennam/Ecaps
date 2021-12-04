<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('shipment/bulkchallan');?>" method="post" autocomplete="off">
          <div class="col-md-3">
            <label>By Client</label>
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
          </div>
          <div class="col-md-12">
            <br />
            <input type="submit" class="btn btn-primary pull-right" value="Get Orders" />
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <form action="#" method="post" autocomplete="off" class="form-add">

              <table class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <th>Shipment Date</th>
                    <th>Delivery Mode</th>
                    <th>Notes Orders</th>
                  </tr>
                  <tr>
                    <td><input type="text" id="shipmentdate" class="form-control" value=<?= date('d-m-Y');?> placeholder="DD-MM-YYYY" name="shipmentdate" required readonly></td>
                    <td>
                      <select name="delivery" class="form-control" id="delivery" required>
                        <option value="courier">Courier</option>
                        <option value="delivery_boy">Delivery Boy</option>
                        <option value="doctors_pickup">Doctors Pickup</option>
                        <option value="mail">Mail</option>
                      </select>
                    </td>
                    <td>
                      <input type="text" id="note" name="note" class="form-control">
                    </td>
                  </tr>
                </tbody>
              </table>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th width="150">Order#</th>
                    <th width="250">Order Date</th>
                    <th width="250">Client</th>
                    <th width="250">Patient</th>
                    <th width="250">Products</th>
                    <th width="250">CaseNo</th>
                    <th width="250">Status</th>
                    <th width="250">DueDate</th>
                    <th>OrderAmount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      foreach ($rows as $row){
                        $product = get_order_product($row->id);
                        // $otitle = get_title_id($row->work, 'status');
                        $ototal = get_order_total($row->id);

                        echo '<tr>
                        <td><input type="checkbox" value="'.$row->order_number.'" name="bulkorders[]" id="bulkorders"></td>
                        <td>'.$row->order_number.'</td>
                        <input type="hidden" id="onumber" value="'.$row->order_number.'">
                        <td>'.date('d-m-Y', strtotime($row->date)).'</td>
                        <input type="hidden" id="odate" value="'.date('d-m-Y', strtotime($row->date)).'">
                        <td>'.ucfirst($row->clientname).'</td>
                        <input type="hidden" id="client" value="'.ucfirst($row->clientname).'">
                        <td>'.$row->patiant_name.'</td>
                        <input type="hidden" id="patiant" value="'.$row->patiant_name.'">
                        <td>'.$product.'</td>
                        <input type="hidden" id="product" value="'.$product.'">
                        <td>'.$row->modal_no.'</td>
                        <input type="hidden" id="modalno" value="'.$row->modal_no.'">
                        <td>'.strtoupper($row->work_type).'</td>
                        <input type="hidden" id="otitle" value="'.$row->work_type.'">
                        <td>'.date('d-m-Y', strtotime($row->due_date)).'</td>
                        <input type="hidden" id="duedate" value="'.date('d-m-Y', strtotime($row->due_date)).'">
                        <td>'.number_format($ototal, 2).'</td>
                        <input type="hidden" id="ototal" value="'.$ototal.'">
                        </tr>';
                      }
                    }
                  ?>
                </tbody>
              </table>
                <input type="hidden" name="client" value="<?= $client;?>" />
                <button type="submit" class="btn btn-primary">Genrate Challan</button>
              </form>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });


$(".form-add").on( "submit", function(e) {
  e.preventDefault();
  axios.post(base_url+'shipment/bulkchallangenrate', $(this).serialize()).then(function(res){
    if(res.data.sts == 1){
      Toast.fire({
        type: 'success',
        title: 'Added successfully.'
      }).then(() => {
        window.open(res.data.data);
        window.location.reload();
      });
    }
  }).catch(function (error) {
    console.log(error);
  });
});
</script>