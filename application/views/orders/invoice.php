<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <?= strtoupper(profile('title'));?>
          <small class="pull-right">Date: <?= Date('d/m/Y');?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>

    <!-- info row -->
    <form action="#" method="post" id="saveinvoice">
      <div class="row invoice-info">
        <div class="col-md-12" style="text-align: center;">
          <h5><strong>TAX INVOICE</strong></h5>
        </div>

        <div class="col-sm-4 invoice-col">
          <address>
            <strong><?= strtoupper(profile('title'));?></strong><br>
            <?= strtoupper(profile('address'));?><br>
            <strong>GST: <?= profile('gst');?></strong><br>
            <strong><?= profile('mobile');?></strong><br>
            <strong><?= profile('email');?></strong>
          </address>
        </div>
        <?php 
          $o = $orderdata;
          $stotal = 0;
          $gst = get_gst($o->client_code);
        ?>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?= client_info($o->client_code, 'clientname')?></strong> <br />
              <?php $add = client_info($o->client_code, 'address'); echo $add;?>
            <input type="hidden" name="address" value="<?= $add; ?>">
          </address>
        </div>

        <input type="hidden" name="order_id[]" value="<?= $o->id?>">
        <input type="hidden" name="order_number[]" value="<?= $o->order_number?>">
        <input type="hidden" name="client_id" value="<?= $o->client_code?>">
        <input type="hidden" name="order_date[]" value="<?= $o->order_date?>">
        <input type="hidden" name="patiant[]" value="<?= $o->patiant_name?>">
        <input type="hidden" name="gst[]" value="<?= $gst;?>">
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <input type="hidden" value="<?= $invoicenumber;?>" name="invoicenumber" />
          <b>Invoice # <?= $invoicenumber;?></b><br>
          <b>GST # <?= strtoupper($gst);?></b><br>
          <b>Order ID:</b> <?= $o->order_number?><br>
          <b>Invoice Date:</b> <input type="text" name="duedate" class="datepicker duedatepic" placeholder="DD/MM/YYYY" autocomplete="off"/><br>
          <!-- <b>Account:</b> 968-34567 -->
        </div>
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="table-responsive">
            <h4>Patiant Name: <?= $o->patiant_name;?></h4>
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Sr.no</th>
                <th>Product</th>
                <th>Units</th>
                <th>Rate / unit</th>
                <th>Discount (%)</th>
                <th>Teeth</th>
                <th>Discount Rate</th>
                <th>Subtotal</th>
              </tr>
              </thead>
              <tbody>
                <?php 
                $i = 0;
                  foreach ($orderproduct as $p){
                ?>
                  <tr>
                    <td><?= ++$i;?></td>
                    <td><?= $p->product;?></td>
                    <td><?= $p->unit;?></td>
                    <td><?= number_format($p->baseprice, 2);?></td>
                    <td><?= number_format($p->discount, 2);?></td>
                    <td>
                      <?php
                        $p1 = [];
                        $p2 = [];
                        $p3 = [];
                        $p4 = [];
                        
                        $a = [
                          11 =>  1,
                          12 =>  2,
                          13 =>  3,
                          14 =>  4,
                          15 =>  5,
                          16 =>  6,
                          17 =>  7,
                          18 =>  8,
                          21 =>  1,
                          22 =>  2,
                          23 =>  3,
                          24 =>  4,
                          25 =>  5,
                          26 =>  6,
                          27 =>  7,
                          28 =>  8,
                          31 =>  1,
                          32 =>  2,
                          33 =>  3,
                          34 =>  4,
                          35 =>  5,
                          36 =>  6,
                          37 =>  7,
                          38 =>  8,
                          41 =>  1,
                          42 =>  2,
                          43 =>  3,
                          44 =>  4,
                          45 =>  5,
                          46 =>  6,
                          47 =>  7,
                          48 =>  8,
                        ];
                        
                        $th = explode(',', $p->teeth);
                        asort($th);
                        foreach ($th as $te){
                          if($te >= 11 && $te <= 18){
                            $p1[] = $a[$te];
                          }

                          if($te >= 21 && $te <= 28){
                            $p2[] = $a[$te];
                          }

                          if($te >= 41 && $te <= 48){
                            $p3[] = $a[$te];
                          }

                          if($te >= 31 && $te <= 38){
                            $p4[] = $a[$te];
                          }
                        }
                      ?>
                      <table class="n-bordered">
                        <tr>
                          <td><?= implode(',',$p1);?></td>
                          <td><?= implode(',',$p2)?></td>
                        </tr>
                        <tr>
                          <td><?= implode(',',$p3)?></td>
                          <td><?= implode(',',$p4)?></td>
                        </tr>
                      </table>
                    </td>
                    
                    <td><?= number_format($p->unit_price, 2)?></td>
                    <td><?= number_format($p->unit_price * $p->unit, 2);?></td><!-- 
                    <td><input type="text" id="igst<?= $p->id?>" value="" onchange="calcul(<?= $p->id?>, <?= $i;?>)" s style="width:120px;"tyle="width:120px"/></td>
                    <td><input type="text" id="cgst<?= $p->id?>" value="" onchange="calcul(<?= $p->id?>, <?= $i;?>)" s style="width:120px;"tyle="width:120px"/></td>
                    <td><input type="text" id="sgst<?= $p->id?>" value="" onchange="calcul(<?= $p->id?>, <?= $i;?>)" style="width:120px"/></td> -->
                    <!-- <td><b id="total<?= $p->id?>"> --- </b></td> -->
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
          <?php 
            foreach ($orderproduct as $p){
              $fstotal = $p->unit_price * $p->unit; 
              $stotal += $p->unit_price * $p->unit;
              echo '<input type="hidden" name="order[]" id="order'.$p->id.'" value="'.$p->order_id.'" />';
              echo '<input type="hidden" name="product[]" id="product'.$p->id.'" value="'.$p->product_id.'" />';
              echo '<input type="hidden" name="producttype[]" id="producttype'.$p->id.'" value="'.$p->product_type.'" />';
              echo '<input type="hidden" name="productcategory[]" id="productcategory'.$p->id.'" value="'.$p->product_category.'" />';
              echo '<input type="hidden" name="units[]" id="units'.$p->id.'" value="'.$p->unit.'" />';
              echo '<input type="hidden" name="unit_price[]" id="unit_price'.$p->id.'" value="'.$p->unit_price.'" />';
              echo '<input type="hidden" name="base_price[]" id="base_price'.$p->id.'" value="'.$p->baseprice.'" />';
              echo '<input type="hidden" name="discount[]" id="discount'.$p->id.'" value="'.$p->discount.'" />';
              echo '<input type="hidden" name="subtotal[]" id="subtotal'.$p->id.'" data-subtotal="'.$p->unit_price * $p->unit.'" value="'.number_format($stotal, 2).'" />';
              echo '<input type="hidden" name="fsubtotal[]" id="fsubtotal'.$p->id.'" data-fsubtotal="'.$p->unit_price * $p->unit.'" value="'.number_format($fstotal, 2).'" />';
              echo '<input type="hidden" name="igst[]" class="figst" id="figst'.$p->id.'" />';
              echo '<input type="hidden" name="cgst[]" class="fcgst" id="fcgst'.$p->id.'" />';
              echo '<input type="hidden" name="sgst[]" class="fsgst" id="fsgst'.$p->id.'" />';
              echo '<input type="hidden" name="total[]" id="ftotal'.$p->id.'" />';
            }
          ?>
      </div>
      
      <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
          <!-- <p class="lead">Amount Due <span id="txtduedate"></span></p> -->
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th>Subtotal:</th>
                <input type="hidden" id="stotal" value="<?= $stotal?>"/>
                <td id="final_subtotal"> <?= number_format($stotal, 2);?> </td>
              </tr>

              <tr>
                <th>IGST (%)</th>
                <!-- <td id="final_gst_amount"> --- </td> -->
                <td><input type="text" id="igst" value="" onchange="calcul()" style="width:120px"/></td>
              </tr>
              <tr>
                <th>CGST (%)</th>
                <!-- <td id="final_gst_amount"> --- </td> -->
                <td><input type="text" id="cgst" value="" onchange="calcul()" style="width:120px"/></td>
              </tr>
              <tr>
                <th>SGST (%)</th>
                <!-- <td id="final_gst_amount"> --- </td> -->
                <td><input type="text" id="sgst" value="" onchange="calcul()" style="width:120px"/></td>
              </tr>

              <tr>
                <th>Additinal Amount:</th>
                <td><?= number_format(($o->add_amount)?$o->add_amount:0, 2)?></td>
                <input type="hidden" id="add_amount" name="add_amount" value="<?= $o->add_amount;?>" />
              </tr>
              <tr>
                <th>Total:</th>
                <td id="final_amount"> --- </td>
              </tr>
              <input type="hidden" id="txfinal_subtotal" name="txfinal_subtotal" />
              <input type="hidden" id="txfinal_gst" name="txfinal_gst" />
              <input type="hidden" id="txfinal_gst_amount" name="txfinal_gst_amount" />              
              <input type="hidden" id="txfinal_amount" name="txfinal_amount" />
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <!-- <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit</button>
          <!-- <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button> -->
        </div>
      </div>
    </form>
  </div>
</section>

<script type="text/javascript">
  $('#saveinvoice').submit(function(e) {
    e.preventDefault();
    axios.post(base_url + 'orders/saveinvoice', $(this).serialize()).then(function(res){
      if(res.data.sts == 1){
        window.open(res.data.data);
        window.location.href = base_url + "orders";
      }
    }).catch(function (error) {
      console.log(error);
    });
  });
</script>