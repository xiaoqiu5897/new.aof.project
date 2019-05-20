$(function(){
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).on("submit", "#frm-create", function(e) {
    e.preventDefault();

    var formData  = $('#frm-create').serialize();

    $.ajax({
      url: app_url + "contact-store",
      type: 'POST',
      data: {
        'data': formData
      },
      success: function(res){
        if (res.err != true) {
          toastr.success(res.msg);
          setTimeout(function() {
            window.location.href = app_url + "contacts";
          }, 2000);
        }
      }
    });
  });

  $(document).on("submit", "#frm-edit", function(e) {
    e.preventDefault();

    var formData  = $('#frm-edit').serialize();

    $.ajax({
      url: app_url + "contact-update",
      type: 'POST',
      data: {
        'data': formData
      },
      success: function(res){
        // console.log(res);
        if (res.err != true) {
          toastr.success(res.msg);
          setTimeout(function() {
            window.location.href = app_url + "contacts";
          }, 2000);
        }
      }
    });
  });

  $(document).on("click", "#btn-delete", function(e) {
    e.preventDefault();

    var id = $(this).attr("value");

    swal({
        title: 'Bạn có muốn xóa?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dd6b55',
        cancelButtonColor: '#999',
        confirmButtonText: 'Có',
        cancelButtonText: 'Không',
        closeOnConfirm: true
    }, function() {

      $.ajax({
        url: app_url + "delete-update",
        type: 'POST',
        data: {
          id: id
        },
        success: function(res){
          if (res.err != true) {
            toastr.success(res.msg);
            setTimeout(function() {
              window.location.href = app_url + "contacts";
            }, 2000);
          }
        }
      });
    });

  });
});
