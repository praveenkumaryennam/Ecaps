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
        
        <!-- <input type="hidden" name="gst" value="<?= $gst;?>"> -->
        
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
                        <th>Discount (%) / Offer</th>
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
                        <?= $p->unit;?>
                        <?php
                          $poffer = get_client_offer($client, $p->unit, get_product_id($p->product_id));

                          if(!empty($poffer)){
                            $punit = ($p->unit - $poffer->offering);
                          }else{
                            $punit = $p->unit;
                          }
                        ?>

                      </td>
                      <td><?= number_format($p->baseprice, 2);?></td>
                      <td>
                        <?= (!isset($poffer->title))?number_format($p->discount, 2):$poffer->title;?>
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
                      
                      <td><?= number_format($p->unit_price, 2)?></td>
                      <td><?= number_format($p->unit_price * $punit, 2);?></td>
                    </tr>
                <?php
                      $fstotal = $p->unit_price * $punit; 
                      $stotal += $p->unit_price * $punit; 
                    
                    echo '<input type="hidden" name="order[]" id="order'.$p->id.'" value="'.$p->order_id.'" />';
                    echo '<input type="hidden" name="product[]" id="product'.$p->id.'" value="'.$p->product_id.'" />';
                    echo '<input type="hidden" name="producttype[]" id="producttype'.$p->id.'" value="'.$p->product_type.'" />';
                    echo '<input type="hidden" name="productcategory[]" id="productcategory'.$p->id.'" value="'.$p->product_category.'" />';
                    echo '<input type="hidden" name="units[]" id="units'.$p->id.'" value="'.$p->unit.'" />';
                    echo '<input type="hidden" name="unit_price[]" id="unit_price'.$p->id.'" value="'.$p->unit_price.'" />';
                    echo '<input type="hidden" name="base_price[]" id="base_price'.$p->id.'" value="'.$p->baseprice.'" />';
                    echo '<input type="hidden" name="discount[]" id="discount'.$p->id.'" value="'.$p->discount.'" />';
                    echo '<input type="hidden" name="offer_id[]" id="offer'.$p->id.'" value="'.$poffer->id.'" />';
                    echo '<input type="hidden" name="subtotal[]" id="subtotal'.$p->id.'" data-subtotal="'.$p->unit_price * $p->unit.'" value="'.number_format($stotal, 2).'" />';
                    echo '<input type="hidden" name="fsubtotal[]" id="fsubtotal'.$p->id.'" data-fsubtotal="'.$p->unit_price * $p->unit.'" value="'.number_format($fstotal, 2).'" />';
                    // echo '<input type="hidden" name="fstotal[]" id="fstotal'.$p->id.'" value="'.$fstotal.'"/>';
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

              <?php
                $amt = 0;
                $amt = ($stotal + $o->add_amount);
                $offer_applicable = get_client_offer($client, $amt);

                if(!empty($offer_applicable) && ($amt >= $offer_applicable->minimum_order)){
                  if($offer_applicable->offeringtype != 'pro'){
                    $type = ($offer_applicable->offeringtype == 'amt')?'INR':'%';
                    $amt = ($type == 'INR')?$offer_applicable->offering:(($amt * $offer_applicable->offering)/100);
              ?>
                    <tr>
                      <th>Discount (<?= $type;?>)</th>
                      <td>
                        <input type="number" placeholder="<?= number_format($amt, 2);?>" style="width:120px" readonly/>
                        <input type="hidden" id="adiscount" name="adiscount" value="<?= $amt;?>" required/>
                      </td>
                    </tr> 
              <?php
                  }
                }
              ?>

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
                <td id="final_amount"><?= number_format(($stotal + (($o->add_amount)?$o->add_amount:0)) - $amt,2);?> </td>
              </tr>
              <input type="hidden" id="txfinal_subtotal" name="txfinal_subtotal" value="<?= $stotal;?>"/>
              <input type="hidden" id="txfinal_gst" name="txfinal_gst" value="0"/>
              <input type="hidden" id="txfinal_gst_amount" name="txfinal_gst_amount" value="0"/>              
              
              <input type="hidden" id="txfinal_amount" name="txfinal_amount" value="<?= ($stotal + (($o->add_amount)?$o->add_amount:0)) - $amt;?>"/>

              <input type="hidden" name="type" value="new"/>
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
  // $('#duedate').change(function(){
  //   $.post(base_url+'orders/invoicenumber', {'date':$(this).val()}, function(res){
  //     $('#ginvoienumber1').val(res);
  //     $('#ginvoienumber').text(res);
  //   });
  // });
  
  // $('.btn-success').click(function(){
  //   $(this).attr('disabled', true);
  // });

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
