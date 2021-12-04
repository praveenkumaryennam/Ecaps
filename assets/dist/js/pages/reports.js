$('#country').change(() => {
  if($('#country').val() != ''){
    $('.states').html('<option> Loading... </option>');
    axios.post(base_url+'clients/statesopt/'+$('#country').val()).then(function(res){
      if(res.data.sts == 1){
        var html = '<option value="">---</option>';
        $.each(res.data.data, (i, v) => {
            html += '<option value="' + v.id + '">' + v.state + '</option>';
        });
        $('.states').html(html);
      }
    }).catch(function (error) {
      console.log(error);
    });
  }else{
    $('.states').html('<option value="">---</option>');
  }
});

$('#state').change(() => {
  if($('#state').val() != ''){
    $('.cities').html('<option> Loading... </option>');
    axios.post(base_url+'clients/citiesopt/'+$('#state').val()).then(function(res){
      if(res.data.sts == 1){
        var html = '<option value="">---</option>';
        $.each(res.data.data, (i, v) => {
            html += '<option value="' + v.id + '">' + v.city + '</option>';
        });
        $('.cities').html(html);
      }
    }).catch(function (error) {
      console.log(error);
    });
  }else{
    $('.cities').html('<option value="">---</option>');
  }
});

$('#city').change(() => {
  if($("#city").val() != ''){
    $('.stations').html('<option> Loading... </option>');
    axios.post(base_url+'clients/stationsopt/'+$("#city").val()).then(function(res){
      if(res.data.sts == 1){
        var html = '<option value="">---</option>';
        $.each(res.data.data, (i, v) => {
            html += '<option value="' + v.id + '">' + v.station + '</option>';
        });
        $('.stations').html(html);
      }
    }).catch(function (error) {
      console.log(error);
    });
  }else{
    $('.stations').html('<option value="">---</option>');
  }
});

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
