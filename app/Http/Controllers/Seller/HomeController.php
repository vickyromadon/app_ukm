<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customer = 0;
        $supplier = 0;
        $product = 0;
        $invoice = 0;

        if (Auth::user()->seller != null) {
            $customer = Customer::where('user_id', Auth::user()->id)->count();
            $supplier = Supplier::where('user_id', Auth::user()->id)->count();
            $product = Product::where('user_id', Auth::user()->id)->count();
            $invoice = Invoice::where('seller_id', Auth::user()->seller->id)->where('status', 'payment')->count();
        }

        return $this->view([
            'customer' => $customer,
            'supplier' => $supplier,
            'product' => $product,
            'invoice' => $invoice,
        ]);
    }
}
