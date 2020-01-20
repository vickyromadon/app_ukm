<?php

namespace App\Http\Controllers\Seller;

use App\Models\Selling;
use App\Models\Product;
use App\Models\DetailSelling;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SellingController extends Controller
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
                "customer",
                "number",
                "description",
                "created_at"
            ];

            $total = Selling::with(['customer'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = Selling::with(['customer'])
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
            'customer' => Customer::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'customer_id' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $selling               = new Selling();
        $selling->number       = "SELLING/" . Auth::user()->id . "/" . date("Ymdhis");
        $selling->customer_id  = $request->customer_id;
        $selling->user_id      = Auth::user()->id;
        $selling->description  = $request->description;

        if (!$selling->save()) {
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
            'customer_id' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $selling               = Selling::find($request->id);
        $selling->customer_id  = $request->customer_id;
        $selling->description  = $request->description;

        if (!$selling->save()) {
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
        $selling = Selling::find($id);

        if ($selling->delete()) {
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
        return $this->view([
            'data' => Selling::find($id),
            'product' => Product::where('user_id', Auth::user()->id)->get(),
            'detail_selling' => DetailSelling::where('selling_id', $id)->get()
        ]);
    }
}
