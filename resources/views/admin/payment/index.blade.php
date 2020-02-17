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
                            <th>No</th>
                            <th>Nomor Invoice</th>
                            <th>User</th>
                            <th>Nama Bank</th>
                            <th>Nominal</th>
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
                    "url": "{{ route('admin.payment.index') }}",
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
                        "data": "invoice",
                        render : function(data, type, row){
                            return data.number
                        },
                        "orderable": false,
                    },
                    {
                        "data": "user",
                        render : function(data, type, row){
                            return data.name
                        },
                        "orderable": false,
                    },
                    {
                        "data": "bank",
                        render : function(data, type, row){
                            return data.name
                        },
                        "orderable": false,
                    },
                    {
                        "data": "nominal",
                        "orderable": false,
                    },
                    {
                        "data": "created_at",
                        "orderable": false,
                    }
                ],
                "order": [ 5, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
