<div class="modal-header ">
    <center>
        <h4 class="modal-title green">PHIẾU THU</h4>
    </center>
</div>
<div class="modal-body">
    <form action="" method="POST" role="form" enctype="multipart/form-data" id="add_receipt_voucher_form" class="row" >
        <div class="col-md-10 row">
            <div class="form-group col-md-6">
                <label for="">Loại đối tượng</label>
                <select name="" id="object_type" class="form-control" required="required">
                    <option value="0">Mời chọn </option>
                    <option value="1">Nhân viên</option>
                    <option value="2">Khách hàng</option>
                    <option value="3">Nhà cung cấp</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="">Tên đối tượng</label>
                <select name="" id="object" class="form-control" required="required" disabled="true">
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="">Người nộp</label>
                <input type="text" class="form-control" id="name_payer" >
            </div>
            <div class="form-group col-md-6">
                <label for="">Địa chỉ</label>
                <input type="text" class="form-control" id="addrress" >
            </div>
            <div class="form-group col-md-12">
                <label for="">Lí do nộp</label>
                <input type="text" class="form-control" id="reason" >
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
                <select name="" id="money" class="form-control" required="required">
                    @foreach($money as $value)
                        <option value="{{$value->id}}"> {{$value->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6" id="exchange_rate">
                <label for="">Tỷ giá</label>
                <input type="text" class="form-control" id="" >
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group" id="accounting_date_div">
                <label for="">Ngày ghi sổ</label>
                <input type="text" class="form-control accounting_date" id="" >
            </div>
            <div class="form-group">
                <label for="">Mã chứng từ</label>
                <input type="text" class="form-control" id="" value="{{ $new_code_voucher }}">
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-hover voucher_detail">
                <thead>
                    <tr>
                        <th>Diễn giải</th>
                        <th>TK Nợ</th>
                        <th>TK Có</th>
                        <th>TK Ngân hàng</th>
                        <th>Số tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </td>
                        <td>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
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