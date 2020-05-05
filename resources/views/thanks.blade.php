@extends('layouts.front');

@section('content')

    <h2 class="alert alert-success"> 
        Muito obrigado
    </h2>
    <h4> Seu pedido foi processado. Código do pedido:  <span class="text-success"> {{request()->get('order')}} </span>.</h4>
    
@endsection
