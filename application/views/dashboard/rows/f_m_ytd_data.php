
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Job Entry Productivity Data</h3>
      </div>

      <style>
        .widget-user-2 .widget-user-username, .widget-user-2 .widget-user-desc{
          margin-left: 0px !important;
        }
      </style>

      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="box box-widget widget-user-2">
              <div class="widget-user-header bg-yellow">
                <h3 class="widget-user-username">FTD</h3>
              </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                  <li><a href="#">Orders <span class="pull-right badge bg-blue" id="ftd1">0</span></a></li>
                  <li><a href="#">Challan <span class="pull-right badge bg-aqua" id="ftd2">0</span></a></li>
                  <li><a href="#">Invoice <span class="pull-right badge bg-red" id="ftd3">0</span></a></li>
                </ul>
              </div>
            </div>
          </div>
            
          <!-- MTD -->
          <div class="col-md-4">
            <div class="box box-widget widget-user-2">
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">MTD</h3>
              </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                  <li><a href="#">Orders <span class="pull-right badge bg-blue" id="mtd1">0</span></a></li>
                  <li><a href="#">Challan <span class="pull-right badge bg-aqua" id="mtd2">0</span></a></li>
                  <li><a href="#">Invoice <span class="pull-right badge bg-red" id="mtd3">0</span></a></li>
                </ul>
              </div>
            </div>
          </div>

          <!-- YTD -->
          <div class="col-md-4">
            <div class="box box-widget widget-user-2">
              <div class="widget-user-header bg-green">
                <h3 class="widget-user-username">YTD</h3>
              </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                  <li><a href="#">Orders <span class="pull-right badge bg-blue" id="ytd1">0</span></a></li>
                  <li><a href="#">Challan <span class="pull-right badge bg-aqua" id="ytd2">0</span></a></li>
                  <li><a href="#">Invoice <span class="pull-right badge bg-red" id="ytd3">0</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function productivitydata(){
    $.post('reports/productivitydata', function(res){
       res = JSON.parse(res).data;

       $('#ftd1').text(res.ftd.order);
       $('#ftd2').text(res.ftd.shipment);
       $('#ftd3').text(res.ftd.invoice);
       $('#mtd1').text(res.mtd.order);
       $('#mtd2').text(res.mtd.shipment);
       $('#mtd3').text(res.mtd.invoice);
       $('#ytd1').text(res.ytd.order);
       $('#ytd2').text(res.ytd.shipment);
       $('#ytd3').text(res.ytd.invoice);
    });
  }

  $(function(){
    productivitydata();
    setInterval(productivitydata, 60000);
  });
</script>