<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailSelling;
use App\Models\Product;
use App\Models\Selling;
use App\Models\ReportSelling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailSellingController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'selling_id'    => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
        ]);

        $checkDetailSelling = DetailSelling::where('selling_id', $request->selling_id)->where('product_id', $request->product_id)->where('status', 'pending')->first();
        if ($checkDetailSelling != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Produk Sudah Terdaftar'
            ]);
        }

        $product = Product::find($request->product_id);
        if ($request->quantity > $product->stock) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Karena Stock Tidak Mencukupi.'
            ]);
        }

        $detailSelling              = new DetailSelling();
        $detailSelling->code        = "DTL/SELLING/" . Auth::user()->id . "/" . date("Ymdhis");
        $detailSelling->product_id  = $request->product_id;
        $detailSelling->selling_id  = $request->selling_id;
        $detailSelling->quantity    = $request->quantity;
        $detailSelling->price       = $request->price;
        $detailSelling->total       = $request->price * $request->quantity;

        if (!$detailSelling->save()) {
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

    public function done(Request $request)
    {
        $selling = Selling::find($request->selling_id);
        $detailSelling = DetailSelling::where('selling_id', $request->selling_id)->get();

        foreach ($detailSelling as $item) {
            $item->status = "done";
            $item->save();

            $product = Product::find($item->product_id);
            $product->stock -= $item->quantity;
            $product->save();

            $reportSelling                  = new ReportSelling();
            $reportSelling->number          = $selling->number;
            $reportSelling->product_id      = $product->id;
            $reportSelling->type            = "offline";
            $reportSelling->quantity        = $item->quantity;
            $reportSelling->price           = $item->total;
            $reportSelling->user_id         = Auth::user()->id;
            $reportSelling->customer_name   = $selling->customer->name;
            $reportSelling->save();
        }

        $selling->status = 'done';
        $selling->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }
}
