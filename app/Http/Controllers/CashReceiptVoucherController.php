<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\GroupObject;
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
        $receipt_vouchers = Voucher::where('type', 1)->orderBy('id','DESC');
        if (request()->ajax()) {
            return Datatables::of($receipt_vouchers)
                ->addColumn('action', function ($receipt_voucher) {
                    $txt = '';

                    $txt .= '<a class="btn btn-xs btn-info btn-show-obj" data-tooltip="tooltip" title="In phiếu" data-show-path=""> <i class="fa fa-print" aria-hidden="true"></i></a>';

                    $txt .= '<a class="btn btn-xs btn-warning btn-edit-obj" data-tooltip="tooltip" title="Chỉnh sửa" data-edit-path=""> <i class="fa fa-edit" aria-hidden="true"></i></a>';
                    
                    $txt .= '<a class="btn btn-xs btn-danger btn-delete-obj" data-tooltip="tooltip" data-delete-id="" title="Xóa"> <i class="fa fa-trash" aria-hidden="true"></i></a>';

                    return $txt;
                })
                ->editColumn('code', function ($receipt_voucher){
                    return $receipt_voucher->code;
                })
                ->editColumn('object_name', function ($receipt_voucher){
                    $object = Object::where('id', $receipt_voucher->object_id)->first();
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
                ->editColumn('accouting_date', function ($receipt_voucher){
                    return $receipt_voucher->accouting_date->format('d/m/Y');
                })
                ->addIndexColumn()
                ->make(true);
        }

        $receipt_voucher = Datatables::of($receipt_vouchers)->make(true);
        //dd($receipt_voucher);
        return view('cash-receipt-voucher.index',compact('receipt_voucher'));
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
