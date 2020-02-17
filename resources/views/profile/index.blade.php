@extends('layouts.app')

@section('header')
	<section class="content-header">
		<h1>
            Profile Member
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Member</a></li>
			<li class="active">Profile</li>
		</ol>
	</section>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-4">
			<div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Profile</h3>
                </div>
				<div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{ $data->name }}</h3>

                    <ul class="list-group list-group-unbordered">
						<li class="list-group-item">
                            <b>Email</b>
                            <p class="pull-right">{{ $data->email }}</p>
                        </li>
                        <li class="list-group-item">
							<b>Alamat</b>
							<p class="pull-right">{{ $data->location != null ? $data->location->address : "-"}}</p>
						</li>
						<li class="list-group-item">
							<b>Kecamatan</b>
							<p class="pull-right">{{ $data->location != null ? $data->location->sub_district : "-"}}</p>
						</li>
						<li class="list-group-item">
							<b>Kabupaten</b>
							<p class="pull-right">{{ $data->location != null ? $data->location->district : "-"}}</p>
						</li>
						<li class="list-group-item">
							<b>Provinsi</b>
							<p class="pull-right">{{ $data->location != null ? $data->location->province : "-"}}</p>
						</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#settings" data-toggle="tab">Pengaturan</a></li>
                    <li><a href="#password" data-toggle="tab">Kata Sandi</a></li>
					<li><a href="#location" data-toggle="tab">Lokasi</a></li>
                </ul>

                <div class="tab-content">
					<!-- setting -->
					<div class="active tab-pane" id="settings">
						<form class="form-horizontal" method="POST" id="formSetting">
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama</label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" value="{{ $data->name }}">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
			                    <div class="col-sm-offset-3 col-sm-9">
			                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
			                    </div>
		                  	</div>
						</form>
					</div>
                    <!-- end setting -->

                    <!-- password -->
					<div class="tab-pane" id="password">
						<form class="form-horizontal" method="POST" id="formPassword">
							<div class="form-group">
								<label class="col-sm-4 control-label">Kata Sandi Lama</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan Kata Sandi Lama">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Kata Sandi Baru</label>

								<div class="col-sm-8">
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan Kata Sandi Baru">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Konfirmasi Kata Sandi</label>

								<div class="col-sm-8">
									<input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Masukkan Konfirmasi Kata Sandi">

									<span class="help-block"></span>
								</div>
							</div>

							<div class="form-group">
			                    <div class="col-sm-offset-4 col-sm-8">
			                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
			                    </div>
		                  	</div>
						</form>
					</div>
                    <!-- password -->

                    <!-- location -->
					<div class="tab-pane" id="location">
						<form class="form-horizontal" method="POST" id="formLocation">
							<div class="form-group">
								<label class="col-sm-3 control-label">Alamat</label>

								<div class="col-sm-9">
									<textarea name="address" id="address" class="form-control" placeholder="Masukkan Alamat">{{ $data->location != null ? $data->location->address : ""}}</textarea>
									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Kecamatan</label>

								<div class="col-sm-9">
                                    <input type="text" name="sub_district" id="sub_district" class="form-control" placeholder="Masukkan Kecamatan" value="{{ $data->location != null ? $data->location->sub_district : ""}}">
									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Kabupaten</label>

								<div class="col-sm-9">
                                    <input type="text" name="district" id="district" class="form-control" placeholder="Masukkan Kabupaten" value="{{ $data->location != null ? $data->location->district : ""}}">
									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Provinsi</label>

								<div class="col-sm-9">
                                    <input type="text" name="province" id="province" class="form-control" placeholder="Masukkan Provinsi" value="{{ $data->location != null ? $data->location->province : ""}}">
									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
			                    <div class="col-sm-offset-3 col-sm-9">
			                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
			                    </div>
		                  	</div>
						</form>
					</div>
                    <!-- end setting -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#formSetting').submit(function (event) {
                event.preventDefault();
    		 	$('#formSetting button[type=submit]').button('loading');
    		 	$('#formSetting div.form-group').removeClass('has-error');
    	        $('#formSetting .help-block').empty();

    		 	var _data = $("#formSetting").serialize();

    		 	$.ajax({
                    url: "{{ route('profile.change-setting', ['id' => $data->id]) }}",
                    method: 'POST',
                    data: _data,
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

                        $('#formSetting')[0].reset();
                        $('#formSetting button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSetting').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formSetting input[name='" + data[key].name + "']").length )
                                        elem = $("#formSetting input[name='" + data[key].name + "']");
                                    else if( $("#formSetting textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formSetting textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formSetting select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
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
                        $('#formSetting button[type=submit]').button('reset');
                    }
                });
    		});

            $('#formPassword').submit(function (event) {
    			event.preventDefault();
    		 	$('#formPassword button[type=submit]').button('loading');
    			$('#formPassword div.form-group').removeClass('has-error');
    	        $('#formPassword .help-block').empty();

    		 	var _data = $("#formPassword").serialize();

    		 	$.ajax({
                    url: "{{ route('profile.change-password', ['id' => $data->id]) }}",
                    method: 'POST',
                    data: _data,
                    cache: false,

                    success: function (response) {
                        if ( response.success ) {
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
                        }
                        else{
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

                        $('#formPassword button[type=submit]').button('reset');
                        $('#formPassword')[0].reset();
                    },

    					error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formPassword').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formPassword input[name='" + data[key].name + "']").length ? $("#formPassword input[name='" + data[key].name + "']") : $("#formPassword select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
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
                        $('#formPassword button[type=submit]').button('reset');
                	}
                });
    		});

            $('#formLocation').submit(function (event) {
    			event.preventDefault();
    		 	$('#formLocation button[type=submit]').button('loading');
    			$('#formLocation div.form-group').removeClass('has-error');
    	        $('#formLocation .help-block').empty();

    		 	var _data = $("#formLocation").serialize();

    		 	$.ajax({
                    url: "{{ route('profile.change-location', ['id' => $data->id]) }}",
                    method: 'POST',
                    data: _data,
                    cache: false,

                    success: function (response) {
                        if ( response.success ) {
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
                        }
                        else{
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

                        $('#formLocation button[type=submit]').button('reset');
                        $('#formLocation')[0].reset();
                    },

    					error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formLocation').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formLocation input[name='" + data[key].name + "']").length )
                                        elem = $("#formLocation input[name='" + data[key].name + "']");
                                    else if( $("#formLocation textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formLocation textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formLocation select[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
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
                        $('#formLocation button[type=submit]').button('reset');
                	}
                });
    		});
        });
    </script>
@endsection

