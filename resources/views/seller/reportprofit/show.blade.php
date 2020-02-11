@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Detail Laporan Laba Rugi
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li>Laporan Laba Rugi</li>
			<li class="active">Detail</li>
		</ol>
	</section>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>Tipe</th>
                            <th>Nomor Trx</th>
                            <th>Tanggal Trx</th>
                            <th>Qty Masuk</th>
                            <th>cOgs Masuk</th>
                            <th>Qty Keluar</th>
                            <th>cOgs Keluar</th>
                            <th>Qty Rerata</th>
                            <th>cOgs Rerata</th>
                            <th>Tanggal di Buat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->detail_report_profits as $item)
                            <tr>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->transaction_number }}</td>
                                <td>{{ $item->transaction_date }}</td>
                                <td>{{ $item->quantity_in }}</td>
                                <td>{{ $item->cogs_in }}</td>
                                <td>{{ $item->quantity_out }}</td>
                                <td>{{ $item->cogs_out }}</td>
                                <td>{{ $item->quantity_avg }}</td>
                                <td>{{ $item->cogs_avg }}</td>
                                <td>{{ $item->created_at }}</td>
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
                "order": [ 9, 'asc' ],
            });
        });
    </script>
@endsection
