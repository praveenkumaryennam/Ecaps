const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 700
});

var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
$("#designation").change(function() {
	var val = $(this).val();
	var month = $('#month').val();
	if(month){
		if(val){
			$.post(base_url+'targets/employees', {code:val, month}, function(res){
				res = JSON.parse(res);
				if(res.sts == 1){
					var html = '';
					$.each(res.data, function(i, v){
						html += '<tr><td>'+v.name+'</td><td>'+v.code+'</td><td>'+months[month-1]+'</td><td><input type="number" id="emp'+v.id+'" value="'+v.target+'" style="30px;"/></td><td><input type="number" value="'+v.incentive+'" id="iemp'+v.id+'"/></td><td><input type="number" id="cemp'+v.id+'" value="'+v.casetarget+'" style="30px;"/></td><td><input type="number" value="'+v.caseincentive+'" id="ciemp'+v.id+'"/></td><td><input type="button" class="btn btn-primary" onclick="set_target('+v.id+')" value="+"/></td></tr>';
					});	
					$('#data').html(html);
				}
			});
		}
	}else{
		Toast.fire({
      		type: 'error',
	      title: 'Please Select Month.!'
	    });
	}
});


function set_target(id){
	var target = $('#emp'+id).val();
	var incentive = $('#iemp'+id).val();
	var type = $('#month').val();
	var ctarget = $('#cemp'+id).val();
	var cincentive = $('#ciemp'+id).val();

	if(target > 0){
		$.post(base_url+'targets/set_target', {code : id, type, target, incentive, ctarget, cincentive}, function(res){
			res = JSON.parse(res);
			if(res.sts == 1){
				Toast.fire({
			      	type: 'success',
			      	title: 'Update successfully.'
			    });
			}else{
				Toast.fire({
			      	type: 'error',
			      	title: 'Somthing Error.!.'
			    });
			}
		});
	}else{
		alert('Please set Target Grater Then 0');
	}
}