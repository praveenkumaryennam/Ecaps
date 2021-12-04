<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <?= $this->config->item('title');?>
          <small class="pull-right">Date: <?= Date('d/m/Y');?></small>
        </h2>
      </div>
    </div>
    <form action="#" method="post" id="saveinvoice">
      <div class="row invoice-info">
        <div class="col-md-12" style="text-align: center;">
          <h5><strong>TAX INVOICE</strong></h5>
        </div>
        <div class="col-sm-5 invoice-col">
          <address>
            <strong><?= $this->config->item('title');?></strong>
            <br><?= $this->config->item('address');?><br>
            <?php
                if($this->config->item('contact'))
                  echo 'Contact: '.$this->config->item('contact').'<br />';

                if(!empty($this->config->item('email')))
                  echo 'Email: '.$this->config->item('email').'<br />';
              ?>
          </address>
        </div>
        <?php 
          $o = $orderdata[0]['order'];
          $stotal = 0;
        ?>
        <div class="col-sm-5 invoice-col">
          To
          <address>
            <strong><?= client_info($client, 'clientname')?></strong> <br />
              <?php $add = client_info($client, 'address'); echo $add;?>
            <input type="hidden" name="address" value="<?= $add; ?>">
          </address>
        </div>
        
        <div class="col-sm-2 invoice-col">
          <input type="hidden" value="<?= $invoicenumber;?>" id="ginvoienumber1" name="invoicenumber" />
          <span>Invoice # <br><b id="ginvoienumber" style="margin-left: 20px;"><?= $invoicenumber;?></b></span><br>
          <span>Invoice Date: <br><b style="margin-left: 20px;"> <?= date('d-m-Y', strtotime($date));?></b></span> 
          <input type="hidden" name="duedate" id="duedate" class=" form-control" value="<?= $date;?>" placeholder="DD/MM/YYYY" autocomplete="off" required readonly="readonly"/><br>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Sr.no</th>
                <th>Order Number</th>
                <th>Order Date</th>
                <th>Patient Name</th>
              </tr>
              </thead>
              <tbody>
                <?php 
                  $i = 0;
                  $stotal = 0;
                  foreach ($orderdata as $order){
                    $a = $order['order'];
                    $j = 0;
                ?>
                      <input type="hidden" name="order_id[]" value="<?= $a->oid;?>" />
                      <input type="hidden" name="order_number[]" value="<?= $a->order_number;?>" />
                      <input type="hidden" name="client_id" value="<?= $a->client_code;?>" />
                      <input type="hidden" name="order_date[]" value="<?= $a->order_date;?>" />
                      <input type="hidden" name="patiant[]" value="<?= $a->patiant_name;?>" />
                      <tr>
                        <td><?= ++$i;?></td>
                        <td><?= $a->order_number;?></td>
                        <td><?= $a->order_date;?></td>
                        <td><?= $a->patiant_name;?></td>
                      </tr>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Product</th>
                        <th>Units</th>
                        <th>Rate / unit</th>
                        <th>Discount (%)</th>
                        <th>Teeth</th>
                        <th>Discount Rate</th>
                        <th>Subtotal</th>
                      </tr>
                <?php
                  foreach ($order['product'] as $pp){
                    foreach ($pp as $p){
                ?>
                    <tr>
                      <td></td>
                      <td style="text-align: right;"><?= ++$j; ?></td>
                      <td><?= $p->product;?></td>
                       <td>
                        <input type="text" name="units[]" class="units" id="units<?= $p->id;?>" onkeyup="rowcalc(<?= $p->id;?>)" value="<?= $p->unit;?>" style="width: 50px; text-align: center;"/>
                      </td>
                      <td>
                        <input type="text" name="base_price[]" class="base_price" id="base_price<?= $p->id;?>" onkeyup="rowcalc(<?= $p->id;?>)" value="<?= $p->baseprice;?>" style="width: 60px; text-align: center;"/>
                      </td>
                      <td>
                        <input type="text" name="discount[]" class="discount" id="discount<?= $p->id;?>" onkeyup="rowcalc(<?= $p->id;?>)" value="<?= $p->discount;?>" style="width: 60px; text-align: center;"/>
                      </td>
                      <td>
                        <?php
                          $teeth = get_teeth_sides($p->teeth);
                        ?>
                        <table class="n-bordered">
                          <tr>
                            <td><?= implode(',',$teeth['p1']);?></td>
                            <td><?= implode(',',$teeth['p2'])?></td>
                          </tr>
                          <tr>
                            <td><?= implode(',',$teeth['p3'])?></td>
                            <td><?= implode(',',$teeth['p4'])?></td>
                          </tr>
                        </table>
                      </td>
                      
                      <td>
                        <input type="text" name="unit_price[]" readonly id="unit_price<?= $p->id;?>" value="<?= $p->unit_price;?>" style="width: 60px; text-align: center;"/>
                      </td>

                      <td>
                        <input type="text" name="subtotal[]" readonly class="rowsubtotal" id="subtotal<?= $p->id;?>" value="<?= $p->unit_price * $p->unit;?>" style="width: 60px; text-align: center;"/>
                      </td>
                    </tr>
                <?php
                    $fstotal = $p->unit_price * $p->unit; 
                    $stotal += $p->unit_price * $p->unit; 
                    echo '<input type="hidden" name="order[]" id="order'.$p->id.'" value="'.$p->order_id.'" />';
                    echo '<input type="hidden" name="product[]" id="product'.$p->id.'" value="'.$p->product_id.'" />';
                    echo '<input type="hidden" name="producttype[]" id="producttype'.$p->id.'" value="'.$p->product_type.'" />';
                    echo '<input type="hidden" name="productcategory[]" id="productcategory'.$p->id.'" value="'.$p->product_category.'" />';
                    // echo '<input type="hidden" name="base_price[]" id="base_price'.$p->id.'" value="'.$p->baseprice.'" />';
                    echo '<input type="hidden" name="fsubtotal[]" id="fsubtotal'.$p->id.'" data-fsubtotal="'.$p->unit_price * $p->unit.'" value="'.number_format($fstotal, 2).'" />';
                    echo '<input type="hidden" name="igst[]" class="figst" id="figst'.$p->id.'" />';
                    echo '<input type="hidden" name="cgst[]" class="fcgst" id="fcgst'.$p->id.'" />';
                    echo '<input type="hidden" name="sgst[]" class="fsgst" id="fsgst'.$p->id.'" />';
                    echo '<input type="hidden" name="total[]" id="ftotal'.$p->id.'" />';
                      }
                    }
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th>Subtotal:</th>
                <input type="hidden" id="stotal" value="<?= $stotal?>"/>
                <td id="final_subtotal"> <?= number_format($stotal, 2);?> </td>
              </tr>
              <tr>
                <th>Additinal Amount:</th>
                <td><?= number_format(($o->add_amount)?$o->add_amount:0, 2)?></td>
                <input type="hidden" id="add_amount" name="add_amount" value="<?= $o->add_amount;?>" />
              </tr>
              <tr>
                <th>IGST (%)</th>
                <td><input type="text" id="igst" name="igst" value="0" onchange="calcul()" style="width:120px" required /></td>
              </tr>
              <tr>
                <th>CGST (%)</th>
                <td><input type="text" id="cgst" name="cgst" value="0" onchange="calcul()" style="width:120px" required /></td>
              </tr>
              <tr>
                <th>SGST (%)</th>
                <td><input type="text" id="sgst" name="sgst" value="0" onchange="calcul()" style="width:120px" required /></td>
              </tr>
              <tr>
                <th>Total:</th>
                <td id="final_amount"><?= number_format(($stotal + (($o->add_amount)?$o->add_amount:0)),2);?> </td>
              </tr>
              <input type="hidden" id="txfinal_subtotal" name="txfinal_subtotal" value="<?= $stotal;?>"/>
              <input type="hidden" id="txfinal_gst" name="txfinal_gst" value="0"/>
              <input type="hidden" id="txfinal_gst_amount" name="txfinal_gst_amount" value="0"/>              
              <input type="hidden" id="txfinal_amount" name="txfinal_amount" value="<?= $stotal + (($o->add_amount)?$o->add_amount:0);?>"/>
              <input type="hidden" name="type" value="redo"/>
            </tbody></table>
          </div>
        </div>
      </div>
      <div class="row no-print">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit </button>
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
        window.location.href = base_url + "orders/getorders";
      }
    }).catch(function (error) {
      console.log(error);
    });
  });

  function rowcalc(id){
    var units = $('#units'+id).val();
    var unit_price = $('#base_price'+id).val();
    var discount = $('#discount'+id).val();

    var discount_amount = ((unit_price*discount)/100);
    var rowtotal = units*(unit_price-discount_amount);
    $("#unit_price"+id).val(unit_price-discount_amount);
    $("#subtotal"+id).val(rowtotal);
    $("#fsubtotal"+id).val(rowtotal);
    subtotal();
  }

  function subtotal(){
    var rowstotal = 0;
    $('.rowsubtotal').each(function(){
      rowstotal += parseFloat($(this).val());
    });
    $('#final_subtotal').text(rowstotal);
    $('#stotal').val(rowstotal);
  }


  $('#igst, #sgst, #cgst').keydown(function(){
    $('#igst').attr('readonly', false).css("background-color", "white");;
    $('#sgst').attr('readonly', false).css("background-color", "white");;
    $('#cgst').attr('readonly', false).css("background-color", "white");;

    if($('#sgst').val() != 0 || $('#cgst').val() != 0 ){
      $('#igst').attr('readonly', true).css("background-color", "gray");
      $('#sgst').attr('readonly', false);
      $('#cgst').attr('readonly', false);
    }
    if($('#igst').val() != 0){
      $('#igst').attr('readonly', false);
      $('#sgst').attr('readonly', true).css("background-color", "gray");
      $('#cgst').attr('readonly', true).css("background-color", "gray");
    }
  });
</script>