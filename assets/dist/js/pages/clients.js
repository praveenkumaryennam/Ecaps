const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 700
});

$(() => {
    var fileupload = $("#image");
    var button = $(".btnFileUpload");
    button.click(function () {
        fileupload.click();
    });
});

//Image priview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgpri').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
$("#image").change(function () {
    readURL(this);
});

$('#country').change(() => {
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
});

$('#state').change(() => {
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
});

$('#city').change(() => {
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
});



$('.chkclient').change(function(){
  if($(this).is(':checked')){
    var id = $(this).val();
    $('#'+id+'_txt').removeAttr('disabled');
  }else{
    $('#'+id+'_num').val('');
    $('#'+$(this).val()+'_txt').attr('disabled', true);
  }
});

$('.disc').change(function(){
  var price = $(this).data('price');
  var code = $(this).data('id');
  var v = price - ((price * $(this).val()) / 100);
  $('#'+code+'_num').val(v);
});

$('#checkall').change(function(){
  if(this.checked){
    $(".chkclient").each(function(){
      this.checked=true;
      $('.disc').removeAttr('disabled');
    })              
  }else{
    $(".chkclient").each(function(){
      this.checked=false;
      $('.disc').attr('disabled', true);
    })              
  }
});

function checkall(){
  // if(this.checked){
    // $(".chkclient").each(function(){
    //   this.checked=true;
    // })              
  // }else{
    // $(".chkclient").each(function(){
    //   this.checked=false;
    // })              
  // }

  alert('asd');
}

function update(id){
  $('#edis'+id).removeAttr('disabled');
  $('#ebtn'+id).hide();
  $('#sbtn'+id).show();
}

function changeDis(id){
  $.post(base_url+'clients/changediscount/'+id, {dis:$('#edis'+id).val()}, function(res){
    $('#edis'+id).attr('disabled', true);
    $('#ebtn'+id).show();
    $('#sbtn'+id).hide();

    Toast.fire({
      type: 'success',
      title: 'Update successfully.'
    });
  });
}

function removeDis(id){
  $.post(base_url+'clients/removeProduct/'+id, function(res){
    Toast.fire({
      type: 'success',
      title: 'Product Removed successfully.'
    }).then(() => {
      $('#cprow'+id).remove();
    });
  });
}