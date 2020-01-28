@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
             Detail Penjualan
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li>Penjualan</li>
			<li class="active">Detail</li>
		</ol>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Penjualan
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nomor</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->number }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Deskripsi</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->description }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Tanggal</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->date }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Status</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->status }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Pembeli
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Kode</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->code }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>No. Hp</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->phone }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Alamat Pembeli
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Alamat</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->location->address }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Kecamatan</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->location->sub_district }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Kabupaten</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->location->district }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Provinsi</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->customer->location->province }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                @if ($data->status == "pending")
                <div class="box-header with-border">
                    <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                @endif

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Status</th>
                                    <th>Tanggal di Buat</th>
                                    @if ($data->status == "pending")
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_selling as $item)
                                    <tr>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        @if ($data->status == "pending")
                                        <td>
                                            <a href="#" data-productid="{{ $item->id }}" class="btn btn-xs btn-danger delete-btn"><i class="fa fa-trash"></i></a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @if ($data->status == "pending")
                                <tr>
                                    <td colspan="8">
                                        <a href="#" id="btnDone" class="btn btn-success pull-right"><i class="fa fa-check"></i> Selesai</a>
                                    </td>
                                </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formAdd" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="selling_id" name="selling_id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Produk</label>

                                <div class="col-sm-9">
                                    <select class="js-example-basic-single form-control" name="product_id" id="product_id">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach ($product as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Kuantitas</label>

                                <div class="col-sm-9">
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Kuantitas">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Harga</label>

                                <div class="col-sm-9">
                                    <input type="number" id="price" name="price" class="form-control" placeholder="Masukkan Harga">
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

    {{-- done --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDone">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formDone">
                    <input type="hidden" name="selling_id" id="selling_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Selesai Penjualan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menyelesaikan penjualan ?</p>
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

    <!-- delete -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('seller.detail-selling.destroy', ['id' => '#']) }}" method="post" id="formDelete">
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
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function($){
            $(document).ready( function () {
                $('#data_table').DataTable({
                    "language": {
                        "emptyTable": "Tidak Ada Data Tersedia",
                    }
                });
            });

            $('.js-example-basic-single').select2({
                theme: "bootstrap"
            });

            var url;

            // add
            $('#btnAdd').click(function () {
                $('#formAdd')[0].reset();
                $('#formAdd .modal-title').text("Tambah Produk");
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd input[name="_method"]').remove();
                url = '{{ route("seller.detail-selling.store") }}';

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

                            $('#modalAdd').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
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
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['image'] != undefined){
                                $("#formAdd input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formAdd input[name='image']").parent().find('.help-block').show();
                                $("#formAdd input[name='image']").parent().parent().addClass('has-error');
                            }
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
                        $('#formAdd button[type=submit]').button('reset');
                    }
                });
            });

            // done
            $('#btnDone').click(function () {
                url = '{{ route("seller.detail-selling.done") }}';

                $('#modalDone').modal('show');
            });

            $('#formDone').submit(function (event) {
                event.preventDefault();
                $('#formDone div.form-group').removeClass('has-error');
                $('#formDone .help-block').empty();
                $('#formDone button[type=submit]').button('loading');

                var formData = new FormData($("#formDone")[0]);

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

                        $('#formDone button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formDone').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formDone input[name='" + data[key].name + "']").length )
                                        elem = $("#formDone input[name='" + data[key].name + "']");
                                    else if( $("#formDone select[name='" + data[key].name + "']").length )
                                        elem = $("#formDone select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formDone textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().find('.help-block').css("color", "red");
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['image'] != undefined){
                                $("#formDone input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formDone input[name='image']").parent().find('.help-block').show();
                                $("#formDone input[name='image']").parent().find('.help-block').css("color", "red");
                                $("#formDone input[name='image']").parent().parent().addClass('has-error');
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
                        $('#formDone button[type=submit]').button('reset');
                    }
                });
            });

            // Delete
            $('#data_table').on('click', '.delete-btn' , function(e){
                url =  $('#formDelete').attr('action').replace('#', $(this).data('productid'));
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
        });
    </script>
@endsection
