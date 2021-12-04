
<style type="text/css">
  div.scrollable {
    width: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}
</style>
<div class="row">
 <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Zones</h3>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Zone</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row['zone'].'</td>
                        <td>
                          <button class="btn btn-warning fa fa-edit" onclick="getedit('.$row['id'].')"></button>
                          <button class="btn btn-info fa fa-globe" onclick="getinfo('.$row['id'].')"></button>
                          <a class="btn btn-success fa fa-info" href="'.base_url("organization/zone_info/".$row['id']).'"></a>
                        </td>
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

<!-- Add Zone Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Zone</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" class="form-zoneadd">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="imp">Zone</label>
              <input type="text" id="title" name="title" class="form-control">
            </div>
          </div>
          <div class="row">
             <div class="col-md-6">
                <label>Country</label>
                <select name="country" id="country" class="form-control">
                    <option value=""> --- </option>
                    <?php 
                    foreach (loadoption('country') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->country.'</option>';
                  }
                  ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>State</label>
              <select name="state" id="state" class="form-control states"></select>
            </div>
            <div class="form-group col-md-6">
              <label>City</label>
              <select name="city[]" id="city" class="form-control cities" multiple="multiple"></select>
            </div>
            <div class="form-group col-md-6">
              <label>Station</label>
              <select name="station[]" id="station" class="form-control stations" multiple="multiple"></select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Zone Modal -->
<div class="modal fade" id="ZoneModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Stations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="tbl_data" style="height: 250px; overflow-y: scroll;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Add or Remove -->
<div class="modal fade" id="updateZoneModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Zone</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="tbl_data">
        <label>Action</label>
        <select id="action_type" class="form-control" >
          <option value="">---</option>
          <option value="1">Add</option>
          <option value="2">Remove</option>
        </select>

        <br>
        <div id="add_from" style="display: none">
          <label>Add Station</label>
          <input type="text" class="astaion_id form-control" />          
        </div>

        <div id="remove_from" style="display: none">
          <label>Station</label>
          <input type="text" class="rstaion_id form-control" />
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="update_btn" class="btn  btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#city').change(() => {
    var city = $("#city").val();
    var html = "";
    $('.stations').html('<option value=""> Loading... </option>');
    $.each(city, function(i, v){
      axios.post(base_url+'clients/stationsopt/'+v).then(function(res){
        if(res.data.sts == 1){
          $.each(res.data.data, (i, v) => {
              html += '<option value="' + v.id + '">' + v.station + '</option>';
          });
        }
        $('.stations').html(html);
      }).catch(function (error) {
        console.log(error);
      });
    });  
  });

  $('.form-zoneadd').submit(function(e){
    e.preventDefault();
    var zone = $('#title').val();
    var sts = $('#station').val();

    $.post(base_url+'organization/zones', {zone:zone, stations:sts}, function(res){
      if(res)
        window.location.reload();
    });
  });

  function getinfo(id){
    axios.post(base_url+'organization/zone_stations/'+id).then(function(res){
      var html = '<ol>';
      if(res.data.sts == 1){
        $.each(res.data.data, (i, v) => {
            html += '<li>' + v + '</li>';
        });
      }
      html += '</ol>';
      $('#tbl_data').html(html);
      $('#ZoneModal').modal('toggle');
    }).catch(function (error) {
      console.log(error);
    });
  }

  var zone_id = 0;
  function getedit(id){
    $('#updateZoneModal').modal('toggle');
    zone_id = id;
  }

  $('#action_type').change(function(){
    var t = $(this).val();
    if(t == 1){
      $('#remove_from').hide();
      $('#add_from').show();
      return;
    }

    if(t == 2){
      $('#add_from').hide();
      $('#remove_from').show();
    }
  });

  $('#update_btn').click(function(){
    var a = $('#action_type').val();

    var s = $('.astaion_id').val();
    if(a == 2)
      s = $('.rstaion_id').val();

    $.post(base_url+'organization/station_validate', {st:s}, function(res){
      if(res == true){
        $.post(base_url+'organization/update_zone', {st: s, act: a, zone:zone_id}, function(res){
          alert('Record Updated');
          $('#action_type').val('');
          $('.staion_id').val('');
          $('#updateZoneModal').modal('toggle');
        });
      }
    });

  });



</script>