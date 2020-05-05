@extends('layouts.front');

@section('content')
    <div class="row">
        <div class="col-6">
            @if ($product->photos->count())
                <img class="img-fluid" src="{{ asset('storage/'.$product->photos->first()->image) }}" alt="">
                
                <div class="row">
                    @foreach ($product->photos as $photo)
                    <div class="col-4">
                        <img class="img-fluid pt-2" src="{{ asset('storage/'.$photo->image)}}" alt="">
                    </div>
                    @endforeach
                    
                </div>
            @else
            <img class="img-fluid" src="{{ asset('assets/img/no-photo.jpg') }}" alt="">
            @endif
        </div>

        <div class="col-6 pl-5">
            <div>
                <h2> {{$product->name }}</h2>
                <p>
                    {{$product->description}}
                </p>
                <h3> R$ {{ number_format($product->price, 2, ',', '.') }} </h3>

                <span> Loja: {{$product->store->name }}</span>
            </div>

            <div class="product-add pt-3">
                <form action="{{ route('cart.add') }}" method="post">

                    @csrf
                    <input type="hidden" name="product[name]" value="{{ $product->name }}">
                    <input type="hidden" name="product[price]" value="{{ $product->price }}">
                    <input type="hidden" name="product[slug]" value="{{ $product->slug }}">

                    <div class="form-group">
                        <label> Quantidade </label>
                        <input class="form-control col-md-2" type="number" value="1" name="product[amount]" id="">
                    </div>

                    <button class="btn btn-lg btn-danger" type="submit"> Comprar  </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col12">
            <hr>
            {{$product->body}}
        </div>
    </div>
@endsection