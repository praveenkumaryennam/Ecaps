<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Warranty Cards</h3>
        <div style="display: inline-flex; float: right">
          <input type="text" placeholder="Card Number" id="card_no" name="card_no" class="form-control pull-right" style="width: 230px;"> &nbsp;
          <button class="btn btn-primary" id="card_no_add"><i class="fa fa-plus"></i> Add</button>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Card No</th>
                    <th>Client</th>
                    <th>Case Number</th>
                    <th>Issued Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $r){
                        $d = ($r['date'])?date('d-m-Y H:i', strtotime($r['date'].' '.$r['time'])):null;
                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$r['card_no'].'</td>
                          <td>'.$r['client_name'].'</td>
                          <td>'.$r['case_number'].'</td>
                          <td>'.$d.'</td>
                        </tr>';
                      }
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<script>
  $('#card_no_add').click(function(){
    var card_no = $('#card_no').val();
    if(card_no){
      $.post(base_url+"/productmaster/warrantycards", {card_no}, function(res){
        res = JSON.parse(res);
        if(res.sts == 1)
          location.reload();
      });
    }else{
      $('#card_no').css('border-color', 'red');
    }
  });
</script>