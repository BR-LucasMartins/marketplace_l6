@extends('layouts/app');

@section('content')
    <h1> Criar loja</h1>

    <form action="{{route('admin.stores.store')}}" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 

        <div class="form-group">
            <label for="">Nome Loja</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

            @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control  @error('description') is-invalid @enderror" value="{{ old('description') }}">

            @error('description')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Telefone</label>
            <input type="text" name="phone" id="phone" class="form-control  @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            @error('phone')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Celular/Whatssapp</label>
            <input type="text" name="mobile_phone" class="form-control @error('mobile_phone') is-invalid @enderror" value="{{ old('mobile_phone') }}" >
            @error('mobile_phone')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror

        </div>

        <div class="form-grop">
            <label for="">Fotos do produto </label>
            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" >

            @error('logo') 
               <div class="clas invalid-feedback">
                   {{ $message }}
               </div>
            @enderror
        </div>

        
        <div class="pt-4 text-center">
            <button type="submit" class="btn btn-lg btn-success "> criar Loja</button>
        </div>
    </form>

@endsection

@section('scripts')

    <script>
    
        let imPhone = new Imputmask('(99) 9999-9999');
        imPhone.mask(document.getElementById('phone'));
    </script>

@endsection
