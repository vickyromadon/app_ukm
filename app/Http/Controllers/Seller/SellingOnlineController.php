<?php

namespace App\Http\Controllers\Seller;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SellingOnlineController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => Invoice::where('seller_id', Auth::user()->seller->id)->where('status', 'payment')->get()
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Invoice::find($id),
        ]);
    }

    public function approve(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "approve";

        if ($invoice->save()) {
            foreach ($$invoice->invoice_carts as $item) {
                $product = Product::find($item->cart->product->id);
                $product->stock -= $item->cart->quantity;
                $product->save();
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Disetujui'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Disetujui'
            ]);
        }
    }

    public function reject(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "reject";

        if ($invoice->save()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Ditolak'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Ditolak'
            ]);
        }
    }
}
