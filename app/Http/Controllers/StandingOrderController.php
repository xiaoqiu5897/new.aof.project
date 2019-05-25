<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\GroupObject;
use App\Models\VoucherDetail;
use App\Models\FinanceAccount;
use App\Models\BankAccount;
use App\Models\Money;
use App\Models\Bank;
use Illuminate\Http\Request;
use Datatables;

class StandingOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('standing-order.index');
    }


    public function getList()
    {
        //type = 2 : phiếu chi
        $standing_orders = Voucher::where('type', 4)->orderBy('id','DESC');
        if (request()->ajax()) {
            return Datatables::of($standing_orders)
            ->addColumn('action', function ($standing_order) {
                $txt = '';

                $txt .= '<a class="btn btn-xs btn-show-obj" data-tooltip="tooltip" title="Xem chi tiết" data-show-path="'.route('standing-order.show',$standing_order->id).'" style="background: #dc58eb; color: white"> <i class="fa fa-eye" aria-hidden="true"></i></a>';

                $txt .= '<a class="btn btn-xs btn-warning btn-edit-obj" data-tooltip="tooltip" title="Chỉnh sửa" data-edit-path=""> <i class="fa fa-edit" aria-hidden="true"></i></a>';

                $txt .= '<a class="btn btn-xs btn-show-obj" data-tooltip="tooltip" title="Ghi sổ" data-show-path="" style="background: #71f847; color: white"> <i class="fa fa-book" aria-hidden="true"></i></a>';

                $txt .= '<a class="btn btn-xs btn-danger btn-delete-obj" data-tooltip="tooltip" data-delete-id="" title="Xóa"> <i class="fa fa-trash" aria-hidden="true"></i></a>';

                return $txt;
            })
            ->editColumn('code', function ($standing_order){
                return $standing_order->code;
            })
            ->editColumn('bank_account', function ($standing_order){
                if ($standing_order->bank_account_id != null) {
                    $account_bank = BankAccount::where('id', $standing_order->bank_account_id)->first();
                    return $account_bank->bank_account;
                }
                return 'Không xác định';
            })
            ->editColumn('bank', function ($standing_order){
                if ($standing_order->bank_account_id != null) {
                    $bank_account = BankAccount::where('id', $standing_order->bank_account_id)->first();
                    $bank = Bank::where('id', $bank_account->bank_id)->first();
                    return $bank->name;
                }
                return 'Không xác định';
            })
            ->editColumn('name_payer', function ($standing_order){
                return $standing_order->name_payer;
            })
            ->editColumn('total_money', function ($standing_order){
                return number_format($standing_order->total_money);
            })
            ->editColumn('reason', function ($standing_order){
                return $standing_order->reason;
            })
            ->editColumn('created_at', function ($standing_order){
                return $standing_order->created_at->format('d/m/Y');
            })
            ->editColumn('accounting_date', function ($standing_order){
                $accounting_date = strtotime($standing_order->accounting_date);
                $new_accounting_date = date('d/m/Y', $accounting_date);
                return $new_accounting_date;
            })
            ->addIndexColumn()
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //loại tiền
        $money = Money::select('id', 'name')->get();
        //tự động tạo mã phiếu thu mới nhất
        $lastest_code_voucher = Voucher::select('code')->where('type', 4)->orderBy('id', 'desc')->first();
        if ($lastest_code_voucher != null) {
            $test = explode("-", $lastest_code_voucher->code);
            $l = max(strlen($test[1]), 1);
            $c = str_pad($test[1] + 1, $l, "0", STR_PAD_LEFT);
            $new_code_voucher = $test[0] . '-' . $c;
        } else {
            $new_code_voucher = "UNC-001";
        }
        //lấy ra toàn bộ tài khoản kế toán
        $finance_accounts = FinanceAccount::select('id', 'code', 'name')->get();
        //lấy ra toàn bộ số tài khoản của cty
        $bank_accounts = BankAccount::select('id', 'bank_account', 'branch_bank')->get();
        return view('standing-order.create', compact('money', 'new_code_voucher', 'finance_accounts', 'bank_accounts'));
    }

    public function getGroupObject(Request $request)
    {
        $list_object = GroupObject::select('id', 'code', 'name')->where('type', $request->type)->get();
        return $list_object;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = strtr($request->accounting_date, '/', '-');
        if ($date == false) {
            $accounting_date = date('Y-m-d');
        } else {
            $accounting_date = date('Y-m-d', strtotime($date));
        }
        if ($request->money != "VNĐ") {
            $voucher = Voucher::create([
                'type' => 4,
                'name_payer' => $request->name_payer,
                'addrress' => $request->addrress,
                'reason' => $request->reason,
                'accounting_date' => $accounting_date,
                'account_to' => $request->account_to,
                'code' => $request->code,
            ]);
            $voucher->money = $request->money;
            $voucher->exchange_rate = $request->rate_exchange;
            $voucher->bank_account_id = $request->bank_account;
            $voucher->save();
        } else {
            $voucher = Voucher::create([
                'type' => 4,
                'name_payer' => $request->name_payer,
                'addrress' => $request->addrress,
                'reason' => $request->reason,
                'accounting_date' => $accounting_date,
                'account_to' => $request->account_to,
                'code' => $request->code,
            ]);
            $voucher->money = $request->money;
            $voucher->bank_account_id = $request->bank_account;
            $voucher->save();
        }
        

        VoucherDetail::create([
            'voucher_id' => $voucher->id,
            'content' => $request->content_1,
            'debit_account_id'  => $request->debit_1,
            'credit_account_id'  => $request->credit_1,
            'amount_money'  => $request->amountmoney_1,
        ]);

        $voucher_details = VoucherDetail::where('voucher_id', $voucher->id)->get();
        if ($request->money != "VNĐ") {
            $voucher->total_money = $voucher_details->sum('amount_money')*$voucher->exchange_rate;
        } else {
            $voucher->total_money = $voucher_details->sum('amount_money');
        }
        $voucher->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = Voucher::where('id', $id)->first();
        $receipt_voucher_detail = VoucherDetail::where('voucher_id', $voucher->id)->get();
        $amount_money = $receipt_voucher_detail->sum('amount_money');
        $accounting_date = explode('-', $voucher->accounting_date);
        $accounting_day = $accounting_date[2];
        $accounting_month = $accounting_date[1];
        $accounting_year = $accounting_date[0];
        return view('standing-order.show',compact('voucher', 'amount_money', 'accounting_day', 'accounting_month', 'accounting_year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
