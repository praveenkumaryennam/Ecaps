const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 700
});

var colors = ['#007bff','#28a745','#17a2b8','#ffc107','#dc3545','#343a40','#6c757d','#CC0000','#FF8800','#007E33','#9933CC','#0d47a1','#00695c','#3F729B'];
var product = [];
var tb = [];
var schedules = [];

if(abc == null){
	abc = [];
}else{
	$.each(abc, function (key, value) {
	   	product.push(value);
	});
}

$.each(osar, function (key, value) {
   	schedules.push(value);
});

add_product();

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
	$('#unitrate').val(0);//.attr('readonly', true);
	// $('#unitrate').val(fv);//.attr('readonly', true);
	$('#cdiscount').val(d);
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
	    if($.inArray($(this).text(), tb) !== -1){
	    	tb.splice($.inArray($(this).text(), tb), 1);
		    $(this).removeClass('btn_t_s');
	    }else{
	    	tb.push($(this).text());
		    $(this).addClass('btn_t_s');
	    }

	    $("#teethcount").val(tb);
	    $("#unit").val(tb.length);
		var unitrate = $("#unitrate").val();
	    var unit = $("#unit").val();
	    $("#total").val(unitrate * unit);
	}
});

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
	
	if(abc == null){
		abc = [];
	}
	abc.push(ab);

    product = [];
	$.each(abc, function (key, value) {
	   	product.push(value);
	});

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

        html += '<table class="table table-bordered"><tr><th>Product Category</th><th>Product Type</th><th>Product</th><th>Teeth</th><th>Units</th><th>Unit Price</th><th>Total</th><th width="60" style="background: '+colors[z]+'"></th></tr><tr><td>'+product[z].productcategory.title+'</td><td>'+product[z].producttype.title+'</td><td>'+product[z].product.title+'</td><td>'+product[z].teethcount+'</td><td>'+product[z].unit+'</td><td>'+product[z].unitrate+'</td><td>'+ ( parseFloat(product[z].unitrate) * parseInt(product[z].unit) ) +'</td><td><a href="javascript:removeProduct('+z+')"><i class="fa fa-remove btn btn-danger"></i></a></td></tr><tr><td colspan="8">'+rx+'</td></tr></table>';
    }
    $('#addedproducts').html(html);
    rxselabel = [];
}

var a = abc;
function removeProduct(id){
	var t = a[id].teethcount.split(",");
    for (var f = 0; f < t.length; f++) {
        $('#t_' + t[f]).removeAttr('style');
    }
	a.splice(id, 1);
	abc = a;
	product = abc;
	add_product();
}

$('.schedules').change(function(){
  	var id = $('.schedules').data('id');
  	var dates = $('.schedules').val();
  	var sts = ($("#ssts"+id+":checked").data('id') > 0)?1:0;
	schedules.push({id:id, date:dates, sts: sts});
});

var fm = 0;
if($('#fm').prop("checked") == true){
	fm = 1;
}

product = product;

$('.redu_order').click(function(){

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

	const orderdetails = {
		'full_mouth': fm,
		'ordernumber' : $('#order_number').val(),
		'client_id': $('#clientid').val(),
		'orderdate': $('#orderdate').val(),
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
		'correction_tamp': $('#correction_tamp').val(),
		'finalenclosure': $('#finalenclosure').val(),
		'docname': $('#docname').val(),
		'paddress': $('#paddress').val(),
		'products': product,
		'schedules': schedules
	};

	if(product.length > 0){
		$('.centered').show();
		$('.placeorder').hide();

		$.post(base_url+'orders/reduorder',{orderdetails}, function(res){
			res  = JSON.parse(res);
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


	//Invoice
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
	// var subtotal = parseFloat($('#subtotal'+id).data('subtotal'));
	var subtotal = parseFloat($('#stotal').val());
	var total = ((subtotal * gst)/100) + subtotal;

	// $("#stotal").val(total.toFixed(2));
	// $("#total").text(total.toFixed(2));

	var aamount = 0;//parseFloat($('#add_amount').val());
	
	// product[s] = {
	// 	"asubtotal": subtotal,
	// 	"agst": gst,
	// 	"atotal": total,
	// };

	// var p = product.length-1;

	// for($z=1;$z<=product.length-1;$z++){
		final_subtotal = subtotal;
		final_amount += total;
		final_gst += gst;
		final_gst_amount = (final_subtotal * final_gst)/100;
	// }


	$("#figst").val(igst);
	$("#fsgst").val(sgst);
	$("#fcgst").val(cgst);

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

$('#doctorlist').change(function(){
	var d = $(this).val();
	$('#docname').val(d);
	$('#modal-default4').modal('toggle');
});

$('#priority').change(function(){
	var p = $('#priority').find(':selected').data('days');
	if($('#fm').prop("checked") == false){
	    $('#duedate').val(get_newDate(p));
	}
});

//Full mouth
$('#fm').click(function(){
	if($(this). prop("checked") == true){
	  $('#loc_tbl').show();
	}else{
	  $('#loc_tbl').hide();
	}
});

var di = 1;
function get_newDate(days, sts = false){
	var start = new Date();
	var n = start.getDay();
	
	if( n == 0 ){
		days = parseInt(days) + 1;
	}else{
		days = parseInt(days) + 0;
	}

	var finish = new Date(start.setDate(start.getDate() + parseInt(days)));

	if(finish.getDay() === 0){
		finish = new Date(start.setDate(start.getDate() + parseInt(1)));
	}else if(finish.getDay() === 1 && days == 2){
		finish = new Date(start.setDate(start.getDate() + parseInt(1)));
	}else if(finish.getDay() === 2 && days == 3){
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