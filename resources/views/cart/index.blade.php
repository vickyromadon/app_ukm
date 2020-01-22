@extends('layouts.app')

@section('content')
    <div class="box box-default">

        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($cart); $i++)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('product.show', ['id' => $cart[$i]->product->id]) }}">
                                        {{ $cart[$i]->product->name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($cart[$i]->product->image != null)
                                        <img class="img-fluid rounded" src="{{ asset('storage/'. $cart[$i]->product->image)}}" style="width:150px; height:150px;">
                                    @else
                                        <img class="img-fluid rounded" src="{{ asset('images/book.jpg') }}" style="width:150px; height:150px;">
                                    @endif
                                </td>
                                <td>{{ $cart[$i]->quantity }}</td>
                                <td>Rp. {{ number_format($cart[$i]->price) }}</td>
                                <td>
                                    <a href="#" data-cartid="{{ $cart[$i]->id }}" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> &nbsp;
                                    <a href="#" data-cartid="{{ $cart[$i]->id }}" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endfor
                        @if ( count($cart) > 0 )
                            <tr>
                                <td colspan="4">
                                    <h3>Total</h3>
                                </td>
                                <td colspan="2">
                                    <h3>Rp. {{ number_format($total_cart) }}</h3>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ( count($cart) > 0 )
            <div class="box-footer">
                <a href="#" class="btn btn-info btn-sm pull-right" id="btnCheckout"><i class="fa fa-money"></i> Lanjut Pembayaran</a>
            </div>
        @endif
    </div>

    <!-- edit cart -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAdd">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="post" id="formAdd" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="cart_id" name="cart_id">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jumlah</label>

                                <div class="col-sm-9">
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Jumlah" min="1">
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
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('cart.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                    {{ method_field('DELETE') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menghapus Produk ?</p>
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

    <!-- checkout -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalCheckout">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formCheckout">
                    <div class="modal-header">
                        <h4 class="modal-title">Lanjut Pembayaran</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin melanjutkan pembayaran ?</p>
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
            $(document).ready( function () {
                $('#data_table').DataTable({
                    "language": {
                        "emptyTable": "Tidak Ada Data Tersedia",
                    }
                });
            });

            // Edit
            $('#data_table').on('click', '.edit-btn', function(e){
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd .modal-title').text("Ubah Produk");
                $('#formAdd')[0].reset();
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("cart.index") }}' + '/' + $(this).data('cartid');

                $('#modalAdd').modal('show');
            });

            $('#formAdd').submit(function (event) {
                event.preventDefault();
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('loading');

                var formData = new FormData($("#formAdd")[0]);

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
    	                    }, 2000);
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

                        $('#formAdd button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formAdd').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formAdd input[name='" + data[key].name + "']").length )
                                        elem = $("#formAdd input[name='" + data[key].name + "']");
                                    else if( $("#formAdd select[name='" + data[key].name + "']").length )
                                        elem = $("#formAdd select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formAdd textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['image'] != undefined){
                                $("#formAdd input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formAdd input[name='image']").parent().find('.help-block').show();
                                $("#formAdd input[name='image']").parent().find('.help-block').css("color", "red");
                                $("#formAdd input[name='image']").parent().parent().addClass('has-error');
                            }
                        }
                        else if (response.status === 400) {
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
                        $('#formAdd button[type=submit]').button('reset');
                    }
                });
            });

            // Delete
            $('#data_table').on('click', '.delete-btn' , function(e){
                url =  $('#formDelete').attr('action').replace('#', $(this).data('cartid'));
                $('#modalDelete').modal('show');
            });

            $('#formDelete').submit(function (event) {
                event.preventDefault();

                $('#modalDelete button[type=submit]').button('loading');
                var _data = $("#formDelete").serialize();

                $.ajax({
                    url: url,
                    type: 'DELETE',
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
    	                    }, 2000);
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
                        $('#modalDelete button[type=submit]').button('reset');
                        $('#formDelete')[0].reset();
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

                        $('#formDelete button[type=submit]').button('reset');
                    }
                });
            });

            // checkout
            $('#btnCheckout').click(function () {
                $('#modalCheckout').modal('show');
            });

            $('#formCheckout').submit(function (event) {
                event.preventDefault();

                $('#modalCheckout button[type=submit]').button('loading');
                var _data = $("#formCheckout").serialize();

                $.ajax({
                    url: '{{ route("invoice.store") }}',
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
    	                    }, 2000);
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
                        $('#modalCheckout button[type=submit]').button('reset');
                        $('#formCheckout')[0].reset();
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

                        $('#formCheckout button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
