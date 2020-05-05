@extends('layouts.front');

@section('content')

    <div class="row">
        <div class="col-12">
            <h2> Pedidos Recebidos</h2>
            <hr>
        </div>

        <div class="col-12 pt-4">
            <div class="accordion" id="accordionExample">

                @forelse ($userOrders as $key => $order)
                
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                            Pedido n°: {{$order->reference}}
                        </button>
                    </h2>
                    </div>
                    <div id="collapse{{$key}}" class="collapse @if($key == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">

                        <ul>
                            @php
                                $items = unserialize($order->items);
                            @endphp
                            @foreach ($items as $item)

                                <li>{{ $item['name'] }} | <span class="text-success">R$ {{ number_format($item['price'] * $item['amount'], 2, ',', '.') }}</span> 
                                <br>
                                Quantidade: {{$item['amount']}}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    </div>
                </div>

                @empty
                    <div class="alert alert_warning"> Nenhum pedido recebido! </div>
                @endforelse
            </div>

            <div class="pt-2"> {{$userOrders->links() }} </div>
        </div>
    </div>
    
@endsection
