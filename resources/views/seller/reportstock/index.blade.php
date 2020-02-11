@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Laporan Ketersediaan Barang
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li class="active">Laporan Ketersediaan Barang</li>
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
                            <th>No</th>
                            <th>Tipe</th>
                            <th>No. Transaksi</th>
                            <th>Nama Produk</th>
                            <th>No. Produk</th>
                            <th>Qty Masuk</th>
                            <th>cOgs Masuk</th>
                            <th>Qty Keluar</th>
                            <th>cOgs Keluar</th>
                            <th>Qty Rerata</th>
                            <th>cOgs Rerata</th>
                            <th>Tanggal di Buat</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(document).ready(function($){
            var table = $('#data_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('seller.report-stock.index') }}",
                    "type": "POST",
                    "data" : {}
                },
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
                "columns": [
                    {
                       data: null,
                       render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                       },
                       "width": "20px",
                       "orderable": false,
                    },
                    {
                        "data": "type",
                        "orderable": true,
                    },
                    {
                        "data": "transaction_number",
                        "orderable": true,
                    },
                    {
                        "data": "product",
                        render : function(data, type, row){
                            return data.name;
                        },
                        "orderable": false,
                    },
                    {
                        "data": "product",
                        render : function(data, type, row){
                            return data.code;
                        },
                        "orderable": false,
                    },
                    {
                        "data": "quantity_in",
                        "orderable": false,
                    },
                    {
                        "data": "cogs_in",
                        "orderable": false,
                    },
                    {
                        "data": "quantity_out",
                        "orderable": false,
                    },
                    {
                        "data": "cogs_out",
                        "orderable": false,
                    },
                    {
                        "data": "quantity_avg",
                        "orderable": false,
                    },
                    {
                        "data": "cogs_avg",
                        "orderable": false,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    }
                ],
                "order": [ 11, 'asc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
