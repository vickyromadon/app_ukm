<?php

namespace App\Http\Controllers\Seller;

use App\Models\Purchase;
use App\Models\DetailPurchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
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
                "supplier",
                "number",
                "description",
                "created_at"
            ];

            $total = Purchase::with(['supplier'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = Purchase::with(['supplier'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
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
            'supplier' => Supplier::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'supplier_id' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $purchase               = new Purchase();
        $purchase->number       = "PURCASE/" . Auth::user()->id . "/" . date("Ymd");
        $purchase->supplier_id  = $request->supplier_id;
        $purchase->user_id      = Auth::user()->id;
        $purchase->description  = $request->description;

        if (!$purchase->save()) {
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

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'supplier_id' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $purchase               = Purchase::find($request->id);
        $purchase->supplier_id  = $request->supplier_id;
        $purchase->description  = $request->description;

        if (!$purchase->save()) {
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
        $purchase = Purchase::find($id);

        if ($purchase->delete()) {
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

    public function show($id)
    {
        return $this->view(['data' => Purchase::find($id)]);
    }

    public function detailPurchase(Request $request, $id)
    {
        $search;
        $start = $request->start;
        $length = $request->length;

        if (!empty($request->search))
            $search = $request->search['value'];
        else
            $search = null;

        $column = [
            "code",
            "quantity",
            "price",
            "total",
            "created_at"
        ];

        $total = DetailPurchase::with(['purchase'])
            ->where('purchase_id', '=', $id)
            ->where(function ($q) use ($search) {
                $q->where("code", 'LIKE', "%$search%")
                    ->orWhere("quantity", 'LIKE', "%$search%")
                    ->orWhere("price", 'LIKE', "%$search%")
                    ->orWhere("total", 'LIKE', "%$search%")
                    ->orWhere("created_at", 'LIKE', "%$search%");
            })
            ->count();

        $data = DetailPurchase::with(['purchase'])
            ->where('purchase_id', '=', $id)
            ->where(function ($q) use ($search) {
                $q->where("code", 'LIKE', "%$search%")
                    ->orWhere("quantity", 'LIKE', "%$search%")
                    ->orWhere("price", 'LIKE', "%$search%")
                    ->orWhere("total", 'LIKE', "%$search%")
                    ->orWhere("created_at", 'LIKE', "%$search%");
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
}
