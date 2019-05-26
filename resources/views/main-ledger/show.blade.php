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
    .cash-book-thead th{
        text-align: center;
    }
    .cash-book-table td, .cash-book-table th, .cash-book-table table {
        border: 1.5px solid #959595!important;
    }
    .money-ledger{
        text-align: right!important;
    }
</style>
<div class="modal-body">
    <div id="print_bill_123">
        <div class="row">
            <div class="col-xs-6 name-company" >
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
                        <span>Ngày 22/12/2014 của Bộ trưởng BTC)</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="text-center">
                    <h3 class="uppercase bold">SỔ CÁI</h3>
                    <span class="reporting_period">
                    </span>
                </div>
            </div>
            <div class="col-xs-12 so">
                <div class="text-right">
                    <span>Số : ......................</span>
                </div>
            </div>
            <div class="col-xs-12 account" style="margin-bottom: 20px">
                <span class="title_hide_dashed">Tài khoản : </span>
                <span class="account_finance"></span>
            </div>
            <div class="col-xs-12 content-table">
                <table class="table table-bordered cash-book-table" id="cash-book-table">
                    <thead class="cash-book-thead">
                        <tr>
                            <th scope="col" rowspan="2">Ngày, tháng ghi sổ</th>
                            <th scope="col" colspan="2">Chứng từ</th>
                            <th scope="col" rowspan="2" class="content-detail">Diễn giải</th>
                            <th scope="col" colspan="2">Nhật ký chung</th>
                            <th scope="col" rowspan="2">TK đối ứng</th>
                            <th scope="col" colspan="2">Số tiền</th>
                        </tr>
                        <tr>
                            <th scope="col">Số hiệu</th>
                            <th scope="col">Ngày tháng</th>
                            <th scope="col">Trang số</th>
                            <th scope="col">STT dòng</th>
                            <th scope="col">Nợ</th>
                            <th scope="col">Có</th>
                        </tr>
                        <tr>
                            <th scope="col">A</th>
                            <th scope="col">B</th>
                            <th scope="col">C</th>
                            <th scope="col">D</th>
                            <th scope="col">E</th>
                            <th scope="col">F</th>
                            <th scope="col">G</th>
                            <th scope="col">1</th>
                            <th scope="col">2</th>
                        </tr>
                    </thead>
                    <tbody class="voucher-detail-table">
                    </tbody>
                </table>
            </div>
            <br>
            <div class="col-xs-8"></div>
            <div class="col-xs-4 date" style="height: 50px;">
                <span>Ngày .......... Tháng .......... Năm ..........</span>
            </div>
            <div class="col-xs-12" style="height: 100px">
                <div class="row sign-div">
                    <div class="col-xs-4 sign">
                        <div class="text-center">
                            <div><span>Thủ quỹ</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-4 sign">
                        <div class="text-center">
                            <div><span>Kế toán trưởng</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                    <div class="col-xs-4 sign">
                        <div class="text-center">
                            <div><span>Giám đốc</span></div>
                            <div><span>(Ký, họ tên)</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix clearfix-50"></div>
        </div>
        <div class="clearfix clearfix-15"></div>
        <div class="row no-print">
            <div class="col-xs-12">
                <center>
                    <button type="button" class="btn btn-sm btn-danger btn-close" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-sm btn-default print-link no-print green" id="print-cash"><i class="fa fa-print"></i> Print</button>
                </center>
            </div>
        </div>
    </div>
</div>


<script>
    $('#print-cash').click(function () {
        var pageTitle = 'Page Title';
        var divToPrint = document.getElementById("print_bill_123");
        stylesheet = 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css';
        win = window.open('', 'Print', 'width=700,height=500');
        win.document.write(
            `<html lang="en">
            <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>` + pageTitle + `</title>
            <link rel="stylesheet" media="print" href="` + stylesheet + `"/>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
                font-family: monospace;
            }
            .cash-book-thead th{
                text-align: center;
            }
            .cash-book-table td, .cash-book-table th, .cash-book-table table {
                border: 1.5px solid #959595!important;
            }
            .name-company{
                width: 50%;
                float: left;
            }
            h3 {
                text-align: center;
            }
            .so {
                width: 50%;
                float: rigth;
            }
            .account {
                width: 50%;
                float: left;
            }
            .content-table{
                clear:both;
            }
            .cash-book-table{
                margin: auto;
                border-collapse: collapse;
            }
            .date {
                float: right;
                margin-right: 100px;
                clear: both;
            }
            .sign{
                width: 33%;
                float: left;
            }
            .content-detail{
                width: 300px;
            }
            .btn-close, #print-cash{
                display: none;
            }
            .sign-div{
                margin: auto;
            }
            .code-voucher {
                width: 150px;
            }
            </style>
            </head><body>` + divToPrint.outerHTML + `</body></html>`);
        win.document.close();
        win.print();
        win.close();
        return false;
    });
</script>