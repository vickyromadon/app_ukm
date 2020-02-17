<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\RefundDana;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => Payment::all(),
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Payment::find($id)
        ]);
    }

    public function refundDana(Request $request) {
        $refundDana = new RefundDana();
        $refundDana->nominal = $request->nominal;
        $refundDana->invoice_id = $request->invoice_id;
        $refundDana->seller_id = $request->seller_id;

        if (!$refundDana->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }
}
