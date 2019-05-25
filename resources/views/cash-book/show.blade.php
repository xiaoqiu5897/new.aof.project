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
    th {
        text-align: center;
    }
    .cash-book-table td, .cash-book-table th, .cash-book-table table {
        border: 1.5px solid #959595!important;
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
                    <div><span>Mẫu số : S07  - DN</span></div>
                    <div>
                        <span>(Ban hành theo Thông tư số: 200/2014/TT-BTC</span>
                        <br>
                        <span>Ngày 22/12/2014 của Bộ trưởng BTC)</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="text-center">
                    <h3 class="uppercase bold">SỔ QUỸ TIỀN MẶT</h3>
                    <span class="reporting_period">
                        {{-- {{ $voucher->created_at->format('\N\g\à\y\ d') }}
                        {{ $voucher->created_at->format('\T\h\á\n\g\ n') }}
                        {{ $voucher->created_at->format('\N\ă\m\ Y') }} --}}
                    </span>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="text-right">
                    <span>Số : ......................</span>
                </div>
            </div>
            <div class="col-xs-12" style="margin-bottom: 20px">
                <span class="title_hide_dashed">Tài khoản : </span>
                <span class="account_finance"></span>
            </div>
            <div class="col-xs-12">
                <table class="table table-bordered cash-book-table" >
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">Ngày, tháng ghi sổ</th>
                            <th scope="col" rowspan="2">Ngày, tháng chứng từ</th>
                            <th scope="col" colspan="2">Số hiệu chứng từ</th>
                            <th scope="col" rowspan="2">Diễn giải</th>
                            <th scope="col" colspan="3">Số tiền</th>
                            <th scope="col" rowspan="2">Ghi chú</th>
                        </tr>
                        <tr>
                            <th scope="col">Thu</th>
                            <th scope="col">Chi</th>
                            <th scope="col">Thu</th>
                            <th scope="col">Chi</th>
                            <th scope="col">Tồn</th>
                        </tr>
                        <tr>
                            <th scope="col">A</th>
                            <th scope="col">B</th>
                            <th scope="col">C</th>
                            <th scope="col">D</th>
                            <th scope="col">E</th>
                            <th scope="col">1</th>
                            <th scope="col">2</th>
                            <th scope="col">3</th>
                            <th scope="col">G</th>
                        </tr>
                    </thead>
                    <tbody class="voucher-detail-table">
                    </tbody>
                </table>
            </div>
            <br>
            <div class="col-xs-8"></div>
            <div class="col-xs-4" style="height: 50px;">
                <span>Ngày .......... Tháng .......... Năm ..........</span>
            </div>
            <div class="col-xs-12" style="height: 100px">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="text-center">
                            <div><span>Thủ quỹ</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="text-center">
                            <div><span>Kế toán trưởng</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="text-center">
                            <div><span>Giám đốc</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix clearfix-50"></div>
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
    function exportPrint() {
        $('#print_bill_123').print();
    }
</script>