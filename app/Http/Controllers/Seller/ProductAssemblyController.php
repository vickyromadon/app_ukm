<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\Assembly;
use App\Models\ProductAssembly;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductAssemblyController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'assembly_id'   => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
        ]);

        $product = Product::find($request->product_id);
        if ($request->quantity > $product->stock) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Karena Stock Tidak Mencukupi.'
            ]);
        }

        $detailAssembly                     = new ProductAssembly();
        $detailAssembly->product_id         = $request->product_id;
        $detailAssembly->assembly_id        = $request->assembly_id;
        $detailAssembly->quantity           = $request->quantity;

        if (!$detailAssembly->save()) {
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

    public function destroy($id)
    {
        $productAssembly = ProductAssembly::find($id);

        if ($productAssembly->delete()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Menghapus'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menghapus'
            ]);
        }
    }
}
