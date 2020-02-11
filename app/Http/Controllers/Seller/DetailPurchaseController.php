<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailPurchase;
use App\Models\ReportPurchase;
use App\Models\ReportStock;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReportProfit;
use App\Models\SideReportProfit;
use App\Models\DetailReportProfit;
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

            $reportProfit                       = ReportProfit::where('product_id', $product->id)->where('user_id', Auth::user()->id)->first();

            $sideReportProfit               = new SideReportProfit();
            $sideReportProfit->product_id   = $product->id;
            $sideReportProfit->type         = "purchase";
            $sideReportProfit->quantity_in  = $item->quantity;
            $sideReportProfit->cogs_in      = $item->price;
            $sideReportProfit->quantity_out = 0;
            $sideReportProfit->cogs_out     = 0;
            $sideReportProfit->quantity_avg = $item->quantity;
            $sideReportProfit->cogs_avg     = $item->price;

            if ($sideReportProfit->save()) {
                $getSideReportProfit = $this->getSideReportProfit($sideReportProfit->product_id, $sideReportProfit->type);

                if (count($getSideReportProfit) < 1) {
                    $detailReportProfit                     = new DetailReportProfit();
                    $detailReportProfit->type               = "purchase";
                    $detailReportProfit->transaction_number = $purchase->number;
                    $detailReportProfit->transaction_date   = $purchase->date;
                    $detailReportProfit->quantity_in        = $item->quantity;
                    $detailReportProfit->cogs_in            = $item->price;
                    $detailReportProfit->quantity_out       = 0;
                    $detailReportProfit->cogs_out           = 0;
                    $detailReportProfit->quantity_avg       = $item->quantity;
                    $detailReportProfit->cogs_avg           = $item->price;
                    $detailReportProfit->save();
                } else {
                    for ($i=0; $i < count($getSideReportProfit); $i++) {
                        $detailReportProfit                     = new DetailReportProfit();
                        $detailReportProfit->type               = "purchase";
                        $detailReportProfit->transaction_number = $purchase->number;
                        $detailReportProfit->transaction_date   = $purchase->date;

                        if ($i == 0) {
                            $detailReportProfit->quantity_in        = $item->quantity;
                            $detailReportProfit->cogs_in            = $item->price;
                        } else {
                            $detailReportProfit->quantity_in        = 0;
                            $detailReportProfit->cogs_in            = 0;
                        }

                        $detailReportProfit->quantity_out       = 0;
                        $detailReportProfit->cogs_out           = 0;

                        $detailReportProfit->quantity_avg       = $getSideReportProfit[$i]->quantity_avg;
                        $detailReportProfit->cogs_avg           = $getSideReportProfit[$i]->cogs_avg;
                        $detailReportProfit->report_profit_id   = $reportProfit->id;

                        $detailReportProfit->save();
                    }
                }
            }
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

    private function getSideReportProfit($product_id, $type)
    {
        $sideReportProfit = SideReportProfit::where('product_id', $product_id)->where('type', $type)->get();
        return $sideReportProfit;
    }
}
