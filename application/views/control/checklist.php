<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Controls <i class="fa fa-spinner fa-spin" id="spin"></i></h3>
        <select class="form-control pull-right" id="role" style="width: 260px;">
          <option value=""> --- </option>
          <?php
            foreach ($opt as $k) {
              echo '<option value="'.$k->code.'">'.$k->title.'</option>';
            }
          ?>
        </select>
      </div>

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div id="html"></div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#spin').hide();
  $('#role').change(function(){
    $('#spin').show();
    var opt = $(this).val();
    $.post(base_url + 'privatization/get_controllers', {opt}, function(res){
      $('#spin').hide();
      res = JSON.parse(res);
      $('#html').html(res);
    });
  });

 function roleupdate(id){
  var role = $('#role').val();
  $.post(base_url+'privatization/update_role', {'role':role, 'menu':id}, function(res){
    console.log(res);
  });
 }

</script>