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
        &nbsp;/&nbsp; 
        {{-- hiển thị theo type --}}
        @if(isset($type))
			@if($type == 1)
	        	Quản lý nhân viên
	        	@php
	        		$code_display = 'Mã nhân viên';
	        	@endphp
	        @elseif($type == 2)
	        	Quản lý khách hàng
	        	@php
	        		$code_display = 'Mã khách hàng';
	        	@endphp
	        @elseif($type == 3)
	        	Quản lý nhà cung cấp
	        	@php
	        		$code_display = 'Mã nhà cung cấp';
	        	@endphp
	        @endif
	    @else
	    	Quản lý nhân viên
	    	@php
	        	$code_display = 'Mã nhân viên';
	        @endphp
        @endif
        {{--=======================================--}}
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        @if(Entrust::can(['permissions-manager']))
        <a data-toggle="modal" href="#createEmp"><button class="btn btn-sm green reset_data btnAdd"><i class="fa fa-plus"></i> Thêm mới</button></a>
        @endif
    </div>
</div>
<div class="portlet-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="employees-table">
	        <thead>
	            <tr>
	                <th style="text-align: center;">STT</th>
	                <th style="text-align: center;">{{ $code_display }}</th>
	                <th style="text-align: center;">Hành động</th>
	                <th style="text-align: center;">Tên</th>
	                <th style="text-align: center;">Email</th>
	                <th style="text-align: center;">Địa chỉ</th>
	                <th style="text-align: center;">Số điện thoại</th>
	                <th style="text-align: center;">Ngày tạo</th>
	            </tr>
	        </thead>
	    </table>
	</div>
</div>
</div>

<div class="modal fade" id="createEmp">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Thêm mới</h4>
		    </div>
			<form id="formCreateEmployee" method="POST" role="form">
			    <div class="modal-body">
			    	<div class="col-sm-6">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="text" name="code" id="code" class="form-control">
			            	<label for="code" class="control-label">Mã<span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="text" name="name" id="name" class="form-control">
			            	<label for="name" class="control-label">Tên <span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="email" name="email" id="email" class="form-control">
			            	<label for="email" class="control-label">Email <span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="text" name="address" id="address" class="form-control">
			            	<label for="address" class="control-label">Địa chỉ <span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="number" name="mobile" id="mobile" class="form-control">
			            	<label for="mobile" class="control-label">Số điện thoại <span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="number" name="tax_code" id="tax_code" class="form-control">
			            	<label for="tax_code" class="control-label">Mã số thuế <span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-12">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="number" name="bank_account" id="bank_account" class="form-control">
			            	<label for="bank_account" class="control-label">Tài khoản ngân hàng <span style="color: red">(*)</span></label>
			          	</div>
			        </div>

			        <div class="col-sm-12">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<label for="bank_id" class="control-label">Ngân hàng <span style="color: red">(*)</span></label>
			            	<select name="bank_id" id="bank_id" class="form-control form-md-line-input form-md-floating-label">
			            		@if(isset($banks))
			            		@foreach($banks as $bank)
			            		<option value={{$bank->id}}>{{$bank->name}}</option>
			            		@endforeach
			            		@endif
			            	</select>
			          	</div>
			        </div>
			    </div>
		    </form>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="submit" form="formCreateEmployee" class="btn btn-sm btn-success" style="margin-top: 20px;" id="btnCreatePer">Thêm mới</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="editEmp">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Chỉnh sửa thông tin</h4>
		    </div>
			<form id="formEditEmployee" role="form">
			    <div class="modal-body">
			    	<div class="col-sm-6">
			          	<div class="form-group">
			          		<label for="code" class="control-label">Mã<span style="color: red">(*)</span></label>
			            	<input type="text" name="code" id="code_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group">
			          		<label for="name" class="control-label">Tên <span style="color: red">(*)</span></label>
			            	<input type="text" name="name" id="name_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group">
			          		<label for="email" class="control-label">Email <span style="color: red">(*)</span></label>
			            	<input type="email" name="email" id="email_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group">
			          		<label for="address" class="control-label">Địa chỉ <span style="color: red">(*)</span></label>
			            	<input type="text" name="address" id="address_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group">
			          		<label for="mobile" class="control-label">Số điện thoại <span style="color: red">(*)</span></label>
			            	<input type="number" name="mobile" id="mobile_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-6">
			          	<div class="form-group">
			          		<label for="tax_code" class="control-label">Mã số thuế <span style="color: red">(*)</span></label>
			            	<input type="number" name="tax_code" id="tax_code_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-12">
			          	<div class="form-group">
			          		<label for="bank_account" class="control-label">Tài khoản ngân hàng <span style="color: red">(*)</span></label>
			            	<input type="number" name="bank_account" id="bank_account_edit" class="form-control">
			          	</div>
			        </div>

			        <div class="col-sm-12">
			          	<div class="form-group">
			            	<label for="bank_id" class="control-label">Ngân hàng <span style="color: red">(*)</span></label>
			            	<select name="bank_id" id="bank_id_edit" class="form-control">
			            		@if(isset($banks))
			            		@foreach($banks as $bank)
			            		<option value={{$bank->id}}>{{$bank->name}}</option>
			            		@endforeach
			            		@endif
			            	</select>
			          	</div>
			        </div>
			    </div>
		    </form>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="submit" form="formEditEmployee" class="btn btn-sm btn-success" style="margin-top: 20px;">Cập nhật</button>
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
<script type="text/javascript">
	//lấy type
	if (<?php echo $type ?>) {
		var type = <?php echo $type ?>;
	} else {
		var type = 1;
	}
	//hết

	//đổi tên đường dẫn theo type
	if (type) {
		if (type == 1) {
			var url = 'employees';
		} else if (type == 2) {
			var url = 'customers';
		} else if (type == 3) {
			var url = 'suppliers';
		}
	} else {
		var url = 'employees';
	}
	//hết
</script>
<script>
	$('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        order: [],
        pageLength: 30,
        ajax: {
				type: 'get',
				url: '{{url('')}}/list-employee?type='+type,
			},
        columns: [
        	{data: 'DT_RowIndex', className:'tbl_stt', 'class':'dt-center', "searchable": false,},
        	{data: 'code', name: 'code', 'class':'dt-center'},
            {data: 'action', name: 'action', 'class':'dt-center', "searchable": false,},
            {data: 'name', name: 'name', 'class':'dt-center'},
            {data: 'email', name: 'email', 'class':'dt-center'},
            {data: 'address', name: 'address', 'class':'dt-center'},
            {data: 'mobile', name: 'mobile', 'class':'dt-center'},
            {data: 'created_at', name: 'created_at', 'class':'dt-center', "searchable": false,},   
        ]
    });
</script>
{{-- Tạo mới --}}
<script type="text/javascript">
	$('.btnAdd').on('click', function() {
		$('#formCreateEmployee')[0].reset();
	});
</script>
<script type="text/javascript">
	$('#formCreateEmployee').on('submit', function(event) {
		event.preventDefault();

		var data = $('#formCreateEmployee').serializeArray();

		$.ajax({
            url: '{{ asset('') }}' + url + '/?type=' + type,
            type: 'POST',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#createEmp').modal('hide');
                    toastr.success(res.message);
                    $('#employees-table').DataTable().ajax.reload(null,false);
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
	$('#employees-table').on('click', '.btn-edit', function() {
		$('#editEmp').modal('show');
		$('#formEditEmployee')[0].reset();

		var id = $(this).attr('data-id');

		$.ajax({
            url: '{{ asset('') }}'+ url +'/'+ id,
            type: 'GET',

            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#name_edit').val(res.data.name);
                    $('#code_edit').val(res.data.code);
                    $('#email_edit').val(res.data.email);
                    $('#address_edit').val(res.data.address);
                    $('#mobile_edit').val(res.data.mobile);
                    $('#tax_code_edit').val(res.data.tax_code);
                    $('#bank_account_edit').val(res.data.bank_account);
                    $('#bank_id_edit').val(res.data.bank_id);

                    $('#formEditEmployee').attr('data-id', id);
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
	$('#formEditEmployee').on('submit', function(event) {
		event.preventDefault();

		var id = $(this).attr('data-id');

		var data = $('#formEditEmployee').serializeArray();

		$.ajax({
            url: '{{ asset('') }}'+ url +'/'+ + id,
            type: 'PUT',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#editEmp').modal('hide');
                    toastr.success(res.message);
                    $('#employees-table').DataTable().ajax.reload(null,false);
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
	$('#employees-table').on('click', '.btn-delete', function() {
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
                    url: '{{ asset('') }}'+ url +'/'+ + id,
                    success: function(res)
                    {
                        if(!res.error) {
                            toastr.success('Xóa thành công!');
                            $('#employees-table').DataTable().ajax.reload(null,false);
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
