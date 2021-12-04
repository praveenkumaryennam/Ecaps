<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="box-header">
        <h3 class="box-title">Employees</h3>
        <button class="btn btn-primary add" style="margin-left: 5px;" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Import</button>
        <a href="<?= base_url('employee/add'); ?>" class="btn btn-primary add"><i class="fa fa-plus"></i> Add</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered datatable_btn">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Designation</th>
                    <th>Location</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($rows)) {
                    $i = 1;
                    foreach ($rows as $row) {
                      if ($row->status == 0) {
                        $remove_btn = '<a href="javascript:dlt_emp(' . $row->id . ')" id="' . $row->id . '" data-id="' . $row->id . '" data-sts="1"><i class="fa fa-trash btn btn-danger"></i></a>';
                      } else {
                        $remove_btn = '<a href="javascript:dlt_emp(' . $row->id . ')" id="' . $row->id . '" data-id="' . $row->id . '" data-sts="0"><i class="fa fa-check btn btn-success"></i></a>';
                      }
                      echo '<tr>
                            <td>' . $i++ . '</td>
                            <td>' . $row->firstname . ' ' . $row->lastname . '</td>
                            <td>' . $row->code . '</td>
                            <td>' . ucfirst($row->gender) . '</td>
                            <td>' . $row->email . '</td>
                            <td>' . $row->mobile . '</td>
                            <td>' . $row->designation . '</td>
                            <td>' . $row->location . '</td>
                            <td>
                              <a href="javascript:fileupload(' . $row->id . ')" class="btn btn-info add" alt="File Upload"><i class="fa fa-file-o"></i></a>
                              <a href="' . base_url("employee/edit/" . $row->id) . '"><i class="fa fa-eye btn btn-warning"></i></a>
                              ' . $remove_btn . '  
                            </td>
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
        <h5 class="modal-title pull-left" id="exampleModalLabel">Import Employees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('employee/import'); ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="imp">DataFile</label>
              <input type="file" name="importfile" class="form-control" required>
              <small> Download Export Format File <a href="<?= base_url('assets/files/Import_Employees.xlsx'); ?>"> <i class="fa fa-download"></i> click here</a></small>
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

<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="exampleModalLabel">Upload Files</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('employee/fileupload'); ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="imp">Upload File</label>
              <input type="file" name="files[]" multiple="multiple" class="form-control" required>
              <input type="hidden" name="empid" id="empid" />
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

<script type="text/javascript">
  function fileupload(id) {
    $('#empid').val(id);
    $('#fileModal').modal('toggle');
  }

  function dlt_emp(id) {
    var sts = $('#'+id).data('sts');
    $.post(base_url + 'employee/dlt_status/' + id + '/' + sts, function(res) {
      if (sts == 1) {
        $('#' + id).find('i').removeClass('fa fa-trash btn btn-danger');
        $('#' + id).find('i').addClass('fa fa-check btn btn-success');
        $('#' + id).data('sts', '0');
      } else {
        $('#' + id).find('i').removeClass('fa fa-check btn btn-success');
        $('#' + id).find('i').addClass('fa fa-trash btn btn-danger');
        $('#' + id).data('sts', '1');
      }
    })
  }
</script>
