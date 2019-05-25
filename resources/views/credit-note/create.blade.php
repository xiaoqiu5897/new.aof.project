<div class="modal-header ">
    <center>
        <h4 class="modal-title green">GIẤY BÁO CÓ</h4>
    </center>
</div>
<form action="" method="POST" data-path="{{ route('credit-note.store') }}" role="form" enctype="multipart/form-data" id="add_credit_note_form" class="row" >
    <div class="modal-body">
        <div class="col-md-10 row">
            <div class="form-group col-md-6">
                <label for="">Người nộp</label>
                <input name="name_payer" type="text" class="form-control" id="name_payer" >
            </div>
            <div class="form-group col-md-6">
                <label for="">Địa chỉ</label>
                <input name="addrress" type="text" class="form-control" id="addrress" >
            </div>
            <div class="form-group col-md-12">
                <label for="">Lí do nộp</label>
                <input name="reason" type="text" class="form-control" id="reason" >
            </div>
            <div class="form-group col-md-12">
                <label for="">Nộp vào Tài khoản</label>
                <select name="bank_account" id="bank_account" class="form-control" required="required">
                    <option value="0">Mời chọn </option>
                    @foreach($bank_accounts as $value)
                        <option value="{{$value->id}}"> {{$value->bank_account}} - {{$value->branch_bank}}</option>
                    @endforeach
                </select>
            </div>
            <div class="portlet-body col-md-6">
                <label for="rfrm-note" style="top: 0;margin-bottom: 0; font-size: 14px; color: #888888;  opacity: 1;">File chứng từ đính kèm (nếu có)</label>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 250px; height: 200px;">
                        <img id="previewimg" src="{{url('images/zents/no-image.png')}}" alt="Loading..." /> 
                    </div>
                    <div style="margin-top: 10px;">
                        <span class="input-group form-md-line-input-btn">
                            <input type="file" name="">
                        </span>
                    </div>
                    <input type="hidden" id="thumbnail" name="image" >
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label for="">Loại tiền</label>
                <select name="money" id="money" class="form-control" required="required">
                    @foreach($money as $value)
                    <option value="{{$value->name}}"> {{$value->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6" id="exchange_rate">
                <label for="">Tỷ giá</label>
                <input name="rate_exchange" type="text" class="form-control" id="rate_exchange" >
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group" id="accounting_date_div">
                <label for="">Ngày ghi sổ</label>
                <input name="accounting_date" type="text" class="form-control accounting_date" id="accounting_date" >
            </div>
            <div class="form-group">
                <label for="">Mã chứng từ</label>
                <input name="code" type="text" class="form-control" id="code" value="{{ $new_code_voucher }}">
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-hover voucher_detail">
                <thead>
                    <tr>
                        <th>Diễn giải</th>
                        <th>TK Nợ</th>
                        <th>TK Có</th>
                        <th>Số tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="content_1" id="" class="form-control">
                        </td>
                        <td>
                            <select name="debit_1" class="form-control">
                                <option value=""> </option>
                                @foreach($finance_accounts as $value)
                                <option value="{{$value->id}}"> {{$value->code}} - {{$value->name}} </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="credit_1" class="form-control">
                                <option value=""> </option>
                                @foreach($finance_accounts as $value)
                                <option value="{{$value->id}}"> {{$value->code}} - {{$value->name}} </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="amountmoney_1" id="" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="content_2" id="" class="form-control">
                        </td>
                        <td>
                            <select name="debit_2" class="form-control" >
                                <option value=""> </option>
                                @foreach($finance_accounts as $value)
                                <option value="{{$value->id}}"> {{$value->code}} - {{$value->name}} </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="credit_2" class="form-control" >
                                <option value=""> </option>
                                @foreach($finance_accounts as $value)
                                <option value="{{$value->id}}"> {{$value->code}} - {{$value->name}} </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="amountmoney_2" id="" class="form-control">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <center>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
            <button type="submit" id="add_btn_receipt"  class="btn btn-sm green" data-path="{{ route('cash-receipt-voucher.store') }}">Tạo</button>
        </center>
    </div>
</form>

</div>

<script>
    $(document).ready(function () {
        $('.number').number(true);
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#accounting_date_div .accounting_date').datepicker({
            "todayHighlight": true,
            "autoclose": true,
            "format": "dd/mm/yyyy",
        });

        $('#accounting_date_div .accounting_date' ).datepicker('setDate', today);
    });
    $(document).on('change', '#money', function () {
        var type_money = $('#money option:selected').text();
        console.log(type_money)
        if (type_money != "VNĐ") {
            $('#exchange_rate').css("display", "block");
        } else {
            $('#exchange_rate').css("display", "none");
        }
    })
</script>

