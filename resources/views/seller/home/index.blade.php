@extends('layouts.seller')

@section('header')
	<section class="content-header">
		<h1>
		Dashboard
		<small>Penjual</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Penjual</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $customer }}</h3>

                    <p>Pelanggan Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('seller.customer.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $supplier }}</h3>

                    <p>Pemasok Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('seller.supplier.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $product }}</h3>

                    <p>Produk Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <a href="{{ route('seller.product.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>0</h3>

                    <p>Penjualan Tertunda</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cube"></i>
                </div>
                <a href="{{ route('seller.selling-online.index') }}" class="small-box-footer">Info Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
