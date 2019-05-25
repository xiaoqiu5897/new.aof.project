<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherDetail;
use App\Models\FinanceAccount;
use App\Models\GroupObject;
use Illuminate\Http\Request;
use Datatables;

class CashBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finance_accounts = FinanceAccount::select('id', 'code', 'name')
        ->where('code', '111')
        ->orWhere('code', '1111')
        ->orWhere('code', '1112')
        ->orWhere('code', '1113')
        ->get();
        return view('cash-book.index', compact('finance_accounts'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    public function filter(Request $request)
    {
        $start_date1 = strtr($request->start_date, '/', '-');
        $end_date1 = strtr($request->end_date, '/', '-');
        $start_date = date('Y-m-d', strtotime($start_date1));
        $end_date = date('Y-m-d', strtotime($end_date1));
        if ($request->start_date != '' && $request->end_date != '') {
            $vouchers = Voucher::whereBetween('accounting_date', [$start_date, $end_date])
            ->whereIn('id', function ($query) use ($request)
            {
                $query->select('voucher_id')
                ->from('voucher_details')
                ->where('credit_account', $request->account_finance)
                ->orWhere('debit_account', $request->account_finance)
                ->get();
            })
            ->orderBy('accounting_date', 'desc');
        }

        return Datatables::of($vouchers)
        ->addIndexColumn()

        ->addColumn('type', function($voucher) {
            if ($voucher->type == 1) {
                return 'Phiếu thu';
            } else if ($voucher->type == 2) {
                return 'Phiếu chi';
            } else {
                return 'Không xác định';
            }
        })
        ->addColumn('code', function($voucher) {
            if ($voucher->code != null) {
                return $voucher->code;
            } else {
                return 'Không xác định';
            }
        })
        ->addColumn('object_name', function($voucher) {
            if ($voucher->object_id != null) {
                $object = GroupObject::where('id', $voucher->object_id)->first();
                if ($object->code != null) {
                    return $object->code . '  ' . $object->name;
                } else {
                    return 'Không xác định';
                }
            } else
                return 'Không xác định';
        })
        ->addColumn('name_payer', function($voucher) {
            return $voucher->name_payer;
        })
        ->addColumn('accounting_date', function($voucher) {
            return $voucher->accounting_date;
        })
        ->addColumn('reason', function($voucher) {
            if ($voucher->reason == 1) {
                return 'Tạm ứng cho nhân viên';
            } else if ($voucher->reason == 2) {
                return 'Gửi tiền vào ngân hàng';
            } else if ($voucher->reason == 3) {
                return $voucher->reason_other;
            } else {
                return $voucher->reason;
            }
        })
        ->addColumn('total_money', function($voucher) {
            if(!empty($voucher->total_money)){
                return number_format($voucher->total_money);
            }
            return 0;
        })
        ->make(true);
    }


    public function printShow()
    {
        return view('cash-book.show');
    }


    public function print(Request $request)
    {
        $reporting_period = $request->reporting_period;
        $start_date1 = strtr($request->start_date, '/', '-');
        $end_date1 = strtr($request->end_date, '/', '-');
        $start_date = date('Y-m-d', strtotime($start_date1));
        $end_date = date('Y-m-d', strtotime($end_date1));
        if ($request->start_date != '' && $request->end_date != '') {
            $voucher_details = VoucherDetail::where('voucher_details.credit_account', $request->account_finance)
            ->orWhere('voucher_details.debit_account', $request->account_finance)
            ->join('vouchers', 'vouchers.id', '=', 'voucher_details.voucher_id')
            ->whereBetween('vouchers.accounting_date', [$start_date, $end_date])
            ->select('vouchers.code', 'vouchers.type', 'vouchers.accounting_date', 'vouchers.created_at', 'voucher_details.content', 'voucher_details.amount_money', 'voucher_details.credit_account', 'voucher_details.debit_account')
            ->get();
        }
        foreach ($voucher_details as $value) {
            $value->created_at1 = date('d/m/Y', strtotime($value->created_at));
            $value->accounting_date1 = date('d/m/Y', strtotime($value->accounting_date));
        }
        $account_finance = FinanceAccount::select('code', 'name', 'surplus_debit')->where('code', $request->account_finance)->first();
        return response()->json([
            'reporting_period' => $reporting_period,
            'account_finance' =>  $account_finance,
            'voucher_details' =>  $voucher_details
        ]);
    }
}
