$(document).ready(function() {
  $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
});

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var remove_learn_time_table, change_learn_time_table;

$(function() {
  remove_learn_time_table = $('#remove-learn-time-tbl').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    bSort: false,
    ajax: {
      url: app_url + "remove-learn-time/get-list",
      type: 'post',
    },
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    columns: [
    {data: 'unit', name: 'unit', 'class':'dt-center', 'width':'45px'},
    {data: 'action', name: 'action', orderable: false, searchable: false, 'class':'dt-center', 'width':'125px'},
    {data: 'unit_name', name: 'unit_name'},
    {data: 'class_name', name: 'class_name'},
    {data: 'learn_time_old', name: 'learn_time_old', 'class':'dt-center','width':'124px'},
    {data: 'reason_remove', name: 'reason_remove', 'width':'300px'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center','width':'124px'},
    ]
  });

  change_learn_time_table = $('#change-learn-time-tbl').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    ajax: {
      url: app_url + "change-learn-time/get-list",
      type: 'post',
    },
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    columns: [
    {data: 'unit', name: 'unit', 'class':'dt-center', 'width':'45px'},
    {data: 'action', name: 'action', orderable: false, searchable: false, 'class':'dt-center', 'width':'85px'},
    {data: 'unit_name', name: 'unit_name'},
    {data: 'class_name', name: 'class_name'},
    {data: 'learn_time_old', name: 'learn_time_old', 'class':'dt-center'},
    {data: 'deadline_old', name: 'deadline_old', 'class':'dt-center'},
    {data: 'learn_time_new', name: 'learn_time_new', 'class':'dt-center'},
    {data: 'deadline_new', name: 'deadline_new', 'class':'dt-center'},
    {data: 'reason_change', name: 'reason_change', 'width':'200px'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center','width':'124px'},
    ]
  });
});

$('#list_remove_time_tab').click(function(){
  remove_learn_time_table.ajax.reload(null, false);
});

$('#list_change_time_tab').click(function(){
  change_learn_time_table.ajax.reload(null, false);
});

//Đổi lịch học
window.managerConfirmChangeLearnTime = function(enroll_id){

  swal({
    title: "Xác nhận đổi lịch học?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    cancelButtonText: "Hủy bỏ",
    confirmButtonText: "Xác nhận",
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        type: "POST",
        url: app_url + "confirm-learn-time",
        data: {
          enroll_id : enroll_id,
          is_changed: 1,
        },
        success: function(res)
        {
          if (!res.error) {
            toastr.success('Xác nhận thành công !');
            change_learn_time_table.ajax.reload(null,false);
          } else {
            toastr.error(res.message);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
    }
  });
}

var declineData = new Array();

window.declineChangeLearnTime = function(enroll_id){
  $('#declineLearnTimeModal').modal('show');
  $('#change-time-title').show();
  $('#remove-time-title').hide();
  $('#declineChangeLearnTimeBtn').show();
  $('#declineRemoveLearnTimeBtn').hide();

  declineData['enroll_id'] = enroll_id;
  declineData['is_changed'] = 0;
  $('#decline-note').val('');
}

$('#declineChangeLearnTimeBtn').on('click', function(){
  if ($('#decline-note').val() == "") {
    $('#decline-note').next().removeClass('hide');

    return false;
  } else {
    $('#decline-note').next().addClass('hide');
  }

  $.ajax({
    type: "POST",
    url: app_url + "confirm-learn-time",
    processing: true,
    serverSide: true,
    data: {
      enroll_id: declineData['enroll_id'],
      is_changed:  declineData['is_changed'],
      reason_change: $('#decline-note').val(),
    },
    success: function(res)
    {
      if (!res.error) {
        toastr.success('Hủy bỏ thành công !');
        $('#declineLearnTimeModal').modal('hide');
        $('#decline-note').val("");
        change_learn_time_table.ajax.reload( null, false );
      } else {
        toastr.error(res.message);
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);
    }
  });
})

//Hủy lịch học
window.managerConfirmRemoveLearnTime = function(enroll_id){

  swal({
    title: "Xác nhận hủy lịch học?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    cancelButtonText: "Hủy bỏ",
    confirmButtonText: "Xác nhận",
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        type: "POST",
        url: app_url + "confirm-remove-learn-time",
        data: {
          enroll_id : enroll_id,
          is_changed: 1,
        },
        success: function(res)
        {
          if (!res.error) {
            toastr.success('Xác nhận thành công !');
            remove_learn_time_table.ajax.reload(null,false);
          } else {
            toastr.error(res.message);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
    }
  });
}

window.declineRemoveLearnTime = function(enroll_id){
  $('#declineLearnTimeModal').modal('show');
  $('#change-time-title').hide();
  $('#remove-time-title').show();
  $('#declineChangeLearnTimeBtn').hide();
  $('#declineRemoveLearnTimeBtn').show();

  declineData['enroll_id'] = enroll_id;
  declineData['is_changed'] = 0;
  $('#decline-note').val('');
}

$('#declineRemoveLearnTimeBtn').on('click', function(){
  if ($('#decline-note').val() == "") {
    $('#decline-note').next().removeClass('hide');

    return false;
  } else {
    $('#decline-note').next().addClass('hide');
  }

  $.ajax({
    type: "POST",
    url: app_url + "confirm-remove-learn-time",
    processing: true,
    serverSide: true,
    data: {
      enroll_id: declineData['enroll_id'],
      is_changed:  declineData['is_changed'],
      reason_remove: $('#decline-note').val(),
    },
    success: function(res)
    {
      if (!res.error) {
        toastr.success('Hủy bỏ thành công !');
        $('#declineLearnTimeModal').modal('hide');
        $('#decline-note').val("");
        remove_learn_time_table.ajax.reload( null, false );
      } else {
        toastr.error(res.message);
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);
    }
  });
})