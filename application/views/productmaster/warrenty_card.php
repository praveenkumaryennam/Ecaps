<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Product Warranty</h3>
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
                    <th>Sr.no</th>
                    <th>Date Time</th>
                    <th>Product</th>
                    <th>Product Type</th>
                    <th>Case Number</th>
                    <th>Dentist Name</th>
                    <th>Dentist Mobile</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){

                        if($row->pstatus == 1){
                          $s = 'Dispatch';//'<select class="from-control" id="pstatus_'.$row->id.'" onChange="pstatus('.$row->id.')">
                          //   <option value="0">Pending</option>
                          //   <option value="1" selected>Dispatch</option>
                          // </select>';
                        }else{
                          $s = '<select class="form-control" id="pstatus_'.$row->id.'" onChange="pstatus('.$row->id.')">
                            <option value="0" selected>Pending</option>
                            <option value="1">Dispatch</option>
                          </select>';
                        }

                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.date('d M, Y h:i A', strtotime($row->date.' '.$row->time)).'</td>
                        <td>'.get_product_title($row->product, 'product').'</td>
                        <td>'.get_product_title($row->product_type, 'producttype').'</td>
                        <td>'.$row->case_number.'</td>
                        <td>'.$row->clientname.'</td>
                        <td>'.$row->cmobile.'</td>
                        <td>'.$s.'</td>
                        <td><a href="'.base_url('productmaster/warrentycard/'.$row->id).'"><i class="fa fa-print btn btn-info"></i></a></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Generate Warranty Card</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/productmaster/warranty_card');?>" method="post">
          <div class="row">
            <div class="col-md-6 form-group">
                <label class="imp">Date</label>
                <input type="text" id="date" name="date" placeholder="DD-MM-YYYY" class="form-control datepicker" value="<?= date('d-m-Y');?>" required="required">
            </div>
            <div class="col-md-6 form-group">
                <label class="imp">Time</label>
                <input type="time" id="time" name="time" class="form-control" value="<?= date('H:i:s');?>" required="required">
            </div>

            <div class="col-md-6 form-group">
                <label>Warranty Code</label>
                <input type="text" id="warrenty_code" name="warrenty_code" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>Verification Code</label>
                <input type="text" id="verification_code" name="verification_code" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>Frame Bar Code</label>
                <input type="text" id="frame_bar_code" name="frame_bar_code" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label class="imp">Case Number</label>
                <input type="text" id="case_number" name="case_number" class="form-control" required="required">
            </div>

            <table class="table table-bordered">
              <tr>
                <th>Product Type</th>
                <th colspan="2"><select name="product_type" id="product_type_p"></select></th>
              <tr>
              </tr>
                <th>Product Name</th>
                <th colspan="2"><select name="product_name" id="product_name_p"></select></th>
              </tr>
              <tr>
                <th>Units</th>
                <th colspan="2"><input type="text" name="units" id="units_p" /></th>
              </tr>
              <tr>
                <th>Case Discription</th>
                <th colspan="2"><input type="text" name="case_desc" id="case_desc_p" /></th>
              </tr>
              <tr>
                <th colspan="3">Shade - 
                  <input type="text" id="s1" name="s1" style="width: 10%" />
                  <input type="text" id="s2" name="s2" style="width: 10%" />
                  <input type="text" id="s3" name="s3" style="width: 10%" />
                </th>

              </tr>
              <tr>
                <th colspan="3">Dentist - <input type="text" name="dentist_name" id="dentist_name_p" /></th>
              </tr>
              <tr>
                <th>Mobile</th>
                <th>Email</th>
                <th>Location</th>
              </tr>
              <tr>
                <td><input type="text" name="cmobile" id="dentist_mobile_p" /></td>
                <td><input type="text" name="cemail" id="dentist_email_p" /></td>
                <td><input type="text" name="clocation" id="dentist_location_p" /></td>
              </tr>

              <tr>
                <th colspan="4">Patient - <input type="text" name="patient_name" id="patient_name_p" /></th>
              </tr>
              <tr>
                <th>Mobile</th>
                <th>Email</th>
                <th>Location</th>
              </tr>
              <tr>
                <td><input type="text" name="pmobile" id="patient_email_p" /></td>
                <td><input type="text" name="pemail" id="patient_mobile_p" /></td>
                <td><input type="text" name="plocation" id="patient_location_p" /></td>
              </tr>
            </table>
          </div>
      </div>
      <div class="modal-footer">
        <select name="status" id="status" class="form-control pull-left" style="width: 200px;">
          <option value="0">Pending</option>
          <option value="1">Dispatch</option>
        </select>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn_stm">Save changes</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script>
  var url = "warranty";
  $('#btn_stm').hide();
  $('#case_number').keyup(function(){
    $.post('case_details/'+$(this).val(), function(res){
      html = '<option value=""> --- </option>';
      res = JSON.parse(res);
      $.each(res, function(i,v){
        html += '<option value="'+v.product_type+'">'+v.title+'</option>';
      });
      $('#product_type_p').html(html);
    });
  });

  $('#warrenty_code').change(function(){
    var wc = $(this).val();
    $.get(base_url+"productmaster/wc/"+wc, function(res){
      if(res == 1){
        $('#btn_stm').show();
        $('#warrenty_code').css('border-color', 'green');
      }
      else{
        $('#btn_stm').hide();
        $('#warrenty_code').css('border-color', 'red');
      }
    })
  });

  $('#product_type_p').change(function(){
    $.post('case_details/'+$('#case_number').val()+'/'+$('#product_type_p').val()+'/'+$(this).val(), function(res){
      html = '<option value=""> --- </option>';
      res = JSON.parse(res);
      $.each(res, function(i,v){
        html += '<option value="'+v.product_id+'">'+v.title+'</option>';
      });
      $('#product_name_p').html(html);
    });
  });

  $('#product_name_p').change(function(){
    $.post('case_info/'+$('#case_number').val()+'/'+$('#product_type_p').val()+'/'+$(this).val(), function(res){
      res = JSON.parse(res);

      $('#units_p').val(res.unit);
      $('#case_desc_p').val(res.note);
      $('#dentist_name_p').val(res.clientname);
      $('#patient_name_p').val(res.patiant_name);
      $('#dentist_email_p').val(res.email);
      $('#dentist_mobile_p').val(res.mobile);
      $('#dentist_location_p').val(res.location);

      get_shade(res.shade_one, 1);
      get_shade(res.shade_two, 2);
      get_shade(res.shade_three, 3);
    });
  });

  function get_shade(s, id){
    $.get('shade_info/'+s, function(res){
      $('#s'+id).val(res);
    });
  }

  function pstatus(id){
    var ps = $('#pstatus_'+id).val();
    $.post(base_url+"productmaster/change_wc_status", {id, ps}, function(res){
      if(res == 1){
        alert('Updated');
      }

      if(res == 0){
        alert('Somting Error.!');
      }
    });
  }

</script>