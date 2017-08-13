@extends('layouts.main')
@section('content')
	@foreach($products as $product)
		<checkout-form :product="{{$product}}"></checkout-form>
	@endforeach
@endsection
