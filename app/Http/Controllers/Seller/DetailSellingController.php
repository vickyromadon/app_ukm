<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailSelling;
use App\Models\ReportStock;
use App\Models\Product;
use App\Models\Selling;
use App\Models\ReportSelling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportProfit;
use App\Models\SideReportProfit;
use App\Models\DetailReportProfit;

class DetailSellingController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'selling_id'    => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
            'price'      => 'required|numeric',
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

            $reportSelling                  = new ReportSelling();
            $reportSelling->number          = $selling->number;
            $reportSelling->product_id      = $product->id;
            $reportSelling->type            = "offline";
            $reportSelling->quantity        = $item->quantity;
            $reportSelling->price           = $item->total;
            $reportSelling->user_id         = Auth::user()->id;
            $reportSelling->customer_name   = $selling->customer->name;
            $reportSelling->save();

            $reportStock                        = new ReportStock();
            $reportStock->type                  = "selling offline";
            $reportStock->transaction_number    = $selling->number;
            $reportStock->quantity_initial      = $product->stock;
            $reportStock->price_initial         = $product->price;
            $reportStock->quantity_in           = 0;
            $reportStock->cogs_in               = 0;
            $reportStock->quantity_out          = $item->quantity;
            $reportStock->cogs_out              = $item->total;
            $reportStock->quantity_avg          = $product->stock - $item->quantity;
            $reportStock->cogs_avg              = $this->getCogsAvg($product->price, $product->stock, $item->price, $item->quantity);
            $reportStock->product_id            = $product->id;
            $reportStock->user_id               = Auth::user()->id;
            $reportStock->save();

            $product->stock -= $item->quantity;
            $product->price = $item->price;
            $product->save();

            $reportProfit                   = ReportProfit::where('product_id', $product->id)->where('user_id', Auth::user()->id)->first();

            $sideReportProfit               = new SideReportProfit();
            $sideReportProfit->product_id   = $product->id;
            $sideReportProfit->type         = "selling offline";
            $sideReportProfit->quantity_in  = 0;
            $sideReportProfit->cogs_in      = 0;
            $sideReportProfit->quantity_out = $item->quantity;
            $sideReportProfit->cogs_out     = $item->price;
            $sideReportProfit->quantity_avg = $item->quantity;
            $sideReportProfit->cogs_avg     = $item->price;

            if ($sideReportProfit->save()) {
                $getSideReportProfit = $this->getSideReportProfit($sideReportProfit->product_id, $sideReportProfit->type);

                if (count($getSideReportProfit) < 1) {
                    $detailReportProfit                     = new DetailReportProfit();
                    $detailReportProfit->type               = "selling offline";
                    $detailReportProfit->transaction_number = $selling->number;
                    $detailReportProfit->transaction_date   = $selling->date;
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
                        $detailReportProfit->type               = "selling offline";
                        $detailReportProfit->transaction_number = $selling->number;
                        $detailReportProfit->transaction_date   = $selling->date;

                        if ($i == 0) {
                            $detailReportProfit->quantity_out       = $item->quantity;
                            $detailReportProfit->cogs_out           = $item->price;
                        } else {
                            $detailReportProfit->quantity_out       = 0;
                            $detailReportProfit->cogs_out           = 0;
                        }

                        $detailReportProfit->quantity_in        = 0;
                        $detailReportProfit->cogs_in            = 0;

                        $detailReportProfit->quantity_avg       = $getSideReportProfit[$i]->quantity_avg;
                        $detailReportProfit->cogs_avg           = $getSideReportProfit[$i]->cogs_avg;
                        $detailReportProfit->report_profit_id   = $reportProfit->id;

                        $detailReportProfit->save();
                    }
                }
            }
        }

        $selling->status = 'done';
        $selling->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }

    public function destroy($id)
    {
        $detailSelling = DetailSelling::find($id);

        if ($detailSelling->delete()) {
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
