$(function() {
    var table = $('#activity-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
        ajax: app_url + 'systems/activities/ajax',
        columns: [
            {data: 'id', name: 'id', 'class':'dt-center'},
            {data: 'created_at', name: 'created_at'},
            {data: 'description', name: 'description'},
            {data: 'userId', name: 'userId'},
            {data: 'methodType', name: 'methodType'},
            {data: 'route', name: 'route'},
            {data: 'ipAddress', name: 'ipAddress'},
            {data: 'userAgent', name: 'userAgent'},
            {data: 'action', name: 'action',  orderable: false, searchable: false},
        ]
    });

    $(document).on("click","#btn-truncate", function(){
	  swal({
	      title: "Bạn có chắc không?",
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      cancelButtonText: "Không",
	      confirmButtonText: "Có",
	  },
	  function(isConfirm) {
	      if (isConfirm) {

	        $.ajax({
	              type: "DELETE",
	              url: app_url + 'systems/activities/truncate-activity-logs',
	              success: function(res)
	              {
	                if(!res.error) {
	                    toastr.success('Thành công!');
	                    table.ajax.reload();
	                }
	              },
	              error: function (xhr, ajaxOptions, thrownError) {
	                toastr.error(thrownError);
	              }
	        });
	      }
	  });
	});


});