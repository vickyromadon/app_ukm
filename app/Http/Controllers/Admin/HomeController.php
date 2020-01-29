<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $totalMember = 0;
        $totalSellerApprove = 0;
        $totalSellerPending = 0;
        $totalSellerReject = 0;

        foreach ($user as $item) {
            if ($item->roles[0]->name == 'seller') {
                if ($item->seller != null) {
                    if ($item->seller->status == "pending") {
                        $totalSellerPending += 1;
                    } else if($item->seller->status == "approve") {
                        $totalSellerApprove += 1;
                    } else {
                        $totalSellerReject += 1;
                    }
                } else {
                    $totalSellerPending += 1;
                }
            } elseif ($item->roles[0]->name == 'member') {
                $totalMember += 1;
            }
        }

        return $this->view([
            'member' => $totalMember,
            'seller_approve' => $totalSellerApprove,
            'seller_pending' => $totalSellerPending,
            'seller_reject' => $totalSellerReject,
        ]);
    }
}
