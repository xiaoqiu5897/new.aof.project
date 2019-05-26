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
        &nbsp;/&nbsp; Quản lý tài khoản ngân hàng
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        @if(Entrust::can(['permissions-manager']))
        <a data-toggle="modal" href="#createBankAccount"><button class="btn btn-sm green reset_data btnAdd"><i class="fa fa-plus"></i> Thêm mới</button></a>
        @endif
    </div>
</div>
<div class="portlet-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="bank-accounts-table">
	        <thead>
	            <tr>
	                <th style="text-align: center;">STT</th>
	                <th style="text-align: center;">Hành động</th>
	                <th style="text-align: center; width: 150px">Tên</th>
                    <th style="text-align: center;">Tài khoản</th>
                    <th style="text-align: center;">Ngân hàng</th>
                    <th style="text-align: center;">Chi nhánh</th>
	                <th style="text-align: center;">Ngày tạo</th>
	            </tr>
	        </thead>
	    </table>
	</div>
</div>
</div>

<div class="modal fade" id="createBankAccount">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <h4 class="modal-title uppercase">Thêm mới</h4>
		    </div>
			<form id="formCreateBankAccount" method="POST" role="form">
			    <div class="modal-body">
			        <div class="col-sm-12">
			          	<div class="form-group form-md-line-input form-md-floating-label">
			            	<input type="text" name="name" id="name" class="form-control">
			            	<label for="name" class="control-label">Tên <span style="color: red">(*)</span></label>
			          	</div>
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="number" name="bank_account" id="bank_account" class="form-control">
                            <label for="bank_account" class="control-label">Tài khoản ngân hàng <span style="color: red">(*)</span></label>
                        </div>
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
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" name="branch_bank" id="branch_bank" class="form-control">
                            <label for="branch_bank" class="control-label">Chi nhánh <span style="color: red">(*)</span></label>
                        </div>
			        </div>
			    </div>
		    </form>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="submit" form="formCreateBankAccount" class="btn btn-sm btn-success" style="margin-top: 20px;" id="btnCreatePer">Thêm mới</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="editBankAccount">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" align="center">
                <h4 class="modal-title uppercase">Chỉnh sửa thông tin</h4>
            </div>
            <form id="formEditBankAccount" method="POST" role="form">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên <span style="color: red">(*)</span></label>
                            <input type="text" name="name" id="name_edit" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="bank_account" class="control-label">Tài khoản ngân hàng <span style="color: red">(*)</span></label>
                            <input type="number" name="bank_account" id="bank_account_edit" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="bank_id" class="control-label">Ngân hàng <span style="color: red">(*)</span></label>
                            <select name="bank_id" id="bank_id_edit" class="form-control form-md-line-input form-md-floating-label">
                                @if(isset($banks))
                                @foreach($banks as $bank)
                                <option value={{$bank->id}}>{{$bank->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="branch_bank" class="control-label">Chi nhánh <span style="color: red">(*)</span></label>
                            <input type="text" name="branch_bank" id="branch_bank_edit" class="form-control">
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <center>
                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
                  <button type="submit" form="formEditBankAccount" class="btn btn-sm btn-success" style="margin-top: 20px;" id="btnCreatePer">Cập nhật</button>
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
	$('#bank-accounts-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        order: [],
        pageLength: 30,
        ajax: {
				type: 'get',
				url: '{{url('')}}/list-bank-account',
			},
        columns: [
        	{data: 'DT_RowIndex', className:'tbl_stt', 'class':'dt-center', "searchable": false,},
            {data: 'action', name: 'action', 'class':'dt-center', "searchable": false,},
            {data: 'name', name: 'name', 'class':'dt-center'},
            {data: 'bank_account', name: 'bank_account', 'class':'dt-center'},
            {data: 'bank_id', name: 'bank_id', 'class':'dt-center'},
            {data: 'branch_bank', name: 'branch_bank', 'class':'dt-center'},
            {data: 'created_at', name: 'created_at', 'class':'dt-center', "searchable": false,},   
        ]
    });
</script>
{{-- Tạo mới --}}
<script type="text/javascript">
	$('.btnAdd').on('click', function() {
		$('#formCreateBankAccount')[0].reset();
	});
</script>
<script type="text/javascript">
	$('#formCreateBankAccount').on('submit', function(event) {
		event.preventDefault();

		var data = $('#formCreateBankAccount').serializeArray();

		$.ajax({
            url: '{{ route('bank-accounts.store') }}',
            type: 'POST',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#createBankAccount').modal('hide');
                    toastr.success(res.message);
                    $('#bank-accounts-table').DataTable().ajax.reload(null,false);
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
	$('#bank-accounts-table').on('click', '.btn-edit', function() {
		$('#editBankAccount').modal('show');
		$('#formEditBankAccount')[0].reset();

		var id = $(this).attr('data-id');

		$.ajax({
            url: '{{ asset('bank-accounts') }}/' + id,
            type: 'GET',

            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#name_edit').val(res.data.name);
                    $('#bank_account_edit').val(res.data.bank_account);
                    $('#bank_id_edit').val(res.data.bank_id);
                    $('#branch_bank_edit').val(res.data.branch_bank);

                    $('#formEditBankAccount').attr('data-id', id);
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
	$('#formEditBankAccount').on('submit', function(event) {
		event.preventDefault();

		var id = $(this).attr('data-id');

		var data = $('#formEditBankAccount').serializeArray();

		$.ajax({
            url: '{{ asset('bank-accounts') }}/' + id,
            type: 'PUT',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#editBankAccount').modal('hide');
                    toastr.success(res.message);
                    $('#bank-accounts-table').DataTable().ajax.reload(null,false);
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
	$('#bank-accounts-table').on('click', '.btn-delete', function() {
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
                    url: '{{ asset('bank-accounts') }}/' + id,
                    success: function(res)
                    {
                        if(!res.error) {
                            toastr.success('Xóa thành công!');
                            $('#bank-accounts-table').DataTable().ajax.reload(null,false);
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
