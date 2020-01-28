<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request) {
        $search = $request->get('search');
        $product = Product::where('name', 'LIKE', '%' . $search . '%')->where('status', '=', 'publish')->orderBy('created_at', 'desc')->paginate(12);

        return $this->view([
            'product' => $product,
        ]);
    }

    public function show($id) {
        return $this->view([
            'product' => Product::find($id),
        ]);
    }
}
