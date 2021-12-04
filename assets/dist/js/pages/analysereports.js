$('#country').change(() => {
  if($('#country').val() != ''){
    $('.states').html('<option> Loading... </option>');
    load_states($('#country').val());
  }else{
    $('.states').html('<option value="">---</option>');
  }
});

$('#state').change(() => {
  if($('#state').val() != ''){
    $('.cities').html('<option> Loading... </option>');
    load_cities($('#state').val());
  }else{
    $('.cities').html('<option value="">---</option>');
  }
});

$('#city').change(() => {
  if($("#city").val() != ''){
    $('.stations').html('<option> Loading... </option>');
    load_stations($("#city").val());
  }else{
    $('.stations').html('<option value="">---</option>');
  }
});

function load_states(country){
  axios.post(base_url+'clients/statesopt/'+country).then(function(res){
    if(res.data.sts == 1){
      var html = '<option value="">---</option>';
      $.each(res.data.data, (i, v) => {
          html += '<option value="' + v.id + '">' + v.state + '</option>';
      });
      $('.states').html(html);
      if($('#state_val').val())
        $('.states').val($('#state_val').val()).change();
    }
  }).catch(function (error) {
    console.log(error);
  });
}

function load_cities(state){
  axios.post(base_url+'clients/citiesopt/'+state).then(function(res){
    if(res.data.sts == 1){
      var html = '<option value="">---</option>';
      $.each(res.data.data, (i, v) => {
          html += '<option value="' + v.id + '">' + v.city + '</option>';
      });
      $('.cities').html(html);
      if($('#city_val').val())
        $('.cities').val($('#city_val').val()).change();
    }
  }).catch(function (error) {
    console.log(error);
  });
}

function load_stations(city){
  axios.post(base_url+'clients/stationsopt/'+city).then(function(res){
    if(res.data.sts == 1){
      var html = '<option value="">---</option>';
      $.each(res.data.data, (i, v) => {
          html += '<option value="' + v.id + '">' + v.station + '</option>';
      });
      $('.stations').html(html);
      if($('#station1_val').val())
        $('.stations').val($('#station1_val').val()).change();
    }
  }).catch(function (error) {
    console.log(error);
  });
}

//Zone Station Options
$('#zone').change(() => {
  if($("#zone").val() != ''){
    $('#zone_stations').html('<option> Loading... </option>');
    load_zone_stations($("#zone").val());
  }else{
    $('#zone_stations').html('<option value="">---</option>');
  }
});

function load_zone_stations(zone){
  axios.post(base_url+'clients/zone_stations_opt/'+zone).then(function(res){
    if(res.data.sts == 1){
      var html = '<option value="">---</option>';
      $.each(res.data.data, (i, v) => {
          html += '<option value="' + v.id + '">' + v.station + '</option>';
      });
      $('#zone_stations').html(html);
      if($('#zone_stations_val').val())
        $('#zone_stations').val($('#zone_stations_val').val()).change();
    }
  }).catch(function (error) {
    console.log(error);
  });  
}

$('#station').change(function(){
  if($(this).val() != ''){
    $('.loaddata').dataTable().fnDestroy();
    var targeturl = base_url+'reports/json_zonewiseclients/'+$(this).val();
    $('.loaddata').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
          "url": targeturl,
          "type": "POST"
      }
    });
  }
});

$('#country').change(function(){
    if($(this).val() != ''){
      var targeturl = base_url+'reports/json_citywiseclients/country/'+$(this).val();
      $('.loaddata').dataTable().fnDestroy();
      $('.loaddata').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": targeturl,
            "type": "POST"
        }
      });
    }
});

$('#state').change(function(){
  if($(this).val() != ''){
    var targeturl = base_url+'reports/json_citywiseclients/state/'+$(this).val();
    $('.loaddata').dataTable().fnDestroy();
    $('.loaddata').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
          "url": targeturl,
          "type": "POST"
      }
    });
  }
});

$('#city').change(function(){
  if($(this).val() != ''){
    var targeturl = base_url+'reports/json_citywiseclients/city/'+$(this).val();
    $('.loaddata').dataTable().fnDestroy();
    $('.loaddata').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
          "url": targeturl,
          "type": "POST"
      }
    });
  }
});

$('#station1').change(function(){
  if($(this).val() != ''){
    $('.loaddata').dataTable().fnDestroy();
    var targeturl = base_url+'reports/json_citywiseclients/station/'+$(this).val();
    $('.loaddata').DataTable({
      "processing": true,
      "serverSide": true,
      "buttons":['excel'],
      "order": [],
      "ajax": {
          "url": targeturl,
          "type": "POST"
      }
    });
  }
});

changedata();

$('#fromdate, #todate, #client').change(function(){
  changedata();
});

function changedata(){
  $('#shipmentdata').DataTable({
    "processing": true,
    "serverSide": true,
    "destroy": true,
    "order": [],
    "ajax": {
        "url": base_url+'analysereports/getshipmentsnotes',
        "data" : {
          'fromdate':$('#fromdate').val(),
          'todate':$('#todate').val(),
          'client':$('#client').val(),
        },
        "type": "POST"
    },
    "columnDefs": [{ 
        "targets": [0],
        "orderable": false
    }]
  });
}