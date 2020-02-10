@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('storage/'. $product->image)}}" style="width:100%;">
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <h2 style="margin:0px; padding:0px;">{{ $product->name }}</h2>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h2 style="margin:0px; padding:0px;">Rp. {{ number_format($product->selling_price) }}</h2>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p style="font-weight:bolder;">Deskripsi : </p>
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h4 style="font-weight:bolder; margin:0px; padding:0px;">Jumlah : {{ $product->stock }} </h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h3 style="font-weight:bolder; margin:0px; padding:0px;">
                        <i class="fa fa-university"></i>
                        <a href="{{ route('umkm.detail', ['id' => $product->user->seller->id]) }}">
                            {{ $product->user->name }}
                        </a>
                    </h3>
                </div>
            </div>
            @if (Auth::user())
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <a id="btnCart" class="btn btn-primary btn-lg">
                            <i class="fa fa-cart-plus"></i>
                            Tambah Keranjang
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- add cart -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalCart">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="post" id="formCart" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jumlah</label>

                                <div class="col-sm-9">
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Jumlah" min="1" max="{{ $product->quantity }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Tambah
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
            // add cart
            $('#btnCart').click(function () {
                $('#formCart')[0].reset();
                $('#formCart .modal-title').text("Tambah Keranjang");
                $('#formCart div.form-group').removeClass('has-error');
                $('#formCart .help-block').empty();
                $('#formCart button[type=submit]').button('reset');

                $('#formCart input[name="_method"]').remove();

                $('#modalCart').modal('show');
            });

            $('#formCart').submit(function (event) {
                event.preventDefault();
                $('#formCart button[type=submit]').button('loading');
                $('#formCart div.form-group').removeClass('has-error');
                $('#formCart .help-block').empty();

                var formData = new FormData($("#formCart")[0]);

                $.ajax({
                    url: "{{ route('cart.store') }}",
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
                        }
                        else{
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
                        $('#formCart button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up

                            var error = response.responseJSON.errors;
                            var data = $('#formCart').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formCart input[name='" + data[key].name + "']").length )
                                        elem = $("#formCart input[name='" + data[key].name + "']");
                                    else if( $("#formCart textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formCart textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formCart select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
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
                        $('#formCart button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
