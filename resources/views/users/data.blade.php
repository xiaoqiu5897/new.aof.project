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
              <td>{{$db->mobile}}</td>  
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

	    <tr>
	      <td colspan="9" align="center">không tìm thấy bản ghi nào</td>
	    </tr>

       @endif
      </tbody>
    </table>
    <div class="portlet-body text-right" id="panigate-user" >
    @if ($flag)
      {!! $users->links() !!}
    @endif
    </div>