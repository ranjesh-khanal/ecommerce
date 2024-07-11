@extends('layouts.admin.app')
@section('category', 'active')
@section('content')


            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Category</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Category</li>
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
                                    <h3 class="card-title">Category</h3>
                                    <a href="{{route('category.create')}}" class="btn btn-primary">Add Category</a>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th style="width: 40px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $category)
                                            <tr>
                                                <td>{{++$id}}</td>
                                                <td>{{$category->name}}</td>
                                                <td>
                                                   {{$category->slug}}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{route('category.edit', $category->id)}}" class="btn btn-primary mr-2">Edit</a>

                                                        <form action="{{route('category.delete', $category->id)}}" method="POST" id="deleteForm">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('deleteForm').submit();">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm m-0 float-right">
                                        {!! $categories->links() !!}
                                    </ul>
                                </div>
                            </div>

                      
                        </div>

                      
                    </div>
                </div>
            </section>

@endsection