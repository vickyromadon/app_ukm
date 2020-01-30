@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach ($seller as $item)
            <div class="col-md-6">
                <div class="box box-degfault">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title ">{{ $item->user->name }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{asset('images/umkm_default.png')}}" style="width:100%; height:200px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    No. HP
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->phone }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    Email
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->user->email }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    Tanggal Tergabung
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->user->email }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    Alamat
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->location->address }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    Kecamatan
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->location->sub_district }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    Kabupaten
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->location->district }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h4 style="font-weight:bolder;">
                                    Provinsi
                                </h4>
                            </div>
                            <div class="col-md-10">
                                <h4>
                                    : {{ $item->location->province }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ route('umkm.detail', ['id' => $item->id]) }}" class="btn btn-info">
                            <i class="fa fa-eye"></i>
                            Lihat UMKM
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $seller->links() }}
            </div>
        </div>
    </div>
@endsection
