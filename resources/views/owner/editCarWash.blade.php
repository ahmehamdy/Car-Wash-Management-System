@extends('layouts.app')

@section('content')
<h1>Edit Car Wash</h1>

<form action="{{ route('carwash.update', $carWash->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $carWash->name }}" required>
    <input type="text" name="address" value="{{ $carWash->address }}" required>
    <input type="text" name="latitude" value="{{ $carWash->latitude }}">
    <input type="text" name="longitude" value="{{ $carWash->longitude }}">
    <button type="submit">Update</button>
</form>
@endsection
