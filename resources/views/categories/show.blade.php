@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">E-Commerce Demo</h1>
    <h2>{{ $category->name }}</h2>

    @if($products->count())
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-3">
            <div class="card p-2">
                <h5>{{ $product->name }}</h5>
                <p>Price: ${{ $product->price }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>No products found in this category.</p>
    @endif
</div>
@endsection
