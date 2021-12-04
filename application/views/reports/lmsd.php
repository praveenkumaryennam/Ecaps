<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="#" method="post" class="form-group" autocomplete="off">
          <div class="col-md-3">
            <label>Month</label>
            <input type="month" class="form-control" name="old_month" placeholder="YYYY-MM" />
          </div>

          <div class="col-md-3">
            <label>Month</label>
            <input type="month" class="form-control" name="new_month" placeholder="YYYY-MM" />
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

          <div class="form-group col-md-3">
              <label>Country</label>
              <select name="country" id="country" class="form-control select2">
                  <option value=""> --- </option>
                  <?php 
                  foreach (loadoption('country') as $opt){
                    $sel = ($arr['country'] == $opt->id)?"selected":"";
                    echo '<option value=\''.$opt->id.'\' '.$sel.'>'.$opt->country.'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="form-group col-md-3">
              <label>State</label>
                <input type="hidden" id="state_val" value="<?= $arr['state'];?>"/>
              <select name="state" id="state" class="form-control states select2"></select>
          </div>
          <div class="form-group col-md-3">
              <label>City</label>
                <input type="hidden" id="city_val" value="<?= $arr['city'];?>"/>
              <select name="city" id="city" class="form-control cities select2"></select>
          </div>
          <div class="form-group col-md-3">
            <label>Station</label>
              <input type="hidden" id="station1_val" value="<?= $arr['station'];?>"/>
            <select name="station" id="station1" class="form-control stations select2">
              <option value=""> --- </option>
            </select>
          </div>


          <div class="form-group col-md-3">
            <label>Zone</label>
            <select class="form-control select2" id="zone" name="zone">
              <option value=""> --- </option>
              <?php
                foreach (loadoption('zones') as $p){
                  if(!empty($arr['zone'])){
                    $sel = ($arr['zone'] == $p->id)?"selected":"";
                    echo '<option value="'.$p->id.'" '.$sel.'>'.$p->zone.'</option>';
                  }
                  else
                    echo '<option value="'.$p->id.'">'.$p->zone.'</option>';
                }
              ?>
            </select>
          </div>

          <div class="form-group col-md-3">
            <label>Zone Wise Stations</label>
            <input type="hidden" id="zone_stations_val" value="<?= $arr['zone_stations']?>">
            <select class="form-control select2" id="zone_stations" name="zone_stations">
              <option value=""> --- </option>
            </select>
          </div>

          <div class="col-md-3" style="margin-top: 25px;">
            <input type="submit" class="pull-left btn btn-primary pull-right" value="Submit" />
          </div>
        </div>
      </form>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-borderd datatable_btn">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Client ID</th>
                    <th>Station</th>
                    <th>Zone</th>
                    <th>Month Compaer Month</th>
                    <?php 
                      for ($i = 1; $i <= $arr['days']; $i++) {
                        echo '<th>'.sprintf("%02d", $i).'</th>';
                      }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($rows)){
                      $i=1;
                      foreach($rows as $row){
                        echo '<tr>
                          <td>'.$i++.'</td>
                          <td>'.$row['name'].'</td>
                          <td>'.$row['code'].'</td>
                          <td>'.strtoupper(get_station_title($row['station'])).'</td>
                          <td>'.get_zone_title_by_station($row['station']).'</td>
                          <td>'.$arr['last_month'].' / '.$arr['cur_month'].'</td>';
                          for($i=1; $i <= $arr['days']; $i++){
                            echo '<td>'.$row['orders'][$arr['last_month']][sprintf("%02d", $i)].' / '.$row['orders'][$arr['cur_month']][sprintf("%02d", $i)].'</td>';
                          }
                        echo '</tr>';
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


<script type="text/javascript">
  $('.sbtn').click(function(){
    $('.fa-spinner').show();
    $(this).attr('style', 'cursor:not-allowed;pointer-events:none');
  });
  $(function(){
    load_zone_stations($("#zone").val());
    load_states($('#country').val());
  });
</script>