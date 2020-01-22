<?php

namespace App\Http\Controllers;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view([
            'product' => Product::where('status', 'publish')->paginate(12),
        ]);
    }

    public function about()
    {
        return $this->view();
    }
}
