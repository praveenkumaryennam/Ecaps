// $(document).ready(function(){
  // $('.loaddata').dataTable().fnDestroy();
  var targeturl = base_url+'reports/json_processdata';
  $('.loaddata').DataTable({
    "processing": true,
    "serverSide": true,
    "buttons":['excel'],
    "order": [],
    "columns" : [],
    "ajax": {
      "url": targeturl,
      "type": "POST"
    }
  });
// });