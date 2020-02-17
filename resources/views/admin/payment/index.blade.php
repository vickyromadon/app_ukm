@extends('layouts.admin')

@section('header')
    <h1>
        Pembayaran Penjualan Online
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Pembayaran Penjualan Online</li>
    </ol>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>Nomor Invoice</th>
                            <th>User Pembeli</th>
                            <th>User Penjual</th>
                            <th>Nama Bank</th>
                            <th>Nominal</th>
                            <th>Status Transaksi</th>
                            <th>Tanggal di Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->invoice->number }}</td>
                                <td>{{ $item->invoice->user->name }}</td>
                                <td>{{ $item->invoice->seller->user->name }}</td>
                                <td>{{ $item->bank->name }}</td>
                                <td>Rp. {{ number_format($item->nominal) }}</td>
                                <td>
                                    @if ($item->invoice->status == 'pending')
                                        Menunggu Konfirmasi
                                    @elseif ($item->invoice->status == 'approve')
                                        Belum Bayar
                                    @elseif ($item->invoice->status == 'payment')
                                        Menunggu Pengiriman
                                    @elseif ($item->invoice->status == 'shipment')
                                        Telah Dikirim
                                    @elseif ($item->invoice->status == 'done')
                                        Telah Diterima
                                    @elseif ($item->invoice->status == 'reject')
                                        Telah Ditolak
                                    @elseif ($item->invoice->status == 'cancel')
                                        Telah Dibatalkan
                                    @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if ($item->invoice->status == "done")
                                        <a href="{{ route('admin.payment.show', ['id' => $item->id]) }}" class="btn-detail btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#data_table').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });
        });
    </script>
@endsection
