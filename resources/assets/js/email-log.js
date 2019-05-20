$(function() {

  list_table = $('#list-table').DataTable({
      processing: true,
      serverSide: true,
      order: [],
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      ajax: app_url + "get-list-email",
      // deferRender: true,
      columns: [
          {data: 'DT_Row_Index', orderable: true, searchable: false},
          {data: 'to', name: 'to'},
          {data: 'subject', name: 'subject'},
          {data: 'type', name: 'type', orderable: false, searchable: false},
          {data: 'status', name: 'status', orderable: false, searchable: false},
          {data: 'num_submissions', name: 'num_submissions'},
          {data: 'updated_at', name: 'updated_at'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
  });

  $(document).on('change', '.filter', function() {

    var type = $('#type_filter').val();

    var status = $('#status_filter').val();

    list_table = $('#list-table').dataTable().fnDestroy();

    list_table = $('#list-table').DataTable({
     
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + "get-list-email",
        data: {
          'status' : status,
          'type'  : type
        },
      }, 
      order: [],
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      deferRender: true,
      columns: [
        {data: 'DT_Row_Index', orderable: true, searchable: false},
        {data: 'to', name: 'to'},
        {data: 'subject', name: 'subject'},
        {data: 'type', name: 'type', orderable: false, searchable: false},
        {data: 'status', name: 'status', orderable: false, searchable: false},
        {data: 'num_submissions', name: 'num_submissions'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

  })

  $(document).on('click', '.btn-resend', function() {

      var id = $(this).data('id');
      $.ajax({
        url: app_url + 'send-email',
        type: 'POST',
        dataType: 'JSON',
        data: {id: id},
        success : function(res) {
          if (!res.error) {
            toastr.success('Gửi thành công!');

            list_table.ajax.reload(null, false);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(xhr.responseJSON.message);  
        }
      });
  })
  $(document).on('click', '.btn-view', function() {
      var id = $(this).data('id');
      $.ajax({
        url: app_url + 'view-email/'+id,
        type: 'GET',
        dataType: 'JSON',
        success : function(res) {
          if (!res.error) {
            console.log(res.data.parameter.content);
            $('#view-email-modal').modal('show');
            $('#view-subject').text(res.data.subject);
            if (res.data.status==0) {
              var status='gửi thành công';
            }
            else if(res.data.status==1){
              var status='gửi lỗi';
            }
            else{
              var status='chưa gửi';
            }
            $('#view-destination').html('<span style=" font-weight: bold;">To: </span>'+res.data.to+'<br><span style=" font-weight: bold;">Trạng thái</span>: '+status+'&emsp; <span  style=" font-weight: bold;">Số lần gửi: </span>'+res.data.num_submissions);
            $('#view-parameter').html('<h3>Nội dung:</h3></br>'+res.data.parameter.content);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(xhr.responseJSON.message);  
        }
      });
  })
  $(document).on('click', '#btn-truncate', function() {
    swal({
    title: "Bạn có chắc muốn xóa?",
        // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "Không",
        confirmButtonText: "Có",
        
        // closeOnConfirm: false,
      },
      function(isConfirm) {
        if (isConfirm) {  
        $.ajax({
          url: app_url + 'truncate-email',
          type: 'delete',
          dataType: 'JSON',
          success : function(res) {
            if (!res.error) {
              toastr.success('Đã xoá toàn bộ email log!');
              list_table.ajax.reload(null, false);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(xhr.responseJSON.message);  
          }
        });
        } 
      });

  })
  $(document).on('click', '#btn-truncate-30-day', function() {
      
      swal({
        title: "Bạn có chắc muốn xóa?",
            // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "Không",
            confirmButtonText: "Có",
            
            // closeOnConfirm: false,
          },
          function(isConfirm) {
            if (isConfirm) {  
              $.ajax({
                url: app_url + 'truncate-30-day-email',
                type: 'delete',
                dataType: 'JSON',
                success : function(res) {
                  if (!res.error) {
                    if (res.leng==0) {
                      toastr.warning('Không có email nào cũ quá 30 ngày');
                    }else{
                      toastr.success('Đã xoá '+res.leng+' email log đã tạo quá 30 ngày!');
                      list_table.ajax.reload(null, false);
                    }
                    // console.log(res);
                  }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  toastr.error(xhr.responseJSON.message);  
                }
              });  
            } 
          });

  })

});