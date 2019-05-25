@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{url('css/datatables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('css/bootstrap-fileinput.css')}}">
<style type="text/css">
.sweet-alert{
    z-index: 50000 !important;
}

.sweet-overlay{
    z-index: 49000 !important;
}

*{
    margin: 0px;
    padding: 0px;
}
.dataTables_filter{
    float: right;
}

.dataTables_filter input{
    margin-left: 10px;
}

.modal-body .info .col-md-6{
    text-align: center;
}

.modal-body .info .col-md-6 span{
    font-size: 16px;
    font-weight: bold;
}

.modal-body .col-md-12{
    margin-bottom: 40px;
}

.ck-editor__main > div{
    height: 200px;
}

.call{
    margin-bottom: 20px;
}

.container-fluid, .container-fluid > div{
    padding: 0;
}

.modal-header{
    border-bottom: 1px solid #ffa331 !important;
    /*background-color: #ffa331;*/
    /*color: white;*/
}

.nav-tabs>li.active>a {
    border:none !important;
    border-bottom: 3px solid orange !important;
}

.over-lay, .over-lay-add-route{
    width: 100%;
    height: 100%;
    background: #e6e6e6;
    z-index: 20;
    position: absolute;
    opacity: 0.5;
    display: none;
}

.action{
    position: absolute;
    /* right: -15%; */
    top: 87%;
    display: none;
    left: 42%;
}

.default{
    border-color: #a9a5a5;
}

.default span{
    color: #a9a5a5 !important;
}

.gray{
    background: #4ECDC4;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #556270, #4ECDC4);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #556270, #4ECDC4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}

.orange{
    background: #FF5F6D;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #FFC371, #FF5F6D);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #FFC371, #FF5F6D); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}

.blue{
    background: #D66D75;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #E29587, #D66D75);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #E29587, #D66D75); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}

.col-md-12{
    margin-bottom: 0px !important;
}


.modal-title{
    font-weight: bold !important;
    text-align: center;
    text-transform: uppercase;
}
.overlay{
    width: 100%;
    height: 100%;
    position: absolute;
    background: whitesmoke;
    opacity: 0.4;
    z-index: 1000;
    top: 0;
    display: none;
}
#student-transaction-history th:after  {
    display: none;
}
.btn:not(.md-skip){
    padding : 7px 12px;
}
.modal-title {
    color: orange;
    font-weight: bold !important;
}
.image_add_money{
    cursor: pointer;
}
.image_add_money:hover{
    box-shadow: 5px 5px 5px grey;
}
.dt-center{
    text-align: center;
}
.dt-right{
    text-align: right;
}
.dt-left{
    text-align: left;
}

#users-table th{
    text-align: center
}
.btn{
    margin:5px;
}
#editImageUser{
    margin-left: -2%;
}
.error{
    color: red;
}
</style>
@endsection

@section('contents')

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption" style="font-size: 14px">
            <i class="fa fa-home" aria-hidden="true"></i>
            <a href="{{ route('dashboard') }}">  Trang chủ </a>
            &nbsp;/&nbsp; Quản lý nhân viên
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
            {{-- @if(Entrust::can(['users-add'])) --}}
            <br>
            <button class="btn btn-sm btn-success btn-create-user"><i class="fa fa-plus"></i> Thêm mới nhân viên</button>
            <br><br>
            {{-- @endif --}}
        </div>
    </div>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover" id="users-table">
        <thead>
            <tr>
                <th>STT</th>
                <th style="text-align: center;">Chức năng</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th style="text-align: center;">Ngày tạo</th>  
            </tr>
        </thead>
    </table>
</div>
</div>

<div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">THÊM MỚI</h4>
            </div>
            <div class="modal-body">
                <form id="formCreateUser" method="POST" role="form">
                    <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                        <input type="text" class="form-control" id="name" name="name">
                        <label for="name">Tên</label>
                    </div>
                    <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                        <input type="text" class="form-control" id="email" name="email">
                        <label for="email">Email</label>
                    </div>
                </form>

                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-sm btn-primary red" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-sm btn-success" form="formCreateUser">Thêm mới</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewUser">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Thông tin chi tiết</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td style="width: 40%">Mã nhân viên</td>
                            <td id="info_user_id"></td>
                        </tr>

                        <tr>
                            <td>Họ và tên</td>
                            <td id="info_user_name"></td>
                        </tr>

                        <tr>
                            <td>Số điện thoại</td>
                            <td id="info_user_mobile"></td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td id="info_user_email"></td>
                        </tr>

                        <tr>
                            <td>Địa chỉ</td>
                            <td id="info_user_address"></td>
                        </tr>

                        <tr>
                            <td>Nơi làm việc</td>
                            <td id="info_user_workPlace"></td>
                        </tr>

                        <tr>
                            <td>Học vấn</td>
                            <td id="info_user_education"></td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Đóng</button>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUser">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cập nhật thông tin tài khoản</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <form id="frmEditUser" method="POST" role="form">

                        <div class="form-wizard">
                            <div class="form-body">
                                <div class="tab-content">
                                    <div class="tab-pane active">
                                        <div class="form-body col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">
                                            <input type="hidden" name="_method" value="" id="user_id">
                                            <div class="form-group form-md-line-input">
                                             <input type="text" class="form-control" id="user_name" name="user_name">

                                             <label for="name">Họ tên <span class="requireds"> (*)</span></label>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <input type="text" class="form-control" id="user_email" name="user_email" readonly="">

                                             <label for="email">Email <span class="requireds"> (*)</span></label>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <input type="text" class="form-control" id="user_mobile" name="user_mobile">

                                             <label for="mobile">Mobile <span class="requireds"> (*)</span></label>
                                             <p style="color: red" class="with-errors" id="org_mobile"></p>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <select id="user_gender" class="form-control" name="user_gender">

                                             </select>

                                             <label for="sex">Giới tính</label>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <input type="text" class="form-control" id="user_birthday" name="user_birthday">

                                             <label for="birthday">Ngày sinh</label>
                                         </div>
                                        
                                        <div class="form-group form-md-line-input">
                                              <textarea class="form-control" rows="3" id="user_describe" name="describe" >{{ old('describe') }}</textarea>
                                           <label for="describe">Thông tin nhân viên</label>
                                        </div>
                                        
                                        <div class="form-group form-md-line-input">
                                             <select  id="user_type" class="form-control" name="user_type">
                                             </select>
                                             <label for="type">Loại</label>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <select  id="department_id" class="form-control" name="department_id">
                                                @if(!empty($departments)) @foreach($departments as $department)
                                                    <option value="{{$department->id}}" >{{$department->department}}</option>
                                                @endforeach @endif

                                            </select>
                                            <label for="department_id">Phòng ban</label>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <select  id="type_job" class="form-control" name="type_job">
                                                <option value="0" >Full-time</option>
                                                <option value="1" >Part-time</option>
                                             </select>
                                             <label for="type_job">Hình thức làm việc</label>
                                         </div>

                                         <div class="form-group form-md-line-input">
                                             <select id="user_status" class="form-control" name="user_status">
                                             </select>
                                         </div>

                                             <div id="editImageUser">
                                              <div class="col-md-2">
                                                  <div class="">Hình ảnh</div>
                                              </div>
                                              <div class="col-md-10">
                                                <div class="portlet-body">
                                                   <div class="fileinput fileinput-new" data-provides="fileinput">
                                                      <div class="fileinput-new thumbnail" style="width: 250px; height: 200px;">
                                                        <img id="previewimg" src="{{url('images/zents/no-image.png')}}" alt="Loading..." />
                                                    </div>

                                                    <div style="margin-top: 10px;">
                                                        <span class="input-group-btn">
                                                          <a id="lfm" data-input="thumbnail" data-preview="previewimg" class="btn btn-sm btn-primary choose_image">
                                                            <i class="fa fa-picture-o"></i> Chọn
                                                        </a>
                                                    </span>

                                                </div>
                                                <input type="hidden" id="thumbnail" name="image" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </form>
                 <div style="clear: both;"></div>
                 <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-sm btn-primary red " data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-sm btn-success " id="btnEditUser">Cập nhật</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="previewImg-modal">
    <div class="modal-dialog" style="width: 65%">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" style="width: 100%">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{url('js/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{url('js/jqueryValidate/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{url('js/autoNumeric-min.js')}}" type="text/javascript"></script>
<script src="{{url('js/bootstrap-fileinput.js')}}"></script>

<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>
    
<script>
    var user_id;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script type="text/javascript">
    $('.btn-create-user').on('click', function() {
        $('#create-user-modal').modal('show');
    });
</script>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="user_birthday"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy/mm/dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
            endDate: '+0d',
        })
    })
</script>

<script>
    $(function() {

        var oTable = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '{!! route('users.list-user') !!}',
            order: [],
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            columns: [
                {data: 'DT_RowIndex', name: 'id', 'class':'dt-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false, 'class':'dt-center'},
                {data: 'name', name: 'name', 'class':'dt-center'},
                {data: 'email', name: 'email', 'class':'dt-center'},
                {data: 'created_at', name: 'created_at', 'class':'dt-center'},
                
            ]
        });

        $('#users-table').on('click', '.btn-delete', function () {

          var path = "{{URL::asset('')}}users/" + $(this).data('id');

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
                url: path,
                success: function(res)
                {
                  if(!res.error) {
                      toastr.success('Xóa thành công!');
                      oTable.ajax.reload(null,false);
                  }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                  toastr.error(thrownError);
              }
          });

          }
      });
      });
    });

    function viewUser(id){
        $.ajax({
            url: '{{ route('get-info-user') }}',
            type: 'POST',
            data: {id: id},
            success: function(res){
                // console.log(res);

                if( res.id != null ){
                    $("#info_user_id").html(res.id);
                } else{
                    $("#info_user_id").html("<i style='color: orange'>Updatting...</i>");
                }

                if( res.name != null ){
                    $("#info_user_name").html(res.name);
                } else{
                    $("#info_user_name").html("<i style='color: orange'>Updatting...</i>");
                }

                if( res.mobile != null ){
                    $("#info_user_mobile").html('<a href="tel:'+res.mobile+'">'+res.mobile+'</a>');
                } else{
                    $("#info_user_mobile").html("<i style='color: orange'>Updatting...</i>");
                }

                if( res.email != null ){
                    $("#info_user_email").html('<a href="mailto:'+res.email+'">'+res.email+'</a>');
                } else{
                    $("#info_user_email").html("<i style='color: orange'>Updatting...</i>");
                }

                if( res.address != null ){
                    $("#info_user_address").html(res.address);
                } else{
                    $("#info_user_address").html("<i style='color: orange'>Updatting...</i>");
                }

                if( res.work_place != null ){
                    $("#info_user_workPlace").html(res.work_place);
                } else{
                    $("#info_user_workPlace").html("<i style='color: orange'>Updatting...</i>");
                }

                if( res.education != null ){
                    $("#info_user_education").html(res.education);
                } else{
                    $("#info_user_education").html("<i style='color: orange'>Updatting...</i>");
                }



            },
            error: function(){

            }
        });
    }

    function editUser(id){
        $.ajax({
            url: '{{ route('get-info-user') }}',
            type: 'POST',
            data: {id: id},
            success: function(res){

                $('#user_name').val(res.name);
                $('#user_email').val(res.email);
                $('#user_mobile').val(res.mobile);
                $('#user_describe').val(res.describe);
                $('#editUser #previewimg').attr("src","{{ asset('') }}"+res.avatar);


                $('#user_gender').children().remove();
                if(res.gender == 1){
                    $('#user_gender').append('<option value="1">Nam</option><option value="0">Nữ</option>');
                }else{
                    $('#user_gender').append('<option value="0">Nữ</option><option value="1">Nam</option>');
                }

                var $datepicker = $('#user_birthday');
                $datepicker.datepicker('setDate', res.birthday);

                $('#user_type').children().remove();
                if(res.type == 1){
                    $('#user_type').append('<option value="1">Nhân viên</option><option value="2">Giáo viên</option><option value="3">Trợ giảng</option><option value="61">Giảng viên tập sự</option>');
                }else if(res.type == 2){
                    $('#user_type').append('<option value="2">Giáo viên</option><option value="1">Nhân viên</option><option value="3">Trợ giảng</option><option value="61">Giảng viên tập sự</option>');
                }else if(res.type == 61){
                    $('#user_type').append('<option value="61">Giảng viên tập sự</option><option value="1">Nhân viên</option><option value="2">Giáo viên</option><option value="3">Trợ giảng</option>');
                }else{
                    $('#user_type').append('<option value="3">Trợ giảng</option><option value="2">Giáo viên</option><option value="1">Nhân viên</option><option value="61">Giảng viên tập sự</option>');
                }

                $('#user_status').children().remove();
                if(res.status == 1){
                    $('#user_status').append('<option value="1">Hiển thị</option><option value="0">Ẩn</option>');
                }else{
                    $('#user_status').append('<option value="0">Ẩn</option><option value="1">Hiển thị</option>');
                }

                if(res.department_id != ''){
                    $('#department_id').val(res.department_id);
                }

                if(res.type_job != ''){
                    $('#type_job').val(res.type_job);
                }

                $('#user_id').val(res.id);
            },
            error: function(){

            }
        });
    }
    $('#frmEditUser').validate({
    errorElement: "span",
    rules: {
      user_name: {
        required: true
      },
      user_mobile: {
        required: true,
        number: true,
        minlength: 10,
        maxlength:10,
      },
      user_email: {
        required: true,
        email: true,
      },
      
    },
    messages: {
      
      user_name: {
        required: '(*) Vui lòng nhập tên liên hệ'
      },
      user_mobile: {
        required: '(*) Vui lòng nhập số điện thoại liên hệ',
        number: '(*) Số điện thoại liên hệ phải nhập kiểu số',
        minlength: '(*) Số điện thoại có 10 số',
        maxlength: '(*) Số điện thoại có 10 số',
      },
      user_email: {
        required: '(*) Vui lòng nhập email liên hệ',
        email: '(*) Email không đúng định dạng',
      },
      
    }

  });

    $('#btnEditUser').on('click', function() {

    var mobile = $('#user_mobile').val();
    var $valid = "valid";

    // var regex = /(09|03|08|01[2|6|8|9])+([0-9]{8})\b/g;
    var regex = /(09|03|08)+([0-9]{8})\b/g;

    if (!regex.test(mobile)) {

      $('#org_mobile').text("(*) Số điện thoại sai định dạng");

      valid = "invalid";
      // return valid;
    }else{
        var check = $('#frmEditUser').valid();
        if (!check) {
          return;
        }
        else {
            var fd = new FormData();
            fd.append('id', $('#user_id').val());
            fd.append('name', $('#user_name').val());
            fd.append('mobile', $('#user_mobile').val());
            fd.append('gender', $('#user_gender option:selected').val());
            fd.append('birthday', $('#user_birthday').val());
            fd.append('describe', $('#user_describe').val());
            fd.append('status', $('#user_status option:selected').val());
            fd.append('type', $('#user_type option:selected').val());
            fd.append('type_job', $('#type_job option:selected').val());
            fd.append('avatar', $('#editUser #thumbnail').val());
          // fd.append('status', status);

          $.ajax({
            contentType: false,
            processData: false,
            url: '{{ route('update-info-user') }}',
            type: 'POST',
            data: fd,
            success: function (res) {
              console.log(res);
              if (!res.error) {
                 $('#editUser').modal('hide');
                 toastr[''+res.status](res.message);
                 $('#users-table').DataTable().ajax.reload(null,false);
              }
              else {
                toastr.error(res.message);
              }
            }
          });

        }
    }
    

  })
</script>

<script type="text/javascript">
 $(document).ready(function () {
  $(document).ajaxStart(function () {
    $("#cover").show();
}).ajaxStop(function () {
    $("#cover").hide();
});
});
</script>


@endsection
