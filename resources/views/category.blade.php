@extends('layouts.front')

@section('content')
<div class="row front">
    <div class="col-12 text-center text-primary"> <h2>{{$category->name}}</h2> <hr> </div>
    
        
            @forelse($category->products as $key => $product)
        
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
        
            
        @empty
            <div class="col-12"> <h3 class="alert alert-warning"> Nenhum produto encontrado para esta categoria</h3> </div>
            
        @endforelse
    
</div>


@endsection