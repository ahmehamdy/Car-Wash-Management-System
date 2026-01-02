{{-- @extends('layouts.app')

@section('content')
<h1>Car Wash Owner Dashboard 🚗</h1>

<h2>Orders</h2>
@foreach($orders as $order)
    <div class="border p-3 mb-2">
        <p>Client: {{ $order->client->name }}</p>
        <p>Service: {{ $order->service->name }}</p>
        <p>Status: {{ $order->status }}</p>

        @if($order->status == 'pending')
            <form action="{{ route('owner.orders.accept', $order->id) }}" method="POST">
                @csrf
                <button class="btn btn-primary">Accept</button>
            </form>
        @elseif($order->status == 'accepted')
            <form action="{{ route('owner.orders.complete', $order->id) }}" method="POST">
                @csrf
                <button class="btn btn-success">Complete</button>
            </form>
        @endif
    </div>
@endforeach

<h2>Services</h2>
@foreach($services as $service)
    <div class="border p-3 mb-2">
        <p>{{ $service->name }} - ${{ $service->price }}</p>
    </div>
@endforeach

<h3>Add New Service</h3>
<form action="{{ route('owner.service.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Service Name" required>
    <input type="number" name="price" placeholder="Price" required>
    <button type="submit" class="btn btn-success">Add Service</button>
</form>

@endsection --}}
@extends('layouts.app')

@section('content')
<h1>My Car Wash</h1>

@if($carWash)
    <p>Name: {{ $carWash->name }}</p>
    <p>Address: {{ $carWash->address }}</p>
    <a href="{{ route('carwash.edit', $carWash->id) }}">Edit</a>
@else
    <p>You don’t have a Car Wash yet.</p>
    <a href="{{ route('carwash.create') }}">Create Car Wash</a>
@endif

@endsection
