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
        &nbsp;/&nbsp; Quyền hạn
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        @if(Entrust::can(['permissions-manager']))
        <a data-toggle="modal" href="#createPer"><button class="btn btn-sm green reset_data btnAdd"><i class="fa fa-plus"></i> Thêm mới</button></a>
        @endif
    </div>
</div>
<div class="portlet-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="permissions-table">
	        <thead>
	            <tr>
	                <th style="text-align: center;">STT</th>
	                <th style="text-align: center;">Hành động</th>
	                <th style="text-align: center;">Tên hiển thị</th>
	                <th style="text-align: center;">Quyền hạn</th>
	                <th style="text-align: center;">Miêu tả</th>
	                <th style="text-align: center;">Ngày tạo</th>
	                
	            </tr>
	        </thead>
	    </table>
	</div>
</div>
</div>

<div class="modal fade" id="createPer">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Thêm mới quyền hạn</h4>
		    </div>

		    <div class="modal-body">
		    	<div class="col-sm-12">
		          <div class="form-group form-md-line-input form-md-floating-label">
		            <input type="text" name="display_name" id="display_name" class="form-control">
		            <label for="display_name" class="control-label">Tên hiển thị <span style="color: red">(*)</span></label>
		          </div>
		        </div>
		        <div class="col-sm-12">
		          <div class="form-group form-md-line-input form-md-floating-label">
		            <input type="text" name="name" id="name" class="form-control">
		            <label for="name" class="control-label">Quyền hạn <span style="color: red">(*)</span></label>
		          </div>
		        </div>
		        <div class="col-sm-12">
		          <div class="form-group form-md-line-input form-md-floating-label">
		            <label for="description" class="lable-select">Miêu tả <span style="color: red"></span></label>
		            <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Content"></textarea>
		          </div>
		        </div>
		    </div>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="button" class="btn btn-sm btn-success" style="margin-top: 20px;" id="btnCreatePer">Thêm mới</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="editPer">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Chỉnh sửa quyền hạn</h4>
		    </div>

		    <div class="modal-body">
		    	<div class="col-sm-12">
		          <div class="form-group form-md-line-input form-md-floating-label">
		            <input type="text" name="display_name" id="display_name" class="form-control"  value=".">
		            <label for="display_name" class="control-label">Tên hiển thị <span style="color: red">(*)</span></label>
		          </div>
		        </div>
		        <div class="col-sm-12">
		          <div class="form-group form-md-line-input form-md-floating-label">
		            <input type="text" name="name" id="name" class="form-control" value=".">
		            <label for="name" class="control-label">Quyền hạn <span style="color: red">(*)</span></label>
		          </div>
		        </div>
		        <div class="col-sm-12">
		          <div class="form-group form-md-line-input form-md-floating-label">
		            <label for="editDescription" class="lable-select">Miêu tả <span style="color: red"></span></label>
		            <textarea class="form-control" name="editDescription" id="editDescription" cols="30" rows="10" placeholder="Miêu tả"></textarea>
		          </div>
		        </div>
		    </div>

		    <div class="modal-footer">
		        <center>
		          <input type="hidden" id="edit_id">
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
		          <button type="button" class="btn btn-sm yellow" style="margin-top: 20px;" id="btnEditPer">Cập nhật</button>
		        </center>
		    </div>
		</div>
	</div>
</div>

<div class="modal fade" id="showPer">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" align="center">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title uppercase">Chi tiết quyền hạn</h4>
		    </div>

		    <div class="modal-body">
		    	
		    </div>

		    <div class="modal-footer">
		        <center>
		          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" style="margin-top: 20px;">Đóng</button>
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
<script type="text/javascript" src="{{mix('build/js/permission.js')}}">
</script>

<script>
	$('#permissions-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        order: [],
        pageLength: 30,
        ajax: {
				type: 'get',
				url: '{{url('')}}/list-permission',
			},
        columns: [
        	{data: 'DT_RowIndex', className:'tbl_stt', 'class':'dt-center', "searchable": false,},
            {data: 'action', name: 'action', 'class':'dt-center', "searchable": false,},
            {data: 'display_name', name: 'display_name'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description', 'class':'dt-center'},
            {data: 'created_at', name: 'created_at', 'class':'dt-center', "searchable": false,},   
        ]
    });
</script>

@endsection
