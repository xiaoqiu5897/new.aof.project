@extends('layouts.master')
@section('head')
<!-- include summernote css/js-->
{{-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet"> --}}
<style>
    .error {
        color:red;
    }
    #createImage{
      margin-left: -2%;
    }
    .fileinput .thumbnail {
      display: inline-block;
      margin-bottom: 5px;
      overflow: hidden;
      text-align: center;
      vertical-align: middle;
    }
</style>
@endsection
@section('contents')
<div class="portlet light bordered" id="form_wizard_1">
    <div class="portlet-title">
      <div class="caption" style="font-size: 14px">
          <i class="fa fa-home" aria-hidden="true"></i>
          <a href="{{ route('dashboard') }}">  Trang chủ </a>
          <a href="{{ route('users.index') }}"> &nbsp;/&nbsp; Quản lý nhân viên </a>
          &nbsp;/&nbsp; Tạo mới nhân viên

      </div>
    </div>
   {{-- <h3 class="block text-center">Thông tin cơ bản</h3> --}}
   <div class="portlet-body form">
   {{-- @if(count($errors))
      <div class="alert alert-danger text-center">
        <strong>Lỗi!</strong> Hãy kiểm tra lại dữ liệu bạn vừa nhập vào.
      </div>
    @endif --}}
      <form  id="frmCreateUser" name="frmCreateUser" method="POST" enctype="multipart/form-data" autocomplete="off">
         {{ csrf_field() }}
         <div class="form-wizard">
            <div class="form-body">
               <div class="tab-content">
                  <div class="tab-pane active">
                     <div class="form-body col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('name') ? 'has-error' : '' }}">
                           <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                           <label for="name">Họ tên <span class="requireds"> (*)</span></label>
                        </div>
                        <p class="font-red-mint">{{ $errors->first('name') }}</p>

                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('email') ? 'has-error' : '' }}">
                           <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                           <label for="email">Email <span class="requireds"> (*)</span></label>
                        </div>
                        <p class="font-red-mint">{{ $errors->first('email') }}</p>

                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('mobile') ? 'has-error' : '' }}">
                           <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}">
                           <label for="mobile">Mobile <span class="requireds"> (*)</span></label>
                        </div>
                        <p class="font-red-mint">{{ $errors->first('mobile') }}</p>
                        <p style="color: red" class="with-errors" id="org_mobile"></p>

                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('gender') ? 'has-error' : '' }}">
                           <select  id = "gender" class="form-control" name="gender">

                              <option value="1" >Nam</option>
                              <option value="0" >Nữ</option>


                           </select>
                           <label for="gender">Giới tính</label>
                        </div>

                        <p class="font-red-mint">{{ $errors->first('gender') }}</p>

                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('birthday') ? 'has-error' : '' }}">
                           <input type="text" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                           <label for="birthday">Ngày sinh</label>
                        </div>
                        <div class="form-group form-md-line-input form-md-floating-label ">
                              <textarea class="form-control" rows="3" id="describe" name="describe" >{{ old('describe') }}</textarea>
                           <label for="describe">Thông tin nhân viên</label>
                        </div>
                        {{-- <p class="font-red-mint">{{ $errors->first('birthday') }}</p> --}}
                        
                        <div class="form-group form-md-line-input form-md-floating-label">
                           <select  id = "type" class="form-control" name="type">
                              @if(!empty($types)) @foreach($types as $type)
                                    <option value="{{$type->id}}" >{{$type->name}}</option>
                              @endforeach @endif

                           </select>
                           <label for="type">Loại</label>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                           <select  id = "department_id" class="form-control" name="department_id">
                              @if(!empty($departments)) @foreach($departments as $department)
                                    <option value="{{$department->id}}" >{{$department->department}}</option>
                              @endforeach @endif

                           </select>
                           <label for="department_id">Nhân viên bộ phận</label>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                           <select  id = "type_job" class="form-control" name="type_job">

                              <option value="0" >Full-time</option>
                              <option value="1" >Part-time</option>

                           </select>
                           <label for="type_job">Hình thức làm việc</label>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('status') ? 'has-error' : '' }}">
                           <select  id = "status" class="form-control" name="status">

                              <option value="1" >Hiển thị</option>
                              <option value="0" >Ẩn</option>

                           </select>
                           {{-- <label for="status">Trạng thái<span class="requireds"> (*)</span></label> --}}
                        </div>

                        <p class="font-red-mint">{{ $errors->first('status') }}</p>
                        
                        <div id="createImage">
                          <div class="col-md-2">
                              <div class="">Hình ảnh</div>
                          </div>
                          <div class="col-md-10">
                            <div class="portlet-body">
                             <div class="fileinput fileinput-new" data-provides="fileinput">
                              <div class="fileinput-new thumbnail" style="width: 250px; height: 200px;">
                                <img style="max-height: 100%;" id="previewimg" src="{{url('images/zents/no-image.png')}}" alt="Loading..." />
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
            <div class="form-actions text-center">
               <div class="col-xs-12 col-sm-12" style="margin-top: 20px;">
                    <a href="{{route('users.index')}}" class="btn btn-sm red button-pre"> Quay Lại
                    </a>               
                   <button type="submit" class="btn btn-sm green">
                   Thêm mới
                      {{-- <i class="fa fa-check"></i> --}}
                    </button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection

@section('footer')
<script src="{{url('js/jqueryValidate/jquery.validate.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{url('js/bootstrap-fileinput.js')}}"></script>
<script>
  {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
</script>
    <script type="text/javascript">
        var route_prefix = "{{ url(config('lfm.prefix')) }}";
        var path_absolute = "{{URL::asset('')}}";

        $('#createImage #lfm').filemanager('image', {prefix: route_prefix});

        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}

        $("#image").change(function(){
            readImage( this );
        });

        function readImage(input) {
            if ( input.files && input.files[0] ) {
                var FR= new FileReader();
                FR.onload = function(e) {
            //e.target.result = base64 format picture
            $('#image_base64').val(e.target.result);
        };
        FR.readAsDataURL( input.files[0] );
    }
}

$('#createImage #lfm').filemanager('image', {prefix: route_prefix});
</script>

<script>
    function IsNull(obj)
    {
        var is;
        if (obj instanceof jQuery)
            is = obj.length <= 0;
        else
            is = obj === null || typeof obj === 'undefined' || obj == "";

        return is;
    }
</script>
<script>

    $('#frmCreateUser').validate({ // initialize the plugin
              errorElement: "span",
              rules: {
                name : {
                  required : true,
                  minlength: 2,
                  maxlength:25

                },
                email : {
                  required :true,
                  email: true,
                },
                mobile : {
                  required :true,
                  minlength: 10,
                  maxlength: 10,
                },
              },
              messages: {
                name : {
                  required : "Vui lòng nhập họ tên",
                  minlength: "Tên có độ dài ít nhất 2 ký tự",
                  maxlength : "Tên có độ dài tối đa 250 ký tự"
                },
                email : {
                  required :"Vui lòng nhập email",
                  email: "Email không đúng định dạng",
                },
                mobile : {
                  required :"Vui lòng nhập số điện thoại",
                  minlength: "Số điện thoại phải có 10 số",
                  maxlength: "Số điện thoại phải có 10 số",
                },
              }
    });

    $('#frmCreateUser').on('submit',function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var mobile = $('#mobile').val();
            var $valid = "valid";

            // var regex = /(09|03|08|01[2|6|8|9])+([0-9]{8})\b/g;
            var regex = /(09|03|08)+([0-9]{8})\b/g;

            if (!regex.test(mobile)) {

              $('#org_mobile').text(" Số điện thoại sai định dạng");

              valid = "invalid";
              // return valid;


            }else{
              var form= $('#frmCreateUser');
              if(! form.valid()) return false;

              $.ajax({
                  type:'POST',
                  url: "{{route('users.store')}}",
                  data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    mobile: $('#mobile').val(),
                    gender: $('#gender option:selected').val(),
                    birthday: $('#birthday').val(),
                    describe: $('#describe').val(),
                    type: $('#type option:selected').val(),
                    department_id: $('#department_id option:selected').val(),
                    type_job: $('#type_job option:selected').val(),
                    status: $('#status option:selected').val(),
                    avatar: $('#createImage #thumbnail').val(),
                  },

                  success:function(data){
                    console.log(data);
                      if(!data.error) {

                          toastr.success(data.message);

                          setTimeout(function () {
                              window.location.href = "{{route('users.index')}}";
                          }, 1000);

                          $('#frmCreateUser button[type="submit"]').prop('disabled',true);


                      } else {

                          if(!IsNull(data.message.name )) {
                              toastr.error(data.message.name[0]);
                          }
                          if(!IsNull(data.message.email)) {
                              toastr.error(data.message.email[0]);
                          }
                          if(!IsNull(data.message.mobile )) {
                              toastr.error(data.message.mobile[0]);
                          }

                          $('#frmCreateUser button[type="submit"]').prop('disabled',false);
                      }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                      toastr.error(thrownError);

                    }
              });
            }

            
        });
</script>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="birthday"]'); //our date input has the name "date"
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
@endsection
