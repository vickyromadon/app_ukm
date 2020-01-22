<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', '=', Auth::user()->id)->where('status', '=', 'pending')->orderBy('created_at', 'desc')->get();
        $totalCart = 0;
        foreach ($cart as $item) {
            $totalCart += $item->price;
        }
        return $this->view([
            'cart' => $cart,
            'total_cart' => $totalCart,
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'product_id'    => 'required',
            'quantity'      => 'required|numeric',
        ]);

        $checkCart = Cart::where('product_id', '=', $request->product_id)->where('user_id', '=', Auth::user()->id)->where('status', '=', 'pending')->first();
        if ($checkCart != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Produk sudah ada di dalam keranjang'
            ]);
        }

        $product = Product::find($request->product_id);

        $cart = new Cart();
        $cart->product_id   = $product->id;
        $cart->seller_id    = $product->user->seller->id;
        $cart->user_id      = Auth::user()->id;
        $cart->quantity     = $request->quantity;
        $cart->price        = $product->price * $request->quantity;

        if ($cart->save()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Tambah Keranjang Berhasil'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Tambah Keranjang Gagal'
            ]);
        }
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);

        if ($cart->delete()) {
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

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'quantity'         => 'required|numeric',
        ]);

        $cart                = Cart::find($id);

        $product = Product::find($cart->product->id);
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success'   => false,
                'message'   => 'Produk tersedia hanya ' . $product->stock
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->price    = $product->price * $request->quantity;

        if (!$cart->save()) {
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
