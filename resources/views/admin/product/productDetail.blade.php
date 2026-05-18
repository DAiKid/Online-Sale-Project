@extends('admin/layout/master')

@section('content')
    <div class='container'>
        <a href="{{ route('product#list') }}" class="btn btn-sm shadow-sm bg-dark text-white rounded">Back</a>
        <div class="row mt-2 shadow rounded border py-5">
            <div class="col-6 text-center">
                <img src="{{ asset('productPhoto/'.$products->photo) }}" class=" img-thumbnail rounded shadow-sm" alt="">
            </div>
            <div class="col-6">
                <p class="text-primary fs-5">{{$products->category_name}}</p>
                <h1 class="text-dark fs-1 fw-bold mt-2 mb-5">{{$products->name}}</h1>
                <p class="text-secondary fs-3 mt-5 mb-5">{{$products->description}}</p>
                <div class="row mt-5">
                    <h2 class="fw-bold fs-2 col text-dark">Price : {{$products->price}}</h2>
                    <h2 class="fw-bold fs-2 col text-dark">Stock : {{$products->stock}}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
