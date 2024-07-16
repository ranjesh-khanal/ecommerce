@extends('layouts.frontend.app')
@section('content')
    <div class="container my-5">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                @foreach($banners as $banner)
                <div class="carousel-item active">
                    <img src="{{ asset('images/banners/'.$banner->image) }}" class="d-block w-100" alt="...">
                </div>
               @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="col-lg-8 px-0 mt-5">
            <h4 style="border-bottom: 1px solid black;">All Products</h4>

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
