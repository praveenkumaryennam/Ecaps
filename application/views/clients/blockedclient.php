<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Blocked Clients  List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th width="1%">Sr.no</th>
                    <th>Client Name</th>
                    <th>Code</th>
                    <th>Zone</th>
                    <th>Blocks</th>
                    <th>Last Block Date</th>
                    <th>Last Block Time</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($rows)){
                      $i = 1;
                      foreach($rows as $row){
                        if($row->status == 0)
                          $dbtn = '<a href="javascript:blockclient(\''.$row->id.'\')"><i id="dbtns'.$row->id.'" data-sts="1" class="fa fa-unlock-alt btn btn-success"></i></a>';
                        else
                          $dbtn = '<a href="javascript:blockclient(\''.$row->id.'\')"><i id="dbtns'.$row->id.'" data-sts="0" class="fa fa-lock btn btn-danger"></i></a>';

                        $datetime = block_date($row->id);
                        if(!empty($datetime)){
                          $date = date('d-m-Y', strtotime(block_date($row->id)));
                          $time = date('h:i a', strtotime(block_date($row->id)));
                        }else{
                          $date = '---';
                          $time = '---';
                        }

                        echo '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$row->clientname.'</td>
                        <td>'.ucfirst($row->code).'</td>
                        <td>'.get_zone_title_by_station($row->station_id).'</td>
                        <td>'.block_count($row->id).'</td>
                        <td>'.$date.'</td>
                        <td>'.$time.'</td>
                        <td>'.$dbtn.'
                        <a href="'.base_url("clients/edit/").$row->id.'"><i class="fa fa-edit btn btn-warning"></i></a></td>
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
        <h5 class="modal-title pull-left" id="exampleModalLabel">Import Clinets</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('clients/import');?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="imp">DataFile</label>
                <input type="file" name="importfile" class="form-control" required>
                <small> Download Export Format File <a href="<?= base_url('files/Import_Clients.xlsx');?>"> <i class="fa fa-download"></i> click here</a></small>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
        </form>
    </div>
  </div>
</div>
<script>
  function blockclient(id){
    var sts = $('#dbtns'+id).data('sts');
    $.post(base_url+'clients/block_client/'+id+'/'+sts, function(res){
      if(sts == 1){
        $('#dbtns'+id).removeClass('fa fa-unlock-alt btn btn-success');
        $('#dbtns'+id).addClass('fa fa-lock btn btn-danger');
        $('#dbtns'+id).data('sts', '0');
      }else{
        $('#dbtns'+id).removeClass('fa fa-lock btn btn-danger');
        $('#dbtns'+id).addClass('fa fa-unlock-alt btn btn-success');
        $('#dbtns'+id).data('sts', '1');
      }
    })
  }
</script>