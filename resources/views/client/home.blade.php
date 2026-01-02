@extends('layouts.app')

@section('content')
<h1>Welcome Client 👋</h1>

<p>Find car washes near you</p>

@foreach($carWashes as $wash)
    <div class="border p-4 mb-2">
        <h2>{{ $wash->name }}</h2>
        <p>{{ $wash->address }}</p>

        <a href="{{ route('client.carwash.show', $wash->id) }}" class="btn btn-primary">
            View Services
        </a>
    </div>
@endforeach
@endsection
