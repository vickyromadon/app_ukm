@extends('layouts.admin')

@section('header')
	<section class="content-header">
		<h1>
		Dashboard
		<small>Admin</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $member }}</h3>

                    <p>Member Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ route('admin.management-member.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $seller_approve }}</h3>

                    <p>UMKM Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('admin.management-seller.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $seller_pending }}</h3>

                    <p>UMKM Tertunda</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('admin.management-seller.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
