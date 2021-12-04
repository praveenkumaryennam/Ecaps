const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 700
});

var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

$('#btn_set_add').click(function() {
	var val = $("#designation").val();
	var month = $('#month').val();
	var department = $('#department').val();
	
	if(month != "" && department != ""){
		if(val){
			$.post(base_url+'targets/employees', {code:val, month, department}, function(res){
				res = JSON.parse(res);
				if(res.sts == 1){
					var html = '';
					$.each(res.data, function(i, v){
						console.log(v.is_type);
						if(v.is_type == 'case')
							html += '<tr><td>'+v.name+'</td><td>'+v.code+'</td><td>'+months[month-1]+'</td><td><select id="temp'+v.id+'"><option value="case" selected>Case</option><option value="units">Units</option></select></td><td><input type="number" id="emp'+v.id+'" value="'+v.target+'" style="30px;"/></td><td><input type="number" value="'+v.incentive+'" id="iemp'+v.id+'"/></td><td><input type="button" class="btn btn-primary" onclick="set_target('+v.id+')" value="+"/></td></tr>';
						else	
							html += '<tr><td>'+v.name+'</td><td>'+v.code+'</td><td>'+months[month-1]+'</td><td><select id="temp'+v.id+'"><option value="case">Case</option><option value="units" selected>Units</option></select></td><td><input type="number" id="emp'+v.id+'" value="'+v.target+'" style="30px;"/></td><td><input type="number" value="'+v.incentive+'" id="iemp'+v.id+'"/></td><td><input type="button" class="btn btn-primary" onclick="set_target('+v.id+')" value="+"/></td></tr>';
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
	var type = $('#temp'+id).val();
	var month = $('#month').val();
	var department = $('#department').val();



	// var ctarget = $('#cemp'+id).val();
	// var cincentive = $('#ciemp'+id).val();


	if(target > 0){
		$.post(base_url+'targets/set_target', {code : id, type, target, incentive, month, department}, function(res){
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