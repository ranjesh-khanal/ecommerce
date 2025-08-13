@extends('layouts.admin.app')
@section('contact', 'active')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Contact</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Contact</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Contact</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.contact.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="contactSelect">Contact</label>
                                    <select name="contact_id" class="form-control" id="contactSelect">
                                        <option value="">Select Contact</option>
                                        @foreach($contacts as $cont)
                                            <option value="{{ $cont->id }}" @selected($contact->contact_id == $cont->id)>{{ $cont->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('contact_id'))
                                        <span class="text-danger">{{ $errors->first('contact_id') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $contact->name }}" id="name" placeholder="Enter name">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="contactNumber">Contact Number</label>
                                    <input type="text" class="form-control" name="number" value="{{ $contact->number }}" id="contactNumber" placeholder="Enter contact number">
                                    @if($errors->has('number'))
                                        <span class="text-danger">{{ $errors->first('number') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" style="width:100%;">{{ $contact->description }}</textarea>
                                    @if($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="featureImage">Featured Image</label>
                                    <input type="file" name="feature_image" class="form-control" id="featureImage">
                                    @if($errors->has('feature_image'))
                                        <span class="text-danger">{{ $errors->first('feature_image') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
