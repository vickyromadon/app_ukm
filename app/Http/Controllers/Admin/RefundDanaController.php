<?php

namespace App\Http\Controllers\Admin;

use App\Models\RefundDana;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefundDanaController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => RefundDana::all(),
        ]);
    }
}
