@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
            Lengkapi Data
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li class="active">Lengkapi Data</li>
		</ol>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="POST" id="formSeller">
                <div class="form-group">
                    <label class="col-sm-2 control-label">No. Handphone</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Handphone">

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Alamat</label>

                    <div class="col-sm-10">
                        <textarea name="address" id="address" class="form-control" placeholder="Masukkan Alamat"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Kecamatan</label>

                    <div class="col-sm-10">
                        <input type="text" name="sub_district" id="sub_district" class="form-control" placeholder="Masukkan Kecamatan">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Kabupaten</label>

                    <div class="col-sm-10">
                        <input type="text" name="district" id="district" class="form-control" placeholder="Masukkan Kabupaten">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Provinsi</label>

                    <div class="col-sm-10">
                        <input type="text" name="province" id="province" class="form-control" placeholder="Masukkan Provinsi">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Poto</label>

                    <div class="col-sm-10">
                        <input type="file" name="photo" id="photo" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">KTP</label>

                    <div class="col-sm-10">
                        <input type="file" name="ktp" id="ktp" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Dokumen</label>

                    <div class="col-sm-10">
                        <input type="file" name="document" id="document" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(document).ready(function($){
            $('#formSeller').submit(function (event) {
                event.preventDefault();
    		 	$('#formSeller button[type=submit]').button('loading');
    		 	$('#formSeller div.form-group').removeClass('has-error');
    	        $('#formSeller .help-block').empty();

    		 	var formData = new FormData($("#formSeller")[0]);

    		 	$.ajax({
                    url: "{{ route('seller.seller.index') }}",
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
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formSeller')[0].reset();
                        $('#formSeller button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSeller').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formSeller input[name='" + data[key].name + "']").length )
                                        elem = $("#formSeller input[name='" + data[key].name + "']");
                                    else if( $("#formSeller textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formSeller textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formSeller select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });

                            if(error['photo'] != undefined){
                                $("#formSeller input[name='photo']").parent().find('.help-block').text(error['photo']);
                                $("#formSeller input[name='photo']").parent().find('.help-block').show();
                                $("#formSeller input[name='photo']").parent().parent().addClass('has-error');
                            }

                            if(error['ktp'] != undefined){
                                $("#formSeller input[name='ktp']").parent().find('.help-block').text(error['ktp']);
                                $("#formSeller input[name='ktp']").parent().find('.help-block').show();
                                $("#formSeller input[name='ktp']").parent().parent().addClass('has-error');
                            }

                            if(error['document'] != undefined){
                                $("#formSeller input[name='document']").parent().find('.help-block').text(error['document']);
                                $("#formSeller input[name='document']").parent().find('.help-block').show();
                                $("#formSeller input[name='document']").parent().parent().addClass('has-error');
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
                        $('#formSeller button[type=submit]').button('reset');
                    }
                });
    		});
        });
    </script>
@endsection
