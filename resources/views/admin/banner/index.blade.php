@extends('layouts.admin.app')
@section('banner', 'active')
@section('content')


            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Banner</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Banner</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h3 class="card-title">Banner</h3>
                                    <a href="{{route('banner.create')}}" class="btn btn-primary">Add Banner</a>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th> Image</th>
                                                <th style="width: 40px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($banners as $banner)
                                            <tr>
                                                <td>{{++$id}}</td>
                                                <td>
                                                    <img src="{{asset('images/banners/'.$banner->image)}}" width="100" height="100" alt="">
                                                </td>
                                              
                                                <td>
                                                    <div class="d-flex">
                                                        {{-- <a href="{{route('product.edit', $banner->id)}}" class="btn btn-primary mr-2">Edit</a> --}}

                                                        {{-- <form action="{{route('product.delete', $banner->id)}}" method="POST" id="deleteForm">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('deleteForm').submit();">Delete</button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm m-0 float-right">
                                        {!! $banners->links() !!}
                                    </ul>
                                </div>
                            </div>

                      
                        </div>

                      
                    </div>
                </div>
            </section>

@endsection