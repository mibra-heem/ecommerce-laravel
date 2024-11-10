@extends('layouts.main')


@section('content')

    <div class="container">
        <h2>Add New Banner</h2>
    </div>

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="container">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Banner Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>
        </div>
        
        
        <div class="row mb-3">
            <label for="image" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Save</button>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

@endsection
