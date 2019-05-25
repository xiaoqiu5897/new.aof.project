@extends('layouts.master')
@section('contents')  

                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                   <h1 class="text-center">THÔNG TIN TÀI KHOẢN </h1>
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
                                    <div class="profile-userpic" align="center">
                                        <img src="@if($profile_user->avatar==Null ){{url('img/default-avatar_men.PNG')}}@else {{url('img/default-avatar_men.PNG')}} @endif" class="img-responsive" alt=""> </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <h4 class="profile-usertitle-name text-center" id="name-main"> {{$profile_user->name}} </h4>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="portlet light ">
                                    <!-- END STAT -->
                                    <div>
                                         <label class="control-label" style="font-weight:bold"><u>Thông tin mạng xã hội </u></label>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-skype"></i>
                                            <span id="sk_profile">@if($profile_user->skype==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->skype}} @endif</span>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-facebook"></i>
                                           <a id="fb_profile" href="@if($profile_user->facebook==Null)#@else {{$profile_user->facebook}} @endif" target="_blank">@if($profile_user->facebook==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->facebook}} @endif</a>
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
                                                        <a href="#tab_1_1" data-toggle="tab">Thông tin tài khoản</a>
                                                    </li>
                                                    <li id="info_profile">
                                                        <a href="#tab_1_2" data-toggle="tab">Sửa thông tin</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_3" data-toggle="tab">Thay đổi avatar</a>
                                                    </li>
                                                    <li id="act-password">
                                                        <a href="#tab_1_4" data-toggle="tab">Thay đổi mật khẩu</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                <!-- Begin info -->
                                                    <div class="tab-pane active" id="tab_1_1">
                                                       <div class="row">
                                                          <div class="col-xs-12 col-sm-6 col-md-12">
                                                             <label class="control-label" style="font-weight:bold"><u>Chi tiết</u></label>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Họ và tên</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="text-left" id="view_name">{{$profile_user->name}}</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Ngày sinh :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="text-left" id="view_birthday">@if($profile_user->birthday==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->birthday}} @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Giới tính :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="text-left" id="view_gender">@if($profile_user->gender==Null)<em>(Chưa cập nhật)</em>@elseif($profile_user->gender!=Null and $profile_user->gender==1) Nam @elseif($profile_user->gender!=Null and $profile_user->gender==2) Nữ @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Địa chỉ :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-left" id="view_address">@if($profile_user->gender==Null)<em>(Chưa cập nhật)</em>@elseif($profile_user->gender!=Null and $profile_user->gender==1) Nam @elseif($profile_user->gender!=Null and $profile_user->gender==2) Nữ @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label" id="view_mobile">Số điện thoại :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-left">{{$profile_user->mobile}}</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label" id="view_education_info">Trình độ học vấn :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-left">@if($profile_user->education_info==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->education_info}} @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Nơi làm việc :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-left" id="view_work_place">@if($profile_user->work_place==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->work_place}} @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Email :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-left" id="view_mail"><a href="mailto:{{$profile_user->email}}">{{$profile_user->email}}</a></span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Kỹ năng :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-left" id="view_skill">@if($profile_user->skill==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->skill}} @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                              <div class="row">
                                                                  <div class="col-xs-12 col-sm-8 col-md-5">
                                                                    <label class="control-label">Chức Vụ :</label>
                                                                  </div>
                                                                  <div class="col-xs-12 col-sm-4 col-md-7">
                                                                    <span class="field text-center" id="view_position">@if($profile_user->position==Null)<em>(Chưa cập nhật)</em>@else {{$profile_user->position}} @endif</span>
                                                                  </div>
                                                              </div>
                                                              <hr>
                                                          </div>
                                                       </div>
                                                    </div>
                                                    <!-- begin Edit Info -->
                                                    <div class="tab-pane" id="tab_1_2">
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12">
                                                        <form id="edit_profile" role="form" >
                                                        {{ csrf_field() }}
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Họ và tên : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" id="name_profile" name="name" placeholder="Họ và tên" value="{{$profile_user->name}}" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorName"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds">(*)</div>
                                                             </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Ngày sinh : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" id="birthday_profile" name="birthday" placeholder="Ngày sinh" value="{{$profile_user->birthday}}" class="form-control" />
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                             </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Giới tính : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <select class="form-control" id="gender_profile" name="gender" style="width:100%">
                                                                    <option value="1" @if($profile_user->gender==1)selected @endif> Nam </option>
                                                                    <option value="2" @if($profile_user->gender==2)selected @endif> Nữ </option>
                                                                </select>
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorGender"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Địa chỉ : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" name="address" id="address_profile" placeholder="Địa chỉ" value="{{$profile_user->address}}" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorAddress"></p> 
                                                                </div>
                                                                 <div class="col-md-1 requireds"></div>
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Số điện thoại : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" id="mobile_profile" name="mobile" placeholder="Số điện thoại" value="{{$profile_user->mobile}}" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorMobile"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds">(*)</div>
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Học vấn : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input class="form-control" id="education_profile" name="education_info" value="{{$profile_user->education_info}}"  placeholder="Trình độ học vấn">
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorEducation"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Nơi làm việc : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" id="work_place_profile" name="work_place" placeholder="Nơi làm việc" value="{{$profile_user->work_place}}" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorWorkPlace"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                            </div>
                                                            <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Email : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" name="email" id="email_profile" placeholder="Email" value="{{$profile_user->email}}" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorEmail"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds">(*)</div> 
                                                            </div>
                                                             <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Kỹ năng : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" name="skill" id="skill_profile" placeholder="Kỹ năng" value="{{$profile_user->skill}}" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error errorSkill"></p>
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                             </div>
                                                             <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Chức vụ : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" name="position" id="position_profile" placeholder="Chức vụ" value="{{$profile_user->position}}" class="form-control" />
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                             </div>
                                                               <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Skype : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" name="skype" id="skype_profile" placeholder="Skype" value="{{$profile_user->skype}}" class="form-control" />
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                             </div>
                                                             <div class="form-group form-md-line-input">
                                                                <label class="control-label col-md-2 col-lg-2 lable_profile">Facebook : </label>
                                                                <div class="col-md-9 col-lg-9">
                                                                <input type="text" name="facebook" id="facebook_profile" placeholder="Link Facebook" value="{{$profile_user->facebook}}" class="form-control" />
                                                                </div>
                                                                <div class="col-md-1 requireds"></div>
                                                             </div>
                                                             <div class=" text-center">
                                                               <button type="submit" class="btn-edit-profile btn btn-xs btn-primary">
                                                                Lưu sửa đổi
                                                                </button>
                                                            </div>           
                                                        </form>
                                                        </div>
                                                         </div>
                                                    </div>
                                                    <!-- END PERSONAL INFO TAB -->
                                                    <!-- CHANGE AVATAR TAB -->
                                                    <div class="tab-pane" id="tab_1_3">
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
                                                                <button type="submit" class="btn-edit-profile btn btn-xs btn-primary">
                                                                Lưu sửa đổi
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- END CHANGE AVATAR TAB -->
                                                    <!-- CHANGE PASSWORD TAB -->
                                                    <div class="tab-pane" id="tab_1_4">
                                                        <form id="edit_profile_password">
                                                              {{ csrf_field() }}
                                                             <div class="form-group">
                                                                <label class="control-label">Mật khẩu mới</label>
                                                                <input type="password" name="new_password" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error error-profile errorNewPassWord"></p>
                                                               </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Nhập lại mật khẩu mới</label>
                                                                <input type="password" name="re_new_password" class="form-control" />
                                                                <p style="color:red;display:none;margin-top: 10px" class="error error-profile errorReNewPassWord ">
                                                                 </div>
                                                            <div class="margin-top-10">
                                                                 <button type="submit" id="sub-password" class="btn btn-xs green">Đổi mật khẩu</button>
                                                                 <button id="reset_change_password" type="reset" class="btn btn-xs default">Làm mới</button>
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
@section('footer')
<script src="{{url('js/ajax-crud.js')}}" type="text/javascript"></script>
@endsection
@endsection