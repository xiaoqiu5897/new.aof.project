@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{url('css/datatables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('css/daterangepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/fontawesome.min.css">
<style type="text/css" media="screen">
  .dt-center{
    text-align: center;
  }
  .statistical-title {
    font-weight: 500;
    font-size: 20px;
  }
  #review-docs-mdl .col-md-12 {
    margin-bottom: 10px;
    font-size: 16px;
  }
  .carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{
    display: block;
    max-width: 100%;
    height: 100%;
  }
</style>

@endsection

@section('contents')

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption" style="font-size: 14px">
        <i class="fa fa-home" aria-hidden="true"></i>
        <a href="{{ route('dashboard') }}">  Trang chủ </a>
        &nbsp;/&nbsp; Quản lý tài chính
        &nbsp;/&nbsp; Thống kê thu - chi
    </div>
  </div>
    <div class="portlet-body">
      <div class="panel panel-default" id="filterPanel">
        <div class="panel-heading"><strong><i class="fa fa-search" aria-hidden="true"></i> Lọc thông tin</strong></div>
          <div class="panel-body" style="margin-left: 25px;">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Thời gian</label>
                  <div>
                    <div class="input-group date col-md-6" id="dateStart" style="width: 48%;float: left;" data-provide="datepicker">
                      <input type="text" id="start_date" class="form-control" name="start_date" placeholder="Từ ngày">
                      <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                    <div class="input-group date col-md-6" id="dateEnd" style="width: 48%;float: right;" data-provide="datepicker" >
                      <input type="text" id="end_date" class="form-control" name="end_date" placeholder="Đến ngày">
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  </div>    
                </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="">Hình thức</label>
                      <select name="type" id="type" class="form-control">
                          <option value="">Chọn</option>
                          <option value="0">Thu</option>
                          <option value="1">Chi</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="">Loại phiếu</label>
                      <select name="mainledgerable_type" id="mainledgerable_type" class="form-control">
                          {{-- <option value="all">Tất cả</option> --}}
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <br>
                  <button style="margin-top: 4px;" class="btn btn-primary" id="btn-search" type="button"><i style="font-size: 16px;" class="fa fa-search"></i> Tìm kiếm</button>
                </div>
              </div>
          </div>
            {{-- </form> --}}
        </div>
      </div>
      <div class="clearfix"></div>
      <div id="export-excel">
          <a class="btn btn-success" href="" id="btn_export" style="float: right; margin-right: 15px;"><i style="font-size: 16px;" class="fa fa-file-excel"></i> Export</a>
      </div>
      <div class="clearfix"></div>
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped table-bordered table-hover" id="list-table">
            <thead>
                <tr>
                  <th style="text-align: center;">STT</th>
                  <th style="text-align: center;">Hình thức</th>
                  <th style="text-align: center;">Người bị tác động</th>
                  <th style="text-align: center;">Người tạo</th>
                  <th style="text-align: center;">Ngày</th>
                  <th style="text-align: center;">Nội dung</th>
                  <th style="text-align: center;">Số tiền</th>
                </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
</div>

@endsection

@section('footer')
<script src="{{url('js/jqueryValidate/jquery.validate.js')}}" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{url('js/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{url('js/ledger_method.js')}}" type="text/javascript"></script>
<script src="{{url('js/moment.min.js')}}" type="text/javascript"></script>
<script src="{{url('js/daterangepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
   var route_prefix = "{{ url(config('lfm.prefix')) }}";
   var path_absolute = "{{URL::asset('')}}";

   $(document).ready(function() {
        $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
    });
</script>
<script>
  {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
</script>
<script>
  $('#ReceiptFrm #lfm').filemanager('image', {prefix: route_prefix});
  // $('#editSlide #lfm').filemanager('image', {prefix: route_prefix});
</script>
<script>
    //change to base64
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
  $("#image").change(function(){
      readImage( this );
    });

</script>
<script type="text/javascript">
      $('#dateStart').datepicker({
          format: 'yyyy-mm-dd',
          "autoclose": true,
      });
        $('#dateEnd').datepicker({
          format: 'yyyy-mm-dd',
          "autoclose": true,
      });
</script>
<script>
    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {

        $('#btn-search').on('click', function() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var type = $('#type').val();
            var mainledgerable_type = $('#mainledgerable_type').val();
            // var bank_account_id = $('#bank_account_id').val();
            if (type == '') {
              toastr.error('Vui lòng chọn hình thức!');
            }else{
              if (start_date != '' && end_date != '' && start_date < end_date) {
                $('#btn_export').attr('href','{{ asset('revenue-expenditure/export') }}/'+start_date+'/'+end_date+'/'+type+'/'+mainledgerable_type);
                $('#list-table').DataTable().destroy();
                $('#list-table').DataTable({
                      processing: true,
                      serverSide: true,
                      ajax: {
                        url: '{!!route('RevenueExpenditure.filter')!!}',
                        type: 'post',
                          data: function (d) {
                              d.start_date = $('input[name=start_date]').val();
                              d.end_date = $('input[name=end_date]').val();
                              d.type = $('select[name=type]').val();
                              d.mainledgerable_type = $('select[name=mainledgerable_type]').val();
                              // d.bank_account_id = $('select[name=bank_account_id]').val();
                          },
                      },
                      lengthMenu: [100],
                      searching: true,
                      ordering: false,
                      pageLength: 30,
                      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
                      columns: [
                        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: "10px"},
                        {data: 'type', name: 'type', width: "150px"},
                        {data: 'user', name: 'user', width: "120px"},
                        {data: 'user-make', name: 'user-make'},
                        {data: 'date', name: 'date', class: 'text-center'},
                        {data: 'content', name: 'content'},
                        {data: 'amount', name: 'amount', class:'text-right'},
                      ]
                  });
            
            }else if (start_date == '' && end_date == '') {
                $('#btn_export').attr('href','{{ asset('revenue-expenditure/export') }}/0/0/'+type+'/'+mainledgerable_type);
                $('#list-table').DataTable().destroy();
                $('#list-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                      url: '{!!route('RevenueExpenditure.filter')!!}',
                      type: 'post',
                        data: function (d) {
                            d.start_date = $('input[name=start_date]').val();
                            d.end_date = $('input[name=end_date]').val();
                            d.type = $('select[name=type]').val();
                            d.mainledgerable_type = $('select[name=mainledgerable_type]').val();
                            // d.bank_account_id = $('select[name=bank_account_id]').val();
                        },
                    },
                    lengthMenu: [100],
                    ordering: false,
                    pageLength: 30,
                    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
                    columns: [
                      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: "10px"},
                      {data: 'type', name: 'type', width: "150px", searchable:false},
                      {data: 'user', name: 'user', width: "120px"},
                      {data: 'user-make', name: 'user-make'},
                      {data: 'date', name: 'date', class: 'text-center'},
                      {data: 'content', name: 'content'},
                      {data: 'amount', name: 'amount', class:'text-right'},
                    ]
                });
              }else if (start_date > end_date) {
                  toastr.error('Ngày bắt đầu phải trước ngày kết thúc!');
              }else if (start_date != '' && end_date == '') {
                  toastr.error('Cần nhập đầy đủ thời gian bắt đầu và kết thúc!');
              }else if (start_date == '' && end_date != '') {
                  toastr.error('Cần nhập đầy đủ thời gian bắt đầu và kết thúc!');
              }

            }
            
        }); 
      })
</script>
<script>
    $(document).ready(function () {

        $(document).on('change','#type',function () {
            if ($(this).val() === "0"){
                $('#mainledgerable_type').html('<option value="all">Tất cả</option><option value="tuition">Phiếu thu học phí</option><option value="fiOther">Phiếu thu khác</option>');
            }else if ($(this).val() === "1"){
              $('#mainledgerable_type').html('<option value="all">Tất cả</option><option value="salaryAdvance">Phiếu chi ứng lương</option><option value="payrollSlip">Phiếu chi lương</option><option value="paymentVouchers">Phiếu chi khác</option>');
            }else{
                $('#mainledgerable_type').html('');
            }
        });
    });
</script>
@endsection
