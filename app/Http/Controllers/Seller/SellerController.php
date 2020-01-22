<?php

namespace App\Http\Controllers\Seller;

use App\Models\Location;
use App\Models\Document;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $checkSeller = Seller::where('user_id', Auth::user()->id)->first();

            if ($checkSeller != null) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Sudah melakukan lengkapi data sebelumnya, Silahkan Tunggu konfirmasi dari admin.'
                ]);
            }

            $validator = $request->validate([
                'phone'         => 'required|numeric',
                'address'       => 'required|string',
                'sub_district'  => 'required|string',
                'district'      => 'required|string',
                'province'      => 'required|string',
                'photo'         => 'required|mimes:jpeg,jpg,png|max:5000',
                'ktp'           => 'required|mimes:jpeg,jpg,png|max:5000',
                'document'      => 'required|mimes:jpeg,jpg,png|max:5000',

            ]);

            $location               = new Location();
            $location->address      = $request->address;
            $location->sub_district = $request->sub_district;
            $location->district     = $request->district;
            $location->province     = $request->province;
            $location->save();

            $document           = new Document();
            $document->photo    = $request->file('photo')->store('document/' . Auth::user()->id . '/photo');
            $document->ktp      = $request->file('ktp')->store('document/' . Auth::user()->id . '/ktp');
            $document->document = $request->file('document')->store('document/' . Auth::user()->id . '/document');
            $document->save();

            $seller                 = new Seller();
            $seller->phone          = $request->phone;
            $seller->user_id        = Auth::user()->id;
            $seller->location_id    = $location->id;
            $seller->document_id    = $document->id;

            if (!$seller->save()) {
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

        return $this->view();
    }
}
