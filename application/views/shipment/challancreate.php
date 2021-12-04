<div class="row">
  <div class="col-md-5">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Confirm Shipment Notes to be generated </h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
            <?php 
              $product = get_order_product($rows->id);
              $otitle = get_title_id($rows->order_status, 'status');
              $ototal = get_order_total($rows->id);
            ?>
            <table class="table table-bordered table-hover">
              <tr>
                <td>Shipment Date</td>
                <td><input type="text" id="shipmentdate" class="form-control datepicker" placeholder="DD-MM-YYYY" name="sipmentdate" readonly="readonly" /></td>
              </tr>
              <tr>
                <td>Client</td>
                <td><?= ucfirst($rows->clientname);?></td>
              </tr>
              <tr>
                <td>Total</td>
                <td><?= number_format($ototal,2);?></td>
              </tr>
              <tr>
                <td>Delivery Mode</td>
                <td>
                  <select name="delivery" class="form-control" id="delivery">
                    <option value="courier">Courier</option>
                    <option value="delivery_boy">Delivery Boy</option>
                    <option value="doctors_pickup">Doctors Pickup</option>
                    <option value="mail">Mail</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Notes Orders</td>
                <td>
                  <input type="text" id="note" class="form-control" />
                  <input type="hidden" value="<?= $rows->order_number;?>" id="onumber"></td>
                </tr>
              </table>

              <table class="table table-bordered">
                <tr>
                  <td>Order</td>
                  <td><?= $rows->order_number;?></td>
                  <tr>
                    <td>OrderDate</td>
                    <td><?= date('d-m-Y', strtotime($rows->date));?></td>
                  </tr>
                  <tr>
                    <td>Patient</td>
                    <td><?= $rows->patiant_name;?></td>
                  </tr>
                  <tr>
                    <td>Products</td>
                    <td><?= $product;?></td>
                  </tr>
                  <tr>
                    <td>Model</td>
                    <td><?= $rows->modal_no;?></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><?= $otitle;?></td>
                  </tr>
                  <tr>
                    <td>DueDate</td>
                    <td><?= date('d-m-Y', strtotime($rows->due_date));?></td>
                  </tr>
                  <tr>
                    <td>OrderAmount</td>
                    <td><?= number_format($ototal,2);?></td>
                  </tr>
                </table>

                <a class="btn btn-primary pull-right" href="javascript:addshipment(true);">Save Shipment Note</a>
          </div>
          </div>        
        </div>        
      </div>
    </div>
  </div>
</div>