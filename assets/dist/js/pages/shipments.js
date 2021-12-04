const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 700
});


$('#shipmentdata').DataTable({
	"processing": true,
	"serverSide": true,
	"order": [],
	"ajax": {
	    "url": base_url+'shipment/getshipmentsnotes',
	    "type": "POST"
	},
	"columnDefs": [{ 
	    "targets": [0],
	    "orderable": false
	}]
});

function gen(id){
	var html = '<table class="table table-bordered table-hover"><tr><td>Shipment Date</td><td><input type="date" id="shipmentdate" class="form-control" name="sipmentdate"/></td></tr><tr><td>Client</td><td>'+$('#client').val()+'</td></tr><tr><td>Total</td><td>'+$('#ototal').val()+'</td></tr><tr><td>Delivery Mode</td><td><select name="delivery" class="form-control" id="delivery"><option value="courier">Courier</option><option value="delivery_boy">Delivery Boy</option><option value="doctors_pickup">Doctors Pickup</option><option value="mail">Mail</option></select></td></tr><tr><td>Notes Orders</td><td><input type="text" id="note" class="form-control" /><input type="hidden" value="'+$('#onumber').val()+'" id="orderno"></td></tr></table><table class="table table-bordered"><tr><td>Order</td><td>'+$('#onumber').val()+'</td><tr><td>OrderDate</td><td>'+$('#odate').val()+'</td></tr><tr><td>Patient</td><td>'+$('#patiant').val()+'</td></tr><tr><td>Products</td><td>'+$('#product').val()+'</td></tr><tr><td>Model</td><td>'+$('#modalno').val()+'</td></tr><tr><td>Status</td><td>'+$('#otitle').val()+'</td></tr><tr><td>DueDate</td><td>'+$('#duedate').val()+'</td></tr><tr><td>OrderAmount</td><td>'+$('#ototal').val()+'</td></tr></table>';
	$('#tbl').html(html);
	$('#exampleModal').modal('toggle');
}

function addshipment(id = false){
	var date = $('#shipmentdate').val();
	var note = $('#note').val();
	var mode = $('#delivery').val();
	var order = $('#onumber').val();

	$.post(base_url+'shipment/addnote', {shipmentdate:date, note:note, mode:mode, order:order}, function(res){
		res = JSON.parse(res);

		if(res.sts == 1){
	      Toast.fire({
	        type: 'success',
	        title: 'Added successfully.'
	      }).then(() => {
	        window.open(res.data);
	        if(id == true)
            	window.location.href = base_url+'orders';
	        else
	        	window.location.reload();
	      });
		}
	});
}