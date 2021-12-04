const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 700
});

var in_total = $('#invoice_total').val();
var	paid_total = $('#paid_total').val();	
var blc = 0;

$(function(){
	$('.cheque').hide();
	$('#gpay').hide();
	blc = Math.round(parseFloat(in_total) - parseFloat(paid_total));
	if(blc == 0){
		$('#blcshow').hide();
	}
	$('#blc_show').text(blc);
	$('#paybtn').hide();
});

$('#pay_amount').keyup(function(){
	var pa = $(this).val();
	var newblc = Math.round(blc-parseFloat(pa));

	if(newblc == 0){
		$('#pay_amount').attr('disabled', true);
		$('#paybtn').show();
	}else{
		if(newblc < 0){
			Toast.fire({
		      type: 'warning',
		      title: 'Sorry amount is more then Balance Amount.',
		      timer: 2000
		    }).then(() => {
				$('#pay_amount').val(0);
				newblc = 0;
		    });
		}else{
			$('#pay_amount').removeAttr('disabled');
		}
	}

	$('#newblc').text('Remaining Balance Amount '+ newblc.toFixed(2));
});


$('#paybtn').click(function(){

	var obj = {
		pamount:$('#pay_amount').val(),
		payment_mode : $('#payement_mode').val(),
		reference_no : $('#reference_no').val(),
		check_no : $('#check_no').val(),
		bankname : $('#bankname').val(),
		ifsc_code : $('#ifsc_code').val(),
		check_date : $('#check_date').val(),
	};

	$.post(base_url+'payment/payamount/'+$(this).data('in'), obj, function(res){
		if(res){
			Toast.fire({
		      type: 'success',
		      title: 'Added successfully.'
		    }).then(() => {
		        window.location.reload();
		    });
		}
	});
});

$('#paybtn2').click(function(){
	var obj = {
		paydate:$('#pay_date').val(),
		amount:$('#pay_amount').val(),
		payment_mode : $('#payement_mode').val(),
		reference_no : $('#reference_no').val(),
		check_no : $('#check_no').val(),
		bankname : $('#bankname').val(),
		ifsc_code : $('#ifsc_code').val(),
		check_date : $('#check_date').val(),
		client : $('#client').val(),
	};

	$.post(base_url+'payment/bulkpayment/', obj, function(res){
		if(res){
			Toast.fire({
		      type: 'success',
		      title: 'Added successfully.'
		    }).then(() => {
		        window.location.reload();
		    });
		}
	});
});

$('#payement_mode').change(function(){
	var c = $(this).val();
	if(c == 'cash'){
		$('.cheque').hide();
		$('#gpay').hide();
	}
	if(c != 'cheque' && c != 'cash'){
		$('.cheque').hide();
		$('#gpay').show();
	}
	if(c == 'cheque' && c != 'cash'){
		$('.cheque').show();
		$('#gpay').hide();
	}
});