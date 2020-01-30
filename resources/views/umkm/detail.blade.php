@extends('layouts.app')

@section('content')
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
                                    Nama UKM
                                </h4>
                            </div>
                            <div class="col-md-8">
                                <h4>
                                    {{ $item->user->name }}
                                </h4>
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
