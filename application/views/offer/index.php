<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Offers</h3>
        <button class="btn btn-primary add" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Offer</th>
                    <th>Offer Type</th>
                    <th>Minimum Order</th>
                    <th>Offering</th>
                    <th>Active / In-active</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.ucfirst($row->title).'</td>
                        <td>'.ucfirst($row->offer_type).'</td>
                        <td>'.$row->minimum_order.'</td>
                        <td>'.$row->offering.'</td>
                        <td>'.($row->status?'Active':'In-active').'</td>
                        <td><a href="#"><i class="fa fa-trash btn btn-danger"></i></a> <a href="javascript:update('.$row->id.', \'company\')"><i class="fa fa-edit btn btn-warning"></i></a></td>
                        </tr>';
                      }
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
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
        <h5 class="modal-title" id="exampleModalLabel">New Offer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" enctype="multipart/form-data" method="post" class="form-add">
          <div class="row">
            <div class="form-group col-md-6">
                <label class="imp">Offer</label>
                <input name="offer" id="offer" type="text" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label class="imp">Offer Type</label>
                <select name="offer_type" id="offer_type" class="form-control" required>
                  <option value="product">Product</option>
                  <option value="billing">Billing</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label class="imp">Minimum Order</label>
                <input type="number" name="min_order" id="min_order" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label class="imp">Discount</label>
                <input type="number" name="offering" id="offering" class="form-control" required>
            </div>

            <div class="form-group col-md-12" style="text-align-last: justify; border: 1px solid #f4f4f4; padding:0px 25%">
                <label><input name="offeringtype" value="amt" class="offeringtype" type="radio" required /> Amount</label>
                <label><input name="offeringtype" value="per" class="offeringtype" type="radio" required/> Percentage</label>
                <label><input name="offeringtype" value="pro" class="offeringtype" type="radio" required/> Product</label>
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


<script type="text/javascript">
  $('form').submit(function(e){
    e.preventDefault();

    var data = {
      'offer' : $('#offer').val(),
      'offer_type' : $('#offer_type').val(),
      'min_order' : $('#min_order').val(),
      'offering' : $('#offering').val(),
      // 'product' : $('#product').val(),
      'offeringtype' : $("input[type='radio']:checked").val(),
    };

    $.post(base_url+'offer', data, function(res){
      console.log(res);
    });
  });
</script>