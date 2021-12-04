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


$.validator.setDefaults({
    errorClass: 'help-block',

    highlight: function (e) {
        $(e).closest('td').addClass('has-error');
    },
    unhighlight: function (e) {
        $(e).closest('td').removeClass('has-error');
    }
});

//form validation
$('form').validate({
    rules: {
        name: {
            required: true,
        }
    }
});

$(".form-add").on( "submit", function(e) {
  e.preventDefault();
  axios.post(base_url+'organization/company', $(this).serialize()).then(function(res){
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

$(".form-update").on( "submit", function(e) {
  e.preventDefault();
  axios.post(base_url+'organization/updatecompany', $(this).serialize()).then(function(res){
    if(res){
      Toast.fire({
        type: 'success',
        title: 'Added successfully.'
      }).then(() => {
          window.location.reload();
      });
    }else{
      Toast.fire({
        type: 'error',
        title: 'Tryagain.'
      })
    }
  }).catch(function (error) {
    console.log(error);
  });
});

function update(id, master){
  $.post(base_url+'organization/update/'+id, {master:master}, function(res){
    res = JSON.parse(res);
    $('#eaddress').val(res.data.address);
    $('#ecin').val(res.data.cin);
    $('#eemail').val(res.data.email);
    $('#efax').val(res.data.fax);
    $('#egst').val(res.data.gst);
    $('#eid').val(res.data.id);
    $('#emobile').val(res.data.mobile);
    $('#epan').val(res.data.pan);
    $('#estatus').val(res.data.status);
    $('#etel').val(res.data.tel);
    $('#ename').val(res.data.title);
    $('#ewebsite').val(res.data.website);
    $('#eid').val(res.data.id);
  });
  $('#updateModal').modal('toggle');
}