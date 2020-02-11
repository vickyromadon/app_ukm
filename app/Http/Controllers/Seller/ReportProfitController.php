<?php

namespace App\Http\Controllers\Seller;

use App\Models\ReportProfit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportProfitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $search;
            $start = $request->start;
            $length = $request->length;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "",
                "",
                "created_at"
            ];

            $total = ReportProfit::with(['product'])
                ->where('user_id', '=', Auth::user()->id)
                ->count();

            $data = ReportProfit::with(['product'])
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                ->skip($start)
                ->take($length)
                ->get();

            $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
        }

        return $this->view();
    }

    public function show($id)
    {
        return $this->view([
            'data' => ReportProfit::find($id),
        ]);
    }
}
