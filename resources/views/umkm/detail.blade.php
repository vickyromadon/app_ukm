@extends('layouts.app')

@section('content')
    <div class="row">
         <div class="col-md-12">
            <div class="box box-degfault">
                <div class="box-header with-border">
                    <center>
                        <h3 class="box-title">
                            Infomasi Tentang UMKM
                        </h3>
                    </center>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Nama</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->user->name }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Email</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->user->email }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Nomor Handphone</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->phone }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Alamat</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->location->address }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Kecamatan</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->location->sub_district }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Kabupaten</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->location->district }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Provinsi</b>
                                </div>
                                <div class="col-md-8">
                                    {{ $seller->location->province }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
    <div class="row">
        @foreach ($product as $item)
            <div class="col-md-4">
                <div class="box box-degfault">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title ">{{ $item->name }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($item->image != null && $item->image != "-")
                                    <img src="{{ asset('storage/'. $item->image)}}" style="width:100%; height:200px;">
                                @else
                                    <img src="{{asset('images/product_default.png')}}" style="width:100%; height:200px;">
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h4 style="font-weight:bolder;">
                                    Harga
                                </h4>
                            </div>
                            <div class="col-md-8">
                                <h4>
                                    Rp. {{ number_format($item->selling_price) }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h4 style="font-weight:bolder;">
                                    Tersedia
                                </h4>
                            </div>
                            <div class="col-md-8">
                                <h4>
                                    {{ $item->stock }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ route('product.show', ['id' => $item->id]) }}" class="btn btn-info">
                            <i class="fa fa-eye"></i>
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $product->links() }}
            </div>
        </div>
    </div>
@endsection
