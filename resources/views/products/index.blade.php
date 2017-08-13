@extends('layouts.main')
@section('content')
    <div class="product-list">
        <h1>
            <em>Welcome</em> to the Beestream store
        </h1>
        @foreach ($products as $product) 
               
            <h3>
                {{$product->name}}
            </h3>

        @endforeach
    </div>
@endsection
