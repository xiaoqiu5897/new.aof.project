@extends('layouts.master')
@section('contents')

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption" style="font-size: 14px">
        <i class="fa fa-home" aria-hidden="true"></i>
        <a href="{{ route('dashboard') }}">  Trang chủ </a> 
        &nbsp;/&nbsp; 
        <a href="{{ route('users.index') }}">Quản lý tài khoản</a>
        &nbsp;/&nbsp; Quyền hạn học liệu
        &nbsp;/&nbsp; {{$user->name}}
    </div>
  </div>
  <input type="hidden" name="id" id="id" value="{{$user->id}}">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs" style="float: left;">
            <li class="active">
                <a href="#nhom-ly-thuyet" data-toggle="tab"> Nhóm lý thuyết </a>
            </li> 
            <li>
                <a href="#nhom-bai-tap" data-toggle="tab"> Nhóm bài tập </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body">
        <div class="tab-content">
            <div class="tab-pane active" id="nhom-ly-thuyet">
                <div class="table-scrollable">
                  <table class="table table-striped table-bordered table-hover" id="table_listCourseware">
                      <thead>
                          <tr>
                             <th class="stl-column color-column">#</th>
                             <th class="stl-column color-column">Nhóm lý thuyết</th>
                             <th class="stl-column color-column">Lý Thuyết</th>
                             <th class="stl-column color-column">Hành động</th>
                          </tr>
                      </thead>
                    
                  </table>
                </div>
            </div>
            <div class="tab-pane" id="nhom-bai-tap">
                <div class="table-scrollable">
                  <table class="table table-striped table-bordered table-hover" id="table_listexercise" style="width: 100%">
                      <thead>
                          <tr>
                             <th class="stl-column color-column">#</th>
                             <th class="stl-column color-column">Nhóm bài tập</th>
                             <th class="stl-column color-column">Bài tập</th>
                             <th class="stl-column color-column">Hành động</th>
                          </tr>
                      </thead>
                      
                  </table>
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
    $(function() {
      $id = $('#id').val();
      
      $('#table_listexercise').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url:'/users/'+$id+'/listexercise',
        },
        columns: [
        {data: 'DT_Row_Index', orderable: false, searchable: false, 'class':'dt-center', 'width': '5%'},
        { data: 'name', name: 'name'},
        { data: 'exercises', name: 'exercises'},
        { data: 'action', name: 'action' },
        ]
      });
    });
    $(function() {
      $id = $('#id').val();
      
      $('#table_listCourseware').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url:'/users/'+$id+'/listCourseware',
        },
        columns: [
        {data: 'DT_Row_Index', orderable: false, searchable: false, 'class':'dt-center', 'width': '5%'},
        { data: 'name', name: 'name' },
        { data: 'theories', name: 'theories' },
        { data: 'action', name: 'action' },
        ]
      });
    });


    // theories group
    function addTheoryGroup(theory_group_id) {
        var checked = $('#checked-' + theory_group_id).val();
        $user_id = $('#id').val();
        $.ajax({
              type: "POST",
              url: "{{route('user.toggle-theories')}}",
              data: {
                theory_group_id: theory_group_id,
                user_id: $user_id,
                checked: checked,
              },
              success: function(res)
              {
                
                if (res.message == 'deleted') {
                  $('#action-' + theory_group_id).removeClass('fa-check-circle').addClass('fa-circle-o');
                  $('#checked-' + theory_group_id).val(0);
                  toastr.success('Xóa thành công');
                } 

                if (res.message == 'added') {
                  $('#action-' + theory_group_id).removeClass('fa-circle-o').addClass('fa-check-circle');
                  $('#checked-' + theory_group_id).val(1);
                  toastr.success('Thêm thành công');
                }
                

              },
              error: function (xhr, ajaxOptions, thrownError) {

                console.log('error');

                toastr.error(thrownError);
              }
        });

      }

      // exercise
      function addExerciseGroup(exercise_group_id) {
        $user_id = $('#id').val();
        var checked = $('#checked-ex-' + exercise_group_id).val();
        $.ajax({
              type: "POST",
              url: "{{route('user.toggle-exercises')}}",
              data: {
                exercise_group_id: exercise_group_id,
                user_id: $user_id,
                checked: checked,
              },
              success: function(res)
              {
                
                if (res.message == 'deleted') {
                  $('#action-ex-' + exercise_group_id).removeClass('fa-check-circle').addClass('fa-circle-o');
                  $('#checked-ex-' + exercise_group_id).val(0);
                  toastr.success('Xóa thành công');
                } 

                if (res.message == 'added') {
                  $('#action-ex-' + exercise_group_id).removeClass('fa-circle-o').addClass('fa-check-circle');
                  $('#checked-ex-' + exercise_group_id).val(1);
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
