@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Penjualan Online
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li class="active">Penjualan Online</li>
		</ol>
	</section>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-header with-border">
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>Nomor Invoice</th>
                            <th>Pembeli</th>
                            <th>Status</th>
                            <th>Tanggal di Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->number }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    @if ($item->status == 'pending')
                                        Menunggu Konfirmasi
                                    @elseif ($item->status == 'approve')
                                        Belum Bayar
                                    @elseif ($item->status == 'payment')
                                        Menunggu Pengiriman
                                    @elseif ($item->status == 'shipment')
                                        Telah Dikirim
                                    @elseif ($item->status == 'done')
                                        Telah Diterima
                                    @elseif ($item->status == 'reject')
                                        Telah Ditolak
                                    @elseif ($item->status == 'cancel')
                                        Telah Dibatalkan
                                    @endif
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('seller.selling-online.index') }}/{{ $item->id }}" class="btn btn-info btn-xs">
                                        <i class="fa fa-eye"></i>
                                    </a>
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
            $(document).ready( function () {
                $('#data_table').DataTable({
                    "language": {
                        "emptyTable": "Tidak Ada Data Tersedia",
                    }
                });
            });
        });
    </script>
@endsection

