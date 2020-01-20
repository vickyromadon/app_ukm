<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailSelling;
use App\Models\Product;
use App\Models\Selling;
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

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Karena Stock Tidak Mencukupi.'
            ]);
        }

        // $product->stock -= $request->quantity;
        // $product->save();

        $detailSelling              = new DetailSelling();
        $detailSelling->code        = "DTL/SELLING/" . Auth::user()->id . "/" . date("Ymdhis");
        $detailSelling->product_id  = $request->product_id;
        $detailSelling->selling_id  = $request->selling_id;
        $detailSelling->quantity    = $request->quantity;
        $detailSelling->price       = $product->price;
        $detailSelling->total       = $product->price * $request->quantity;

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
        }

        $selling->status = 'done';
        $selling->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }
}
