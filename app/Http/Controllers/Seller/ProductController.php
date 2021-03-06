<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportProfit;
use App\Models\DetailReportProfit;
use App\Models\SideReportProfit;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $search;
            $start = $request->start;
            $length = $request->length;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "code",
                "name",
                // "price",
                "selling_price",
                "stock",
                "status",
                "created_at"
            ];

            $total = Product::with(['unit', 'type'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("selling_price", 'LIKE', "%$search%")
                        ->orWhere("stock", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Product::with(['unit', 'type'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("selling_price", 'LIKE', "%$search%")
                        ->orWhere("stock", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                ->skip($start)
                ->take($length)
                ->get();

            $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
        }

        return $this->view([
            'unit' => Unit::all(),
            'type' => Type::all()
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::user()->seller->bank == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Harap Isi Akun Bank Terlebih Dahulu.'
            ]);
        }

        $validator = $request->validate([
            'name'          => 'required|string|max:20',
            'description'   => 'required|string',
            // 'selling_price' => 'required|numeric',
            // 'price'         => 'required|numeric',
            // 'stock'         => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
            'unit_id'       => 'required',
            'type_id'       => 'required',
            'status'        => 'required',
        ]);

        $product                = new Product();
        $product->code          = "PR" . date("Ymdhis");
        $product->name          = $request->name;
        $product->description   = $request->description;
        $product->selling_price = 0;
        $product->price         = 0;
        $product->stock         = 0;
        $product->minimum_stock = $request->minimum_stock;
        $product->unit_id       = $request->unit_id;
        $product->type_id       = $request->type_id;
        $product->status        = $request->status;
        $product->user_id       = Auth::user()->id;

        if ($request->image != null) {
            $product->image     = $request->file('image')->store('product/' . Auth::user()->id);
        }

        if (!$product->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Product::where('image', '=', $product->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            $reportProfit               = new ReportProfit();
            $reportProfit->product_id   = $product->id;
            $reportProfit->user_id      = Auth::user()->id;

            if ($reportProfit->save()) {
                $detailReportProfit                     = new DetailReportProfit();
                $detailReportProfit->report_profit_id   = $reportProfit->id;
                $detailReportProfit->quantity_in        = 0;
                $detailReportProfit->cogs_in            = 0;
                $detailReportProfit->quantity_out       = 0;
                $detailReportProfit->cogs_out           = 0;
                $detailReportProfit->quantity_avg       = 0;
                $detailReportProfit->cogs_avg           = 0;
                $detailReportProfit->type               = "initial";
                $detailReportProfit->transaction_number = "-";
                $detailReportProfit->transaction_date   = date("Y-m-d");

                if ($detailReportProfit->save()) {
                    $sideReportProfit                           = new SideReportProfit();
                    $sideReportProfit->product_id               = $product->id;
                    $sideReportProfit->type                     = $detailReportProfit->type;
                    $sideReportProfit->quantity_in              = $detailReportProfit->quantity_in;
                    $sideReportProfit->cogs_in                  = $detailReportProfit->cogs_in;
                    $sideReportProfit->quantity_out             = $detailReportProfit->quantity_out;
                    $sideReportProfit->cogs_out                 = $detailReportProfit->cogs_out;
                    $sideReportProfit->quantity_avg             = $detailReportProfit->quantity_avg;
                    $sideReportProfit->cogs_avg                 = $detailReportProfit->cogs_avg;

                    $sideReportProfit->save();
                }
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'name'          => 'required|string|max:20',
            'description'   => 'required|string',
            'selling_price' => 'required|numeric',
            // 'price'         => 'required|numeric',
            // 'stock'         => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'unit_id'       => 'required',
            'type_id'       => 'required',
            'status'        => 'required',
        ]);

        $product                = Product::find($request->id);
        $product->name          = $request->name;
        $product->description   = $request->description;
        $product->selling_price = $request->selling_price;
        $product->minimum_stock = $request->minimum_stock;
        $product->unit_id       = $request->unit_id;
        $product->type_id       = $request->type_id;
        $product->status        = $request->status;


        if ($request->image != null) {
            if ($product->image != null) {
                $picture = Product::where('image', '=', $product->image)->first();
                Storage::delete($picture->image);
            }

            $product->image = $request->file('image')->store('product/' . Auth::user()->id);
        }

        if (!$product->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Product::where('image', '=', $product->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Merubah'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Merubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete($product->image);

        if ($product->delete()) {
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
