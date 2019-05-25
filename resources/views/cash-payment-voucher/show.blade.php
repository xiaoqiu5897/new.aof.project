<style>
    .hr_dotted{
        margin: 30px 0 0 0;
        border:none;
        border-top:1px dotted #ccc;
        color:#fff;
        background-color:#fff;
    }
    .parent_border_dashed{
        border-bottom: 1px dotted #000;
    }
    .title_hide_dashed{
        background: #fff;
        padding: 10px 10px 10px 0px;
    }
    .mg-bot-20{
        margin-bottom: 20px;
    }
    .clearfix-50{
        height: 50px;
        clear: both;
    }
    .clearfix-15{
        height: 15px;
        clear: both;
    }
    hr{
        margin: 0;
    }
    #print_bill_123{
        font-size: 15px;
    }
</style>
<div class="modal-body">
    <div id="print_bill_123">
        <div class="row">
            <div class="col-xs-6">
                <div>
                    <div>
                        <span>Đơn vị : </span><span>Công ty Cổ Phần Giáo Dục Và Công Nghệ Số Zent</span>
                    </div>
                    <div>
                        <span>Bộ phận : </span><span>...................</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="pull-right text-center">
                    <div><span>Mẫu số : 02  - TT</span></div>
                    <div>
                        <span>(Ban hành theo Thông tư số: 133/2016/TT-BTC</span>
                        <br>
                        <span>Ngày 26/08/2016 của Bộ trưởng BTC)</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="text-center">
                    <h3 class="uppercase bold">Phiếu Chi</h3>
                    <span>{{ $voucher->created_at->format('\N\g\à\y\ d') }}
                        {{ $voucher->created_at->format('\T\h\á\n\g\ n') }}
                        {{ $voucher->created_at->format('\N\ă\m\ Y') }}</span>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="text-right">
                    <span>Số : ......................</span>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed">Họ và tên người nhận tiền : </span>
                    <span>{{ $voucher->name_payer }}</span>
                </div>
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed">Địa chỉ : </span>
                    <span>{{ $voucher->addrress }}</span>
                </div>
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed">Lý do chi : </span>
                    <span>{{ $voucher->reason }}</span>
                </div>
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed">Số tiền : </span>
                    <span>{{ number_format( $voucher->total_money ) }} VNĐ &nbsp &nbsp</span>
                    <span class="title_hide_dashed">(Viết bằng chữ)</span>
                    <span>{{ VndText( $voucher->total_money , 'VNĐ') }}</span>
                </div>
            </div>
            <br>
            <div class="col-xs-8"></div>
            <div class="col-xs-4" style="height: 50px;">
                <span>Ngày {{$accounting_day}} Tháng {{$accounting_month}} Năm {{$accounting_year}}</span>
            </div>
            <div class="col-xs-12" style="height: 100px">
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-2">
                        <div class="text-center">
                            <div><span>Giám đốc</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="text-center">
                            <div><span>Kế toán trưởng</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="text-center">
                            <div><span>Người nhận tiền</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="text-center">
                            <div><span>Người lập phiếu</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="text-center">
                            <div><span>Thủ quỹ</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-1"></div>
                </div>
            </div>
            <div class="clearfix clearfix-50"></div>
            @if($voucher->exchange_rate != null)
            <div class="col-xs-12">
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed">Đã nhận đủ số tiền (viết bằng chữ) : </span>
                    <span>{{ VndText($amount_money, $voucher->money) }}</span>
                </div>
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed"> + Tỉ giá ngoại tệ : </span>
                    <span>{{ $voucher->exchange_rate }}</span>
                </div>
                <div class="parent_border_dashed mg-bot-20">
                    <span class="title_hide_dashed"> + Số tiền quy đổi : </span>
                    <span>{{ $voucher->total_money }} VNĐ</span>
                </div>
            </div>
            @endif
        </div>
        <hr>
        <div class="clearfix clearfix-15"></div>
        <div class="row no-print">
            <div class="col-xs-12">
                <center>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-default print-link no-print green" onclick="exportPrint();"><i class="fa fa-print"></i> Print</button>
                </center>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.number').number(true);
    });
</script>
<script>
    function exportPrint() {
        $('#print_bill_123').print();
    }
</script>