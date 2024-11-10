@extends('layouts.main')


@section('content')

    <div class="container">
        <h2>Edit Item</h2>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="container">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <label for="name" class="col-sm-2 col-form-label">Product Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name" value="{{old('name', $product->name)}}">
          </div>
        </div>
        <div class="row mb-3">
          <label for="category" class="col-sm-2 col-form-label">Category</label>
          <div class="col-sm-10">
            <select class="form-select text-secondary" name="category" id="category" name="category" aria-label="Default select example">
              <option>Select Category...</option>
              @foreach ($categories as $category)
                @if ($category->cname === $product->categories)
                <option selected value="{{old('category', $category->cname)}}">{{$category->cname}}</option>
                @else
                <option value="{{old('category', $category->cname)}}">{{$category->cname}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label for="price" class="col-sm-2 col-form-label">Price</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" name="price" id="price" value="{{old('price', $product->price)}}">
          </div>
        </div>
        <div class="row mb-3">
          <label for="image" class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name="image" id="image" value="{{old('image', $product->image)}}">
          </div>
        </div>
        <div class="row mb-3">
            <label for="descr" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="descr" placeholder="Description..." id="descr">{{old('descr', $product->descr)}}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>

        @if($errors->any())
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