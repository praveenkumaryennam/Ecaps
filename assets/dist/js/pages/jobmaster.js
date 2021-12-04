const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 700
});


$(".form-add").submit(function(e) {
  e.preventDefault();
  axios.post(base_url+'jobmaster/'+$(this).attr('action'), $(this).serialize()).then(function(res){
    if(res.data.status){
    	Toast.fire({
	        type: 'success',
	        title: 'Added successfully.'
	      }).then(() => {
            window.location.reload();
        });
    }
  }).catch(function (error) {
    console.log(error);
  });
});