@extends('layouts.master')
@section('head')
@endsection
@section('contents')
<link rel="stylesheet" href="{{url('css/datatables.bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}"/>
<link rel="stylesheet" href="{{URL::asset('')}}css/jquery.datetimepicker.min.css">
<link rel="stylesheet" href="{{URL::asset('')}}css/bootstrap-switch.min.css">
<link rel="stylesheet" href="{{ asset('css/jquery.qtip.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}"/>
<style>
   #logs-table td, th {
   text-align: center;
   }
   .nav-tabs>li.active>a {
   border:none !important;
   border-bottom: 3px solid #f36e24 !important;
   }
   .coursewares-view ul{
   list-style: none; 
   padding: 0;
   }
   .coursewares-view ol{
   padding: 0;
   }
   .coursewares-view ol li{
   height: 35px;
   }
   .coursewares-view li {
   border-bottom: 1px #eeeeee solid;
   line-height: 200%;
   }
   .coursewares-view li a {
   color: black;
   }
   .coursewares-view b {
   margin-left: 10px;
   color: #f36e24;
   }
   .panel {
   margin-bottom: 15px !important;
   }
   .low-student-body a {
   color: black;
   }
   .low-student-body i {
   color: #f36e24;
   }
   .low-student-body a:hover{
   color: #f36e24;
   }
   .qtip-zent {
   background-color: #F36E24;
   border-color: #F36E24;
   color: white;
   }
   #logs-table td, th {
   text-align: center;
   }
   .nav-tabs>li.active>a {
   border:none !important;
   border-bottom: 3px solid #f36e24 !important;
   }
   .coursewares-view ul{
   list-style: none;
   padding: 0;
   }
   .coursewares-view ol{
   padding: 0;
   }
   .coursewares-view ol li{
   height: 35px;
   }
   .coursewares-view li {
   border-bottom: 1px #eeeeee solid;
   line-height: 200%;
   }
   .coursewares-view li a {
   color: black;
   }
   .coursewares-view b {
   margin-left: 10px;
   color: #f36e24;
   }
   .sweet-alert{
   z-index: 12000;
   }
   .sweet-overlay{
   z-index: 11000;
   }
   .panel {
   margin-bottom: 15px !important;
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
   .reset-padding{
   padding: 0px !important;
   }
   
   .btn-class-name{
    width: 100px;
    margin-top: 5px;
   }
   .btn-class-name:hover {
    color: #f36e24;
   }
   .btn-class-name-active{
    color: white !important;
    background: #f36e24;

   }
   .btn-class-name-active:hover {
      color: white;
   }
   #class_name_chart {
      text-align: center;
      font-weight: 900;
   }
   tr.study-group {
      color: #f36e24;
   }
   #study-group-block {
      width: 30px;
      height: 19px;
      background: #f36e24;
      display: inline-block;
   }
   tr.main-study {
      color: #3598dc;
   }
   #main-study-block {
      width: 30px;
      height: 19px;
      background: #3598dc;
      display: inline-block;
   }
</style>
<div class="page-bar">
   <ul class="page-breadcrumb">
      <li>
         <span>
         <img src="https://zent.edu.vn/img/new-tech-logo-gs.jpg" alt="Logo" style="width: 200px;">
         </span>
      </li>
      <li>
         <div id="carousel-id" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="item active">
                  <span></span>
               </div>
               <div class="item">
                  <span>Chào {{ Auth::user()->name}}, chúc bạn ngày mới tốt lành !</span>
               </div>
               <div class="item">
                  <span></span>
               </div>
            </div>
         </div>
      </li>
   </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<br><br>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS 1-->

<div class="row" style="position: relative;">
   {{-- Khoá học --}}
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="dashboard-stat purple">
         <div class="visual">
            <i class="fa fa-globe"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" > </span>
            </div>
            <div class="desc"> Khoá học </div>
         </div>
         <a class="more" href=""> Chi tiết
         <i class="fa fa-arrow-right" aria-hidden="true"></i>
         </a>
      </div>
   </div>
   {{-- end --}}
   {{-- Lớp học --}}
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="dashboard-stat green">
         <div class="visual">
            <i class="fa fa-windows"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" data-value="">  </span>
            </div>
            <div class="desc"> Lớp học </div>
         </div>
         <a class="more" href=""> Chi tiết
         <i class="fa fa-arrow-right" aria-hidden="true"></i>
         </a>
      </div>
   </div>
   {{-- end --}}
   {{-- Nhân viên --}}
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="dashboard-stat blue">
         <div class="visual">
            <i class="fa fa-comments"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" data-value=""> </span>
            </div>
            <div class="desc"> Nhân viên </div>
         </div>
         <a class="more" href=""> Chi tiết
         <i class="fa fa-arrow-right" aria-hidden="true"></i>
         </a>
      </div>
   </div>
   {{-- end --}}
   {{-- Học viên --}}
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="dashboard-stat red">
         <div class="visual">
            <i class="fa fa-graduation-cap"></i>
         </div>
         <div class="details">
            <div class="number">
               <span data-counter="counterup" data-value=""> </span>
            </div>
            <div class="desc"> Học viên </div>
         </div>
         <a class="more" href=""> Chi tiết
         <i class="fa fa-arrow-right" aria-hidden="true"></i>
         </a>
      </div>
   </div>
   {{-- end --}}
</div>
{{-- expr --}}

<div class="clearfix"></div>
@endsection
@section('footer')
<script src="{{url('js/jquery.waypoints.min.js')}}" type="text/javascript"></script>
{{-- <script src="{{url('js/jquery.counterup.min.js')}}" type="text/javascript"></script> --}}
<script src="{{url('js/jquery.vmap.js')}}" type="text/javascript"></script>
<script src="{{url('js/jquery.vmap.russia.js')}}" type="text/javascript"></script>
<script src="{{url('js/jquery.vmap.world.js')}}" type="text/javascript"></script>
<script src="{{url('js/jquery.vmap.europe.js')}}" type="text/javascript"></script>
<script src="{{url('js/jquery.vmap.germany.js')}}" type="text/javascript"></script>
<script src="{{url('js/jquery.vmap.usa.js')}}" type="text/javascript"></script>
{{-- <script src="{{url('js/jquery.vmap.sampledata.js')}}" type="text/javascript"></script> --}}
<script src="{{url('js/morris.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('js/locale-all.js') }}"></script>
<script src="{{ asset('js/jquery.qtip.min.js') }}"></script>
<script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{url('js/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script type="text/javascript"> 
   tinymce.init({
     selector: '#addNewAnswer',
     height: 350,
     theme: 'modern',
     menubar: false,
     autosave_ask_before_unload: false,
     plugins: [
     "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
     "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
     "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern codesample"
     ],
     toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft | codesample",
     image_advtab: true,
     content_css: [
     '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
     '//www.tinymce.com/css/codepen.min.css'
     ],
     relative_urls: false,
     remove_script_host : false,
     file_browser_callback : function(field_name, url, type, win) {
       var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
       var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
   
       var cmsURL = route_prefix + '?field_name=' + field_name;
       if (type == 'image') {
         cmsURL = cmsURL + "&type=Images";
       } else {
         cmsURL = cmsURL + "&type=Files";
       }
   
       tinyMCE.activeEditor.windowManager.open({
         file : cmsURL,
         title : 'Image manager',
         width : x * 0.9,
         height : y * 0.9,
         resizable : "yes",
         close_previous : "no"
       });
     }
   });
</script>
@endsection