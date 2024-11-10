@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="col">
            <h2>Banners</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('banners.create') }}" class="btn btn-primary btn-lg">Add banner</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Image</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @php
                  $sr = 1;
                @endphp
                @foreach ($banners as $banner)
                
                    <tr>
                        <th scope="row">{{ $banner->id }}</th>
                        <td><img style="height: 120px; width:150px; border-radius:10px" src="{{ asset($banner->image) }}"
                                alt=""></td>
                        <td><a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-secondary btn-md">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('banners.destroy', $banner->id) }}" method="POST">
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
