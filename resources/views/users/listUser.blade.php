@extends('layouts.master')
@section('contents')
<style>
  .error {
    color: red;
  }
</style>
<div class="portlet light bordered">
	<div  class="portlet-body">
    <div class="table-toolbar">
      <div class="row">
        <div class="col-md-12">
          <ul class="list-inline">
           <li class="btn-group col-md-6 pull-left">
              <button id="myBtn" class="btn btn-sm green  btn-outline" data-toggle="dropdown">Thêm
              <i class="fa fa-plus"></i>
              </button>
           </li>
           <li class="col-md-6 pull-right text-center">
              <form method="get" action="">
                <input type="text" class="search-class form-control " id="search"  name="search"  placeholder="Nhập Thông Tin Tìm Kiếm">
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div id="repalceTable" class="row table-responsive">
    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
      <thead>
          <tr>
              <th class="stl-column color-column">ID</th>
              <th class="stl-column color-column">  
                 Hành Động
              </th>
              <th class="stl-column color-column">Họ Tên </th>
              <th class="stl-column color-column">Số Điện Thoại</th>
              <th class="stl-column color-column">Email</th>
              <th class="stl-column color-column">Quyền</th>
              <th class="stl-column color-column">Loại</th>                        
              <th class="stl-column color-column">Trạng Thái</th>
              <th class="stl-column color-column">Ngày tạo</th>
              
          </tr>
      </thead>
      <tbody>
      @if (count($users)  > 0)
      @foreach($users as $db)
          <tr align="center" id="userRow{{$db->id}}">
              <td>{{$db->id}}</td>
              <td>
                <ul class="list-inline">
                    <li>
                        <a href="#"><i class="fa fa-info btn-xs btn-detail btn-info style-css" data-id="{{$db->id}}" aria-hidden="true" title="Xem Chi tiết User"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o btn-xs btn-warning btn-edit style-css " data-id="{{$db->id}}" aria-hidden="true" title="Sửa Thông Tin User"></i></a>
                    </li>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <li>
                        <a href="#"><i class="fa fa-trash-o btn-xs btn-danger btn-del  style-css action-{{$db->id}}" data-id="{{$db->id}}" aria-hidden="true" title="Xóa User"></i> </a>
                    </li>
                </ul> 
              </td> 
              <td>{{$db->name}}</td>
              <td><a href="tel:{{$db->mobile}}">{{$db->mobile}}</a></td>  
              <td><a href="{{$db->email}}">{{$db->email}}</a></td>
              <td>
              @if(count($db->roles))
                @foreach($db->roles as $role)
                <label class="label label-success">{{$role->display_name}}</label>
                @endforeach
              @endif
              </td>
              <td>
              @if($db->type==1)
                Quản Lý
              @endif
              @if($db->type==2)
               Giáo Viên 
              @endif  
              @if($db->type==3)
               Trợ Lý
              @endif
              </td>
              <td>
              @if($db->status==1)
                Đang Mở
              @endif                           
              @if($db->status==2)
                Đã Đóng
              @endif  
              </td>
              <td>
                {{date('Y-m-d H:i:s', strtotime($db->created_at))}}
              </td>
              
          </tr>
       @endforeach

       @else 

        <p align="center">Không có bản ghi nào</p>

       @endif
      </tbody>
    </table>
    <div class="portlet-body text-right" id="panigate-user" >
    @if ($flag)
      {!! $users->links() !!}
    @endif
    </div>
    </div>
  
  </div>   

</div>

<!-- Begin Edit -->
<div class="modal fade bs-modal-lg" id="User-modal-edit" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="suanguoidung">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Sửa Người Dùng
                </h4>
            </div>        
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form id="frmEditUser" name="frmEditUser" class="form-horizontal" role="form">
                {{ csrf_field() }}
          <!-- begin row -->
                <div class="row">
                  <!-- begin edit Left -->
                    <div class="col-sm-6">
                          <div class="form-group form-md-line-input">
                                <label  class="col-sm-3 control-label"
                                          for="name">Họ Tên</label>
                                <div class="col-sm-8">
                                    <input class="style-formEdit form-control" id="editName" name="editName" placeholder="Họ Và Tên" type="text"/>
                                     <p style="color:red;display:none" class="error errorName"></p>
                                </div>
                                <div class="col-sm-1 requireds">(*)</div>
                          </div>
                          <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label"
                                      for="birthday" >Số Điện Thoại</label>
                                <div class="col-sm-8">
                                 <input class="form-control phone_number" data-id="" id="editMobile" name="editMobile" placeholder="Số Điện Thoại" type="text"/>
                                  <p style="color:red;display:none" class="error errorMobile"></p>
                                </div>
                                <div class="col-sm-1"></div>
                          </div>
                          <input type="hidden" class="form-control has-error" id="editID" name="editID" value="">
                          <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                   Ngày Sinh
                                </label>
                                <div class="col-sm-8 form-md-line-input">
                                 <input class="form-control" id="editBirthday"   name="date" placeholder="YYYY/MM/DD" type="text"/>  <p style="color:red;display:none" class="error errorBirthday"></p>
                                  </div>
                                  <div class="col-sm-1"></div>
                          </div>
                          <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                    Giới Tính
                                </label>
                                <div class="col-sm-8">
                                   <select class="form-control" id="editGender" name="editGender" style="width:100%">
                                        <option  value="1">Nam</option>
                                        <option value="2" >Nữ</option>
                                    </select>
                                     <p style="color:red;display:none" class="error errorGender"></p>
                               </div>
                               <div class="col-sm-1 requireds">(*)</div>
                          </div>

                          <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                   Email
                                </label>
                                <div class="col-sm-8">
                                   <input class="form-control editEmail" id="editEmail" data-id="" name="editEmail" placeholder="Email" type="email"/>
                                   <p style="color:red;display:none" class="error errorEmail"></p>
                                </div>
                                <div class="col-sm-1 requireds">(*)</div>
                         </div>
                        
                          <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                   Facebook
                                </label>
                                <div class="col-sm-8">
                                  <input class="form-control url_input" id="editFacebook" name="editFacebook" placeholder="Link Facebook" type="text"/>
                                  <p style="color:red;display:none" class="error errorFacebook errorUrl"></p>
                              </div>
                              <div class="col-sm-9"></div>
                          </div>  
                          <div class="form-group form-md-line-input">
                                  <label class="col-sm-3 control-label">
                                     Skype
                                  </label>
                                  <div class="col-sm-8">
                                    <input class="form-control" id="editSkype" name="editSkype" placeholder="Skype" type="text"/>
                                     <p style="color:red;display:none" class="error errorSkype"></p>
                                </div>
                                <div class="col-sm-1"></div>
                          </div>    
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                  Trình Độ
                                </label>
                                <div class="col-sm-8">
                                <textarea type="text" class="form-control" id="editEducation" name="editEducation" placeholder="Trình Độ" rows="4" cols="50"></textarea>
                              </div>
                              <div class="col-sm-1"></div>   
                        </div>                      
                    </div>
                  <!-- end edit Left -->
                  <!-- begin edit Right -->
                    <div class="col-sm-6">
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                   Địa Chỉ
                                </label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" id="editAddress" name="editAddress" placeholder="Địa Chỉ">
                                </input>
                                 <p style="color:red;display:none" class="error errorAddress"></p>
                              </div>
                              <div class="col-sm-1"></div>
                        </div>   
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                  Nơi Làm Việc
                                </label>
                                <div class="col-sm-8">
                                 <input class="form-control" id="editWorkFace" name="editWorkFace" placeholder="Nơi Làm Việc" type="text"/>
                              </div>
                              <div class="col-sm-1"></div>
                        </div> 
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                  Kỹ Năng
                                </label>
                                <div class="col-sm-8">
                                <textarea  class="form-control" id="editSkill" name="editSkill" placeholder="Kỹ Năng" type="text"/> </textarea>
                              </div>
                              <div class="col-sm-1"></div>
                        </div>
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                  Chức Vụ
                                </label>
                                <div class="col-sm-8">
                                <input class="form-control" id="editPosition" name="editPosition" placeholder="Chức Vụ" type="text"/>
                              </div>
                              <div></div>
                        </div class="col-sm-1">
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                Loại User
                                </label>
                                <div class="col-sm-8">
                                 <select class="form-control" id="editType" name="editType" style="width:100">
                                        <option value="1">Quản Lý</option>
                                        <option value="2">Giáo Viên</option>
                                        <option value="3">Trợ Lý</option>

                                 </select>
                                 <p style="color:red;display:none" class="error errorType"></p>
                              </div>
                              <div class="col-sm-1"></div>
                        </div>
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                Quyền
                                </label>
                                 <div class="col-sm-8">
                                   <select class="form-control" id="editRole" name="editRole[]" multiple="" style="width:100%">
                                      @foreach($roles as $role)
                                        <option value="{{$role->id}}" id="select_role{{$role->id}}">{{$role->display_name}}</option>
                                        @endforeach
                                   </select>
                                   <p style="color:red;display:none" class="error errorType"></p>
                                 </div>
                                 <div class="col-sm-1 "></div>
                        </div>
                        <div class="form-group form-md-line-input">
                                <label class="col-sm-3 control-label">
                                Trạng Thái
                                </label>
                                <div class="col-sm-8">
                                <select class="form-control" id="editStatus" name="editStatus" style="width:100%">
                                        <option value="1">Đang Mở</option>
                                        <option value="2">Đã Đóng</option>
                                    </select>
                                 <p style="color:red;display:none" class="error errorStatus"></p>
                              </div>
                              <div class="col-sm-1"></div>
                        </div>                      
                    </div>
                  <!-- end edit right -->
                </div>
          <!-- end row -->
              <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-default"
                        data-dismiss="modal">
                           Đóng
                </button>
                <button type="submit" class="btn btn-xs btn-primary">
                    Lưu Thay Đổi
                </button>
            </div>                                                                     
                </form>     
            </div>
        </div>
    </div>
</div>


<!-- poup Create -->

<div class="modal fade bs-modal-lg" id="createUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" id="themmoi">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Thêm Mới</h4>
                        </div>
                        <div class="modal-body">
                             <form id="frmCreateUser" name="frmCreateUser" class="form-horizontal" role="form">
                               {{ csrf_field() }}
                               <div class="row">
                                  <div class="col-sm-6">
                                       <div class="form-group form-md-line-input">
                                        <label  class="col-sm-3 control-label"
                                           for="name">Họ Tên</label>
                                        <div class="col-sm-8">
                                           <input class="style-formEdit form-control" id="name" name="name" placeholder="VD: Tùng dz" type="text"/>
                                           <p style="color:red;display:none" class="error errorName"></p>
                                        </div>
                                        <div class="col-sm-1 requireds">(*)</div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label"
                                           for="phone" >Số Điện Thoại</label>
                                        <div class="col-sm-8">
                                           <input class="form-control " id="mobile" name="mobile" placeholder="VD: 0989999999" type="text"/>
                                           <p style="color:red;display:none" class="error errorMobile"></p>
                                        </div>
                                        <div class="col-sm-1 requireds">(*)</div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label"
                                           for="password" >Mật khẩu</label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="password" name="password" placeholder="Mật Khẩu" type="password"/>  
                                           <p style="color:red;display:none" class="error errorPassword"></p>
                                        </div>
                                        <div class="col-sm-1 requireds">(*)</div>
                                     </div>
                                     <input type="hidden" class="form-control has-error" id="ID" name="ID" value="">
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Ngày Sinh
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="birthday"   name="birthday" placeholder="MM/DD/YYYY" type="text"/>
                                           <p style="color:red;display:none" class="error errorBirthday"></p>
                                        </div>
                                        <div class="col-sm-1"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Giới Tính
                                        </label>
                                        <div class="col-sm-8">
                                           <select class="form-control" id="gender" name="gender" style="width:100%">
                                              <option  value="1">Nam</option>
                                              <option value="2" >Nữ</option>
                                           </select>
                                           <p style="color:red;display:none" class="error errorGender"></p>
                                        </div>
                                        <div class="col-sm-1 requireds"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Email
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="email" name="email" placeholder="VD: tungdz@gmail.com" type="email"/>
                                           <p style="color:red;display:none" class="error errorEmail"></p>
                                        </div>
                                        <div class="col-sm-1 requireds">(*)</div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Facebook
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control c_url_input" id="facebook" name="facebook" placeholder="Link Facebook" type="text"/>
                                           <p style="color:red;display:none" class="error errorFacebook errorUrl"></p>
                                        </div>
                                        <div class="col-sm-1"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Skype
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="skype" name="skype" placeholder="Skype" type="text"/>
                                        </div>
                                         <div class="col-sm-1"></div>
                                     </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Địa Chỉ
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="address" value="" name="address" placeholder="Địa Chỉ" type="text"/>
                                        </div>
                                        <div class="col-sm-1"></div>
                                      </div>

                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Nơi Làm Việc
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="work_place" name="work_place" placeholder="Nơi Làm Việc" type="text"/>
                                           <p style="color:red;display:none" class="error errorWork_place"></p>
                                        </div>
                                        <div class="col-sm-1"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Trình Độ
                                        </label>
                                        <div class="col-sm-8">
                                        <textarea class="form-control" id="education_info" type="text" name="education_info" value="" placeholder="Trình Độ"></textarea>
                                           <!-- <textarea class="form-control" id="education_info"  rows="3"  name="education_info" placeholder="Trình Độ"></textarea> -->
                                        </div>
                                         <div class="col-sm-1"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Kỹ Năng
                                        </label>
                                        <div class="col-sm-8">
                                           <textarea class="form-control" id="skill" name="skill" placeholder="Kỹ Năng" type="text"/></textarea>
                                        </div>
                                        <div class="col-sm-1"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Chức Vụ
                                        </label>
                                        <div class="col-sm-8">
                                           <input class="form-control" id="position" name="position" placeholder="Chức Vụ" type="text"/>
                                        </div>
                                        <div class="col-sm-1"></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Loại User
                                        </label>
                                        <div class="col-sm-8">
                                           <select class="form-control" id="type" name="type" style="width:100%">
                                              <option value="1">Quản Lý</option>
                                              <option value="2">Giáo Viên</option>
                                              <option value="3">Trợ Lý</option>
                                           </select>
                                           <p style="color:red;display:none" class="error errorType"></p>
                                         </div>
                                         <div class="col-sm-1 "></div>
                                     </div>
                                     <div class="form-group form-md-line-input">
                                              <label class="col-sm-3 control-label">
                                              Quyền
                                              </label>
                                               <div class="col-sm-8">
                                                 <select class="form-control" id="roles" name="roles[]" multiple="" style="width:100%">
                                                    @foreach($roles as $role)
                                                      <option value="{{$role->id}}" @if($role->id==5) selected @endif >{{$role->display_name}}</option> 
                                                      @endforeach
                                                 </select>
                                                 <p style="color:red;display:none" class="error errorType"></p>
                                               </div>
                                               <div class="col-sm-1 "></div>
                                      </div>
                                     <div class="form-group form-md-line-input">
                                        <label class="col-sm-3 control-label">
                                        Trạng Thái
                                        </label>
                                        <div class="col-sm-8">
                                           <select class="form-control" id="status" name="status" style="width:100%">
                   
                                              <option value="1">Đang Mở</option>
                                              <option value="2">Đã Đóng</option>
                                           </select>
                                           <p style="color:red;display:none" class="error errorStatus"></p>
                                        </div>
                                        <div class="col-sm-1 requireds"></div>
                                     </div>
                                  </div>
                               </div>
                                         
                                    
                                   
                                     <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-default"
                                           data-dismiss="modal">
                                        Đóng
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                        Thêm Mới
                                        </button>
                                     </div>
                                  </form>

                               </div>

                          </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                  </div>
<!-- endCreate -->
<!-- poup Show Detail -->
<div  class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="User-modal-info" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="chitiet">
                <button type="button" class="close btn-xs" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  Thông Tin Chi Tiết
                </h4>
            </div>        
            <!-- Modal Body -->
            <div class="modal-body">
                
             <form class="form-horizontal" role="form">
             <div class="row">
                  <div class="col-sm-6">
                          <div class="form-group form-md-line-input">
                            <label  class="col-sm-3 control-label " for="name">Họ Tên</label>
                              <div class="col-sm-8 ">
                                  <input class="style-formEdit form-control" id="infoName" placeholder="Số Điện Thoại" type="text"/>
                              </div>
                            <div class="col-sm-1 requireds"></div>
                      </div>
                      <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label"
                                  for="phone" >Số Điện Thoại</label>
                            <div class="col-sm-8 " >
                             <input class="form-control" id="infoMobile" placeholder="Số Điện Thoại" type="text"/>
                            </div>
                            <div class="col-sm-1"></div>
                      </div>
                      <input type="hidden" class="form-control has-error" id="infoID"  value="">
                      <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label">
                               Ngày Sinh
                            </label>
                            <div class="col-sm-8 ">
                             <input class="form-control" id="infoBirthday" type="text"/>
                              </div>
                              <div class="col-sm-1"></div>
                      </div>
                      <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label">
                                Giới Tính
                            </label>
                            <div class="col-sm-8 ">
                               <select class="form-control" id="infoGender"  style="width:100%">
                                    <option  value="1">Nam</option>
                                    <option value="2" >Nữ</option>

                                </select>
                                 
                           </div>
                           <div class="col-sm-1 requireds"></div>
                      </div>

                      <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label">
                               Email
                            </label>
                            <div class="col-sm-8 ">
                               <input class="form-control" id="infoEmail"  type="email"/>
                               
                            </div>
                            <div class="col-sm-1 requireds"></div>
                     </div>
                    
                      <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label">
                               Facebook
                            </label>
                            <div class="col-sm-8 ">
                              <input class="form-control" id="infoFacebook"  type="text"/>
                          </div>
                          <div class="col-sm-1"></div>
                    </div>  
                    <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label">
                               Skype
                            </label>
                            <div class="col-sm-8 ">
                              <input class="form-control" id="infoSkype"  type="text"/>
                          </div>
                          <div class="col-sm-1"></div>
                    </div>
                   <div class="form-group form-md-line-input">
                        <label class="col-sm-3 control-label">
                           Địa Chỉ
                        </label>
                        <div class="col-sm-8 ">
                        <input type="text" class="form-control" id="infoAddress"  >
                        </input>
                      </div>
                      <div class="col-sm-1"></div>
                  </div>                       
               </div>
               <div class="col-sm-6 ">   
                  <div class="form-group form-md-line-input">
                        <label class="col-sm-3 control-label">
                          Nơi Làm Việc
                        </label>
                        <div class="col-sm-8">
                         <input class="form-control" id="infoWorkFace" type="text"/>
                      </div>
                      <div class="col-sm-1"></div>
                  </div> 
                  <div class="form-group form-md-line-input ">
                        <label class="col-sm-3 control-label">
                          Trình Độ
                        </label>
                        <div class="col-sm-8">
                        <input type="text" name="" class="form-control" id="infoEducation" value="" placeholder="">
<!--                         <textarea class="form-control" id="infoEducation" rows="5" cols="50"></textarea>
 -->                      </div>
                      <div class="col-sm-1"></div>   
                  </div> 
                  <div class="form-group form-md-line-input ">
                        <label class="col-sm-3 control-label">
                          Kỹ Năng
                        </label>
                        <div class="col-sm-8 ">
                        <input class="form-control" id="infoSkill" type="text"/>
                      </div>
                      <div class="col-sm-1"></div>
                  </div>
                  <div class="form-group form-md-line-input ">
                        <label class="col-sm-3 control-label">
                          Chức Vụ
                        </label>
                        <div class="col-sm-8 ">
                          <input class="form-control" id="infoPosition" type="text"/>
                        </div>
                        </div class="col-sm-1">
                  <div class="form-group form-md-line-input">
                        <label class="col-sm-3 control-label">
                        Loại User
                        </label>
                        <div class="col-sm-8 ">
                         <select class="form-control" id="infoType" style="width:100%">
                                <option value="1">Quản Lý</option>
                                <option value="2">Giáo Viên</option>
                                <option value="3">Trợ Lý</option>

                         </select>
                      </div>
                      <div class="col-sm-1"></div>
                    </div>
                   <div class="form-group form-md-line-input">
                            <label class="col-sm-3 control-label">
                            Quyền
                            </label>
                             <div class="col-sm-8">
                               <select class="form-control" id="roles_user"  multiple="" style="width:100%">
                                
                               </select>
                             </div>
                             <div class="col-sm-1 "></div>
                    </div>
                    <div class="form-group form-md-line-input ">
                          <label class="col-sm-3 control-label">
                          Trạng Thái
                          </label>
                          <div class="col-sm-8 ">
                          <select class="form-control" id="infoStatus" style="width:100%">
                                  <option value="1">Đang Mở</option>
                                  <option value="2">Đã Đóng</option>
                              </select>
                        </div>
                        <div class="col-sm-1"></div>
                   </div>
               </div>
           </div>   
               
              <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-default"
                        data-dismiss="modal">
                           Đóng
                </button>
            </div>                                                                     
                </form>     
            </div>
            
            <!-- Modal Footer -->

        </div>
    </div>
</div>
<script>
jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
  phone_number = phone_number.replace(/\s+/g, "");
  return this.optional(element) || phone_number.length >= 10 &&
        phone_number.match(/^(\(?(0|\+84)[1-9]{1}\d{1,4}?\)?\s?\d{3,4}\s?\d{3,4})$/);
}, "Invalid phone number");
  $('#frmCreateUser').validate({
      errorElement: "span",
        rules: {
          name : {
            required: true,
          },
          mobile : {
            required:true,
            minlength : 10,
            phoneUS :true,
            number : true,
          },
          password : {
            required:true,
            minlength : 6
          },
          birthday : {
            required:true,
            date    : true
          },
          gender : {
            required : true,
          },
          email : {
            required : true,
            email    : true
          },
          facebook : {
            url : true,
          },
          type : {
            required : true,
          },
          status : {
            required : true,
          },
        },
        messages: {
          name : {
            required: "Bạn vui lòng nhập đầy đủ họ tên",
          },
          mobile : {
            required:"Bạn vui lòng nhập số điện thoại",
            minlength : "số điện thoại tối thiểu 9 số",
            phoneUS :"Số điện thoại không đúng định dạng VD:(0|+84)999 999 999",
            number : "ký tự nhập vào phải là kiểu số",
          },
          password : {
            required:"Bạn vui lòng nhập mật khẩu",
            minlength : "Mật khẩu tối thiểu 6 ký tự"
          },
          birthday : {
            required:"Bạn vui lòng nhập ngày sinh",
            date    : "Ngày sinh không đúng định dạng"
          },
          gender : {
            required : "Bạn vui lòng chọn giới tính",
          },
          email : {
            required : "Bạn vui lòng nhập email",
            email    : "Email không đúng định dạng (abc@gmail.com)"
          },
          facebook : {
            url : "Đường link không đúng định dạng (https://www.google.com.vn)",
          },
          type : {
            required : "Bạn vui lòng chọn loại User",
          },
          status : {
            required : "Bạn vui lòng chọn trạng thái",
          },
        }
    });
$('#frmEditUser').validate({
      errorElement: "span",
        rules: {
          editName : {
            required: true,
          },
          editMobile : {
            required:true,
            minlength : 10,
            phoneUS :true,
            number : true,
          },
          date : {
            required:true,
            date    : true
          },
          editGender : {
            required : true,
          },
          editEmail : {
            required : true,
            email    : true
          },
          editFacebook : {
            url : true,
          },
          editType : {
            required : true,
          },
          editStatus : {
            required : true,
          },
        },
        messages: {
          editName : {
            required: "Bạn vui lòng nhập đầy đủ họ tên",
          },
          editMobile : {
            required:"Bạn vui lòng nhập số điện thoại",
            minlength : "số điện thoại tối thiểu 9 số",
            phoneUS :"Số điện thoại không đúng định dạng VD:(0|+84)999 999 999",
            number : "ký tự nhập vào phải là kiểu số",
          },
          date : {
            required:"Bạn vui lòng nhập ngày sinh",
            date    : "Ngày sinh không đúng định dạng"
          },
          editGender : {
            required : "Bạn vui lòng chọn giới tính",
          },
          editEmail : {
            required : "Bạn vui lòng nhập email",
            email    : "Email không đúng định dạng (abc@gmail.com)"
          },
          editFacebook : {
            url : "Đường link không đúng định dạng (https://www.google.com.vn)",
          },
          editType : {
            required : "Bạn vui lòng chọn loại User",
          },
          editStatus : {
            required : "Bạn vui lòng chọn trạng thái",
          },
        }
    });
</script>
@section('footer')
<script src="{{url('js/ajax-crud.js')}}" type="text/javascript"></script>
@endsection
<!-- endcreate -->
@endsection