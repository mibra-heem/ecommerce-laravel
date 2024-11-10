@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="col">
            <h2>Products</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">Add Product</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price (Rs.)</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @php
                  $sr = 1;
                @endphp
                @foreach ($products as $product)
                
                    <tr>
                        <th scope="row">{{ $sr }}</th>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td><img style="height: 120px; width:150px; border-radius:10px" src="{{ asset($product->image) }}"
                                alt=""></td>
                        <td>{{ $product->descr }}</td>
                        <td><a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary btn-md">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                  @php
                    $sr++;
                  @endphp
                @endforeach
                
            </tbody>
        </table>
    </div>
@endsection
