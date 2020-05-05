@extends('layouts/app')
    
    @section('content')
    @if (!$store)
    <a href="{{route('admin.stores.create') }}"class="btn btn-lg btn-success text-center" > Criar Loja </a>
   
    @else
        <hr>
        <table class="table table-striped pt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th> Loja </th>
                    <th> Total de produtos </th>
                    <th> Ações </th>
                </tr>
            </thead>
            <tbody>
                
                    <tr>
                        <td> {{ $store->id }} </td>
                        <td> {{ $store->name }}  </td>
                        <td> {{ $store->products->count() }} </td>
                        <td> 
                            <div class="btn-group">

                                <a href="{{ route('admin.stores.edit', ['store' => $store->id]) }}" class="btn btn-info btn-sm"> Editar </a>
                                <form action="{{ route('admin.stores.destroy', ['store' => $store->id]) }}" method="POST">
                                    @csrf
                                    @method("DELETE")

                                <button type="submit" class="btn btn-danger btn-sm"> Remover </button>
                                </form>
                            </div>
                        </td>
                    </tr>
            
            </tbody>
        </table>

        @endif
    @endsection
    
