@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Barang Diterima</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Barang Diterima</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="box box-default">
            <div class="box-body">
                <div class="col-md-6">
                    <table>
                        <tr>
                            <th colspan="3">{{ $invoice->number }}</th>
                        </tr>
                        <tr>
                            <th>Tanggal di buat</th>
                            <td> : </td>
                            <td>{{ $invoice->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Penjual</th>
                            <td> : </td>
                            <td>{{ $invoice->seller->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Pembeli</th>
                            <td> : </td>
                            <td>{{ $invoice->user->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table>
                        <tr>
                            <th colspan="3">Detail Pengiriman</th>
                        </tr>
                        <tr>
                            <th>Jenis Pengiriman</th>
                            <td> : </td>
                            <td>{{ $invoice->receipt_type }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Pengiriman</th>
                            <td> : </td>
                            <td>{{ $invoice->receipt_number }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="box box-default">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jumlah</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->invoice_carts as $item)
                                    <tr>
                                        <td>{{ $item->cart->quantity }}</td>
                                        <td>{{ $item->cart->product->name }}</td>
                                        <td>Rp. {{ number_format($item->cart->product->price) }}</td>
                                        <td>Rp. {{ number_format($item->cart->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tr style="font-size:25px;">
                                <td colspan="3">
                                    Subtotal
                                </td>
                                <td>Rp. {{ number_format($invoice->subtotal) }}</td>
                            </tr>
                            <tr style="font-size:25px;">
                                <td colspan="3">
                                    Ongkos Kirim
                                </td>
                                <td>Rp. {{ number_format($invoice->shipping) }}</td>
                            </tr>
                            <tr style="font-size:25px;">
                                <td colspan="3">
                                    Total
                                </td>
                                <td>Rp. {{ number_format($invoice->total) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
