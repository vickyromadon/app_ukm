<?php

namespace App\Http\Controllers\Seller;

use App\Models\DetailAvailability;
use App\Models\Product;
use App\Models\Availability;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailAvailabilityController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'availability_id'   => 'required|numeric',
            'product_id'    => 'required|numeric',
            'quantity'      => 'required|numeric',
        ]);

        $checkDetailAvailability = DetailAvailability::where('availability_id', $request->availability_id)->where('product_id', $request->product_id)->where('status', 'pending')->first();
        if ($checkDetailAvailability != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan, Produk Sudah Terdaftar'
            ]);
        }

        $detailAvailability                     = new DetailAvailability();
        $detailAvailability->code               = "DTL/AVAILABILITY/" . Auth::user()->id . "/" . date("Ymdhis");
        $detailAvailability->product_id         = $request->product_id;
        $detailAvailability->availability_id    = $request->availability_id;
        $detailAvailability->quantity           = $request->quantity;

        if (!$detailAvailability->save()) {
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

    public function destroy($id)
    {
        $detailAvailability = DetailAvailability::find($id);

        if ($detailAvailability->delete()) {
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

    public function done(Request $request)
    {
        $availability = Availability::find($request->availability_id);
        $detailAvailability = DetailAvailability::where('availability_id', $request->availability_id)->get();

        foreach ($detailAvailability as $item) {
            $item->status = "done";
            $item->save();

            $product = Product::find($item->product_id);
            $product->stock += $item->quantity;
            $product->save();
        }

        $availability->status = 'done';
        $availability->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Menyelesaikan'
        ]);
    }
}
