<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
                "code",
                "name",
                "price",
                "stock",
                "status",
                "created_at"
            ];

            $total = Product::with(['unit', 'type'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("stock", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Product::with(['unit', 'type'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("code", 'LIKE', "%$search%")
                        ->orWhere("name", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("stock", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
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

        return $this->view([
            'unit' => Unit::all(),
            'type' => Type::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'          => 'required|string|max:20',
            'description'   => 'required|string',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
            'unit_id'       => 'required',
            'type_id'       => 'required',
            'status'        => 'required',
        ]);

        $product                = new Product();
        $product->code          = "PR" . date("Ymd");
        $product->name          = $request->name;
        $product->description   = $request->description;
        $product->price         = $request->price;
        $product->stock         = $request->stock;
        $product->minimum_stock = $request->minimum_stock;
        $product->unit_id       = $request->unit_id;
        $product->type_id       = $request->type_id;
        $product->status        = $request->status;
        $product->user_id       = Auth::user()->id;

        if ($request->image != null) {
            $product->image     = $request->file('image')->store('product/' . Auth::user()->id);
        }

        if (!$product->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Product::where('image', '=', $product->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'name'          => 'required|string|max:20',
            'description'   => 'required|string',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'unit_id'       => 'required',
            'type_id'       => 'required',
            'status'        => 'required',
        ]);

        $product                = Product::find($request->id);
        $product->name          = $request->name;
        $product->description   = $request->description;
        $product->price         = $request->price;
        $product->stock         = $request->stock;
        $product->minimum_stock = $request->minimum_stock;
        $product->unit_id       = $request->unit_id;
        $product->type_id       = $request->type_id;
        $product->status        = $request->status;


        if ($request->image != null) {
            if ($product->image != null) {
                $picture = Product::where('image', '=', $product->image)->first();
                Storage::delete($picture->image);
            }

            $product->image = $request->file('image')->store('product/' . Auth::user()->id);
        }

        if (!$product->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Product::where('image', '=', $product->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Merubah'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Merubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete($product->image);

        if ($product->delete()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Menghapus'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menghapus'
            ]);
        }
    }
}
