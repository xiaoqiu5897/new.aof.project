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
        &nbsp;/&nbsp; Quản lý ngân hàng
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        @if(Entrust::can(['permissions-manager']))
        <a data-toggle="modal" href="#createBank"><button class="btn btn-sm green reset_data btnAdd"><i class="fa fa-plus"></i> Thêm mới</button></a>
        @endif
    </div>
</div>
<div class="portlet-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="banks-table">
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

<div class="modal fade" id="createBank">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Thêm mới</h4>
		    </div>
			<form id="formCreateBank" method="POST" role="form">
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
		          <button type="submit" form="formCreateBank" class="btn btn-sm btn-success" style="margin-top: 20px;" id="btnCreatePer">Thêm mới</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="editBank">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Chỉnh sửa thông tin</h4>
		    </div>
			<form id="formEditBank" role="form">
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
		          <button type="submit" form="formEditBank" class="btn btn-sm btn-success" style="margin-top: 20px;">Cập nhật</button>
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
	$('#banks-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        order: [],
        pageLength: 30,
        ajax: {
				type: 'get',
				url: '{{url('')}}/list-bank',
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
		$('#formCreateBank')[0].reset();
	});
</script>
<script type="text/javascript">
	$('#formCreateBank').on('submit', function(event) {
		event.preventDefault();

		var data = $('#formCreateBank').serializeArray();

		$.ajax({
            url: '{{ route('banks.store') }}',
            type: 'POST',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#createBank').modal('hide');
                    toastr.success(res.message);
                    $('#banks-table').DataTable().ajax.reload(null,false);
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
	$('#banks-table').on('click', '.btn-edit', function() {
		$('#editBank').modal('show');
		$('#formEditBank')[0].reset();

		var id = $(this).attr('data-id');

		$.ajax({
            url: '{{ asset('banks') }}/' + id,
            type: 'GET',

            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#name_edit').val(res.data.name);

                    $('#formEditBank').attr('data-id', id);
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
	$('#formEditBank').on('submit', function(event) {
		event.preventDefault();

		var id = $(this).attr('data-id');

		var data = $('#formEditBank').serializeArray();

		$.ajax({
            url: '{{ asset('banks') }}/' + id,
            type: 'PUT',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#editBank').modal('hide');
                    toastr.success(res.message);
                    $('#banks-table').DataTable().ajax.reload(null,false);
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
	$('#banks-table').on('click', '.btn-delete', function() {
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
                    url: '{{ asset('banks') }}/' + id,
                    success: function(res)
                    {
                        if(!res.error) {
                            toastr.success('Xóa thành công!');
                            $('#banks-table').DataTable().ajax.reload(null,false);
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
