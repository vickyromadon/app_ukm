<?php

namespace App\Http\Controllers\Seller;

use App\Models\Supplier;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
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
                "email",
                "phone",
                "status",
                "created_at"
            ];

            $total = Supplier::with(['location'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("email", 'LIKE', "%$search%")
                        ->orWhere("phone", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Supplier::with(['location'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("email", 'LIKE', "%$search%")
                        ->orWhere("phone", 'LIKE', "%$search%")
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

        return $this->view();
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'          => 'required|string|max:191',
            'email'         => 'required|email',
            'phone'         => 'required|numeric',
            'status'        => 'required',
            'address'       => 'required|string',
            'sub_district'  => 'required|string',
            'district'      => 'required|string',
            'province'      => 'required|string'
        ]);

        $location               = new Location();
        $location->address      = $request->address;
        $location->sub_district = $request->sub_district;
        $location->district    = $request->district;
        $location->province     = $request->province;
        $location->save();

        $supplier               = new Supplier();
        $supplier->code         = "SPL" . date('Ymd');
        $supplier->name         = $request->name;
        $supplier->email        = $request->email;
        $supplier->phone        = $request->phone;
        $supplier->status       = $request->status;
        $supplier->location_id  = $location->id;
        $supplier->user_id      = Auth::user()->id;

        if (!$supplier->save()) {
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
            'name'        => 'required|string|max:191',
            'email'         => 'required|email',
            'phone'         => 'required|numeric',
            'status'        => 'required',
            'address'       => 'required|string',
            'sub_district'  => 'required|string',
            'district'      => 'required|string',
            'province'      => 'required|string'
        ]);

        $supplier               = Supplier::find($request->id);

        $location               = Location::find($supplier->location_id);
        $location->address      = $request->address;
        $location->sub_district = $request->sub_district;
        $location->district    = $request->district;
        $location->province     = $request->province;
        $location->save();

        $supplier->name         = $request->name;
        $supplier->name         = $request->name;
        $supplier->email        = $request->email;
        $supplier->phone        = $request->phone;
        $supplier->status       = $request->status;

        if (!$supplier->save()) {
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
        $supplier = Supplier::find($id);

        if ($supplier->delete()) {
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
