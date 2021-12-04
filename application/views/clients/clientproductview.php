<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="box-header">
                <h3 class="box-title">Clients</h3>
                <a href="<?= base_url('clients/addclientproducts/').$id;?>" class="btn btn-primary add"><i class="fa fa-plus"></i> Add</a>
                <!-- <button class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button> -->
            </div>

            <!-- /.box-header -->
            <div class="box-body">
            	<div class="table-responsive">
    				    <table id="example" class="table table-bordered table-striped datatable">
    				        <thead>
    				            <tr>
    				                <th></th>
                            <th>Product Name</th>
    				                <th>Product Category</th>
    				                <th>Code</th>
    				                <th>Price</th>
    				                <th width="120">Discount(%)</th>
                            <th>Price Band</th>
                            <th><a href="<?= base_url('clients/priceband_report/'.$id);?>" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i></a></th>
    				            </tr>
    				        </thead>
    				        <tbody>
    				            	<?php $i = 1; 
    		            			//$d = client_product($id);
    			            			foreach($rows as $o){ ?>
    				                <tr id="cprow<?= $o->cpid;?>">
    				                    <td><?= $i++;?></td>
    				                    <td><?= ucfirst($o->title);?></td>
                                <td><?= ucfirst($o->category);?></td>
    				                    <td><?= $o->code;?></td>
    				                    <td><?= number_format((float)$o->unit_price, 2);?></td>
    				                    <td>
                                  <input type="text" value="<?= $o->discount;?>" id="edis<?= $o->cpid;?>" disabled="disabled"/>
                                </td>
                                <td><?= number_format(((float)$o->unit_price - ((float)$o->unit_price * (float)$o->discount)/100), 2);?></td>
                                <td style="display: inline-flex">
                                  <a id="ebtn<?= $o->cpid;?>" href="javascript:update(<?= $o->cpid;?>);"><i class="fa fa-edit btn btn-warning"></i></a>&nbsp;
                                  <a id="sbtn<?= $o->cpid;?>" href="javascript:changeDis(<?= $o->cpid;?>);" style="display:none"><i class="fa fa-check btn btn-success"></i></a>&nbsp;
                                  <a href="javascript:removeDis(<?= $o->cpid;?>);"><i class="fa fa-trash btn btn-danger"></i></a>
                                </td>
    				                </tr>
    				            	<?php } ?>
    				        </tbody>
    				    </table>
      				</div>
            </div>
        </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('clients/addclientproducts/').$id;?>" method="get" class="form-add">
          <div class="row">
            <div class="col-md-12 form-group">
            	<label class="imp">Category</label>
                <select class="form-control" id="category" name="category">
                  <option value=""> --- </option>
                  <?php
                    foreach (loadoptions('category') as $opt){
                      echo '<option value=\''.$opt->id.'\'>'.$opt->title.'</option>';
                    }
                  ?>
                </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
        </form>
    </div>
  </div>
</div>