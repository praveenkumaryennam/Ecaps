const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 700
});


$.validator.setDefaults({
  errorClass: 'help-block',
  highlight: function (e) {
    $(e).closest('td').addClass('has-error');
  },
  unhighlight: function (e) {
    $(e).closest('td').removeClass('has-error');
  }
});

function typeupdate(id){
  $('#ecategory').val('');
  $('#etype').val('');
  $('#eid').val('');
  $('#ecode').val('');
  $('#rxselabel').val('');
  $('#erxselabel').val('');
  $('#rxlabel').val('');
  $('#rxlabel').val('');

  $.get(base_url+'productmaster/producttypeupdate/'+id, function(res){
    res = JSON.parse(res);
    $('#ecategory').val(res.type.product_category).change();
    $('#etype').val(res.type.title).change();
    $('#eid').val(res.type.id);
    $('#ecode').val(res.type.code);

    // if(res.rx != null){
    //   rx = JSON.parse(res.rx.options);
    //   if(rx.length>0){
    //     for(var i=0;i<rx.length;i++){
    //       $('#et'+rx[i].id).prop('checked',true);
    //     }
    //   }
    // }

    $('#updateModal').modal('toggle');
  });
}

//form validation
$('form').validate({
    rules: {
        title: {
          required: true,
        },
        code: {
          required: true,
        }
    }
});

$(".form-add").submit(function(e) {
  e.preventDefault();
  axios.post(base_url+'productmaster/'+url, $(this).serialize()).then(function(res){
    Toast.fire({
      type: 'success',
      title: 'Added successfully.'
    }).then(() => {
      window.location.reload();
    });
  }).catch(function (error) {
    console.log(error);
  });
});


$(".form-update").submit(function(e) {
  e.preventDefault();
  axios.post(base_url+'productmaster/updateproduct', $(this).serialize()).then(function(res){
    Toast.fire({
      type: 'success',
      title: 'Updated successfully.'
    }).then(() => {
      window.location.reload();
    });
  }).catch(function (error) {
    console.log(error);
  });
});

$(".form-typeupdate").submit(function(e) {
  e.preventDefault();
  axios.post(base_url+'productmaster/typeupdate', $(this).serialize()).then(function(res){
    Toast.fire({
      type: 'success',
      title: 'Updated successfully.'
    }).then(() => {
       window.location.reload();
    });
  }).catch(function (error) {
    console.log(error);
  });
});

var rxslabel = [];

function mservices() {
    var rxlabel = [];
  $('input[type=checkbox]:checked').map(function(_, el) {
    if($.isNumeric($(el).val()))
      rxlabel.push($(el).val());
  }).get();
  rxslabel = rxlabel;
  $('#rxlabel').val(rxlabel);
  $('#erxlabel').val(rxlabel);
}

var rxselabel = [];
$('.selopt').change(function(){
  var sid = $(this).val();
  var id = $(this).data('id');
  for(var i = 0; i <= rxslabel.length; i++){
    if(rxslabel[i] == id){
      rxselabel.push({id:id, option:sid});
    }
  }
  $('#rxselabel').val(JSON.stringify(rxselabel));
  $('#erxselabel').val(JSON.stringify(rxselabel));
});

$('.form-import').on('submit', function(event){
  event.preventDefault();
  $.ajax({
    url:"<?= base_url();?>productmaster/import/brand",
    method:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    success:function(data){
      $('#file').val('');
    }
  })
});

$('#category').change(() => {
  axios.post(base_url+'productmaster/typesopt/'+$('#category').val()).then(function(res){
    if(res.data.sts == 1){
      var html = '<option value="">---</option>';
      $.each(res.data.data, (i, v) => {
        html += '<option value="' + v.code + '">' + v.title + '</option>';
      });
      $('.types').html(html);
    }
  }).catch(function (error) {
    console.log(error);
  });
});

var etype = '';

function update(id){
  $('#eproduct_id').val(id);
  $('#etitle').val($('#vtitle'+id).val());
  $('#ecode').val($('#vcode'+id).val());
  $('#egroup').val($('#vgroup'+id).val()).change();
  $('#ebrand').val($('#vbrand'+id).val()).change();
  $('#ewarranty').val($('#vwarranty'+id).val()).change();
  $('#ecategory').val($('#vcategory'+id).val()).change();
  $('#eprice').val($('#vunit_price'+id).val()); 
  $('#updateModal').modal('toggle');
  etype = $('#vtype'+id).val();
}

$('#ecategory').change(() => {
  axios.post(base_url+'productmaster/typesopt/'+$('#ecategory').val()).then(function(res){
    if(res.data.sts == 1){
      var html = '<option value="">---</option>';
      $.each(res.data.data, (i, v) => {
        html += '<option value="' + v.code + '">' + v.title + '</option>';
      });
      $('.types').html(html);
    }
  $('#etype').val(etype).change();
  }).catch(function (error) {
    console.log(error);
  });
});