@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Tentang UKM</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <img src="{{ asset('images/logo-ukm.png') }}" style="width:50vh; height:30vh;">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>e-UKM Indonesia</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <p>
                Usaha Kecil dan Menengah disingkat UKM adalah sebuah istilah yang mengacu ke jenis usaha kecil yang memiliki kekayaan bersih paling banyak Rp 200.000.000 tidak termasuk tanah dan bangunan tempat usaha. Dan usaha yang berdiri sendiri. Menurut Keputusan Presiden RI no. 99 tahun 1998 pengertian Usaha Kecil adalah: “Kegiatan ekonomi rakyat yang berskala kecil dengan bidang usaha yang secara mayoritas merupakan kegiatan usaha kecil dan perlu dilindungi untuk mencegah dari persaingan usaha yang tidak sehat.”
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <img src="{{ asset('images/mikroskil.jpg') }}" style="width:50vh; height:30vh;">
        </div>
    </div>
@endsection
