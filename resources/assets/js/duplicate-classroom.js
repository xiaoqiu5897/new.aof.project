$(document).ready(function() {

	var app_url = $('meta[name="website"]').attr('content');

    var today = new Date();

    var minDate = today.getFullYear() + '/' + (today.getMonth()+1) + '/' + today.getDate();

	$('.datetimepicker').datetimepicker({
  	   	format: "dd DD/MM/YYYY HH:mm",
	    minDate: minDate,
	    locale: 'vi',
	    keepOpen: false,
  	});
 
    $('.duplicate-datepicker').datetimepicker({
  	   	format: "dd DD/MM/YYYY",
	    minDate: minDate,
	    locale: 'vi',
	    keepOpen: false,
    });    

      $('#duplicate_orientation_time').on('dp.change', function() {
       var minDate = $('#duplicate_orientation_time').data('DateTimePicker').viewDate()['_d'];
       minDate.setHours(0,0,0);
        $('#duplicate_first_unit').data('DateTimePicker').minDate(minDate)
        $('#duplicate_second_unit').data('DateTimePicker').minDate(minDate)
      })
      $('#duplicate_first_unit').on('dp.change', function() {
       var minDate = $('#duplicate_first_unit').data('DateTimePicker').viewDate()['_d'];
       minDate.setHours(0,0,0);
        $('#duplicate_second_unit').data('DateTimePicker').minDate(minDate)
      })

	window.duplicateClassroom = function(class_id) {
		$.ajax({
			type: 'GET',
			url : app_url + 'duplicate-classrooms/' + class_id,
			success: function(res){
				if (!res.error) {
					$('#units_count').text(res.units + ' buổi');
					$('#exercises_count').text(res.exercises + ' bài');
					$('#theories_count').text(res.theories + ' bài');
					$('.datetimepicker').data('DateTimePicker').clear();
					$('.duplicate-datepicker').data('DateTimePicker').clear();
					$('#duplicate-classroom-mdl').modal('show');
					$('#class_id').val(class_id);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
            	toastr.error(thrownError);
          	}
		});
	}

	$('#duplicate-frm').validate({
		onkeyup: false,
		rules: {
			duplicate_name: {
				required: true,
			},
			duplicate_code: {
				required: true,
				remote: {
					url: app_url + 'duplicate-classrooms/check-exists-code',
			        type: "post",
			        data: {
			          code: function() {
			          	return $("#duplicate_code").val();
			          },
			        }
				}
			},
			duplicate_orientation_time: {
				required: true,
			},
			duplicate_first_unit: {
				required: true,
			},
			duplicate_second_unit: {
				required: true,
			},
		},
		messages: {
			duplicate_name: {
				required: "Tên lớp mới không được bỏ trống",
			},
			duplicate_code: {
				required: 'Mã lớp không được bỏ trống"',
				remote: 'Mã lớp đã tồn tại',
			},
			duplicate_orientation_time: {
				required: 'Ngày khai giảng dự kiến không được bỏ trống"',
			},
			duplicate_first_unit: {
				required: 'Buổi học số 1 không được bỏ trống"',
			},
			duplicate_second_unit: {
				required: 'Buổi học số 2 không được bỏ trống',
			},
		}
	});

	$('#duplicate-btn').on('click', function() {

		var duplicate_orientation_time = formatDate($('#duplicate_orientation_time').data("DateTimePicker").viewDate()['_d']);
		var duplicate_first_unit = formatDate($('#duplicate_first_unit').data("DateTimePicker").viewDate()['_d']);
		var duplicate_second_unit = formatDate($('#duplicate_second_unit').data("DateTimePicker").viewDate()['_d']);

		if ($('#duplicate-frm').valid()) {
			$.ajax({
				type: 'POST',
				url : app_url + 'duplicate-classrooms/store',
				data: {
					'class_id': $('#class_id').val(),
					'class_name': $('#duplicate_name').val(),
					'code': $('#duplicate_code').val(),
					'orientation_time': duplicate_orientation_time,
					'first_unit': duplicate_first_unit,
					'second_unit': duplicate_second_unit,
				},
				success: function(res){
					if (!res.error) {
						toastr.success(res.message);
						$('#duplicate-classroom-mdl').modal('hide');
						$('#duplicate-frm').trigger('reset');
						$('#class-table').DataTable().ajax.reload();
					} else if (res.error){
						toastr.error(res.message);
					} else {
						toastr.warning(res.message);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
	            	toastr.error(thrownError);
	          	}
			});
		}
	})

	window.formatDate = function(date)
	{

	  	var day = addZero(date.getDate());
	  	var month = addZero(date.getMonth() + 1);
	  	var year = addZero(date.getFullYear());
	  	var hours = addZero(date.getHours());
	  	var minutes = addZero(date.getMinutes());
	  	var seconds = addZero(date.getSeconds());

	  	return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
	}

	window.addZero = function(time)
	{
		if (time < 10) {
	        time = "0" + time;
	    }

	    return time;
	}
})