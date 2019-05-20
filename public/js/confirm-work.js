$(document).ready(function(){
	var web = $('meta[name="website"]').attr('content');

	var table = $('#job-calendar-table').DataTable({
		processing: true,
		serverSide: true,
		ordering: false,
		order: [], 
		pageLength: 30,
		lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
		ajax: {
			type: 'GET',
			url: web + 'confirm-work/get-confirm-work',
		},
		columns: [
		{data: 'is_confirm', name: 'is_confirm', orderable: false, searchable: false, 'class': 'text-center'},
		{data: 'number_hour_work', name: 'number_hour_work', 'class': 'text-center'},
		{data: 'user_id', name: 'user_id', 'width': '20%'},
		{data: 'email', name: 'email'},
		{data: 'mobile', name: 'mobile'},
		{data: 'shift', name: 'shift', 'class': 'text-center', 'width': '10%'},
		{data: 'type_job', name: 'type_job', 'class': 'text-center', 'width': '10%'},
		]
	});

	//Xác nhận làm việc của nhân viên
	$('body').on('click','#is-confirm-work',function(){
		var id = $(this).data('id');	

		swal({
			title: 'Bạn có muốn xác nhận giờ làm việc của nhân viên này?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			cancelButtonText: 'Không',
			confirmButtonText: 'Có',
		},
		function() { 
			$.ajax({
				url: web + 'confirm-work/is-confirm-work',
				type: 'POST',
				data: {
					id: id,
					number_hour_work: $('#number_hour_work-' + id).val(),
				},
				success: function (res){
					if (res.error != true) {
						toastr.success(res.message);
						$('#job-calendar-table').DataTable().ajax.reload();
					}else{
						toastr.error(res.message);
					}
				}, 
				error: function (err){
				}
			});
		});
	});

	//Hủy xác nhận làm việc
	$('body').on('click','#is-not-confirm-work',function(){
		var id = $(this).data('id');
		$('#confirm_work_id').val(id);
		$('#reason').val(''),
		$('#reason-modal').modal('show');	
	});

	$('#reason').on('keyup', function(){	
		var reason = $("#reason").val();

		if(reason == null || reason == ''){
			$('#error_reason').html('Lý do hủy xác nhận không được để trống');
			$('#error_reason').css("color", "red");
			$('#btn-confirm-reason').prop('disabled', true);
			return false;
		}else{
			$('#error_reason').html('');
			$('#btn-confirm-reason').removeAttr('disabled');
			return true;
		}
	})

	$('#btn-confirm-reason').on('click',function(){
		var reason = $("#reason").val();

		swal({
			title: 'Bạn có muốn hủy xác nhận giờ làm việc của nhân viên này?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			cancelButtonText: 'Không',
			confirmButtonText: 'Có',
		},
		function() { 
			$.ajax({
				url: web + 'confirm-work/is-not-confirm-work',
				type: 'POST',
				data: {
					reason: reason,
					id: $('#confirm_work_id').val(),
				},
				success: function (res){
					if (res.error != true) {
						toastr.success(res.message);
						$('#job-calendar-table').DataTable().ajax.reload();
						$('#reason-modal').modal('hide');	
					}else{
						toastr.error(res.message);
					}
				}, 
				error: function (err){
				}
			});
		});
	});

	//Show lý do hủy xác nhận làm việc
	$('body').on('click','#reason-form',function(){
		var id = $(this).data('id');

		$.ajax({
			url: web + 'confirm-work/get-reason',
			type: 'POST',
			data: {
				id: id,
				number_hour_work: $('#number_hour_work').val(),
			},
			success: function (res){
				if (res.error != true) {
					$('#reason-confirm-work').html(res.reason);
					$('#frmReasonModal').modal('show');	
				}else{
					toastr.error(res.message);
				}
			}, 
			error: function (err){
			}
		});
	});

	//Thêm mới giờ làm việc cho nhân viên
	$('body').on('click','#add-new',function(){
		var id = $(this).data('id');

		$.ajax({
			url: web + 'confirm-work/get-list-user',
			type: 'POST',
			data: {
				id: id,
			},
			success: function (res){
				if (!res.error) {
					var user_id = document.getElementById('user_id');

					if (user_id.length > 0) {
						for (var j = 0; j < res.arr.length; j++) {  
							$("#user_id option[value='" + res.arr[j] + "']").remove();
						}
					}
				}

				$('#createModal').modal('show');
			}, 
			error: function (err){
			}
		});
	});

	//Lưu nhân viên làm thêm giờ
	$('#add').on('click',function(){
		var reason = $("#reason").val();

		swal({
			title: 'Bạn muốn thêm giờ làm việc của nhân viên này?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			cancelButtonText: 'Không',
			confirmButtonText: 'Có',
		},
		function() { 
			$.ajax({
				url: web + 'confirm-work/add-number-hour-work',
				type: 'POST',
				data: {
					user_id: $('#user_id').val(),
					shift: $('#shift').val(),
				},
				success: function (res){
					if (res.error != true) {
						toastr.success(res.message);
						$('#job-calendar-table').DataTable().ajax.reload();
						$('#createModal').modal('hide');	
					}else{
						toastr.error(res.message);
					}
				}, 
				error: function (err){
				}
			});
		});
	});

});