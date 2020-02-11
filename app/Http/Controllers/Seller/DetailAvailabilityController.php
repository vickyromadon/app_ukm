<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailAvailability;
use App\Models\ReportStock;
use App\Models\Product;
use App\Models\Availability;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportProfit;
use App\Models\SideReportProfit;
use App\Models\DetailReportProfit;

class DetailAvailabilityController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'availability_id'   => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
        ]);

        $checkDetailAvailability = DetailAvailability::where('availability_id', $request->availability_id)->where('product_id', $request->product_id)->where('status', 'pending')->first();
        if ($checkDetailAvailability != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Produk Sudah Terdaftar'
            ]);
        }

        $detailAvailability                     = new DetailAvailability();
        $detailAvailability->code               = "DTL/AVAILABILITY/" . Auth::user()->id . "/" . date("Ymdhis");
        $detailAvailability->product_id         = $request->product_id;
        $detailAvailability->availability_id    = $request->availability_id;
        $detailAvailability->quantity           = $request->quantity;

        if (!$detailAvailability->save()) {
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
        $detailAvailability = DetailAvailability::find($id);

        if ($detailAvailability->delete()) {
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
        $availability = Availability::find($request->availability_id);
        $detailAvailability = DetailAvailability::where('availability_id', $request->availability_id)->get();

        foreach ($detailAvailability as $item) {
            $item->status = "done";
            $item->save();

            $product = Product::find($item->product_id);

            $reportStock                        = new ReportStock();
            $reportStock->type                  = "availability";
            $reportStock->transaction_number    = $availability->number;
            $reportStock->quantity_initial      = $product->stock;
            $reportStock->price_initial         = $product->price;
            $reportStock->quantity_in           = $item->quantity;
            $reportStock->cogs_in               = 0;
            $reportStock->quantity_out          = 0;
            $reportStock->cogs_out              = 0;
            $reportStock->quantity_avg          = $product->stock + $item->quantity;
            $reportStock->cogs_avg              = $this->getCogsAvg($product->price, $product->stock, 0, $item->quantity);
            $reportStock->product_id            = $product->id;
            $reportStock->user_id               = Auth::user()->id;
            $reportStock->save();

            $product->stock += $item->quantity;
            $product->save();

            $reportProfit                       = ReportProfit::where('product_id', $product->id)->where('user_id', Auth::user()->id)->first();

            $sideReportProfit               = new SideReportProfit();
            $sideReportProfit->product_id   = $product->id;
            $sideReportProfit->type         = "availability";
            $sideReportProfit->quantity_in  = $item->quantity;
            $sideReportProfit->cogs_in      = 0;
            $sideReportProfit->quantity_out = 0;
            $sideReportProfit->cogs_out     = 0;
            $sideReportProfit->quantity_avg = $item->quantity;
            $sideReportProfit->cogs_avg     = 0;

            if ($sideReportProfit->save()) {
                $getSideReportProfit = $this->getSideReportProfit($sideReportProfit->product_id, $sideReportProfit->type);

                if (count($getSideReportProfit) < 1) {
                    $detailReportProfit                     = new DetailReportProfit();
                    $detailReportProfit->type               = "availability";
                    $detailReportProfit->transaction_number = $availability->number;
                    $detailReportProfit->transaction_date   = $availability->date;
                    $detailReportProfit->quantity_in        = $item->quantity;
                    $detailReportProfit->cogs_in            = 0;
                    $detailReportProfit->quantity_out       = 0;
                    $detailReportProfit->cogs_out           = 0;
                    $detailReportProfit->quantity_avg       = $item->quantity;
                    $detailReportProfit->cogs_avg           = 0;
                    $detailReportProfit->save();
                } else {
                    for ($i = 0; $i < count($getSideReportProfit); $i++) {
                        $detailReportProfit                     = new DetailReportProfit();
                        $detailReportProfit->type               = "availability";
                        $detailReportProfit->transaction_number = $availability->number;
                        $detailReportProfit->transaction_date   = $availability->date;

                        if ($i == 0) {
                            $detailReportProfit->quantity_in        = $item->quantity;
                            $detailReportProfit->cogs_in            = 0;
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

        $availability->status = 'done';
        $availability->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
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
