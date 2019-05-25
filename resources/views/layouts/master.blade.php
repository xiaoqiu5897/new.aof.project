<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Hệ thống quản lý học viên | admin.zent.edu.vn</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <meta content="{{URL::asset('')}}" name="website" />
    <link rel="shortcut icon" href="{{url('img/favicon.ico')}}" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker.min.css"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link rel='stylesheet' href='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css'>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">


    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{mix('build/css/components-md.css')}}" rel="stylesheet" id="style_components" type="text/css" />

    <link href="{{mix('build/css/plugins-md.css')}}" rel="stylesheet" type="text/css" />

    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{mix('build/css/layout.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{mix('build/css/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />

    <link href="{{mix('build/css/custom.css')}}" rel="stylesheet" type="text/css" />


    <link href="{{mix('build/css/user.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{mix('build/css/style.css')}}" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="{{mix('build/css/chatbox.css')}}">

    <!-- END THEME LAYOUT STYLES -->

    @yield('head')

    <style type="text/css">
        @media screen and (max-width: 415px){
         .responsemodal{
            width:145%;


        }

    }

    #cover {
        position: fixed;
        width: 100%;
        min-height: 100%;
        z-index: 999999;
        background: rgba(255, 255, 255, 0.3);
        text-align: center;
        display: none;
    }
    #cover img {
        margin-top: 23%;
    }
    @media screen and (max-width: 600px){
     .detail{
        display:block;
        width:300px;
        word-wrap:break-word;

    }
}
@media screen and (max-width: 992px) and (min-width: 600px) {
 .detail{
    display:block;
    width:400px;
    word-wrap:break-word;

}
}

@media screen and (min-width: 993px){
   .detail{
    display:block;
    width:700px;
    word-wrap:break-word;

}
}
</style>

</head>
<!-- END HEAD -->

<body class="page-sidebar-closed-hide-logo page-content-white page-md">

    <div id="cover" class=""><img src="{{ asset('images/zents/load.svg') }}"></div>
    <!-- BEGIN HEADER -->
    <div class="page-header navbar">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{URL::asset('')}}">
                    <img src="{{url('img/logo.png')}}" alt="logo" class="logo-default" /> 
                </a>

                <div class="menu-toggler sidebar-toggler"> </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" style="width: 30px;height: 30px;" src="@if(Auth::user()->avatar == Null) {{url('img/default_avatar.jpg')}}@endif @if(Auth::user()->avatar != Null) {{url(Auth::user()->avatar)}}@endif" />

                            <span class="username username-hide-on-mobile" id="id_login" data-id="{{ Auth::user()->id }}">   {{ Auth::user()->name }} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        @if (Auth::guard('web')->check())
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{-- {{route('users.profiles')}} --}}">
                                    <i class="fa fa-cog" aria-hidden="true"></i> Cài đặt
                                </a>
                            </li>

                            <li class="divider"> </li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </li>
                        </ul>
                        @endif

                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">

                <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                    <li class="sidebar-toggler-wrapper hide">
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                        <div class="sidebar-toggler"> </div>
                        <!-- END SIDEBAR TOGGLER BUTTON -->
                    </li>
                    <li class="nav-item start {{ Request::is('/*') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">
                            <i class="icon-home"></i>
                            <span class="title">Bảng điều khiển</span>
                        </a>
                    </li>

                    {{-- START QUẢN LÝ TÀI CHÍNH --}}
                    <li class="heading">
                        <h3 class="uppercase">Quản lý tài chính</h3>
                    </li>
                    <li class="nav-item {{ Request::is('cash-receipt-voucher*','cash-payment-voucher*') ? 'active open' : '' }}  ">
        
                        <a href="" class="nav-link nav-toggle">
                            <i class="fa fa-credit-card"></i>
                            <span class="title">Tiền mặt</span>
                            <span class="arrow {{ Request::is('cash-receipt-voucher*','cash-payment-voucher*') ? 'open' : '' }}"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item {{ Request::is('cash-receipt-voucher*') ? 'active open' : '' }}  ">
                                <a href="{{ route('cash-receipt-voucher.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span class="title">Phiếu thu</span>
                                </a>
                            </li>
                            <li class="nav-item {{ Request::is('cash-payment-voucher*') ? 'active open' : '' }}  ">
                                <a href="{{ route('cash-payment-voucher.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span class="title">Phiếu chi</span>
                                </a>
                            </li>
                        </ul>

                    </li>

                    <li class="nav-item {{ Request::is('credit-note*', 'standing-order*') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">
                            <i class="fa fa-credit-card"></i>
                            <span class="title">Ngân hàng</span>
                            <span class="arrow {{ Request::is('credit-note*', 'standing-order*') ? 'open' : '' }}"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item {{ Request::is('credit-note*') ? 'active open' : '' }}  ">
                                <a href="{{ route('credit-note.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Giấy báo có</span>
                                </a>
                            </li>

                            <li class="nav-item {{ Request::is('standing-order*') ? 'active open' : '' }}  ">
                                <a href="{{ route('standing-order.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Uỷ nhiệm chi</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    
                    <li class="nav-item {{ Request::is('cash-book*', 'bank-deposit-book*') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">
                            <i class="fa fa-credit-card"></i>
                            <span class="title">Sổ quỹ</span>
                            <span class="arrow {{ Request::is('cash-book*', 'bank-deposit-book*') ? 'open' : '' }}"></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="nav-item {{ Request::is('cash-book*') ? 'active open' : '' }}  ">
                                <a href="{{ route('cash-book.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Sổ quỹ tiền mặt</span>
                                </a>
                            </li>

                            <li class="nav-item {{ Request::is('bank-deposit-book*') ? 'active open' : '' }}  ">
                                <a href="{{ route('bank-deposit-book.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Sổ tiền gửi</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item {{ Request::is('main-ledger/list*') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            <span class="title">Sổ cái</span>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('revenue-expenditure*','report-collect-tuition-fee*','report-teacher-salary*') ? 'active open' : '' }}  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-credit-card"></i>
                            <span class="title">Báo cáo </span>
                            <span class="arrow {{ Request::is('revenue-expenditure*','report-collect-tuition-fee*','report-teacher-salary*') ? 'open' : '' }}"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ Request::is('revenue-expenditure*') ? 'active open' : '' }}  ">
                                <a href="" class="nav-link nav-toggle">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span class="title">Thu - Chi<span style="color: red; font-size: 12px" id="total_votes"></span></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="heading">
                        <h3 class="uppercase">Nhân viên</h3>
                    </li>

                    <li class="nav-item {{ Request::is('users*') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">

                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span class="title">Quản lý nhân viên</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('*department-manager*') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">

                            <i class="fa fa-id-card" aria-hidden="true"></i>
                            <span class="title">Quản lý phòng ban</span>
                        </a>
                    </li>

                    {{-- end --}}

                    {{-- STUDENT --}}

                    <li class="heading">
                        <h3 class="uppercase">Học viên</h3>
                    </li>


                    <li class="nav-item {{ Request::is('students') ? 'active open' : '' }}  ">
                        <a href="" class="nav-link nav-toggle">
                            <i class="fa fa-user"></i>
                            <span class="title">Quản lý học viên</span>
                        </a>
                    </li>



                    <li class="heading">
                        <h3 class="uppercase">Quản trị hệ thống</h3>
                    </li>


                    <li class="nav-item {{ Request::is('role*') ? 'active open' : '' }}">
                        <a href="" class="nav-link nav-toggle">

                            <i class="icon-lock ion" aria-hidden="true"></i>
                            <span class="title">Vai trò</span>
                        </a>
                    </li>


                    <li class="nav-item {{ Request::is('permission*') ? 'active open' : '' }}">
                        <a href="" class="nav-link nav-toggle">
                            <i class="icon-shield ion" aria-hidden="true"></i>

                            <span class="title">Quyền hạn</span>
                        </a>
                    </li>


                </ul>

                <!-- END SIDEBAR -->


            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">

                    @yield('contents')

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2018 &copy; Zent Soft-ware.
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>

        <!-- END FOOTER -->
        <!--[if lt IE 9]>

        <![endif]-->

        <!-- BEGIN CORE PLUGINS -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.0.4/js.cookie.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.2/jquery.slimscroll.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js" type="text/javascript"></script>

        <script src='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js'></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js" type="text/javascript"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js" type="text/javascript"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>

        <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>

        <!-- END CORE PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->

        <script src="{{mix('build/js/app.min.js')}}" type="text/javascript"></script>

        <script src="{{ asset('assets/layouts/layout/scripts/common.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{mix('build/js/layout.min.js')}}" type="text/javascript"></script>

        <script src="{{mix('build/js/demo.min.js')}}" type="text/javascript"></script>

        <script src="{{mix('build/js/quick-sidebar.min.js')}}" type="text/javascript"></script>

        <script src="{{mix('build/js/chatbox.js')  }}" type="text/javascript"></script>

        <!-- Include Date Range Picker -->

        <script type="text/javascript">
         $.ajaxSetup({
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });

         function IsNull(obj)
         {
          var is;
          if (obj instanceof jQuery)
              is = obj.length <= 0;
          else
              is = obj === null || typeof obj === 'undefined' || obj == "";

          return is;

      }

      var app_url = $('meta[name="website"]').attr('content');


  </script>

  <script>
    $(function() {

  		// tooltip
        $("body").tooltip({ selector: '[data-tooltip=tooltip]' });

        //set timeout toastr
        toastr.options = {
            "preventOpenDuplicates": true,
            "timeOut": 3000
        };

        // localStorage.setItem('menu_close', false);
        $(document).on('click','.menu-toggler', function() {

            var check = localStorage.getItem('menu_close');
            console.log(check);
            if (check == 'true') {
                check = false;
            }
            else {
                check = true;
            }


            localStorage.setItem('menu_close', check);
        })

        if (localStorage.getItem('menu_close') == 'true') {
            $('body').addClass('page-sidebar-closed');
            $('ul.page-sidebar-menu').addClass('page-sidebar-menu-closed');
        }
        else {
            $('body').removeClass('page-sidebar-closed')
            $('ul.page-sidebar-menu').removeClass('page-sidebar-menu-closed');
        }


    });

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

<script type="text/javascript">
    $('.box li').click(function() {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
    });
</script>
<script type="text/javascript">
    function total_votes(){
        $.ajax({
          url: "",
          type: "POST",
          success: function(res){

            if (res.error == false) {
                if (res.count_finance > 0) {
                    $('#total_votes').html(' (' +res.count_finance+ ')');
                }else{
                    $('#total_votes').html('');
                }
                if (res.count_payment > 0) {
                    $('#total_votes_2').html(' (' +res.count_payment+ ')');
                }else{
                    $('#total_votes_2').html('');
                }     
            }
            if (res.error == true) {
            }
        }
    })
    }
    total_votes();
</script>
@yield('footer')

</body>

</html>
