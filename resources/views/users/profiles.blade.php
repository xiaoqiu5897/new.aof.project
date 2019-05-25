@extends('layouts.master')

@section('contents')

<h3 class="text-center">THÔNG TIN TÀI KHOẢN</h3>

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">

  <div class="col-md-12">
    <!-- BEGIN PROFILE SIDEBAR -->
    <div class="col-md-4">
      <div class="profile-sidebar">
        <!-- PORTLET MAIN -->
        <div class="portlet light profile-sidebar-portlet ">
          <!-- SIDEBAR USERPIC -->
          <div class="profile-userpic" align="center" style="padding-bottom: 50px">

           <img id="profile-img-tag" src="@if($user->avatar==Null ){{url('img/default-avatar_men.png')}}@else {{asset($user->avatar)}} @endif" class="img-responsive" alt="{{$user->name}}">
           <div class="col-md-6">
            <form  id="frmCreateUser" name="frmCreateUser" method="POST" enctype="multipart/form-data" autocomplete="off">
             {{ csrf_field() }}
             <div class="form-wizard">
              <div id="createImage">
                <div class="col-md-6">
                  <div class="portlet-body">
                   <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div >
                      <span class="input-group-btn" style="padding: 10px"> 
                        <a id="lfm" data-input="thumbnail" data-preview="profile-img-tag" style="border-radius: 8px;" class="btn btn-sm btn-primary choose_image">
                          <i class="fa fa-picture-o"></i> Chọn
                        </a>
                        <input type="hidden" name="idUser" id="idUser" value="{{$user->id}}">
                         <button type="submit" class="btn btn-sm green" style="margin: 10px; border-radius: 8px;">lưu ảnh</button>
                      </span>
                    </div>
                    <input type="hidden" id="thumbnail" name="image" >
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- <div class="form-actions text-center">
           <div class="col-xs-12 col-sm-12" style="margin-top: 20px;">             
             <button type="submit" class="btn btn-sm green">
               Thêm mới
             </button>
           </div>
         </div> --}}
         
       </form>
     </div>
   </div>

   <!-- END SIDEBAR USERPIC -->
   <!-- SIDEBAR USER TITLE -->
                {{-- <div class="profile-usertitle">
                    <h4 class="profile-usertitle-name text-center" id="name-main"> {{$user->name}} </h4>
                  </div> --}}
                  <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->
                <div class="portlet light ">
                  <!-- END STAT -->
                  <div>
                   <label class="control-label" style="font-weight:bold;"><u>Thông tin khác </u></label>
                   <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-slack" aria-hidden="true"></i>
                    <span id="sk_profile">@if($user->slack==Null)<em>(Chưa cập nhật)</em>@else {{$user->slack}} @endif</span>
                  </div>
                  <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-facebook"></i>
                    <a id="fb_profile" href="@if($user->facebook==Null) @else {{$user->facebook}} @endif" target="_blank">@if($user->facebook==Null)<em>(Chưa cập nhật)</em>@else {{$user->facebook}} @endif</a>
                  </div>
                  <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-skype"></i>
                    <span id="sk_profile">@if($user->skype==Null)<em>(Chưa cập nhật)</em>@else {{$user->skype}} @endif</span>
                  </div>
                </div>
              </div>
              <!-- END PORTLET MAIN -->
            </div>
          </div>
          <!-- END BEGIN PROFILE SIDEBAR -->
          <!-- BEGIN PROFILE CONTENT -->
          <div class="col-md-8">
            <div class="profile-content">
              <div class="row">

                <div class="col-md-12">
                  <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                      <ul class="nav nav-tabs">
                        <li id="view-profile" class="active" >
                          <a href="#information" data-toggle="tab">Thông tin tài khoản</a>
                        </li>
                        <li id="info_profile">
                          <a href="#edit-information" data-toggle="tab">Sửa thông tin</a>
                        </li>
                               {{--  <li>
                                    <a href="#tab_1_3" data-toggle="tab">Thay đổi avatar</a>
                                  </li> --}}
                                  <li id="act-password">
                                    <a href="#change-password" data-toggle="tab">Thay đổi mật khẩu</a>
                                  </li>
                                </ul>
                              </div>
                              <div class="portlet-body">
                                <div class="tab-content">
                                  <!-- Begin info -->
                                  <div class="tab-pane active" id="information">
                                   <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                     <label class="control-label" style="font-weight:bold"><u>Chi tiết</u></label>
                                     <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Họ tên:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="text-left" id="view_name">{{$user->name}}</span>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Ngày sinh:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="text-left" id="view_birthday">@if($user->birthday==Null)<em>(Chưa cập nhật)</em>@else {{date('d-m-Y',strtotime($user->birthday))}} @endif</span>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Giới tính</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="text-left" id="view_gender">@if($user->gender==Null)<em>(Chưa cập nhật)</em>@elseif($user->gender!=Null and $user->gender==1) Nam @elseif($user->gender!=Null and $user->gender==2) Nữ @endif</span>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label" id="view_mobile">Điện thoại:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="field text-left">{{$user->mobile}}</span>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Địa chỉ:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="field text-left" id="address">@if($user->address==Null)<em>(Chưa cập nhật)</em>@else {{$user->address}} @endif</span>
                                      </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Nơi làm việc:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="field text-left" id="school">@if(empty($user->work_place))<em>(Chưa cập nhật)</em>@else {{$user->work_place}} @endif</span>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Chức vụ:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="field text-left" id="school">@if(empty($user->position))<em>(Chưa cập nhật)</em>@else {{$user->position}} @endif</span>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-8 col-md-5">
                                        <label class="control-label">Email:</label>
                                      </div>
                                      <div class="col-xs-12 col-sm-4 col-md-7">
                                        <span class="field text-left" id="view_mail"><a href="mailto:{{$user->email}}">{{$user->email}}</a></span>
                                      </div>
                                    </div>
                                    <hr>

                                  </div>
                                </div>
                              </div>
                              <!-- begin Edit Info -->
                              <div class="tab-pane" id="edit-information">
                                <div class="row">
                                  <div class="col-md-12 col-lg-12">
                                    <form id="edit-profile" name="edit-profile" role="form" >
                                      {{ csrf_field() }}
                                      <input type="hidden" name="id" id="id" value="{{$user->id}}">
                                      <input type="hidden" name="email" id="email" value="{{$user->email}}">
                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Họ tên </label>
                                        <div class="col-md-9 col-lg-9">
                                          <input type="text" required id="name_profile" name="name" placeholder="Họ và tên" value="{{$user->name}}" class="form-control" />
                                          <p style="color:red;display:none;margin-top: 10px" class="error errorName"></p>
                                        </div>
                                        <div class="col-md-1 requireds">(*)</div>
                                      </div>
                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Ngày sinh</label>
                                        <div class="col-md-9 col-lg-9">
                                          <input type="text" id="birthday_profile" name="birthday" placeholder="Ngày sinh" value="{{$user->birthday}}" class="form-control" />
                                        </div>
                                        <div class="col-md-1 requireds"></div>
                                      </div>
                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Giới tính </label>
                                        <div class="col-md-9 col-lg-9">
                                          <select class="form-control" id="gender_profile" name="gender" style="width:100%">
                                            <option value="1" @if($user->gender==1)selected @endif> Nam </option>
                                            <option value="2" @if($user->gender==2)selected @endif> Nữ </option>
                                          </select>
                                          <p style="color:red;display:none;margin-top: 10px" class="error errorGender"></p>
                                        </div>
                                        <div class="col-md-1 requireds"></div>
                                      </div>
                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Điện thoại</label>
                                        <div class="col-md-9 col-lg-9">
                                          <input type="text" required id="mobile_profile" name="mobile" placeholder="Số điện thoại" value="{{$user->mobile}}" class="form-control" />
                                          <p style="color:red;display:none;margin-top: 10px" class="error errorMobile"></p>
                                        </div>
                                        <div class="col-md-1 requireds">(*)</div>
                                      </div>
                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Địa chỉ </label>
                                        <div class="col-md-9 col-lg-9">
                                          <input type="text" name="address" id="address_profile" placeholder="Địa chỉ" value="{{$user->address}}" class="form-control" />
                                          <p style="color:red;display:none;margin-top: 10px" class="error errorAddress"></p>
                                        </div>
                                        <div class="col-md-1 requireds"></div>
                                      </div>


                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Nơi làm việc</label>
                                        <div class="col-md-9 col-lg-9">
                                          <input type="text" id="work_place" name="work_place" placeholder="Nơi làm việc" value="{{$user->work_place}}" class="form-control" />
                                          <p style="color:red;display:none;margin-top: 10px" class="error errorWorkPlace"></p>
                                        </div>
                                        <div class="col-md-1 requireds"></div>
                                      </div>
                                      <div class="form-group form-md-line-input">
                                        <label class="control-label col-md-2 col-lg-2 lable_profile">Chức vụ</label>
                                        <div class="col-md-9 col-lg-9">
                                          <input type="text" id="position" name="position" placeholder="Chức vụ" value="{{$user->position}}" class="form-control" />

                                        </div>
                                        <div class="col-md-1 requireds"></div>
                                      </div>

                                        {{-- <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-2 col-lg-2 lable_profile">Kỹ năng</label>
                                            <div class="col-md-9 col-lg-9">
                                              <textarea class="form-control" name="skill" placeholder="Kỹ năng" id="skill" rows="5">{{$user->skill}}</textarea>

                                            </div>
                                            <div class="col-md-1 requireds"></div>
                                          </div> --}}

                                          <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-2 col-lg-2 lable_profile">Slack</label>
                                            <div class="col-md-9 col-lg-9">
                                              <input type="text" name="slack" id="slack_profile" placeholder="@Slack" value="{{$user->slack}}" class="form-control" />
                                            </div>
                                            <div class="col-md-1 requireds"></div>
                                          </div>

                                          <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-2 col-lg-2 lable_profile">Facebook</label>
                                            <div class="col-md-9 col-lg-9">
                                              <input type="text" name="facebook" id="facebook_profile" placeholder="Link Facebook" value="{{$user->facebook}}" class="form-control" />
                                            </div>
                                            <div class="col-md-1 requireds"></div>
                                          </div>

                                          <div class="form-group form-md-line-input">
                                            <label class="control-label col-md-2 col-lg-2 lable_profile">Skype</label>
                                            <div class="col-md-9 col-lg-9">
                                              <input type="text" name="skype" id="skype_profile" placeholder="Skype" value="{{$user->skype}}" class="form-control" />
                                            </div>
                                            <div class="col-md-1 requireds"></div>
                                          </div>
                                          <div class=" text-center">
                                           <button type="submit" class="btn-edit-profile btn btn-sm btn-primary">
                                            Cập nhật
                                          </button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                {{-- <div class="tab-pane" id="tab_1_3">
                                    <em>Để thay đổi ảnh đại diện bạn hãy chọn ảnh cho riêng mình. </em>
                                    <form id="edit_avatar_profile" enctype="multipart/form-data" role="form" style="margin-top: 20px;">
                                       {{ csrf_field() }}

                                        <div class="form-group">
                                        <!--     <div class="fileinput fileinput-new"  data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="" alt="" /> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div> -->
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new">Chọn ảnh </span>
                                                       <input type="file" id= "avatar_profile" name="avatar" class="form-control">

                                                     </span>
                                                </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="margin-top-10">
                                            <button type="submit" class="btn-edit-profile btn btn-primary">
                                            Lưu sửa đổi
                                            </button>
                                        </div>
                                    </form>
                                  </div> --}}
                                  <!-- END CHANGE AVATAR TAB -->
                                  <!-- CHANGE PASSWORD TAB -->
                                  <div class="tab-pane" id="change-password">
                                    <form id="edit-profile-password" name="edit-profile-password">
                                      {{ csrf_field() }}
                                      <input type="hidden" name="id" value="{{$user->id}}">
                                      <div class="form-group">
                                        <label class="control-label">Mật khẩu hiện tại</label>
                                        <input type="password" name="password_old" class="form-control" />
                                        <p style="color:red;display:none;margin-top: 10px" class="error error-profile errorOldPassWord"></p>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label">Mật khẩu mới</label>
                                        <input type="password" name="password" class="form-control" />
                                        <p style="color:red;display:none;margin-top: 10px" class="error error-profile errorNewPassWord"></p>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label">Nhập lại mật khẩu mới</label>
                                        <input type="password" name="password_confirmation" class="form-control" />
                                        <p style="color:red;display:none;margin-top: 10px" class="error error-profile errorReNewPassWord ">
                                        </div>
                                        <div class="margin-top-10">
                                         <button type="submit" id="sub-password" class="btn btn-sm green">Đổi mật khẩu</button>
                                         <button id="reset_change_password" type="reset" class="btn btn-sm default">Làm mới</button>
                                       </div>
                                     </form>
                                   </div>
                                   <!-- END CHANGE PASSWORD TAB -->
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                     <!-- END PROFILE CONTENT -->
                   </div>

                 </div>
                 @endsection

                 @section('footer')

                 <script src="{{url('js/ajax-crud.js')}}" type="text/javascript"></script>
                 <script>
                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                </script>
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
      $('#edit-profile').on('submit',function(e){
        e.preventDefault();
        var form= $('#edit-profile');
        var formData= form.serialize();

        $.ajax({
          type:'PUT',
          url: '{{route('users.update-profiles')}}',
          data: formData,
          success:function(data){
            toastr["success"]("Cập nhật thành công");
            setTimeout(function(){
              window.location.reload();
            }, 1000);
          },
          error: function (xhr, ajaxOptions, thrownError) {
           toastr.error(thrownError);
         }
       });

      });
    </script>



    <script>
      $('#edit-profile-password').on('submit',function(e){

        e.preventDefault();

        var form= $('#edit-profile-password');
        var formData= form.serialize();

        $.ajax({
          type:'PUT',
          url: '{{route('users.update-password')}}',
          data: formData,
          success:function(data){




            if(data.error) {
              if(!IsNull(data.message.password_old )) {
                toastr.error(data.message.password_old[0]);
              }
              if(!IsNull(data.message.password )) {
                toastr.error(data.message.password[0]);
              }
              if(!IsNull(data.message.password_confirmation)) {
                toastr.error(data.message.password_confirmation[0]);
              }

              if (data.type == 'err_pass_old') {
                toastr.error(data.message);
              }


            } else {

            	toastr["success"]("Cập nhật thành công");

             setTimeout(function(){
               window.location.reload();
             }, 1000);
           }


         },
         error: function (xhr, ajaxOptions, thrownError) {
           toastr.error(thrownError);
         }
       });

      });
    </script>

    <script type="text/javascript">

      $('#frmCreateUser').on('submit',function(e){

        e.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var form= $('#frmCreateUser');
        // if(! form.valid()) return false;

        $.ajax({
          type:'POST',
          url: "{{route('users.updateavatar')}}",
          data: {
            id: $('#idUser').val(),
            avatar: $('#createImage #thumbnail').val(),
          },
          success:function(data){
            console.log(data);
            if(!data.error) {
              toastr.success('Cập nhật ảnh thành công!');
              setTimeout(function () {
                window.location.href = "{{route('users.profiles')}}";
              }, 1000);
              $('#frmCreateUser button[type="submit"]').prop('disabled',true);
            } else {
              $('#frmCreateUser button[type="submit"]').prop('disabled',false);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      });
    </script>

    @endsection
