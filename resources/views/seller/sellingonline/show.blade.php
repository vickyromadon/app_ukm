@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Detail Penjualan Online
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li>Penjualan Online</li>
			<li class="active">Detail</li>
		</ol>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Invoice</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nomor Invoice</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->number }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Total</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->total }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Status</b>
                        </div>
                        <div class="col-md-8">
                            @if ($data->status == "payment")
                                Menunggu Konfirmasi
                            @elseif($data->status == "approve")
                                Telah Disejui
                            @else
                                Telah Ditolak
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Pembeli</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nama</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->user->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Email</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->user->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Pembayaran
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nominal</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->payment->nominal }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Tanggal Transfer</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->payment->created_at }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Bukti Transfer</b>
                        </div>
                        <div class="col-md-8">
                            <img src="{{ asset('storage/'. $data->payment->proof)}}" style="width:100%; height:200px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Bank Transfer
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nama</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->payment->bank->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>No. Rekening</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->payment->bank->number }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nama Pemilik</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->payment->bank->owner }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class>Detail Belanja Produk</h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jumlah</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->invoice_carts as $item)
                                <tr>
                                    <td>{{ $item->cart->quantity }}</td>
                                    <td>{{ $item->cart->product->code }}</td>
                                    <td>{{ $item->cart->product->name }}</td>
                                    <td>Rp. {{ number_format($item->cart->product->price) }}</td>
                                    <td>Rp. {{ number_format($item->cart->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <h3>Total</h3>
                                </td>
                                <td>
                                    <h3>Rp. {{ number_format($data->total) }}</h3>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if ($data->status == "payment")
                    <div class="box-footer">
                        <a id="btnReject" class="btn btn-danger pull-left">
                            <i class="fa fa-close"></i>
                            Tolak
                        </a>
                        <a id="btnApprove" class="btn btn-success pull-right">
                            <i class="fa fa-check"></i>
                            Setuju
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- approve -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalApprove">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formApprove">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Setujui Belanja Online</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menyetujui Belanja Online ini ?</p>

                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                        </div>
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

    <!-- reject -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalReject">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formReject">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Batalkan Belanja Online</h4>
                    </div>

                    <input type="hidden" id="id" name="id" value="{{ $data->id }}">

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan Belanja Online ini ?</p>
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

@section('js')]
    <script>
        jQuery(document).ready(function($){
            var url;

            // approve
            $('#btnApprove').click(function () {
                url = '{{ route("seller.selling-online.approve") }}';
                $('#modalApprove').modal('show');
            });

            $('#formApprove').submit(function (event) {
                event.preventDefault();
                $('#formApprove button[type=submit]').button('loading');

                var formData = new FormData($("#formApprove")[0]);

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

                            $('#modalApprove').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                        else {
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

                        $('#formApprove button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
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
                        }
                        else {
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
                        $('#formApprove button[type=submit]').button('reset');
                    }
                });
            });

            // reject
            $('#btnReject').click(function () {
                url = '{{ route("seller.selling-online.reject") }}';
                $('#modalReject').modal('show');
            });

            $('#formReject').submit(function (event) {
                event.preventDefault();
                $('#formReject button[type=submit]').button('loading');

                var formData = new FormData($("#formReject")[0]);

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

                            $('#modalReject').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                        else {
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

                        $('#formReject button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
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
                        }
                        else {
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
                        $('#formReject button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
