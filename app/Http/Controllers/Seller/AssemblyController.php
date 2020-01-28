<?php

namespace App\Http\Controllers\Seller;

use App\Models\Assembly;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Type;
use App\Models\DetailAssembly;
use App\Models\ProductAssembly;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssemblyController extends Controller
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
                "number",
                "description",
                "date",
                "created_at"
            ];

            $total = Assembly::where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%")
                        ->orWhere("date", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = Assembly::where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%")
                        ->orWhere("date", 'LIKE', "%$search%")
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

        return $this->view();
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $assembly               = new Assembly();
        $assembly->number       = "ASSEMBLY/" . Auth::user()->id . "/" . date("Ymdhis");
        $assembly->user_id      = Auth::user()->id;
        $assembly->description  = $request->description;
        $assembly->date  = $request->date;

        if (!$assembly->save()) {
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
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $assembly               = Assembly::find($request->id);
        $assembly->description  = $request->description;
        $assembly->date  = $request->date;

        if (!$assembly->save()) {
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
        $assembly = Assembly::find($id);

        if ($assembly->delete()) {
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
            'data' => Assembly::find($id),
            'product' => Product::where('user_id', Auth::user()->id)->get(),
            'product_assembly' => ProductAssembly::where('assembly_id', $id)->get(),
            'detail_assembly' => DetailAssembly::where('assembly_id', $id)->get(),
            'unit' => Unit::all(),
            'type' => Type::all()
        ]);
    }
}
