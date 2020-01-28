<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\Assembly;
use App\Models\DetailAssembly;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailAssemblyController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'      => 'required|string',
            'price'     => 'required|numeric',
            'quantity'  => 'required|numeric',
            'unit_id'   => 'required|numeric',
            'type_id'   => 'required|numeric',
        ]);

        $product                = new Product();
        $product->code          = "PR" . date("Ymdhis");
        $product->name          = $request->name;
        $product->description   = "-";
        $product->selling_price = 0;
        $product->price         = $request->price;
        $product->stock         = $request->quantity;
        $product->minimum_stock = 0;
        $product->unit_id       = $request->unit_id;
        $product->type_id       = $request->type_id;
        $product->status        = "no publish";
        $product->user_id       = Auth::user()->id;
        $product->image         = "-";

        if ($product->save()) {
            $detailAssembly = new DetailAssembly();
            $detailAssembly->code = "DTL/ASSEMBLY/" . Auth::user()->id . "/" . date("Ymdhis");
            $detailAssembly->quantity = $request->quantity;
            $detailAssembly->product_id = $product->id;
            $detailAssembly->assembly_id = $request->assembly_id;
            $detailAssembly->save();

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        }
    }

    public function done(Request $request)
    {
        $assembly = Assembly::find($request->assembly_id);
        $detailAssembly = DetailAssembly::where('assembly_id', $request->assembly_id)->get();

        foreach ($detailAssembly as $item) {
            $item->status = "done";
            $item->save();
        }

        foreach ($assembly->product_assemblies as $item) {
            $product = Product::find($item->product_id);
            $product->stock -= $item->quantity;
            $product->save();
        }

        $assembly->status = 'done';
        $assembly->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }
}
