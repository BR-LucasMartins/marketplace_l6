@extends('layouts.front')

@section('content')
   <div class="row front">
    <div class="col-12 text-center text-primary"> <h2>Produtos em Destaque</h2> </div>
    <hr>
    @foreach ($products as $key => $product)
    
    <div class="col-md-4 pt-5">
        
        <div class="card" style="width: 90%;">

            @if ($product->photos->count())
                <img style="width: 310px; height: 200px; padding-left: 5px; padding-top: 2px;" src="{{ asset('storage/'.$product->photos->first()->image) }}" alt="">
            @else
            <img style="width: 310px; height: 200px; padding-left: 5px; padding-top: 2px;" src="{{ asset('assets/img/no-photo.jpg') }}" alt="">
            @endif

            <div class="card-body">
                    <h2 class="card-title"> {{ $product->name }}</h2>
                    <p class="card-text"> {{ $product->description }} </p>
                    <h3> R$ {{ number_format($product->price, 2, ',', '.') }} </h3>
                    <a href="{{route('product.single', ['slug' => $product->slug])}}" class="btn btn-success"> Ver produto</a>
            </div>
        </div>
    </div>

    @if (($key + 1)%3==0)
    </div> <div class="row front"> @endif

@endforeach
   </div>

<div class="clas row">

    <div class="col-12 text-center text-primary"> <h2>Lojas em Destaque</h2> </div>
    
    @foreach ($stores as $store)

    <div class="col-4 pt-5">

        @if ($store->logo)
        <img  src="{{asset('storage/'. $store->logo)}}" alt="Logo da loja {{$store->name}}" class="img-fluid">
        @else
            <img style="width: 310px; height: 200px; padding-left: 5px; padding-top: 2px;"src="https://via.placeholder.com/350X200.png?text=logo" alt="Loja sem logo cadastrada">
        @endif
        <h3> {{$store->name }}</h3>
        <p> {{$store->description }} </p>
        
        <a href="{{route('store.single',['slug' => $store->slug])}}" class="btn btn-success btn-sm"> Ver Loja</a>
    </div>

    @endforeach
</div>


@endsection