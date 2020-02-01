<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seller;
use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => User::find(Auth::user()->id),
        ]);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        if (!(Hash::check($request->current_password, $user->password))) {
            return response()->json([
                'success' => false,
                'message' => 'Kata Sandi Lama Salah, Silahkan Coba Lagi.',
            ]);
        }

        $validator = $request->validate([
            'new_password'         => 'required|min:6',
            'new_password_confirm' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Berhasil diubah',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Gagal diubah',
            ]);
        }
    }

    public function changeSetting(Request $request, $id)
    {
        $validator = $request->validate([
            'name'          => 'required|string|max:191',
            'phone'         => ['required', 'string'],
        ]);

        $statusRes = false;

        DB::transaction(function () use ($request, &$statusRes, &$id) {
            $user       = User::find($id);
            $user->name = $request->name;

            if ($user->save()) {
                $seller         = Seller::where('user_id', $user->id)->first();
                $seller->phone  = $request->phone;

                if ($seller->save()) {
                    $statusRes = true;
                }
            }
        });

        if (!$statusRes) {
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

    public function changeLocation(Request $request, $id)
    {
        $validator = $request->validate([
            'address'   => 'required|string|max:191',
            'sub_district'   => 'required|string|max:191',
            'district'   => 'required|string|max:191',
            'province'   => 'required|string|max:191',
        ]);

        $user       = User::find($id);

        $location = Location::find($user->seller->location->id);
        $location->address = $request->address;
        $location->sub_district = $request->sub_district;
        $location->district = $request->district;
        $location->province = $request->province;

        if ($location->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Merubah',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Merubah',
            ]);
        }
    }
}
