@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{url('css/datatables.bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset('optimization/css/custom.css') }}">
<link rel='stylesheet' href='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker.min.css">
<style type="text/css">
    .modal-header{
        background-color: orange;
    }
    .voucher_detail input{
        border-top: none;
        border-left: none;
        border-right: none;
        border-radius: 0px;
    }
    #add_receipt_voucher label{
        font-size: 15px;
    }
    .bank_account_box{
        display: none;
    }
    .recipient_hidden{
        display: none;
    }
    th{
        text-align: center;
    }

    .modal-title{
        color: white;
        font-weight: bold !important;
    }

    table.dataTable thead .sorting_asc:after{
        display: none;
    }

    #historyFinance #list-collect-tuition-table_length, #historyFinance #list-collect-tuition-table_filter, #historyFinance #list-collect-tuition-table_info, #historyFinance #list-collect-tuition-table_paginate, #student-finance-table_filter, #list-collect-tuition-table-2_filter{
        display: none;
    }

    .nav-tabs>li.active>a {
        border:none !important;
        border-bottom: 3px solid orange !important;
    }

    .sweet-alert{
        z-index: 12000;
    }

    .sweet-overlay{
        z-index: 11000;
    }

    .tbl_stt, .tbl_status, .tbl_action{
        text-align: center;
    }

    .tbl_tuition, .tbl_tuition_reduce, .tbl_tuition_repaid, .tbl_tuition_owed{
        text-align: right;
    }

    #amount-receipt{
        float: right;
    }
    #exchange_rate{
        display: none;
    }
</style>
@endsection

@section('contents')

<div class="modal fade bs-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            {{-- call ajax here --}}
        </div>
    </div>
</div>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption" style="font-size: 14px">
            <i class="fa fa-home" aria-hidden="true"></i>
            <a href="">  Trang chủ </a>
            &nbsp;/&nbsp; Quản lý kế toán
        </div>
    </div>
    <div class="portlet-body">
        <br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab">Danh sách tài khoản kế toán</a></li>
        </ul>
        <div class="tab-content">
            <div id="new-students" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-xs-12">
                        <br>
                        <button type="button" class="btn btn-sm green btn-create" style="background: #0039a5">
                            <i class="fa fa-plus"></i> Tạo tài khoản kế toán
                        </button>
                    </div>
                </div>
                <br>
                <table class="table table-striped table-bordered table-hover" id="finance_account_table">
                    <thead>
                        <tr>
                            <th class="stl-column color-column">STT</th>
                            <th class="stl-column color-column">Level</th>
                            <th class="stl-column color-column">Mã</th>
                            <th class="stl-column color-column">Tên</th>
                            <th class="stl-column color-column">Chức năng</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('/finance_account/create')
@include('/finance_account/edit')
@endsection
@section('footer')
<script src="{{url('js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{url('js/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{ asset('optimization/jQuery.print-master/jQuery.print.js') }}"></script>
<script src="{{ asset('optimization/js/moment.min.js') }}"></script>
<script src="{{ asset('optimization/js/moment-with-locales.min.js') }}" charset="UTF-8"></script>
<script src="{{ asset('assets/global/plugins/jquery-number-master/jquery.number.min.js') }}" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src='https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js'></script>
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
<script type="text/javascript">
    $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
</script>
<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>
<script>
    $('#finance_account_table').DataTable({
        processing: true,
        serverSide: true,
        ordering:   false,
        pageLength: 25,
        ajax: '{!! route('get-list-finance-account') !!}',
        pageLength: 30,
        lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
        columns: [
        {data: 'DT_RowIndex', className:'stt'},
        {data: 'level', name: 'level'},
        {data: 'code', name: 'code'},
        {data: 'name', name: 'name'},
        {data: 'action', name: 'action', className: 'text-center'},
        ]
    });
</script>
<script type="text/javascript">
    $('.btn-create').on('click', function() {
        $('#modal-finance-account').modal('show');
        $('#add_finance_account_form')[0].reset();
        $('#parent_id').empty();
        $('#parent_id').attr('disabled', true);
        $('#surplus_debit').attr('disabled', true);
        $('#surplus_credit').attr('disabled', true);
    });
</script>
<script type="text/javascript">
    $('#level').on('change', function() {
        var level = $('#level').val();

        if (level == 1) {
            $('#parent_id').removeAttr('disabled');
            $('#surplus_debit').removeAttr('disabled');
            $('#surplus_credit').removeAttr('disabled');

            $.ajax({
                type: 'get',
                url: '{{ url('/create-finance-account') }}',
                
                success: function (response) {
                    $.each(response.parents, function( key, value ) {
                        $('#parent_id').append("<option value="+value.id+">"+value.name+"</option>");
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //xử lý lỗi tại đây
                }
            })
        } else {
            $('#parent_id').empty();
            $('#parent_id').attr('disabled',true);
            $('#surplus_debit').attr('disabled',true);
            $('#surplus_credit').attr('disabled',true);
        }
    });
</script>
<script type="text/javascript">
    $('#add_finance_account_form').on('submit', function(event) {
        event.preventDefault();
        
        var data = $('#add_finance_account_form').serializeArray();

        $.ajax({
            url: '{{ route('finance_account.store') }}',
            type: 'POST',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#modal-finance-account').modal('hide');
                    toastr.success(res.message);
                    $('#finance_account_table').DataTable().ajax.reload(null,false);
                }
                else {
                    $.each(res.message, function( key, value ) {
                        toastr.error(value);
                    });
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $('#finance_account_table').on('click', '.btn-edit', function() {
        $('#modal-finance-account-edit').modal('show');
        $('#edit_finance_account_form')[0].reset();

        var id = $(this).attr('data-id');

        $.ajax({
            url: '{{ asset('finance_account') }}/' + id,
            type: 'GET',

            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $.each(res.parents, function( key, value ) {
                        $('#parent_id_edit').append("<option value="+value.id+">"+value.name+"</option>");
                    });
                    $('#code_edit').val(res.data.code);
                    $('#name_edit').val(res.data.name);
                    $('#surplus_debit_edit').val(res.data.surplus_debit);
                    $('#surplus_credit_edit').val(res.data.surplus_credit);
                    $('#parent_id_edit').val(res.data.parent_id);

                    $('#edit_finance_account_form').attr('data-id', id);
                } else {
                    $.each(res.message, function( key, value ) {
                        toastr.error(value);
                    });
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $('#edit_finance_account_form').on('submit', function(event) {
        event.preventDefault();

        var id = $(this).attr('data-id');

        var data = $('#edit_finance_account_form').serializeArray();

        $.ajax({
            url: '{{ asset('finance_account') }}/' + id,
            type: 'PUT',
            data: data,
            
            success: function (res) {
                console.log(res);
                if (!res.error) {
                    $('#modal-finance-account-edit').modal('hide');
                    toastr.success(res.message);
                    $('#finance_account_table').DataTable().ajax.reload(null,false);
                }
                else {
                    toastr.error(res.message);
                }
            }
        });
    });
</script>
@endsection

