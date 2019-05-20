$(function() {
    var table = $('#logs-table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
        ajax: app_url + 'systems/list-logs',
        columns: [
            {data: 'id', name: 'id', 'class':'dt-center'},
            {data: 'level', name: 'level'},
            {data: 'formatted', name: 'formatted'},
            {data: 'extra', name: 'extra'},
            // {data: 'web', name: 'web',  orderable: false, searchable: false},

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
	              type: "POST",
	              url: app_url + 'truncate-logs-table',
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