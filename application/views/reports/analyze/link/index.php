<style type="text/css">
  .widget-user .widget-user-header{
    height: auto !important;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <div class="row">
          <form action="<?= base_url('analysereports/index');?>" method="post" autocomplete="off">        
            <div class="form-group col-md-3">
              <label>Date</label>
              <input name="date" id="date" class="form-control datepicker" value="<?= date('d-m-Y');?>" />
            </div>

            <div class="form-group col-md-3">
              <label>WorkType</label>
              <select name="worktype" id="worktype" class="form-control worktype">
                <option value="new">New</option>
                <option value="redo">Redo</option>
                <option value="correction">Correction</option>
              </select>
            </div>

            <div class="form-group col-md-3">
              <label>Country</label>
              <select name="country" id="country" class="form-control select2">
                <option value=""> --- </option>
                <?php 
                  foreach (loadoption('country') as $opt){
                    echo '<option value=\''.$opt->id.'\'>'.$opt->country.'</option>';
                } ?>
              </select>
            </div>

            <div class="col-md-12">
              <button type="submit" class="btn btn-primary pull-right sbtn"><i class="fa fa-spinner fa-spin" style="display: none; margin-right: 5px;"></i> Get Report </button>
            </div>
          </form>
        </div>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <?php $this->load->view($table_data);?>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.sbtn').click(function(){
    $('.fa-spinner').show();
    $(this).attr('style', 'cursor:not-allowed;pointer-events:none');
  });
</script>