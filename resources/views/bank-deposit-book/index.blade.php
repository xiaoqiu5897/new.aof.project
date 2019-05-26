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
			<a href="{{ route('dashboard') }}">  Trang chủ </a>
			&nbsp;/&nbsp; Sổ quỹ
			&nbsp;/&nbsp; Sổ tiền gửi ngân hàng
		</div>
	</div>
	<div class="portlet-body">
		<div class="panel panel-default" id="filterPanel">
			<div class="panel-heading"><strong><i class="fa fa-search" aria-hidden="true"></i> Lọc thông tin</strong></div>
			<div class="panel-body" style="margin-left: 25px;">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Kỳ báo cáo</label>
							<select name="reporting_period" id="reporting_period" class="form-control">
								<option value="">Chọn</option>
								<option value="Qúy này">Qúy này</option>
								<option value="Đầu quý đến hiện tại">Đầu quý đến hiện tại</option>
								<option value="Năm nay">Năm nay</option>
								<option value="Đầu năm đến hiện tại">Đầu năm đến hiện tại</option>
								<option value="Tháng 1">Tháng 1</option>
								<option value="Tháng 2">Tháng 2</option>
								<option value="Tháng 3">Tháng 3</option>
								<option value="Tháng 4">Tháng 4</option>
								<option value="Tháng 5">Tháng 5</option>
								<option value="Tháng 6">Tháng 6</option>
								<option value="Tháng 7">Tháng 7</option>
								<option value="Tháng 8">Tháng 8</option>
								<option value="Tháng 9">Tháng 9</option>
								<option value="Tháng 10">Tháng 10</option>
								<option value="Tháng 11">Tháng 11</option>
								<option value="Tháng 12">Tháng 12</option>
								<option value="Qúy I">Qúy I</option>
								<option value="Qúy II">Qúy II</option>
								<option value="Qúy III">Qúy III</option>
								<option value="Qúy IV">Qúy IV</option>
								<option value="Tháng trước">Tháng trước</option>
								<option value="Qúy trước">Qúy trước</option>
								<option value="Năm trước">Năm trước</option>
							</select>
						</div>
					</div>
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
							<label for="">Tài khoản</label>
							<select name="account_finance" id="account_finance" class="form-control">
								@foreach($finance_accounts as $value)
								<option value="{{$value->code}}">{{$value->code}} - {{$value->name}}</option>
								@endforeach
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
			</div>
		</div>
		<div class="clearfix"></div>
		<div id="print_cash_book">
			<a class="btn" href="" data-url="{{route('bank-deposit-book.print-show')}}" id="btn_print" style="background: #ffa331; color:white; float: right; margin-right: 15px; margin-bottom: 15px;"><i class="fa fa-print" style="font-size: 16px;"></i> Print</a>
		</div>
		<div id="export-excel">
			<a class="btn btn-success" href="" id="btn_export" style="float: right; margin-right: 15px; margin-bottom: 15px;"><i style="font-size: 16px;" class="fa fa-file-excel"></i> Export</a>
		</div>
		<div class="clearfix"></div>
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover" id="list-table">
					<thead>
						<tr>
							<th style="text-align: center;">STT</th>
							<th style="text-align: center;">Hình thức</th>
							<th style="text-align: center;">Mã chứng từ</th>
							<th style="text-align: center;">Người tạo phiếu</th>
							<th style="text-align: center;">Người bị tác động</th>
							<th style="text-align: center;">Ngày ghi sổ</th>
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
	$(document).ready(function() {
		$("body").tooltip({ selector: '[data-tooltip=tooltip]' });
	});
</script>

<script>
    //change to base64
    function readImage(input) {
    	if ( input.files && input.files[0] ) {
    		var FR= new FileReader();
    		FR.onload = function(e) {
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
<script type="text/javascript">
	$(document).on('change', '#reporting_period', function () {
		var d = new Date();
		var currMonth = d.getMonth();
		var currYear = d.getFullYear();
		$("#start_date").datepicker({format: 'dd/mm/yyyy',});
		$("#end_date").datepicker({format: 'dd/mm/yyyy',});
		if ($('#reporting_period').val() == "Qúy này") {
			var startDate = new Date();
			var endDate = new Date();
			if (currMonth + 1 >= 1 && currMonth + 1 <= 3) {
				startDate = new Date(currYear, 1-1, 1);
				endDate = new Date(currYear, 3-1, 31);
			}
			if (currMonth + 1 > 3 && currMonth + 1 <= 6) {
				startDate = new Date(currYear, 4-1, 1);
				endDate = new Date(currYear, 6-1, 30);
			}
			if (currMonth + 1 > 6 && currMonth + 1 <= 9) {
				startDate = new Date(currYear, 7-1, 1);
				endDate = new Date(currYear, 9-1, 30);
			}
			if (currMonth + 1 > 9 && currMonth + 1 <= 12) {
				startDate = new Date(currYear, 10-1, 1);
				endDate = new Date(currYear, 12-1, 31);
			}
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Đầu quý đến hiện tại') {
			var startDate = new Date();
			var endDate = new Date();
			if (currMonth + 1 >= 1 && currMonth + 1 <= 3) {
				startDate = new Date(currYear, 1-1, 1);
			}
			if (currMonth + 1 > 3 && currMonth + 1 <= 6) {
				startDate = new Date(currYear, 4-1, 1);
			}
			if (currMonth + 1 > 6 && currMonth + 1 <= 9) {
				startDate = new Date(currYear, 7-1, 1);
			}
			if (currMonth + 1 > 9 && currMonth + 1 <= 12) {
				startDate = new Date(currYear, 10-1, 1);
			}
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Năm nay') {
			var startDate = new Date(currYear, 1-1, 1);
			var endDate = new Date(currYear, 12-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Đầu năm đến hiện tại') {
			var startDate = new Date(currYear, 1-1, 1);
			var endDate = new Date();
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 1') {
			var startDate = new Date(currYear, 1-1, 1);
			var endDate = new Date(currYear, 1-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 2') {
			var startDate = new Date(currYear, 2-1, 1);
			var endDate = new Date(currYear, 2-1, 28);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 3') {
			var startDate = new Date(currYear, 3-1, 1);
			var endDate = new Date(currYear, 3-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 4') {
			var startDate = new Date(currYear, 4-1, 1);
			var endDate = new Date(currYear, 4-1, 30);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 5') {
			var startDate = new Date(currYear, 5-1, 1);
			var endDate = new Date(currYear, 5-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 6') {
			var startDate = new Date(currYear, 6-1, 1);
			var endDate = new Date(currYear, 6-1, 30);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 7') {
			var startDate = new Date(currYear, 7-1, 1);
			var endDate = new Date(currYear, 7-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 8') {
			var startDate = new Date(currYear, 8-1, 1);
			var endDate = new Date(currYear, 8-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 9') {
			var startDate = new Date(currYear, 9-1, 1);
			var endDate = new Date(currYear, 9-1, 30);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 10') {
			var startDate = new Date(currYear, 10-1, 1);
			var endDate = new Date(currYear, 10-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 11') {
			var startDate = new Date(currYear, 11-1, 1);
			var endDate = new Date(currYear, 11-1, 30);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng 12') {
			var startDate = new Date(currYear, 12-1, 1);
			var endDate = new Date(currYear, 12-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Qúy I') {
			var startDate = new Date(currYear, 1-1, 1);
			var endDate = new Date(currYear, 3-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Qúy II') {
			var startDate = new Date(currYear, 4-1, 1);
			var endDate = new Date(currYear, 6-1, 30);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Qúy III') {
			var startDate = new Date(currYear, 7-1, 1);
			var endDate = new Date(currYear, 9-1, 30);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Qúy IV') {
			var startDate = new Date(currYear, 10-1, 1);
			var endDate = new Date(currYear, 12-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Tháng trước') {
			var startDate = new Date(currYear, currMonth-1, 1);
			var endDate = new Date(currYear, currMonth, 0);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Qúy trước') {
			var startDate = new Date();
			var endDate = new Date();
			if (currMonth + 1 >= 1 && currMonth + 1 <= 3) {
				startDate = new Date(currYear-1, 10-1, 1);
				endDate = new Date(currYear-1, 12-1, 31);
			}
			if (currMonth + 1 > 3 && currMonth + 1 <= 6) {
				startDate = new Date(currYear, 1-1, 1);
				endDate = new Date(currYear, 3-1, 31);
			}
			if (currMonth + 1 > 6 && currMonth + 1 <= 9) {
				startDate = new Date(currYear, 4-1, 1);
				endDate = new Date(currYear, 6-1, 30);
			}
			if (currMonth + 1 > 9 && currMonth + 1 <= 12) {
				startDate = new Date(currYear, 7-1, 1);
				endDate = new Date(currYear, 9-1, 30);
			}
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		} else if ($('#reporting_period').val() == 'Năm trước') {
			var startDate = new Date(currYear-1, 1-1, 1);
			var endDate = new Date(currYear-1, 12-1, 31);
			$("#start_date").datepicker("setDate", startDate);
			$("#end_date").datepicker("setDate", endDate);
		}
	})
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
			var reporting_period = $('#reporting_period').val();
			var account_finance = $('#account_finance').val();
			if (reporting_period == '') {
				toastr.error('Vui lòng chọn kỳ báo cáo!');
			}else{
				if (start_date != '' && end_date != '' && start_date < end_date) {
					$('#btn_export').attr('href','/'+start_date+'/'+end_date+'/'+reporting_period+'/'+account_finance);
					$('#list-table').DataTable().destroy();
					$('#list-table').DataTable({
						processing: true,
						serverSide: true,
						ajax: {
							url: '{!!route('bank-deposit-book.filter')!!}',
							type: 'post',
							data: function (d) {
								d.start_date = $('input[name=start_date]').val();
								d.end_date = $('input[name=end_date]').val();
								d.reporting_period = $('select[name=reporting_period]').val();
								d.account_finance = $('select[name=account_finance]').val();
							},
						},
						lengthMenu: [100],
						searching: true,
						ordering: false,
						pageLength: 30,
						lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
						columns: [
						{data: 'DT_RowIndex', name: 'DT_Row_Index', 'class':'text-center', width: "10px"},
						{data: 'type', name: 'type', width: "100px"},
						{data: 'code', name: 'code', width: "50px"},
						{data: 'object_name', name: 'object', width: "120px"},
						{data: 'name_payer', name: 'name_payer', width: "120px"},
						{data: 'accounting_date', name: 'accounting_date', class: 'text-center'},
						{data: 'reason', name: 'reason', width: "200px"},
						{data: 'total_money', name: 'total_money', class:'text-right'},
						]
					});

				} else if (start_date > end_date) {
					toastr.error('Ngày bắt đầu phải trước ngày kết thúc!');
				} else if (start_date != '' && end_date == '') {
					toastr.error('Cần nhập đầy đủ thời gian bắt đầu và kết thúc!');
				} else if (start_date == '' && end_date != '') {
					toastr.error('Cần nhập đầy đủ thời gian bắt đầu và kết thúc!');
				}

			}

		}); 
	})
</script>
<script type="text/javascript">
	function format_number(num){
		var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
		if(str.indexOf(".") > 0) {
			parts = str.split(".");
			str = parts[0];
		}
		str = str.split("").reverse();
		for(var j = 0, len = str.length; j < len; j++) {
			if(str[j] != ".") {
				output.push(str[j]);
				if(i%3 == 0 && j < (len - 1)) {
					output.push(".");
				}
				i++;
			}
		}
		formatted = output.reverse().join("");
		return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
	};

</script>
<script type="text/javascript">
	$(document).on('click', '#btn_print', function (e) {
		e.preventDefault();
		var path = $(this).data('url');
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var reporting_period = $('#reporting_period').val();
		var account_finance = $('#account_finance').val();
		$.ajax({
			type: 'post',
			url: '/bank-deposit-book/print',
			data: {
				start_date: start_date,
				end_date: end_date,
				reporting_period: reporting_period,
				account_finance: account_finance
			},
			success: function (response) {
				console.log(response)
				$('.modal-content').load(path, function(){
					$('#myModal').modal({show:true})
					$('.account_finance').html(response.account_finance.code + ' - ' + response.account_finance.name)
					var surplus_debit = response.account_finance.surplus_debit;
					var money = surplus_debit;
					var sum_debit = 0;
					var sum_credit = 0;
					$('.voucher-detail-table').append(`
						<tr>
						<th width="75px"></th>
						<th width="75px"></th>
						<td></td>
						<th>- Số tồn đầu kỳ</th>
						<td width="75px"></td>
						<td></td>
						<td></td>
						<th align="right">` + format_number(surplus_debit) + `</th>
						<th></th>
						</tr>`)
					$('.voucher-detail-table').append(`
						<tr>
						<th width="75px"></th>
						<th width="75px"></th>
						<td></td>
						<th>- Số phát sinh trong kỳ</th>
						<td></td>
						<td></td>
						<td></td>
						<th></th>
						<th></th>
						</tr>`)
					$.each(response.voucher_details, function(i, item) {
						if (item.debit_account == account_finance) { 
							money += item.amount_money
							sum_debit += item.amount_money
							$('.voucher-detail-table').append(`
								<tr>
									<td>` + item.accounting_date1 + `</td>
									<td>` + item.code + `</td>
									<td align="center">` + item.created_at1 + `</td>
									<td >` + item.content + `</td>
									<td>` + item.credit_account + `</td>
									<td align="right">` + format_number(item.amount_money) + `</td>
									<td></td>
									<td align="right">` + format_number(money) + `</td>
									<td></td>
								</tr>`)
						}
						if (item.credit_account == account_finance) {
							money -= item.amount_money
							sum_credit += item.amount_money
							$('.voucher-detail-table').append(`
								<tr>
									<td>` + item.accounting_date1 + `</td>
									<td>` + item.code + `</td>
									<td align="center">` + item.created_at1 + `</td>
									<td >` + item.content + `</td>
									<td>` + item.debit_account + `</td>
									<td></td>
									<td align="right">` + format_number(item.amount_money) + `</td>
									<td align="right">` + format_number(money) + `</td>
									<td></td>
								</tr>`)
						}
					})

					$('.voucher-detail-table').append(`
						<tr>
						<th width="75px"></th>
						<th width="75px"></th>
						<td></td>
						<th>- Cộng số phát sinh trong kỳ</th>
						<td></td>
						<td>` + format_number(sum_debit) + `</td>
						<td>` + format_number(sum_credit) + `</td>
						<th></th>
						<th></th>
						</tr>`)
					$('.voucher-detail-table').append(`
						<tr>
						<th width="75px"></th>
						<th width="75px"></th>
						<td></td>
						<th>- Số dư cuối kỳ</th>
						<td></td>
						<td></td>
						<td></td>
						<th>` + format_number(surplus_debit + sum_debit - sum_credit) + `</td>
						<th></th>
						</tr>`)
				})
			}
		})
	})
</script>
@endsection
