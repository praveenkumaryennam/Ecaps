<?php $this->load->view('dashboard/rows/row_1');?>

<div class="col--md-12">
  <div class="box box-solid">
    <div class="box-header">
      <div class="pull-right">
        <select class="form-control" id="_for" style="width:250px;">
          <option value="1"> FTD </option>
          <option value="2"> MTD </option>
          <option value="3"> YTD </option>
        </select>
      </div>
    </div>
    
    <div class="box-body with-border" style="background:#2d2b2b17">
      <!--
        * Total Orders, Employees, Clients, Products
        * Methods Used 
          -- helpers/dashboard_helper.php
            -- get_count('employee') => Total Employees
            -- get_count('clients') =>  Total Clients
            -- get_count('product') => Total Products
            -- get_order_count_c('orders') => Total Orders
      -->

      <!--
        * Total New, Redo, Correction Ordes
          -- get_order_count(2)
          1 - new
          2 - redo
          3 - correction
      -->
      <?php $this->load->view('dashboard/rows/row_2');?>

      <!--
        * Total Invoices, Challasns, Total Invoice Amount
          -- total invoices -> total_invoices()
          -- total challans -> total_challans()
          -- total invoice amount -> total_invoice_amount()
      -->
      <?php $this->load->view('dashboard/rows/row_3');?>

    </div>
  </div>
</div>

<!--
  * Total today dispatch, pendding dispatch, dispatch sales Amount
    -- today dispatch -> challans()
    -- today pendding dispatch -> challans(true)
    -- today dispatch sales amount -> challans_amt()
-->
<?php $this->load->view('dashboard/rows/row_4');?>

<!--
  * Total today dispatch persantage, pendding dispatch in persantage
    -- today dispatch -> challans()
    -- today pendding dispatch -> challans(true)
-->
<?php $this->load->view('dashboard/rows/row_5');?>

<!--
  * FTD, MTD, YTD conting data
-->
<?php //$this->load->view('dashboard/rows/f_m_ytd_data.php');?>



<script>
  $(function () {
    load_card_data(1);
  });

  $('#_for').change(function(){
    load_card_data($(this).val());
  });

  function load_card_data(id){
    $.post(base_url+"dashboard/carddata/"+id, function(res){
      res = JSON.parse(res);
      $('#count_employee').text(res.employee);
      $('#count_clients').text(res.clients);
      $('#count_product').text(res.product);
      $('#count_orders').text(res.orders);
      $('#new_orders').text(res.new_orders);
      $('#redo_orders').text(res.redo_orders);
      $('#correction_order').text(res.correction_order);
      $('#count_invoices').text(res.total_invoices);
      $('#count_challans').text(res.total_challans);
      $('#count_invoice_amt').text(res.total_invoice_amount);
    });
  }

</script>