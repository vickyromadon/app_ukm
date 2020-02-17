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
                            @if ($data->status == 'pending')
                                Menunggu Konfirmasi
                            @elseif ($data->status == 'approve')
                                Belum Bayar
                            @elseif ($data->status == 'payment')
                                Menunggu Pengiriman
                            @elseif ($data->status == 'shipment')
                                Telah Dikirim
                            @elseif ($data->status == 'done')
                                Telah Diterima
                            @elseif ($data->status == 'reject')
                                Telah Ditolak
                            @elseif ($data->status == 'cancel')
                                Telah Dibatalkan
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
                    <div class="row">
                        <div class="col-md-4">
                            <b>Alamat</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->user->location->address }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Kecamatan</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->user->location->sub_district }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Kabupaten</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->user->location->district }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>Provinsi</b>
                        </div>
                        <div class="col-md-8">
                            {{ $data->user->location->province }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($data->status == "reject")
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Alasan Penolakan</h3>
                    </div>
                    <div class="box-body">
                        {{ $data->reason }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($data->status != "pending" AND $data->status != "cancel" AND $data->status != "reject")
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
            <div class="row">
                <div class="col-md-12">
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
            @if ($data->status == "shipment" OR $data->status == "done")
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    Detail Pengiriman
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <b>Jenis Pengiriman</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $data->receipt_type }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <b>Nomor Pengiriman</b>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $data->receipt_number }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

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
                                    <h4>Subtotal</h4>
                                </td>
                                <td>
                                    <h4>Rp. {{ number_format($data->subtotal) }}</h4>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h4>Ongkos Kirim</h4>
                                </td>
                                <td>
                                    <h4>Rp. {{ number_format($data->shipping) }}</h4>
                                    @if ($data->status == "pending" AND $data->shipping == 0)
                                        <a id="btnShipping" class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i> Tambah Ongkos Kirim</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h4>Total</h4>
                                </td>
                                <td>
                                    <h4>Rp. {{ number_format($data->total) }}</h4>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="box-footer">
                    @if ($data->status == "pending")
                        <a id="btnReject" class="btn btn-danger pull-left">
                            <i class="fa fa-close"></i>
                            Tolak
                        </a>
                        @if ($data->shipping > 0)
                            <a id="btnApprove" class="btn btn-success pull-right">
                                <i class="fa fa-check"></i>
                                Setuju
                            </a>
                        @endif
                    @endif
                </div>
                @if ($data->status == "payment")
                    <div class="box-footer">
                        <a id="btnSend" class="btn btn-primary pull-right">
                            <i class="fa fa-truck"></i>
                            Kirim Barang
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
                            <input type="hidden" name="id" value="{{ $data->id }}">
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

    <!-- send -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalSend">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formSend">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Pengiriman Barang</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin melakukan pengiriman barang ?</p>

                        <div class="form-horizontal">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <select name="receipt_type" id="receipt_type" class="form-control" required>
                                <option value="">-- Pilih Jenis Pengiriman --</option>
                                <option value="JNE">JNE</option>
                                <option value="TIKI">TIKI</option>
                                <option value="SICEPAT">SICEPAT</option>
                                <option value="JET EXPRESS">JET EXPRESS</option>
                                <option value="J&T">J&T</option>
                            </select>
                            <input class="form-control" type="text" name="receipt_number" id="receipt_number" placeholder="Masukkan Nomor Resi Pengiriman" required>
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

                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan Belanja Online ini ?</p>
                        <textarea name="reason" id="reason" class="form-control" placeholder="Masukkan Alasan Membatalkan"></textarea>
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

    <!-- shiping -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalShipping">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formShipping">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Masukkan Harga Untuk Ongkos Kirim</h4>
                    </div>

                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="modal-body">
                        <p id="del-success">Pastikan Anda Memasukkan Ongkos Kirim dengan Benar ?</p>
                        <input type="number" class="form-control" name="shipping" id="shipping" placeholder="Masukkan Ongkos Kirim" required>
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

            // send
            $('#btnSend').click(function () {
                url = '{{ route("seller.selling-online.send") }}';
                $('#modalSend').modal('show');
            });

            $('#formSend').submit(function (event) {
                event.preventDefault();
                $('#formSend button[type=submit]').button('loading');

                var formData = new FormData($("#formSend")[0]);

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

                            $('#modalSend').modal('hide');

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

                        $('#formSend button[type=submit]').button('reset');
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
                        $('#formSend button[type=submit]').button('reset');
                    }
                });
            });

            // shipping
            $('#btnShipping').click(function () {
                url = '{{ route("seller.selling-online.add-shipping") }}';
                $('#modalShipping').modal('show');
            });

            $('#formShipping').submit(function (event) {
                event.preventDefault();
                $('#formShipping button[type=submit]').button('loading');

                var formData = new FormData($("#formShipping")[0]);

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

                            $('#modalShipping').modal('hide');

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

                        $('#formShipping button[type=submit]').button('reset');
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
                        $('#formShipping button[type=submit]').button('reset');
                    }
                });
            });

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
