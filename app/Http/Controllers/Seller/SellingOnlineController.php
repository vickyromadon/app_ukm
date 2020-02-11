<?php

namespace App\Http\Controllers\Seller;

use App\Models\Invoice;
use App\Models\ReportStock;
use App\Models\Product;
use App\Models\ReportSelling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportProfit;
use App\Models\SideReportProfit;
use App\Models\DetailReportProfit;

class SellingOnlineController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => Invoice::where('seller_id', Auth::user()->seller->id)->get()
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Invoice::find($id),
        ]);
    }

    public function approve(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "approve";

        if ($invoice->save()) {
            foreach ($invoice->invoice_carts as $item) {
                $product = Product::find($item->cart->product->id);

                $reportSelling                  = new ReportSelling();
                $reportSelling->number          = $invoice->number;
                $reportSelling->product_id      = $product->id;
                $reportSelling->type            = "online";
                $reportSelling->quantity        = $item->cart->quantity;
                $reportSelling->price           = $item->cart->price;
                $reportSelling->user_id         = Auth::user()->id;
                $reportSelling->customer_name   = $invoice->user->name;
                $reportSelling->save();

                $reportStock                        = new ReportStock();
                $reportStock->type                  = "selling online";
                $reportStock->transaction_number    = $invoice->number;
                $reportStock->quantity_initial      = $product->stock;
                $reportStock->price_initial         = $product->price;
                $reportStock->quantity_in           = 0;
                $reportStock->cogs_in               = 0;
                $reportStock->quantity_out          = $item->cart->quantity;
                $reportStock->cogs_out              = $item->cart->price;
                $reportStock->quantity_avg          = $product->stock - $item->cart->quantity;
                $reportStock->cogs_avg              = $this->getCogsAvg($product->price, $product->stock, ($item->cart->price / $item->cart->quantity), $item->cart->quantity);
                $reportStock->product_id            = $product->id;
                $reportStock->user_id               = Auth::user()->id;
                $reportStock->save();

                $product->stock -= $item->cart->quantity;
                $product->price = $item->cart->price / $item->cart->quantity;
                $product->save();

                $reportProfit                   = ReportProfit::where('product_id', $product->id)->where('user_id', Auth::user()->id)->first();

                $sideReportProfit               = new SideReportProfit();
                $sideReportProfit->product_id   = $product->id;
                $sideReportProfit->type         = "selling online";
                $sideReportProfit->quantity_in  = 0;
                $sideReportProfit->cogs_in      = 0;
                $sideReportProfit->quantity_out = $item->cart->quantity;
                $sideReportProfit->cogs_out     = $item->cart->price;
                $sideReportProfit->quantity_avg = $item->cart->quantity;
                $sideReportProfit->cogs_avg     = $item->cart->price;

                if ($sideReportProfit->save()) {
                    $getSideReportProfit = $this->getSideReportProfit($sideReportProfit->product_id, $sideReportProfit->type);

                    if (count($getSideReportProfit) < 1) {
                        $detailReportProfit                     = new DetailReportProfit();
                        $detailReportProfit->type               = "selling online";
                        $detailReportProfit->transaction_number = $invoice->number;
                        $detailReportProfit->transaction_date   = $invoice->created_at;
                        $detailReportProfit->quantity_in        = $item->cart->quantity;
                        $detailReportProfit->cogs_in            = $item->cart->price;
                        $detailReportProfit->quantity_out       = 0;
                        $detailReportProfit->cogs_out           = 0;
                        $detailReportProfit->quantity_avg       = $item->cart->quantity;
                        $detailReportProfit->cogs_avg           = $item->cart->price;
                        $detailReportProfit->save();
                    } else {
                        for ($i = 0; $i < count($getSideReportProfit); $i++) {
                            $detailReportProfit                     = new DetailReportProfit();
                            $detailReportProfit->type               = "selling online";
                            $detailReportProfit->transaction_number = $invoice->number;
                            $detailReportProfit->transaction_date   = $invoice->created_at;

                            if ($i == 0) {
                                $detailReportProfit->quantity_out       = $item->cart->quantity;
                                $detailReportProfit->cogs_out           = $item->cart->price;
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

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Disetujui'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Disetujui'
            ]);
        }
    }

    public function reject(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "reject";

        if ($invoice->save()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Ditolak'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Ditolak'
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
