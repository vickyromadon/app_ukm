<?php

namespace App\Http\Controllers\Seller;

use App\Models\Availability;
use App\Models\Product;
use App\Models\DetailAvailability;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
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

            $total = Availability::where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%")
                        ->orWhere("date", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = Availability::where('user_id', '=', Auth::user()->id)
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

        $availability               = new Availability();
        $availability->number       = "AVAILABILITY/" . Auth::user()->id . "/" . date("Ymdhis");
        $availability->user_id      = Auth::user()->id;
        $availability->description  = $request->description;
        $availability->date  = $request->date;

        if (!$availability->save()) {
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

        $availability               = Availability::find($request->id);
        $availability->description  = $request->description;
        $availability->date  = $request->date;

        if (!$availability->save()) {
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
        $availability = Availability::find($id);

        if ($availability->delete()) {
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
            'data' => Availability::find($id),
            'product' => Product::where('user_id', Auth::user()->id)->get(),
            'detail_availability' => DetailAvailability::where('availability_id', $id)->get()
        ]);
    }
}
