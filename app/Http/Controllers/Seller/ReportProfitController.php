<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportProfitController extends Controller
{
    public function index(Request $request)
    {
        return $this->view();
    }
}
