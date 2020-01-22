<?php

namespace App\Http\Controllers\Seller;

use App\Models\Bank;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
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
                "name",
                "number",
                "owner",
                "created_at"
            ];

            $total = Bank::where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("name", 'LIKE', "%$search%")
                        ->orWhere("number", 'LIKE', "%$search%")
                        ->orWhere("owner", 'LIKE', "%$search%");
                })
                ->count();

            $data = Bank::where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("name", 'LIKE', "%$search%")
                        ->orWhere("number", 'LIKE', "%$search%")
                        ->orWhere("owner", 'LIKE', "%$search%");
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
            'name'        => 'required|string|max:191',
            'number'    => 'required|string|unique:banks',
            'owner'     => 'required|string|max:191',
        ]);

        $bank           = new Bank();
        $bank->name     = $request->name;
        $bank->number   = $request->number;
        $bank->owner    = $request->owner;
        $bank->user_id  = Auth::user()->id;

        if (!$bank->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            $seller = Seller::where('user_id', Auth::user()->id)->first();
            $seller->bank_id = $bank->id;
            $seller->save();

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
            'number'    => 'required', 'string', Rule::unique('banks')->ignore($id),
            'owner'     => 'required|string|max:191',
        ]);

        $bank           = Bank::find($request->id);
        $bank->name     = $request->name;
        $bank->number   = $request->number;
        $bank->owner    = $request->owner;

        if (!$bank->save()) {
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
}
