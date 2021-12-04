const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 1000
});

var colors = ['#007bff','#28a745','#17a2b8','#ffc107','#dc3545','#343a40','#6c757d','#CC0000','#FF8800','#007E33','#9933CC','#0d47a1','#00695c','#3F729B'];
var product = [];
var tb = [];
var rem_cap_amt = 0;
var wave_cap_amt = 0;

$('#productcategory').change(function() {
	axios.post(base_url + 'productmaster/typesopt/'+$(this).val()).then(function(res){
	    if(res.data.sts == 1){
	    	var html = '<option value="">---</option>';
	      	$.each(res.data.data, (i, v) => {
	        	html += '<option value="' + v.code + '">' + v.title + '</option>';
	      	});
	      	$('.ptyps').html(html);
	    }
  	}).catch(function (error) {
    	console.log(error);
  	});
})

$('#producttype').change(function() {
	var client_id = $('#clientid').val();
	axios.post(base_url + 'productmaster/productsopt/'+$(this).val()+'/'+client_id).then(function(res){
	    if(res.data.sts == 1){
	    	var html = '<option value="">---</option>';
	      	$.each(res.data.data, (i, v) => {
	        	var dprice = parseFloat(v.price) - ((parseFloat(v.price) * parseFloat(v.discount))/100);
	        	html += '<option value="' + v.code + '" data-v="'+ v.price +'" data-d="'+ v.discount +'">' + v.title +' (Rs:'+dprice+'/-)</option>';
	      	});
	      	$('.products').html(html);
	    }
  	}).catch(function (error) {
    	console.log(error);
  	});
})

$('#producttype').change(function() {
	var client_id = $('#clientid').val();
	axios.post(base_url + 'productmaster/rxs/'+$(this).val()).then(function(res){
	    if(res.data.sts == 1){
	    	rx = JSON.parse(res.data.data);
	    	$.each(rx, (i, v) => {
	    		$("#rx"+v.id).show();
	    		// $("#rxs"+v.id).val(v.option).change();
	      	});
	    }
  	}).catch(function (error) {
    	console.log(error);
  	});
})

$('.products').change(function(){
	var id = $(this).val();
	var p = $(this).find(':selected').data('v');
	var d = $(this).find(':selected').data('d');
	var fv = p-((p*d)/100);
	$('#unitrate').val(fv).attr('readonly', true);
	$('#cdiscount').val(d);
	$('#sel_all_teeth').show();
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

$('.btn_t').click(function(){
	if($('.products').val() == null){
		alert('Please Select Product');
	}else{
		var selected_teeth = $(this).text();
		if($.inArray(selected_teeth, tb) !== -1){
	    	tb.splice($.inArray(selected_teeth, tb), 1);
		    $(this).removeClass('btn_t_s');
	    }else{
	    	tb.push(selected_teeth);
		    $(this).addClass('btn_t_s');
	    }
	    teeth_count();
	}
});

function teeth_count(){
	$("#teethcount").val(tb);
	$("#unit").val(tb.length);
	var unitrate = $("#unitrate").val();
    var unit = $("#unit").val();
    $("#total").val(unitrate * unit);
}

// Select All Teeth
	$('#sel_all_teeth').click(function(){
		if($('.products').val() == null){
			alert('Please Select Product');
		}else{
			var ek = $('.btn_t').map((_,el) => el.innerText).get();
			$.each(ek, (i, v) => {
				if($.inArray(v, tb) !== -1){
			    	tb.splice($.inArray(v, tb), 1);
				    $('.btn_t').removeClass('btn_t_s');
			    	$("#teethcount").val('');
				    $("#unit").val('');
				    $("#total").val('');
			    }else{
					tb.push(v);
					$('.btn_t').addClass('btn_t_s');
                	teeth_count();
			    }
			});
		}
	});



// Select All Teeth


$('#btnAdd').click(function () {
    var array = [];
    var arraya = [];
    $("input:checkbox[name=type]:checked").each(function () {
    	var id = $(this).data('id');
    	var attr = $(this).data('value');
        array.push($(this).data('value') +":"+ $('#en'+id).val());
        arraya.push($(this).data('value') +":"+ $('#en'+id).val());
    });
    
    $('#enclosure').text(array); 
    $('#finalenclosure').val(JSON.stringify(arraya));
    $('#modal-default1').modal('toggle');
});

var rxselabel = [];
$('.selopt').change(function(){
  	var id = $(this).data('id');
  	var rxs = $(this).val();
	rxselabel.push({id:id, opt:rxs, title:$("#rxl"+id).text(), sel:$("#rx"+id+" option:selected").text()});
});

$('#btnproduct').click(function () {
    var ab = {
        "productcategory": {id:$("#productcategory").val(), title:$("#productcategory option:selected").text()},
        "producttype": {id:$("#producttype").val(), title:$("#producttype option:selected").text()},
        "product": {id:$("#product").val(), title:$("#product option:selected").text()},
        "teethcount": $("#teethcount").val(),
        "unit": $("#unit").val(),
        "unitrate": $("#unitrate").val(),
        "cdiscount": $("#cdiscount").val(),
        "total": $("#total").val(),
        "rx":rxselabel
	};
    product.push(ab); 
    add_product();

    tb.length = 0;
    $("#productcategory").val("");
    $("#producttype").val("");
    $("#product").val("");
    $("#teethcount").val("");
    $("#unit").val("");
    $("#unitrate").val("");
    $("#total").val("");
    $(".btn_t").removeClass("btn_t_s");
    $("#restorationtype").val("");
});

function add_product() {
    var html = '';
    var cap_amt = parseFloat($('#capping_amt').text());
    var cap_val = parseFloat($('#cap_value').val());
    
    
    $('#addedproducts').html('');
    
    for (var z = 0; z < product.length; z++) {
	    var t = product[z].teethcount.split(",");
	    for (var f = 0; f < t.length; f++) {
	        $('#t_' + t[f]).css("border", '2px solid '+colors[z]);
	        $('#t_' + t[f]).css("border-radius", '50%');
	        $('#t_' + t[f]).css("padding", '5px');
	    }
	    
	    var rx = "";
	    $.each(product[z].rx, function(i, v){
	    	rx += "<label>"+v.title+"</label> : " + v.sel +", ";
	    });

	    html += '<table class="table table-bordered"><tr><th>Product Category</th><th>Product Type</th><th>Product</th><th>Teeth</th><th>Units</th><th>Unit Price</th><th>Total</th><th width="60" style="background: '+colors[z]+'"></th></tr><tr><td>'+product[z].productcategory.title+'</td><td>'+product[z].producttype.title+'</td><td>'+product[z].product.title+'</td><td>'+product[z].teethcount+'</td><td>'+product[z].unit+'</td><td>'+product[z].unitrate+'</td><td>'+ (parseFloat(product[z].unitrate) * parseInt(product[z].unit)) +'</td><td><i class="fa fa-remove btn btn-danger"></i></td></tr><tr><td colspan="8">'+rx+'</td></tr></table>';
			var t = (parseFloat(product[z].unitrate) * parseInt(product[z].unit));
			cap_amt -= t;
			wave_cap_amt += t;
	}
	$('#addedproducts').html(html);


    if(cap_val > 0){
    	if(cap_amt >= 0)
        	$('#capping_amt').text(cap_amt);
        else{
        	Toast.fire({
		        type: 'error',
		        title: 'Capping Amount Reached'
		      });
        	// product = [];
        	// $('.tb').removeAttr('style');
        	// $('#addedproducts').html('');
        }
        rem_cap_amt = cap_amt;
        if(rem_cap_amt < 0){
        	$('.placeorder').hide();
        }    
    }
    rxselabel = [];
}

var schedules = [];
$('.schedules').change(function(){
  	var id = $(this).data('id');
  	var dates = $(this).val();
  	var sts = ($("#ssts"+id+":checked").data('id') > 0)?1:0;
	schedules.push({id:id, date:dates, sts: sts});
});


$('.placeorder').click(function(){
	if($('#patientname').val() == ''){
		alert('patient name required.!');
		return false;
	}

	if($('#priority').val() == ''){
		alert('priority required.!');
		return false;
	}

	if($('#status').val() == ''){
		alert('status required.!');
		return false;
	}
	
	var fm = 0;
	if($('#fm').prop("checked") == true){
		fm = 1;
	}

	const orderdetails = {
		'client_id': $('#clientid').val(),
		'full_mouth': fm,
		'orderdate': $('#orderdate').val(),
		'duedate': $('#duedate').val(),
		'indate': $('#indate').val(),
		'duetime': $('#duetime').val(),
		'intime': $('#intime').val(),
		'patientname': $('#patientname').val(),
		'patientage': $('#age').val(),
		'modalno': $('#modalno').val(),
		'anote': $('#anote').val(),
		'additionalamount': $('#additionalamount').val(),
		'delivery': $('#delivery').val(),
		'status': $('#status').val(),
		'priority': $('#priority').val(),
		'pan_tray': $('#pan_tray').val(),
		'assignto': $('#assignto').val(),
		'manufacturer': $('#manufacturer').val(),
		'dept': $('#dept').val(),
		'worktype': $('#worktype').val(),
		'shade1': $('#shade1').val(),
		'shade2': $('#shade2').val(),
		'shade3': $('#shade3').val(),
		'shadenote': $('#shadenote').val(),
		'articulatortag': $('#articulatortag').val(),
		'finalenclosure': $('#finalenclosure').val(),
		'correction_tamp': $('#correction_tamp').val(),
		'docname': $('#docname').val(),
		'paddress': $('#paddress').val(),
		'products': product,
		'schedules': schedules,
		'rem_cap_amt': rem_cap_amt,
		'wave_cap_amt': wave_cap_amt
	};

	if(product.length > 0){
	    $('.centered').show();
	    $('.placeorder').hide();
	
		$.post(base_url+'orders/placeorder',{orderdetails}, function(res) {
			res = JSON.parse(res);
			if(res.sts == 1){
		    	Toast.fire({
			        type: 'success',
			        title: res.data
			      }).then(() => {
		            window.location.href = base_url+'/orders';
		        });
		    }
		});
	}else{
		alert('Please add product');
		return false;
	}
});


var product = [];
function calcul(){
	var final_subtotal = 0;
	var final_gst = 0;
	var final_amount = 0;
	var final_gst_amount = 0;
	var p = 0;
	var igst = parseFloat($('#igst').val());
	var sgst = parseFloat($('#sgst').val());
	var cgst = parseFloat($('#cgst').val());

	var gst = igst + sgst + cgst;
	var orgsubtotal = parseFloat($('#stotal').val());
	var subtotal = orgsubtotal;
	var add_amouunt = parseFloat($('#add_amount').val());
	var discount = parseFloat($('#adiscount').val());

	if(add_amouunt > 0){
		subtotal = (subtotal + add_amouunt);	
	}
	
	if(discount > 0){
		subtotal = (subtotal - discount);	
	}

	var total = ((subtotal * gst)/100) + subtotal;

	var aamount = 0;



	final_subtotal = orgsubtotal;



	final_amount += total;
	final_gst += gst;
	final_gst_amount = (final_subtotal * final_gst)/100;

	$(".figst").val(igst);
	$(".fsgst").val(sgst);
	$(".fcgst").val(cgst);

	$('#final_subtotal').text(final_subtotal.toFixed(2));
	$('#final_gst').text(final_gst.toFixed(2));
	$('#final_gst_amount').text(final_gst_amount.toFixed(2));
	$('#final_amount').text((final_amount+aamount).toFixed(2));

	$('#txfinal_subtotal').val(final_subtotal.toFixed(2));
	$('#txfinal_gst').val(final_gst.toFixed(2));
	$('#txfinal_gst_amount').val(final_gst_amount.toFixed(2));
	$('#txfinal_amount').val((final_amount+aamount).toFixed(2));
}

$('.duedatepic').change(function(){
    var tt = $(this).val();

    var date = new Date(tt);
    var newdate = new Date(date);
    newdate.setDate(date.getDate() + 3);
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = mm + '/' + dd + '/' + y;
	$('#txtduedate').text(someFormattedDate);
});

function getNumberOfWeekDays(start, end, dayNum){
  // Sunday's num is 0 with Date.prototype.getDay.
  dayNum = dayNum || 0;
  // Calculate the number of days between start and end.
  var daysInInterval = Math.ceil((end.getTime() - start.getTime()) / (1000 * 3600 * 24));
  // Calculate the nb of days before the next target day (e.g. next Sunday after start).
  var toNextTargetDay = (7 + dayNum - start.getDay()) % 7;
  // Calculate the number of days from the first target day to the end.
  var daysFromFirstTargetDay = Math.max(daysInInterval - toNextTargetDay, 0);
  // Calculate the number of weeks (even partial) from the first target day to the end.
  return Math.ceil(daysFromFirstTargetDay / 7);
}

//Add Sub Doctor
$('#addsubdoc').click(function(){
	$dat = {
		'client_id' : $('#clientid').val(),
		'name' : $('#adoctorname').val(),
		'mobile' : $('#adcontact').val(),
		'dp' : $('#adp').val(),
	};
	$.post(base_url+'clients/add_subdoctor', $dat, function(res){
		if(res == 1){
			$('#adoctorname').val('');
			$('#adcontact').val('');
			$('#adp').val('');
			$('#docname').val($dat['name']);
		}
	});
});

//GET Sub Doctor List
$('#doctorlist').change(function(){
	var d = $(this).val();
	$('#docname').val(d);
	$('#modal-default4').modal('toggle');
});

// Delete Order By Order ID
function deleteorder(id, order_numner){
	var odnum = prompt("Please confirm Order Numner");
	
	if (odnum == order_numner) {
		$.post(base_url+"orders/deleteorder/"+id, function(res){
	      Toast.fire({
	        type: 'success',
	        title: res.data
	      }).then(() => {
	          window.location.reload();
	      });
	    });
	}else{
		Toast.fire({
	        type: 'warning',
	        title: 'Sorry, Order confirmation failed.!'
	    });
	}
}


//Full mouth
$('#fm').click(function(){
	if($(this). prop("checked") == true){
	  $('#loc_tbl').show();
	}else{
	  $('#loc_tbl').hide();
	}
});

$('.rlocation').click(function(){
	if($(this).is(':checked')) {
	  var p = $(this).val();
	  var nd = get_newDate(p);
	  $('#duedate').val(nd);
	}
});

$('#priority').change(function(){
	var p = $('#priority').find(':selected').data('days');
	if($('#fm').prop("checked") == false){
	    $('#duedate').val(get_newDate(p));
	}
});

var di = 1;
function get_newDate(days, sts = false){
	var start = new Date();
	var n = start.getDay();

	if( n == 0 || (n == 6 && days == 4)){
		days = parseInt(days) + 1;
	}else{
		days = parseInt(days) + 0;
	}

	var finish = new Date(start.setDate(start.getDate() + parseInt(days)));
	if(finish.getDay() === 0){
		finish = new Date(start.setDate(start.getDate() + parseInt(1)));
	}else if(finish.getDay() === 1 && days == 2){
		finish = new Date(start.setDate(start.getDate() + parseInt(1)));
	}else if(finish.getDay() === 2 && (days == 3 || days == 4)){
		finish = new Date(start.setDate(start.getDate() + parseInt(1)));
	}

	console.log(FormateDate(finish));
	return FormateDate(finish);
}


function FormateDate(finish){
	var dd = ("0"+finish.getDate()).slice(-2);
	var m = finish.getMonth() + 1;
	var mm = ("0"+ (m)).slice(-2);
	var y = finish.getFullYear();
	return dd + '-' + mm + '-' + y;
}


//Get Order Rows 
$('#loaddata').DataTable( {
    // Processing indicator
    "processing": true,
    // DataTables server-side processing mode
    "serverSide": true,
    
    // Initial no order.
    "order": [],
  
    // Load data from an Ajax source
    "ajax": {
        "url": base_url+"orders/loaddata",
        "type": "POST"
    },

    //Set column definition initialisation properties
    "columnDefs": [{ 
        "targets": [0],
        "orderable": false
    }]
});

$('#loadinvoices').DataTable( {
    // Processing indicator
    "processing": true,
    // DataTables server-side processing mode
    "serverSide": true,
    
    // Initial no order.
    "order": [],
  
    // Load data from an Ajax source
    "ajax": {
        "url": base_url+"orders/loadinvoices",
        "type": "POST"
    },

    //Set column definition initialisation properties
    "columnDefs": [{ 
        "targets": [0],
        "orderable": false
    }]
});
