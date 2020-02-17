@extends('layouts.admin')

@section('header')
    <h1>
        Detail Pembayaran Online
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Pembayaran Online</li>
        <li class="active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Pembeli
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            Nama
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Email
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Alamat
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->location->address }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Kecamatan
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->location->sub_district }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Kabupaten
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->location->district }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Provinsi
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->location->province }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Penjual
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            Nama
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->user->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Email
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->user->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. HP
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->phone }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Alamat
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->user->location->address }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Kecamatan
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->location->sub_district }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Kabupaten
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->location->district }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Provinsi
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->location->province }}
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
                        Detail Bank Rekening Bersama
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            Nama
                        </div>
                        <div class="col-md-8">
                            {{ $data->bank->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. Rekening
                        </div>
                        <div class="col-md-8">
                            {{ $data->bank->number }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Nama Pemilik
                        </div>
                        <div class="col-md-8">
                            {{ $data->bank->owner }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Bank Penjual
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            Nama
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->bank->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. Rekening
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->bank->number }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Nama Pemilik
                        </div>
                        <div class="col-md-8">
                            {{ $data->invoice->seller->bank->owner }}
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
                    <h3 class="box-title">
                        Detail Barang Yang Dibeli
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data->invoice->invoice_carts as $item)
                                        <td>{{ $item->cart->product->name }}</td>
                                        <td>{{ $item->cart->quantity }}</td>
                                        <td>{{ $item->cart->price }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Subtotal</th>
                                    <th>{{ $data->invoice->subtotal }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Ongkos Kirim</th>
                                    <th>{{ $data->invoice->shipping }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th>{{ $data->invoice->total }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($data->invoice->refund_dana == null)
        <div class="row">
            <div class="col-md-12">
                <a id="btnRefundDana" class="btn btn-primary pull-right">
                    Kembalikan Dana
                </a>
            </div>
        </div>
    @endif

    <!-- refund-dana -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalRefundDana">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formRefundDana">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Mengembalikan Dana</h4>
                    </div>

                    <input type="hidden" name="invoice_id" value="{{ $data->invoice->id }}">
                    <input type="hidden" name="seller_id" value="{{ $data->invoice->seller->id }}">
                    <input type="hidden" name="nominal" value="{{ $data->nominal }}">

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin mengembalikan dana ini ?</p>
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
            var url;

            // send
            $('#btnRefundDana').click(function () {
                url = '{{ route("admin.payment.refund-dana") }}';
                $('#modalRefundDana').modal('show');
            });

            $('#formRefundDana').submit(function (event) {
                event.preventDefault();
                $('#formRefundDana button[type=submit]').button('loading');

                var formData = new FormData($("#formRefundDana")[0]);

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

                            $('#modalRefundDana').modal('hide');

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

                        $('#formRefundDana button[type=submit]').button('reset');
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
                        $('#formRefundDana button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
