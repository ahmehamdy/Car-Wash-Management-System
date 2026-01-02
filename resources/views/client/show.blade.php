@extends('layouts.app')

@section('content')
<h1>Services for {{ $carWash->name }}</h1>

@foreach($carWash->services as $service)
    <div class="border p-3 mb-2">
        <h3>{{ $service->name }} - ${{ $service->price }}</h3>

        <form action="{{ route('client.order.store') }}" method="POST">
            @csrf
            <input type="hidden" name="car_wash_id" value="{{ $carWash->id }}">
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <button type="submit" class="btn btn-success">Request Service</button>
        </form>
    </div>
@endforeach
@endsection
