$(function(){
     $('.select2').select2();
     $('.reservationtime').daterangepicker({ datepicker:true, timePicker: false, timePickerIncrement: 30, locale: { format: 'DD/MM/YYYY' }}).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".ranges").hide();
        });

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });

    $('#logout_btn').click(function(){
      Toast.fire({
        type: 'success',
        title: 'Signout successfully.'
      })
      setInterval(function(){ logout() }, 1000);
    });

    function logout(){
      window.location.replace("/");
    }

    //Datatables
    $('.datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'ordering'    : true,
    })

    $('table.datatable_btn').DataTable({
      'ordering'    : false,
      dom: 'Blfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          title: excel_title
        },
      ]
    });

    $('table.datatable_exl_repo').DataTable({
      'paging'      : false,
      "searching"   : false,
      'lengthChange': false,
      'ordering'    : false,
      dom: 'Blfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          title: excel_title
        },
      ]
    });

    $('.datatable_exl').DataTable({
      'ordering'    : true,
      dom: 'Blfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          title: $('#pclientl').val()
        },
      ]
    });

    $('.datatable_pag').DataTable({
      'paging'      : true,
      'ordering'    : true,
      'lengthChange': true,
      'info'        : true,
    })


    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      "maxDate": new Date()
    })
    
    var adate = new Date();
    adate.setDate(adate.getDate()-7);
    $(".pre_dates").datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        startDate: adate,
        
        endDate: new Date()
    }); 
    

    
    $('.dynamic_select').on('change', function () {
        var url = $(this).val();
        if (url) {
          window.location = url;
        }
        return false;
    });
  });

  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    $($.fn.dataTable.tables(true)).DataTable().scroller.measure();
  });


  // navigator.serviceWorker.register('assets/dist/sw.js', { scope: '/' })
  // .then(function (registration)
  // {
  //   console.log('Service worker registered successfully');
  // }).catch(function (e)
  // {
  //   console.log('Error during service worker registration:', e);
  // });