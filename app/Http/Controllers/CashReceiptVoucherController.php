<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\GroupObject;
use App\Models\VoucherDetail;
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

                    $txt .= '<a class="btn btn-xs btn-show-obj" data-tooltip="tooltip" title="Xem chi tiết" data-show-path="" style="background: #dc58eb; color: white"> <i class="fa fa-eye" aria-hidden="true"></i></a>';

                    $txt .= '<a class="btn btn-xs btn-show-obj" data-tooltip="tooltip" title="In phiếu" data-show-path="" style="background: #34e1da; color: white"> <i class="fa fa-print" aria-hidden="true"></i></a>';

                    $txt .= '<a class="btn btn-xs btn-warning btn-edit-obj" data-tooltip="tooltip" title="Chỉnh sửa" data-edit-path=""> <i class="fa fa-edit" aria-hidden="true"></i></a>';

                    $txt .= '<a class="btn btn-xs btn-show-obj" data-tooltip="tooltip" title="Ghi sổ" data-show-path="" style="background: #71f847; color: white"> <i class="fa fa-book" aria-hidden="true"></i></a>';
                    
                    $txt .= '<a class="btn btn-xs btn-danger btn-delete-obj" data-tooltip="tooltip" data-delete-id="" title="Xóa"> <i class="fa fa-trash" aria-hidden="true"></i></a>';

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
                ->editColumn('amount_money', function ($receipt_voucher){
                    $receipt_voucher_detail = VoucherDetail::where('voucher_id', $receipt_voucher->id)->get();
                    $amount_money = $receipt_voucher_detail->sum('amount_money');
                    return $amount_money;
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
        $test = explode("-", $lastest_code_voucher->code);
        $l = max(strlen($test[1]), 1);
        $c = str_pad($test[1] + 1, $l, "0", STR_PAD_LEFT);
        $new_code_voucher = $test[0] . '-' . $c;
        return view('cash-receipt-voucher.create', compact('money', 'new_code_voucher'));
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
