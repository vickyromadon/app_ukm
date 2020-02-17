@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Laporan Pengembalian Dana
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li class="active">Laporan Pengembalian Dana</li>
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
                            <th>Nomor Invoice</th>
                            <th>User</th>
                            <th>Nama Bank</th>
                            <th>Nominal</th>
                            <th>Tanggal di Buat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @if ( $item->seller_id == Auth::user()->seller->id )
                                <tr>
                                    <td>{{ $item->invoice->number }}</td>
                                    <td>{{ $item->seller->user->name }}</td>
                                    <td>{{ $item->seller->bank->name }}</td>
                                    <td>{{ $item->nominal }}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @endif
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
