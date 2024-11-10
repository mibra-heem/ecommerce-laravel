@extends('layouts.main')

@section('title', "Home Page")

@section('content')

<x-product-form>
  <x-slot name="method"> GET </x-slot><x-slot name="action"> product.index </x-slot>
  <x-input>
    <x-slot name="type"></x-slot><x-slot name="name"></x-slot><x-slot name="id"></x-slot><x-slot name="value"></x-slot>
  </x-input>
</x-product-form>
<x-button>
  <x-slot name="color" >yellow</x-slot>
  submit
</x-button>
@endsection



