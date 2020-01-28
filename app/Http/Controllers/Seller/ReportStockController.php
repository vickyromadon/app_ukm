<?php

namespace App\Http\Controllers\Seller;

use App\Models\ReportStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportStockController extends Controller
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
                "type",
                "transaction_number",
                "product",
                "product",
                "quantity_in",
                "cogs_in",
                "quantity_out",
                "cogs_out",
                "quantity_avg",
                "cogs_avg",
                "created_at"
            ];

            $total = ReportStock::with(['product'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("type", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = ReportStock::with(['product'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("type", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
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
}
