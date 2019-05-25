@extends('layouts.master')
@section('contents')

<div class="portlet light bordered">
<div class="portlet-title">
  <div class="caption" style="font-size: 14px">
      <i class="fa fa-home" aria-hidden="true"></i>
      <a href="{{ route('dashboard') }}">  Trang chủ </a> 
      &nbsp;/&nbsp; 
      <a href="{{ route('users.index') }}">Quản lý tài khoản</a>
      &nbsp;/&nbsp; Vai trò
      &nbsp;/&nbsp; {{$user->name}}
  </div>
</div>
<div class="row">
    {{-- <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        <a href="#"><button class="btn green btn-circle"><i class="fa fa-plus"></i> Thêm mới</button></a>
    </div> --}}
    {{-- <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
        <form method="get" action="">
            <input type="text" class="search-class form-control" id="search"  name="search"  placeholder="Nhập Thông Tin Tìm Kiếm">
        </form>
    </div> --}}
</div>
<div class="portlet-body">
    <div class="table-scrollable">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                   <th class="stl-column color-column">#</th>
                   <th class="stl-column color-column">Hành động</th>
                   <th class="stl-column color-column">Vai trò</th>
                   {{-- <th class="stl-column color-column">Quyền hạn</th> --}}
                   <th class="stl-column color-column">Miêu tả</th>
                   <th class="stl-column color-column">Quyền hạn</th>
                   
                </tr>
            </thead>
            <tbody>
                @if(!empty($roles)) @foreach($roles as $key => $role)
                <tr>
                    <td class="text-center"> {{ $key + 1 }} </td>
                    <td class="text-center"> 
                        <input type="hidden" id="checked-{{$role->id}}" value="{{$role->checked}}">

                          @if(!empty($role->checked))
                            
                           <i id="action-{{$role->id}}" class="fa fa-check-circle" onclick="addRole({{$user->id}},{{$role->id}})" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>
                        @else 

                          <i id="action-{{$role->id}}" class="fa fa-circle-o"  onclick="addRole({{$user->id}}, {{$role->id}})" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>

                        @endif


                     </td>
                    
                    <td class="text-left"> {{ $role->display_name }} </td>
                  
                    <td class="text-left"> {{ $role->description }} </td>

                    <td class="text-left"> 
                    @if(!empty($role->permissions))
                        @foreach($role->permissions as $k => $permission)
                         
                            <label class="btn green btn-outline btn-circle btn-xs">
                                                {{$permission->display_name}}
                              </label>
                            
                          
                        @endforeach
                    @endif
                    

                    </td>

                    
                    
                   
                </tr>
                @endforeach @else
                  <tr>
                    <td colspan="4" class="text-center"> Không có bản ghi nào </td>
                  </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
</div>

<div class="modal fade bs-modal-lg" id="createTheoryGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header " id="themmoi">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> --}}
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    function addRole(user_id, role_id) {

        var checked = $('#checked-' + role_id).val();

        $.ajax({
              type: "POST",
              url: "{{route('user.update-roles')}}",
              data: {
                role_id: role_id,
                user_id: user_id,
                checked: checked,
              },
              success: function(res)
              {
                
                if (res.message == 'deleted') {
                  $('#action-' + role_id).removeClass('fa-check-circle').addClass('fa-circle-o');
                  $('#checked-' + role_id).val(0);
                  toastr.success('Xóa thành công');
                } 

                if (res.message == 'added') {
                  $('#action-' + role_id).removeClass('fa-circle-o').addClass('fa-check-circle');
                  $('#checked-' + role_id).val(1);
                  toastr.success('Thêm thành công');
                }
                

              },
              error: function (xhr, ajaxOptions, thrownError) {

                console.log('error');

                toastr.error(thrownError);
              }
        });
        }
</script>


@endsection
