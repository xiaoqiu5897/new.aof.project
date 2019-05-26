@extends('layouts.master')

@section('head')
<style type="text/css">
    .dt-center{
        text-align: center;
    }
</style>
@endsection

@section('contents')

<div class="portlet light bordered">
<div class="portlet-title">
    <div class="caption" style="font-size: 14px">
        <i class="fa fa-home" aria-hidden="true"></i>
        <a href="{{ route('dashboard') }}">  Trang chủ </a>
        &nbsp;/&nbsp; Quản lý tiền tệ
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        @if(Entrust::can(['permissions-manager']))
        <a data-toggle="modal" href="#createMoney"><button class="btn btn-sm green reset_data btnAdd"><i class="fa fa-plus"></i> Thêm mới</button></a>
        @endif
    </div>
</div>
<div class="portlet-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="moneys-table">
	        <thead>
	            <tr>
	                <th style="text-align: center;">STT</th>
	                <th style="text-align: center;">Hành động</th>
	                <th style="text-align: center;">Tên</th>
	                <th style="text-align: center;">Ngày tạo</th>
	            </tr>
	        </thead>
	    </table>
	</div>
</div>
</div>

<div class="modal fade" id="createMoney">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Thêm mới</h4>
		    </div>
			<form id="formCreateMoney" method="POST" role="form">
			    <div class="modal-body">
			        <div class="col-sm-12">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="text" name="name" id="name" class="form-control">
			            	<label for="name" class="control-label">Tên <span style="color: red">(*)</span></label>
			          	</div>
			        </div>
			    </div>
		    </form>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="submit" form="formCreateMoney" class="btn btn-sm btn-success" style="margin-top: 20px;" id="btnCreatePer">Thêm mới</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="editMoney">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Chỉnh sửa thông tin</h4>
		    </div>
			<form id="formEditMoney" role="form">
			    <div class="modal-body">
			        <div class="col-sm-12">
			          	<div class="form-group">
			          		<label for="name" class="control-label">Tên <span style="color: red">(*)</span></label>
			            	<input type="text" name="name" id="name_edit" class="form-control">
			          	</div>
			        </div>
			    </div>
		    </form>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="submit" form="formEditMoney" class="btn btn-sm btn-success" style="margin-top: 20px;">Cập nhật</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

@endsection

@section('footer')

<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script src="{{url('js/bootstrap-fileinput.js')}}"></script>
<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>

<script>
	$('#moneys-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        order: [],
        pageLength: 30,
        ajax: {
				type: 'get',
				url: '{{url('')}}/list-money',
			},
        columns: [
        	{data: 'DT_RowIndex', className:'tbl_stt', 'class':'dt-center', "searchable": false,},
            {data: 'action', name: 'action', 'class':'dt-center', "searchable": false,},
            {data: 'name', name: 'name', 'class':'dt-center'},
            {data: 'created_at', name: 'created_at', 'class':'dt-center', "searchable": false,},   
        ]
    });
</script>
{{-- Tạo mới --}}
<script type="text/javascript">
	$('.btnAdd').on('click', function() {
		$('#formCreateMoney')[0].reset();
	});
</script>
<script type="text/javascript">
	$('#formCreateMoney').on('submit', function(event) {
		event.preventDefault();

		var data = $('#formCreateMoney').serializeArray();

		$.ajax({
            url: '{{ route('moneys.store') }}',
            type: 'POST',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#createMoney').modal('hide');
                    toastr.success(res.message);
                    $('#moneys-table').DataTable().ajax.reload(null,false);
                }
                else {
                    $.each(res.message, function( key, value ) {
                        toastr.error(value);
                    });
                }
            }
        });
	});
</script>
{{-- ========================= --}}
{{-- Chỉnh sửa --}}
<script type="text/javascript">
	$('#moneys-table').on('click', '.btn-edit', function() {
		$('#editMoney').modal('show');
		$('#formEditMoney')[0].reset();

		var id = $(this).attr('data-id');

		$.ajax({
            url: '{{ asset('moneys') }}/' + id,
            type: 'GET',

            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#name_edit').val(res.data.name);

                    $('#formEditMoney').attr('data-id', id);
                }
                else {
                    $.each(res.message, function( key, value ) {
                        toastr.error(value);
                    });
                }
            }
        });
	});
</script>
<script type="text/javascript">
	$('#formEditMoney').on('submit', function(event) {
		event.preventDefault();

		var id = $(this).attr('data-id');

		var data = $('#formEditMoney').serializeArray();

		$.ajax({
            url: '{{ asset('moneys') }}/' + id,
            type: 'PUT',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#editMoney').modal('hide');
                    toastr.success(res.message);
                    $('#moneys-table').DataTable().ajax.reload(null,false);
                }
                else {
                    toastr.error(res.message);
                }
            }
        });
	});
</script>
{{-- ========================= --}}
{{-- Xóa --}}
<script type="text/javascript">
	$('#moneys-table').on('click', '.btn-delete', function() {
		var id = $(this).attr('data-id');

		swal({
            title: "Bạn có chắc muốn xóa?",
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
                    url: '{{ asset('moneys') }}/' + id,
                    success: function(res)
                    {
                        if(!res.error) {
                            toastr.success('Xóa thành công!');
                            $('#moneys-table').DataTable().ajax.reload(null,false);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(thrownError);
                    }
                });
            }
        });
	});
</script>
{{-- ========================= --}}
@endsection
