<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;


class UMKMController extends Controller
{
    public function category($id) {
        $seller = Seller::where('category_id', $id)->paginate(12);

        return $this->view([
            'seller' => $seller
        ]);
    }

    public function detail(Request $request, $id) {
        $search = $request->get('search');

        $seller = Seller::find($id);
        $product = Product::where('name', 'LIKE', '%' . $search . '%')->where('status', '=', 'publish')->orderBy('created_at', 'desc')->where('user_id', $seller->user->id)->paginate(12);

        return $this->view([
            'product' => $product,
            'seller' => $seller
        ]);
    }
}
