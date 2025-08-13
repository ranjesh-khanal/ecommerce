@extends('layouts.admin.app')
@section('product', 'active')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Contact Form</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Contact</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('contact.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contact</label>
                                        <select name="contact_id" class="form-control" id="">
                                            <option value="">Select Contact</option>
                                            {{-- @foreach($Category as $contact) --}}
                                            {{-- <option value="{{$contact->id}}" @selected(old('contact_id') == $contact->id)>{{$contact->name}}</option> --}}
                                            {{-- @endforeach --}}
                                        </select>
                                        @if($errors->has('contact_id'))
                                        <span class="text-danger">{{$errors->first('contact_id')}}</span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" id="exampleInputEmail1"
                                        placeholder="Enter name">
                                        @if($errors->has('name'))
                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contact NO:</label>
                                    <input type="text" class="form-control" name="number" value="{{old('number')}}" id="exampleInputEmail1"
                                        placeholder="Enter Number">
                                        @if($errors->has('number'))
                                        <span class="text-danger">{{$errors->first('number')}}</span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea name="description" id="" style="width:100%;"></textarea>
                                        @if($errors->has('description'))
                                        <span class="text-danger">{{$errors->first('description')}}</span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Featured Image</label>
                                    <input type="file" name="feature_image" class="form-control">
                                        @if($errors->has('featured_image'))
                                        <span class="text-danger">{{$errors->first('featured_image')}}</span>
                                        @endif
                                </div>
                            
                            
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

            

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
