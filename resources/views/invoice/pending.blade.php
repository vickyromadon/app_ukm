@extends('layouts.app')

@section('header')
    <h1 class="mt-4 mb-3">Transaksi
        <small>Dibatalkan</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Dibatalkan</li>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3">Dapat Melakukan Transfer ke Bank di bawah ini :</th>
                            </tr>
                            <tr>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Pemilik</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $invoice->seller->bank->name }}</td>
                                <td>{{ $invoice->seller->bank->number }}</td>
                                <td>{{ $invoice->seller->bank->owner }}</td>
                            </tr>
                        </tbody>
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

    <div class="row">
        <div class="col-md-12">
            @if ($invoice->total > 0 AND $invoice->status == "pending" )
                <button id="btnPayment" class="btn btn-primary pull-right">
                    <i class="fa fa-dollar"></i>
                    Bayar
                </button>
            @endif

            @if ( $invoice->status == "pending" )
                <button id="btnCancel" class="btn btn-danger pull-left">
                    <i class="fa fa-close"></i>
                    Batal
                </button>
            @endif
        </div>
    </div>

    <!-- payment -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalPayment">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formPayment">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">

                    <div class="modal-header">
                        <h4 class="modal-title">Bayar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Silahkan Upload Bukti Transfer</p>
                        <input type="file" name="proof" id="proff" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- cancel -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalCancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="#" id="formCancel">
                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Batalkan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan pembayaran ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            // Payment
            $('#btnPayment').click(function () {
                url = '{{ route("invoice.payment") }}';
                $('#modalPayment').modal('show');
            });

            $('#formPayment').submit(function (event) {
                event.preventDefault();

                $('#modalPayment button[type=submit]').button('loading');
    		 	var formData = new FormData($("#formPayment")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 1000);
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#modalPayment button[type=submit]').button('reset');
                        $('#formPayment')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formPayment button[type=submit]').button('reset');
                    }
                });
            });

            // Cancel
            $('#btnCancel').click(function () {
                url = '{{ route("invoice.cancel") }}';
                $('#modalCancel').modal('show');
            });

            $('#formCancel').submit(function (event) {
                event.preventDefault();

                $('#modalCancel button[type=submit]').button('loading');
                var _data = $("#formCancel").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            setTimeout(function () {
    	                        location.reload();
    	                    }, 1000);
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#modalCancel button[type=submit]').button('reset');
                        $('#formCancel')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formCancel button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
