@extends('layouts.frontend.app')
@section('content')
    <div class="container my-5">
        <div class="col-lg-8 px-0 mt-5">
            <h4 style="border-bottom: 1px solid black;">
                @if($category == null)
                <h2>All Category</h2>
                @else
                <h2>{{$category->name}}</h2>
                @endif
            </h4>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('images/products/'.$product->feature_image) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$product->name}}</h5>
                                <p class="card-text">Rs.{{$product->price}}</p>
                                <a href="{{route('frontend.product_detail', $product->slug)}}" class="btn btn-primary">View Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div>
            </div>
        </div>
    @endsection
