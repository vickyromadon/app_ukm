<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id) {
        return $this->view([
            'product' => Product::find($id),
        ]);
    }
}
