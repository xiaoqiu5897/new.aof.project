<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\GroupObject;
use App\Models\VoucherDetail;
use App\Models\FinanceAccount;
use App\Models\BankAccount;
use App\Models\Money;
use Illuminate\Http\Request;
use Datatables;

class CashReceiptVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash-receipt-voucher.index');
    }


    public function getList()
    {
        $receipt_vouchers = Voucher::where('type', 1)->orderBy('id','DESC');
        if (request()->ajax()) {
            return Datatables::of($receipt_vouchers)
            ->addColumn('action', function ($receipt_voucher) {
                $txt = '';

                $txt .= '<a class="btn btn-xs btn-show-obj" data-tooltip="tooltip" title="Xem chi tiết" data-show-path="'.route('cash-receipt-voucher.show',$receipt_voucher->id).'" style="background: #dc58eb; color: white"> <i class="fa fa-eye" aria-hidden="true"></i></a>';
                if ($receipt_voucher->status != 1) {
                    $txt .= '<a class="btn btn-xs btn-warning btn-edit-obj" id="edit-receipt-'.$receipt_voucher->id.'" data-tooltip="tooltip" title="Chỉnh sửa" data-edit-path=""> <i class="fa fa-edit" aria-hidden="true"></i></a>';

                    $txt .= '<a class="btn btn-xs btn-note-obj" id="note-receipt-'.$receipt_voucher->id.'" data-id="'.$receipt_voucher->id.'" data-tooltip="tooltip" title="Ghi sổ" data-show-path="'.route('cash-receipt-voucher.note',$receipt_voucher->id).'" style="background: #71f847; color: white"> <i class="fa fa-book" aria-hidden="true"></i></a>';
                    
                    $txt .= '<a class="btn btn-xs btn-danger btn-delete-obj" id="delete-receipt-'.$receipt_voucher->id.'" data-tooltip="tooltip" data-delete-id="" title="Xóa"> <i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                return $txt;
            })
            ->editColumn('code', function ($receipt_voucher){
                return $receipt_voucher->code;
            })
            ->editColumn('object_name', function ($receipt_voucher){
                $object = GroupObject::where('id', $receipt_voucher->object_id)->first();
                if(!empty($object)){
                    return $object->name;
                }
                return 'Không xác định';
            })
            ->editColumn('name_payer', function ($receipt_voucher){
                return $receipt_voucher->name_payer;
            })
            ->editColumn('total_money', function ($receipt_voucher){
                return number_format($receipt_voucher->total_money);
            })
            ->editColumn('reason', function ($receipt_voucher){
                return $receipt_voucher->reason;
            })
            ->editColumn('created_at', function ($receipt_voucher){
                return $receipt_voucher->created_at->format('d/m/Y');
            })
            ->editColumn('accounting_date', function ($receipt_voucher){
                $accounting_date = strtotime($receipt_voucher->accounting_date);
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
        $lastest_code_voucher = Voucher::select('code')->where('type', 1)->orderBy('id', 'desc')->first();
        if ($lastest_code_voucher != null) {
            $test = explode("-", $lastest_code_voucher->code);
            $l = max(strlen($test[1]), 1);
            $c = str_pad($test[1] + 1, $l, "0", STR_PAD_LEFT);
            $new_code_voucher = $test[0] . '-' . $c;
        } else {
            $new_code_voucher = "PT-001";
        }
        //lấy ra toàn bộ tài khoản kế toán
        $finance_accounts = FinanceAccount::select('id', 'code', 'name')->get();
        //lấy ra toàn bộ số tài khoản của cty
        $bank_accounts = BankAccount::select('id', 'bank_account', 'branch_bank')->get();
        return view('cash-receipt-voucher.create', compact('money', 'new_code_voucher', 'finance_accounts', 'bank_accounts'));
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
                'object_id' => $request->object,
                'type' => 1,
                'name_payer' => $request->name_payer,
                'addrress' => $request->addrress,
                'reason' => $request->reason,
                'accounting_date' => $accounting_date,
                'code' => $request->code,
            ]);
            $voucher->money = $request->money;
            $voucher->exchange_rate = $request->rate_exchange;
            $voucher->save();
        } else {
            $voucher = Voucher::create([
                'object_id' => $request->object,
                'type' => 1,
                'name_payer' => $request->name_payer,
                'addrress' => $request->addrress,
                'reason' => $request->reason,
                'accounting_date' => $accounting_date,
                'code' => $request->code,
            ]);
            $voucher->money = $request->money;
            $voucher->save();
        }
        

        $new_voucher_detail = VoucherDetail::create([
            'voucher_id' => $voucher->id,
            'content' => $request->content_1,
            'amount_money'  => $request->amountmoney_1*$voucher->exchange_rate,
            'bank_account_id' => $request->bankaccount_1,
        ]);

        $new_voucher_detail->debit_account = $request->debit_1;
        $new_voucher_detail->credit_account = $request->credit_1;
        $new_voucher_detail->save();

        $voucher_details = VoucherDetail::where('voucher_id', $voucher->id)->get();
        $voucher->total_money = $voucher_details->sum('amount_money');
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
        return view('cash-receipt-voucher.show',compact('voucher', 'amount_money', 'accounting_day', 'accounting_month', 'accounting_year'));
    }

    public function note($id)
    {
        $voucher = Voucher::find($id);
        $voucher->status = 1;
        $voucher->save();
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
