<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\ReportStock;
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
            'assembly_id'    => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
            'price'      => 'required|numeric',
        ]);

        $checkDetailAssembly = DetailAssembly::where('assembly_id', $request->assembly_id)->where('product_id', $request->product_id)->where('status', 'pending')->first();
        if ($checkDetailAssembly != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Produk Sudah Terdaftar'
            ]);
        }

        $detailAssembly                 = new DetailAssembly();
        $detailAssembly->code           = "DTL/ASSEMBLY/" . Auth::user()->id . "/" . date("Ymdhis");
        $detailAssembly->quantity       = $request->quantity;
        $detailAssembly->product_id     = $request->product_id;
        $detailAssembly->assembly_id    = $request->assembly_id;
        $detailAssembly->price          = $request->price;
        $detailAssembly->total          = $request->price * $request->quantity;

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

    public function done(Request $request)
    {
        $assembly = Assembly::find($request->assembly_id);
        $detailAssembly = DetailAssembly::where('assembly_id', $request->assembly_id)->get();

        foreach ($detailAssembly as $item) {
            $item->status = "done";
            $item->save();

            $productPlus = Product::find($item->product_id);

            $reportStockPlus                        = new ReportStock();
            $reportStockPlus->type                  = "assembly plus";
            $reportStockPlus->transaction_number    = $assembly->number;
            $reportStockPlus->quantity_initial      = $productPlus->stock;
            $reportStockPlus->price_initial         = $productPlus->price;
            $reportStockPlus->quantity_in           = $item->quantity;
            $reportStockPlus->cogs_in               = $item->total;
            $reportStockPlus->quantity_out          = 0;
            $reportStockPlus->cogs_out              = 0;
            $reportStockPlus->quantity_avg          = $productPlus->stock + $item->quantity;
            $reportStockPlus->cogs_avg              = $this->getCogsAvg($productPlus->price, $productPlus->stock, $item->price, $item->quantity);
            $reportStockPlus->product_id            = $productPlus->id;
            $reportStockPlus->user_id               = Auth::user()->id;
            $reportStockPlus->save();

            $productPlus->stock += $item->quantity;
            $productPlus->price = $item->price;
            $productPlus->save();
        }

        foreach ($assembly->product_assemblies as $item) {
            $productMinus = Product::find($item->product_id);

            $reportStockMinus                        = new ReportStock();
            $reportStockMinus->type                  = "assembly minus";
            $reportStockMinus->transaction_number    = $assembly->number;
            $reportStockMinus->quantity_initial      = $productMinus->stock;
            $reportStockMinus->price_initial         = $productMinus->price;
            $reportStockMinus->quantity_in           = 0;
            $reportStockMinus->cogs_in               = 0;
            $reportStockMinus->quantity_out          = $item->quantity;
            $reportStockMinus->cogs_out              = $productMinus->price;
            $reportStockMinus->quantity_avg          = $productMinus->stock - $item->quantity;
            $reportStockMinus->cogs_avg              = $this->getCogsAvg($productMinus->price, $productMinus->stock, $productMinus->price, $item->quantity);
            $reportStockMinus->product_id            = $productMinus->id;
            $reportStockMinus->user_id               = Auth::user()->id;
            $reportStockMinus->save();

            $productMinus->stock -= $item->quantity;
            $productMinus->save();
        }

        $assembly->status = 'done';
        $assembly->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }

    public function destroy($id)
    {
        $detailAssembly = DetailAssembly::find($id);

        if ($detailAssembly->delete()) {
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

    private function getCogsAvg($price_initial, $quantity_initial, $price, $quantity)
    {
        $cogs = (($price_initial * $quantity_initial) + ($price * $quantity)) / ($quantity_initial + $quantity);
        return $cogs;
    }
}
