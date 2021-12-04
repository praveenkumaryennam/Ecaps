const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 700
});

$(() => {
  load_countrys();
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
  axios.post(base_url+'organization/'+url, $(this).serialize()).then(function(res){
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
  axios.post(base_url+'organization/makechnages', $(this).serialize()).then(function(res){
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

$('#country').change(() => {
  axios.post(base_url+'organization/statesopt/'+$('#country').val()).then(function(res){
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
  axios.post(base_url+'organization/citiesopt/'+$('#state').val()).then(function(res){
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

function load_countrys(){
 if (localStorage.getItem('countries') == null) {
    axios.post(base_url +'organization/countriesopt').then(res => {
        if (res.data.sts == true) {
            localStorage.setItem('countries', JSON.stringify(res.data.data));
            genrate_countries();
        }
    }).catch(err => {
        console.log(err);
    });
  } else {
    genrate_countries();
  }
}

function genrate_countries() {
    var staff = JSON.parse(localStorage.getItem('countries'));
    var html = '<option value="">---</option>';
    $.each(staff, (i, v) => {
        html += '<option value="' + v.id + '">' + v.country + '</option>';
    });
    $('.countries').html(html);
}

function load_states(){
 if (localStorage.getItem('states') == null) {
    axios.post(base_url +'organization/statesopt').then(res => {
        if (res.data.sts == true) {
            localStorage.setItem('states', JSON.stringify(res.data.data));
            genrate_states();
        }
    }).catch(err => {
        console.log(err);
    });
  } else {
    genrate_states();
  }
}

function genrate_states() {
    var staff = JSON.parse(localStorage.getItem('states'));
    var html = '<option value="">---</option>';
    $.each(staff, (i, v) => {
        html += '<option value="' + v.id + '">' + v.state + '</option>';
    });
    $('.states').html(html);
}

function update(id, master){
  $.post(base_url+'organization/update/'+id, {master:master}, function(res){
    res = JSON.parse(res);
    $('#eid').val(res.data.id);
    $('#etitle').val(res.data.title);
    $('#ecode').val(res.data.code);
  });
  $('#updateModal').modal('toggle');
}

function rowdelete(id, master){
  // $.post(base_url+'organization/row_delete/'+id, {master:master}, function(res){
  //   location.reload();
  // });
  // $('#updateModal').modal('toggle');
}