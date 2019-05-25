@extends('layouts.master')

@section('head')

<style type="text/css">
    .btn:not(.md-skip){
        padding : 7px 12px;
    }

    .dt-center{
        text-align: center;
    }
    .dt-left{
        text-align: left;
    }
    .dt-right{
        text-align: right;
    }
    #roles-table .btn {
    	margin-top: 5px;
    }
</style>
@endsection

@section('contents')

<div class="portlet light bordered">
<div class="portlet-title">
    <div class="caption" style="font-size: 14px">
        <i class="fa fa-home" aria-hidden="true"></i>
        <a href="{{ route('dashboard') }}">  Trang chủ </a> 
        &nbsp;/&nbsp; Vai trò
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        {{-- @if(Entrust::can(['roles-manager'])) --}}
        <button class="btn green btn-sm btn-add-role"><i class="fa fa-plus"></i> Thêm mới</button>
        {{-- @endif --}}
    </div>

</div>
<div class="portlet-body">
    <div class="table-responsive">
    	<table class="table table-striped table-bordered table-hover" id="roles-table">
            <thead>
                <tr>
                    <th style="text-align: center;">STT</th>
                    <th style="text-align: center;">Hành động</th>
                    <th style="text-align: center;">Tên hiển thị</th>
                    <th style="text-align: center;">Vai trò</th>
                    <th style="text-align: center;">Miêu tả</th>
                    <th style="text-align: center;">Ngày tạo</th>
                    
                </tr>
            </thead>
    	</table>
    </div>
    
</div>
</div>

<div class="modal fade bs-modal-lg" id="createRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header ">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> --}}
                <h4 class="modal-title green">THÊM MỚI</h4>
            </div>
            <div class="modal-body">
                    <form id="add-role" name="add-role" action="" method="POST">
                        {{csrf_field()}}
                            <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" id="display_name" name="display_name">
                                <label for="class_fb_group">Tên hiển thị <span style="color:red;">(*)</span></label>
                                
                            </div>

                            <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" id="name" name="name">
                                <label for="class_fb_group">Vai trò <span style="color:red;">(*)</span></label>
                                
                            </div>

                            <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
          
                                <textarea class="form-control" id="description" name="description" placeholder="Miêu tả"></textarea>
                                {{-- <label for="class_fb_group">Miêu tả</label> --}}
                                
                            </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default red" data-dismiss="modal">
                                Hủy
                            </button>
                            <button type="submit" id="add"  class="btn btn-sm green">
                                Tạo
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-lg" id="editRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header ">
                
                <h4 class="modal-title green">CẬP NHẬT</h4>
            </div>
            <div class="modal-body">
                    <form id="edit-role" name="edit-role" action="" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" value="PUT" name="_method">

                            <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" id="edit_display_name" name="display_name">
                                <label for="class_fb_group">Tên hiển thị <span style="color:red;">(*)</span></label>
                                
                            </div>

                            <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                <input type="hidden" class="form-control" id="edit_id" name="id">
                                <input type="text" class="form-control" id="edit_name" name="name">
                                <label for="class_fb_group">Vai trò <span style="color:red;">(*)</span></label>
                                
                            </div>

                            <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
          
                                <textarea class="form-control" id="edit_description" name="description" placeholder="Miêu tả"></textarea>
                                {{-- <label for="class_fb_group">Miêu tả</label> --}}
                                
                            </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default red" data-dismiss="modal">
                                Hủy
                            </button>
                            <button type="submit" id="update"  class="btn btn-sm green">
                                Lưu
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>
{{-- <script type="text/javascript" src="{{mix('build/js/role.js')}}"></script> --}}
<script type="text/javascript" >
    $(function() {
        var table = $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            order: [],
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            ajax: app_url + 'list-role',
            columns: [
                {data: 'DT_RowIndex', name: 'id', 'class':'dt-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false, 'class':'dt-center'},
                {data: 'display_name', name: 'display_name'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at', 'class':'dt-center'},
                
            ]
        });

        //edit role
    $(document).on('click', '.btn-edit', function () {

        $('#editRoleModal').modal('show');
        var id = $(this).data('id');

        $.ajax({
              type: "GET",
              url: app_url + "roles/" + id,
              success: function(res)
              {

                $('#edit_name').val(res.data.name);
                $('#edit_id').val(res.data.id);
                $('#edit_name').focus();
                $('#edit_display_name').val(res.data.display_name);
                $('#edit_display_name').focus();
                $('#edit_description').val(res.data.description);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(thrownError);
              }
        });
    }); 


    $(document).on('submit','#edit-role',function(e){

          e.preventDefault();

          var id = $('#edit_id').val();
          var form= $('#edit-role');
          var formData= form.serialize();

          if(! form.valid()) return false;

          $.ajax({
            type:'PUT',
            url: app_url + 'roles/' +id,
            data: formData,
            success:function(data) {
                if(!data.error) {

                    toastr.success("Cập nhật thành công"); 
    
                    $('#editRoleModal').modal('hide');
                    
                    table.ajax.reload(null, false);

                } else {
                    
                    if(data.message.display_name == undefined && data.message.name == undefined){
                        toastr.error(data.message);
                    }else{
                        if(data.message.display_name != undefined) {
                            toastr.error(data.message.display_name);
                        }
                        if(data.message.name != undefined) {
                            toastr.error(data.message.name);
                        }
                    }
                }
              
            },
            error: function (xhr, ajaxOptions, thrownError) {
              toastr.error(thrownError);
            }
          });

    });


    //delete role
    $(document).on('click', '.btn-delete', function (){
        
        var role_id =  $(this).data('id');

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
                      url: app_url + "roles/" + role_id,
                      success: function(res)
                      {
                        if (res.error == false) {
                            toastr.success('Xóa thành công!');
                            table.ajax.reload(null, false);
                        } 
                        if (res.error == true) {
                            toastr.error('Xóa thất bại do vai trò này đang được sử dụng!');
                            table.ajax.reload(null, false);
                        }
                      },
                      error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(thrownError);
                      }
                });   
            } 
        });
    });


    //show popup add role
    $(document).on('click','.btn-add-role', function() {
        $('#createRoleModal').modal('show');
        $('#name').val('');
        $('#display_name').val('');
        $('#description').val('');
    });

    $(document).on('submit','#add-role', function(e){

        e.preventDefault();

        var form= $('#add-role');
        var formData= form.serialize();

        if(! form.valid()) return false;

        $.ajax({
            type:'POST',
            url: app_url + 'roles',
            data: formData,
            success:function(data){

                if(!data.error) {

                    toastr.success("Thành công");               
                    $('#createRoleModal').modal('hide');                        
                    table.ajax.reload(null, false); 

                } else {
                    if(data.message.display_name == undefined && data.message.name == undefined){
                        toastr.error(data.message);
                    }else{
                        if(data.message.display_name != undefined) {
                            toastr.error(data.message.display_name);
                        }
                        if(data.message.name != undefined) {
                            toastr.error(data.message.name);
                        }
                    }
                }   
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
              toastr.error(thrownError);
            }
        });
    });

});
        
</script>

@endsection
