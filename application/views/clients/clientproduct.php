<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="box-header">
                <h3 class="box-title">Clients</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
            	<div class="table-responsive">
				    <form action="<?= base_url('clients/addclientproducts/').$id;?>" method="post">
					    <table id="example" class="table table-bordered table-striped">
					        <thead>
					            <tr>
					                <th><input type="checkbox" id="checkall" /></th>
					                <th>Product Name</th>
					                <th>Product Category</th>
					                <th>Code</th>
					                <th>Price</th>
					                <th width="120">Discount(%)</th>
					                <th width="120">Price Band</th>
					            </tr>
					        </thead>
					        <tbody>
					            	<?php 
					            		$i = 1;
					            		$d = client_product($id);
			            				if(!empty($d)){
					            			foreach($d as $o){
					            	?>
							                <tr>
							                    <td><input type="checkbox" class="chkclient" name="check[]" value="<?= $o->code;?>" id="<?= $o->code;?>"></td>
							                    <td><?= ucfirst($o->title);?></td>
							                    <td><?= ucfirst($o->category);?></td>
							                    <td><?= $o->code;?></td>
							                    <td><?= number_format($o->unit_price, 2);?></td>
							                    <td><input type="number" name="discount[]" class="form-control disc" id="<?= $o->code;?>_txt" data-id="<?= $o->code?>" data-price="<?= $o->unit_price;?>" value="0" style="width: 120px;" disabled="disabled"/></td>
							                    <td><input type="text" class="form-control abc" id="<?= $o->code;?>_num" style="width: 120px;" disabled="disabled"/></td>
							                </tr>
					            	<?php } } ?>
					        </tbody>
					    </table>
		            	<button type="submit" class="btn btn-primary pull-right" style="width: 120px;">Submit</button>
		            </form>
				</div>
            </div>
        </div>
	</div>
</div>