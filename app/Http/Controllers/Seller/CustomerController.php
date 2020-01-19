<?php

namespace App\Http\Controllers\Seller;

use App\Models\Customer;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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

            $total = Customer::with(['location'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("email", 'LIKE', "%$search%")
                        ->orWhere("phone", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Customer::with(['location'])
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
        $location->district     = $request->district;
        $location->province     = $request->province;
        $location->save();

        $customer               = new Customer();
        $customer->code         = "CS" . date('Ymd');
        $customer->name         = $request->name;
        $customer->email        = $request->email;
        $customer->phone        = $request->phone;
        $customer->status       = $request->status;
        $customer->location_id  = $location->id;
        $customer->user_id      = Auth::user()->id;

        if (!$customer->save()) {
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

        $customer               = Customer::find($request->id);

        $location               = Location::find($customer->location_id);
        $location->address      = $request->address;
        $location->sub_district = $request->sub_district;
        $location->district    = $request->district;
        $location->province     = $request->province;
        $location->save();

        $customer->name         = $request->name;
        $customer->name         = $request->name;
        $customer->email        = $request->email;
        $customer->phone        = $request->phone;
        $customer->status       = $request->status;

        if (!$customer->save()) {
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
        $customer = Customer::find($id);

        if ($customer->delete()) {
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
