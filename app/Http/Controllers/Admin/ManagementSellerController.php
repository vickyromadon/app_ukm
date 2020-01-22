<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagementSellerController extends Controller
{
    public function index() {
        return $this->view([
            'data' => User::all()
        ]);
    }

    public function show($id) {
        return $this->view([
            'data' => User::find($id)
        ]);
    }

    public function approve(Request $request)
    {
        $seller = Seller::find($request->id);
        $seller->status = "approve";

        if ($seller->save()) {
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
        $seller = Seller::find($request->id);
        $seller->status = "reject";

        if ($seller->save()) {
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
}
