<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\ReportStock;
use App\Models\Assembly;
use App\Models\DetailAssembly;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportProfit;
use App\Models\SideReportProfit;
use App\Models\DetailReportProfit;

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

            $reportProfitPlus                       = ReportProfit::where('product_id', $productPlus->id)->where('user_id', Auth::user()->id)->first();

            $sideReportProfit               = new SideReportProfit();
            $sideReportProfit->product_id   = $productPlus->id;
            $sideReportProfit->type         = "assembly plus";
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
                    $detailReportProfit->type               = "assembly plus";
                    $detailReportProfit->transaction_number = $assembly->number;
                    $detailReportProfit->transaction_date   = $assembly->date;
                    $detailReportProfit->quantity_in        = $item->quantity;
                    $detailReportProfit->cogs_in            = $item->price;
                    $detailReportProfit->quantity_out       = 0;
                    $detailReportProfit->cogs_out           = 0;
                    $detailReportProfit->quantity_avg       = $item->quantity;
                    $detailReportProfit->cogs_avg           = $item->price;
                    $detailReportProfit->save();
                } else {
                    for ($i = 0; $i < count($getSideReportProfit); $i++) {
                        $detailReportProfit                     = new DetailReportProfit();
                        $detailReportProfit->type               = "assembly plus";
                        $detailReportProfit->transaction_number = $assembly->number;
                        $detailReportProfit->transaction_date   = $assembly->date;

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
                        $detailReportProfit->report_profit_id   = $reportProfitPlus->id;

                        $detailReportProfit->save();
                    }
                }
            }
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

            $reportProfitMinus                   = ReportProfit::where('product_id', $productMinus->id)->where('user_id', Auth::user()->id)->first();

            $sideReportProfit               = new SideReportProfit();
            $sideReportProfit->product_id   = $productMinus->id;
            $sideReportProfit->type         = "assembly minus";
            $sideReportProfit->quantity_in  = 0;
            $sideReportProfit->cogs_in      = 0;
            $sideReportProfit->quantity_out = $item->quantity;
            $sideReportProfit->cogs_out     = 0;
            $sideReportProfit->quantity_avg = $item->quantity;
            $sideReportProfit->cogs_avg     = 0;

            if ($sideReportProfit->save()) {
                $getSideReportProfit = $this->getSideReportProfit($sideReportProfit->product_id, $sideReportProfit->type);

                if (count($getSideReportProfit) < 1) {
                    $detailReportProfit                     = new DetailReportProfit();
                    $detailReportProfit->type               = "assembly minus";
                    $detailReportProfit->transaction_number = $assembly->number;
                    $detailReportProfit->transaction_date   = $assembly->date;
                    $detailReportProfit->quantity_in        = $item->quantity;
                    $detailReportProfit->cogs_in            = $item->price;
                    $detailReportProfit->quantity_out       = 0;
                    $detailReportProfit->cogs_out           = 0;
                    $detailReportProfit->quantity_avg       = $item->quantity;
                    $detailReportProfit->cogs_avg           = $item->price;
                    $detailReportProfit->save();
                } else {
                    for ($i = 0; $i < count($getSideReportProfit); $i++) {
                        $detailReportProfit                     = new DetailReportProfit();
                        $detailReportProfit->type               = "assembly minus";
                        $detailReportProfit->transaction_number = $assembly->number;
                        $detailReportProfit->transaction_date   = $assembly->date;

                        if ($i == 0) {
                            $detailReportProfit->quantity_out       = $item->quantity;
                            $detailReportProfit->cogs_out           = 0;
                        } else {
                            $detailReportProfit->quantity_out       = 0;
                            $detailReportProfit->cogs_out           = 0;
                        }

                        $detailReportProfit->quantity_in        = 0;
                        $detailReportProfit->cogs_in            = 0;

                        $detailReportProfit->quantity_avg       = $getSideReportProfit[$i]->quantity_avg;
                        $detailReportProfit->cogs_avg           = $getSideReportProfit[$i]->cogs_avg;
                        $detailReportProfit->report_profit_id   = $reportProfitMinus->id;

                        $detailReportProfit->save();
                    }
                }
            }
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

    private function getSideReportProfit($product_id, $type)
    {
        $sideReportProfit = SideReportProfit::where('product_id', $product_id)->where('type', $type)->get();
        return $sideReportProfit;
    }
}
