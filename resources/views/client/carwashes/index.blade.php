@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-8 text-center">
        Available Car Washes
    </h1>

    @if($carWashes->isEmpty())
        <p class="text-gray-500 text-center">No Car Washes available at the moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($carWashes as $carWash)
                <div class="border rounded-lg shadow-lg p-6 hover:shadow-xl transition bg-white">
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $carWash->name }}</h2>
                        <p class="text-gray-600 mb-2">
                            Status:
                            <span class="{{ $carWash->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2 py-1 rounded text-sm">
                                {{ $carWash->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">Services:</h3>
                        @if($carWash->services->isEmpty())
                            <p class="text-gray-500">No services available.</p>
                        @else
                            <ul class="list-disc list-inside text-gray-700">
                                @foreach($carWash->services as $service)
                                    <li class="mb-1">{{ $service->name }} - <span class="font-medium">{{ $service->price }} EGP</span></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- زر إنشاء أوردر -->
                    <form action="{{ route('client.order.create', $carWash->id) }}" method="GET">
                        <button type="submit" class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Place Order
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
