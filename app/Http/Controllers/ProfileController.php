<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ]);

        $user       = User::find($id);
        $user->name = $request->name;

        if ($user->save()) {
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

    public function changeLocation(Request $request, $id)
    {
        $validator = $request->validate([
            'address'   => 'required|string|max:191',
            'sub_district'   => 'required|string|max:191',
            'district'   => 'required|string|max:191',
            'province'   => 'required|string|max:191',
        ]);

        $user       = User::find($id);
        $location   = null;

        if ($user->location != null) {
            $location = Location::find($user->location->id);
        } else {
            $location = new Location();
        }

        $location->address = $request->address;
        $location->sub_district = $request->sub_district;
        $location->district = $request->district;
        $location->province = $request->province;

        if ($location->save()) {
            $user->location_id = $location->id;
            $user->save();

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
