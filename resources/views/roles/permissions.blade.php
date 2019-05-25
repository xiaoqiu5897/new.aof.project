@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{url('css/datatables.bootstrap.css')}}">
<style>
	table.table-bordered.dataTable td:last-child {
  	text-align: center;
  }
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
        &nbsp;/&nbsp; <a href="{{ route('roles.index') }}">Vai trò</a>
        &nbsp;/&nbsp; {{$role->name}}
        &nbsp;/&nbsp; Quyền hạn
    </div>
</div>

<div class="portlet-body">
    
    <table class="table table-striped table-bordered table-hover" id="role-permissions-table">
        <thead>
            <tr>
                <th style="text-align: center;">STT</th>
                <th style="text-align: center;">Hành động</th>
                <th style="text-align: center;">Quyền hạn</th>
                <th style="text-align: center;">Miêu tả</th>
                
            </tr>
        </thead>
    </table>

</div>
</div>

<div class="modal fade bs-modal-lg" id="createTheoryGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header " id="themmoi">
                <h4 class="modal-title green">THÊM MỚI</h4>
            </div>
            <div class="modal-body">

                        <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" id="name" name="name">
                            <label for="class_fb_group">Tên nhóm</label>
                            
                        </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default btn-circle"
                                data-dismiss="modal">
                            Hủy
                        </button>
                        <button type="button" id="add"  class="btn btn-sm green btn-circle">
                            Thêm Mới
                        </button>
                    </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')

{{-- <script src="{{url('js/curd-Theory.js')}}" type="text/javascript"></script> --}}
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{url('js/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
    });
</script>
<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>


<script>
$(function() {
    $('#role-permissions-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '{!! route('user.role-list-permissions', [$name]) !!}',
        order: [],
        columns: [
            {data: 'DT_RowIndex', name: 'id', 'class':'dt-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'display_name', name: 'display_name'},
            {data: 'description', name: 'description', width:'50%'},
            
        ]
    });
});
</script>

<script>
    function addPermission(role_id, permission_id) {

        var checked = $('#checked-' + permission_id).val();

        $.ajax({
              type: "POST",
              url: "{{route('user.update-role-permissions')}}",
              data: {
                role_id: role_id,
                permission_id: permission_id,
                checked: checked,
              },
              success: function(res)
              {
                
                if (res.message == 'deleted') {
                  $('#action-' + permission_id).removeClass('fa-check-circle').addClass('fa-circle-o');
                  $('#checked-' + permission_id).val(0);
                  toastr.success('Xóa thành công');
                } 

                if (res.message == 'added') {
                  $('#action-' + permission_id).removeClass('fa-circle-o').addClass('fa-check-circle');
                  $('#checked-' + permission_id).val(1);
                  toastr.success('Thêm thành công');
                }
                

              },
              error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(thrownError);
              }
        });
        }
</script>


@endsection
