<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagementMemberController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => User::all()
        ]);
    }
}
