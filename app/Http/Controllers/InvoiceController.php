<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCart;
use App\Models\Cart;
use App\Models\User;
use App\Models\Payment;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        return $this->view([
            'invoice_pending'   => Invoice::where('user_id', Auth::user()->id)->where('status', "pending")->get(),
            'invoice_payment'   => Invoice::where('user_id', Auth::user()->id)->where('status', "payment")->get(),
            'invoice_cancel'    => Invoice::where('user_id', Auth::user()->id)->where('status', "cancel")->get(),
            'invoice_approve'   => Invoice::where('user_id', Auth::user()->id)->where('status', "approve")->get(),
            'invoice_reject'    => Invoice::where('user_id', Auth::user()->id)->where('status', "reject")->get(),
        ]);
    }

    public function pending($id)
    {
        $invoice = Invoice::find($id);
        $total = 0;

        foreach ($invoice->invoice_carts as $item) {
            $total += $item->cart->price;
        }
        $invoice->total     = $total;
        $invoice->save();

        return $this->view([
            'invoice'       => $invoice,
        ]);
    }

    public function canceled($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function approve($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function reject($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function pagePayment($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function cancel(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "cancel";

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Melakukan Pembatalan'
            ]);
        } else {
            foreach ($invoice->invoice_carts as $item) {
                $cart = Cart::find($item->cart_id);
                $cart->status = "cancel";
                $cart->save();
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Melakukan Pembatalan'
            ]);
        }
    }

    public function payment(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "payment";

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Melakukan Pembayaran'
            ]);
        } else {
            $payment                    = new Payment();
            $payment->nominal           = $invoice->total;
            $payment->user_id           = Auth::user()->id;
            $payment->invoice_id        = $invoice->id;
            $payment->bank_id           = $invoice->seller->bank->id;
            $payment->proof             = $request->file('proof')->store('payment/' . Auth::user()->id);
            $payment->save();

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Melakukan Pembayaran'
            ]);
        }
    }

    public function store()
    {
        $user = User::find(Auth::user()->id);
        $cart = Cart::where('user_id', '=', $user->id)->where('status', '=', 'pending')->get();

        $sellerId    = array();
        foreach ($cart as $item) {
            if (!in_array($item->seller_id, $sellerId)) {
                array_push($sellerId, $item->seller_id);
            }
        }

        foreach ($sellerId as $item) {
            $invoice = new Invoice();
            $invoice->number                = "INV/" . date("Y-m-d_H:i:s") . "/" . $item . "/" . Auth::user()->email . "/" . $this->getInvoiceLast();
            $invoice->status                = "pending";
            $invoice->user_id               = $user->id;
            $invoice->seller_id             = $item;
            $invoice->save();
        }

        foreach ($cart as $item) {
            $invoiceCart                = new InvoiceCart();
            $invoiceCart->invoice_id    = $this->getInvoice($item->seller_id, $item->user_id);
            $invoiceCart->cart_id       = $this->getCart($item->seller_id, $item->user_id, $item->product_id);
            $invoiceCart->save();
        }

        foreach ($cart as $item) {
            $item->status = "done";
            $item->save();
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Lanjut Pembayaran'
        ]);
    }

    private function getCart($seller, $user, $product)
    {
        $cart = Cart::where('seller_id', $seller)->where('user_id', $user)->where('product_id', $product)->where('status', 'pending')->first();
        return $cart->id;
    }

    private function getInvoice($seller, $user)
    {
        $invoice = Invoice::where('seller_id', $seller)->where('user_id', $user)->where('status', 'pending')->first();
        return $invoice->id;
    }

    private function getInvoiceLast()
    {
        $invoice = Invoice::orderBy('created_at', 'desc')->first();
        if ($invoice == null) {
            return "1";
        } else {
            return strval($invoice->id + 1);
        }
    }
}
