@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Produk
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li class="active">Produk</li>
		</ol>
	</section>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-header with-border">
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Tersedia</th>
                            <th>Status</th>
                            <th>Tanggal di Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
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
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama</label>

                                <div class="col-sm-9">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama">
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
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tersedia</label>

                                <div class="col-sm-9">
                                    <input type="number" id="stock" name="stock" class="form-control" placeholder="Masukkan Tersedia">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Minimal Tersedia</label>

                                <div class="col-sm-9">
                                    <input type="number" id="minimum_stock" name="minimum_stock" class="form-control" placeholder="Masukkan Minimal Tersedia">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Deskripsi</label>

                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" placeholder="Masukkan Deskripsi"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Gambar</label>

                                <div class="col-sm-9">
                                    <input type="file" id="image" name="image" class="form-control" placeholder="Masukkan Gambar">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Satuan</label>

                                <div class="col-sm-9">
                                    <select name="unit_id" id="unit_id" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->id }}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jenis</label>

                                <div class="col-sm-9">
                                    <select name="type_id" id="type_id" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach ($type as $item)
                                            <option value="{{ $item->id }}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status</label>

                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        <option value="publish">Aktif</option>
                                        <option value="no publish">Tidak Aktif</option>
                                    </select>
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
                <form action="{{ route('seller.product.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                	{{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Hapus Produk</h4>
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

    <!-- view -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalView">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table style="border-spacing: 10px; border-collapse: separate;">
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td id="code"></td>
                        </tr>
                        <tr>
                            <th>Gambar</th>
                            <td>:</td>
                            <td id="image"><img src="#" class="img-thumbnail" style="height:40vh; width:50vh;"></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <th>Tersedia</th>
                            <td>:</td>
                            <td id="stock"></td>
                        </tr>
                        <tr>
                            <th>Minimal Tersedia</th>
                            <td>:</td>
                            <td id="minimum_stock"></td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>:</td>
                            <td id="price"></td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>:</td>
                            <td id="unit"></td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>:</td>
                            <td id="type"></td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>:</td>
                            <td id="description"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:</td>
                            <td id="status"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
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
                    "url": "{{ route('seller.product.index') }}",
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
                        "data": "code",
                        "orderable": true,
                    },
                    {
                        "data": "name",
                        "orderable": true,
                    },
                    {
                        "data": "price",
                        "orderable": true,
                    },
                    {
                        "data": "stock",
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="view-btn btn btn-xs btn-info"><i class="fa fa-eye"></i></a> &nbsp' +
                                    '<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 6, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
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
                url = '{{ route("seller.product.store") }}';

                $('#modalAdd').modal('show');
            });

            // Edit
            $('#data_table').on('click', '.edit-btn', function(e){
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd .modal-title').text("Ubah Produk");
                $('#formAdd')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("seller.product.index") }}' + '/' + aData.id;

                $('#id').val(aData.id);
                $('#name').val(aData.name);
                $('#stock').val(aData.stock);
                $('#price').val(aData.price);
                $('#minimum_stock').val(aData.minimum_stock);
                $('#description').val(aData.description);
                $('#unit_id').val(aData.unit_id);
                $('#type_id').val(aData.type_id);
                $('#status').val(aData.status);

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
                            table.draw();
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

            // Delete
            $('#data_table').on('click', '.delete-btn' , function(e){
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                url =  $('#formDelete').attr('action').replace('#', aData.id);
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
                            table.draw();

                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

                            $('#modalDelete').modal('toggle');
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
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }

                        $('#formDelete button[type=submit]').button('reset');
                    }
                });
            });

            // View
            $('#data_table').on('click', '.view-btn', function(e){
                $('#modalView .modal-title').text("Lihat Produk");

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                $('#modalView #code').text(aData.code);
                $('#modalView #name').text(aData.name);
                $('#modalView #image img').attr("src", "{{ asset('storage/')}}" + "/" + aData.image);
                $('#modalView #description').text(aData.description);
                $('#modalView #stock').text(aData.stock);
                $('#modalView #price').text(aData.price);
                $('#modalView #minimum_stock').text(aData.minimum_stock);
                $('#modalView #unit').text(aData.unit.name);
                $('#modalView #type').text(aData.type.name);

                if (aData.status == 'publish') {
                    $('#modalView #status').text("Aktif");
                } else {
                    $('#modalView #status').text("Tidak Aktif");
                }

                $('#modalView').modal('show');
            });
        });
    </script>
@endsection
