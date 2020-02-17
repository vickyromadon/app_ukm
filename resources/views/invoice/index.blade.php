@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Saya</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#pending" data-toggle="tab">Menunggu Disetujui UMKM</a></li>
					<li><a href="#approve" data-toggle="tab">Belum Bayar</a></li>
					<li><a href="#payment" data-toggle="tab">Menunggu Pengiriman</a></li>
					<li><a href="#shipment" data-toggle="tab">Telah Dikirim</a></li>
					<li><a href="#done" data-toggle="tab">Telah Terima</a></li>
					<li><a href="#reject" data-toggle="tab">Telah Ditolak</a></li>
					<li><a href="#cancel" data-toggle="tab">Telah Dibatalkan</a></li>
                </ul>

                <div class="tab-content">
					<div class="active tab-pane" id="pending">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_pending" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_pending); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_pending[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-pending', ['id' => $invoice_pending[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="approve">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_approve" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_approve); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_approve[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-approve', ['id' => $invoice_approve[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="payment">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_payment" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_payment); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_payment[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-payment', ['id' => $invoice_payment[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="shipment">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_shipment" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_shipment); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_shipment[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-shipment', ['id' => $invoice_shipment[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="done">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_done" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_done); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_done[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-done', ['id' => $invoice_done[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="tab-pane" id="cancel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_cancel" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_cancel); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_cancel[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-cancel', ['id' => $invoice_cancel[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="reject">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="data_table_invoice_reject" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr >
                                                        <th>No</th>
                                                        <th>Nomor Invoice</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($invoice_reject); $i++)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $invoice_reject[$i]->number }}</td>
                                                            <td>
                                                                <a href="{{ route('invoice.page-reject', ['id' => $invoice_reject[$i]->id]) }}" class="edit-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#data_table_invoice_pending').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            $('#data_table_invoice_approve').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            $('#data_table_invoice_payment').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            $('#data_table_invoice_shipment').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            $('#data_table_invoice_done').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            $('#data_table_invoice_cancel').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });

            $('#data_table_invoice_reject').DataTable({
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
            });
        });
    </script>
@endsection


