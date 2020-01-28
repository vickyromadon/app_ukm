<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailPurchase;
use App\Models\ReportPurchase;
use App\Models\ReportStock;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailPurchaseController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'purchase_id'   => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
        ]);

        $checkDetailPurchase = DetailPurchase::where('purchase_id', $request->purchase_id)->where('product_id', $request->product_id)->where('status', 'pending')->first();
        if ($checkDetailPurchase != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Produk Sudah Terdaftar'
            ]);
        }

        $detailPurchase              = new DetailPurchase();
        $detailPurchase->code        = "DTL/PURCHASE/" . Auth::user()->id . "/" . date("Ymdhis");
        $detailPurchase->product_id  = $request->product_id;
        $detailPurchase->purchase_id = $request->purchase_id;
        $detailPurchase->quantity    = $request->quantity;
        $detailPurchase->price       = $request->price;
        $detailPurchase->total       = $request->price * $request->quantity;

        if (!$detailPurchase->save()) {
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
        $detailPurchase = DetailPurchase::find($id);

        if ($detailPurchase->delete()) {
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

    public function done(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        $detailPurchase = DetailPurchase::where('purchase_id', $request->purchase_id)->get();

        foreach ($detailPurchase as $item) {
            $item->status = "done";
            $item->save();

            $product = Product::find($item->product_id);

            $reportPurchase                 = new ReportPurchase();
            $reportPurchase->number         = $purchase->number;
            $reportPurchase->product_id     = $product->id;
            $reportPurchase->supplier_id    = $purchase->supplier_id;
            $reportPurchase->quantity       = $item->quantity;
            $reportPurchase->price          = $item->price;
            $reportPurchase->user_id        = Auth::user()->id;
            $reportPurchase->save();

            $reportStock                        = new ReportStock();
            $reportStock->type                  = "purchase";
            $reportStock->transaction_number    = $purchase->number;
            $reportStock->quantity_initial      = $product->stock;
            $reportStock->price_initial         = $product->price;
            $reportStock->quantity_in           = $item->quantity;
            $reportStock->cogs_in               = $item->total;
            $reportStock->quantity_out          = 0;
            $reportStock->cogs_out              = 0;
            $reportStock->quantity_avg          = $product->stock + $item->quantity;
            $reportStock->cogs_avg              = $this->getCogsAvg($product->price, $product->stock, $item->price, $item->quantity);
            $reportStock->product_id            = $product->id;
            $reportStock->user_id               = Auth::user()->id;
            $reportStock->save();

            $product->stock += $item->quantity;
            $product->price = $item->price;
            $product->save();
        }

        $purchase->status = 'done';
        $purchase->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }

    private function getCogsAvg($price_initial, $quantity_initial, $price, $quantity) {
        $cogs = (( $price_initial * $quantity_initial ) + ( $price * $quantity )) / ($quantity_initial + $quantity);
        return $cogs;
    }
}
