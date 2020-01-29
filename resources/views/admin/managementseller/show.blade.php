@extends('layouts.admin')

@section('header')
    <h1>
        Detail Pengelola Penjual
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Pengelola Penjual</li>
        <li class="active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Photo
                    </h3>
                </div>
                <div class="box-body">
                    <img src="{{ asset('storage/'. $data->seller->document->photo)}}" style="width:100%; height:200px;">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        KTP
                    </h3>
                </div>
                <div class="box-body">
                    <img src="{{ asset('storage/'. $data->seller->document->ktp)}}" style="width:100%; height:200px;">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Dokumen
                    </h3>
                </div>
                <div class="box-body">
                    <img src="{{ asset('storage/'. $data->seller->document->document)}}" style="width:100%; height:200px;">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
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
                            {{ $data->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Email
                        </div>
                        <div class="col-md-8">
                            {{ $data->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. Handphone
                        </div>
                        <div class="col-md-8">
                            {{ $data->seller->phone }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Kategori
                        </div>
                        <div class="col-md-8">
                            {{ $data->seller->category->name }}
                        </div>
                    </div>
                </div>
                @if ($data->seller->status == "pending")
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
                        <h4 class="modal-title">Setujui Penjual</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menyetujui Penjual ini ?</p>

                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id" value="{{ $data->seller->id }}">
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
                        <h4 class="modal-title">Batalkan Penjual</h4>
                    </div>

                    <input type="hidden" id="id" name="id" value="{{ $data->seller->id }}">

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan Penjual ini ?</p>
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
                url = '{{ route("admin.management-seller.approve") }}';
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
                url = '{{ route("admin.management-seller.reject") }}';
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
