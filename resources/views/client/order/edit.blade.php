@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">

        <h1 class="text-3xl font-bold mb-6 text-center">
            Update Order – {{ $order->carWash->name }}
        </h1>

        <form id="updateOrderForm" class="bg-white shadow rounded p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Pickup Time --}}
            <div>
                <label class="block font-semibold mb-1">Pickup Time</label>
                <input type="datetime-local" id="pickup_time_input" value="{{ $order->pickup_time->format('Y-m-d\TH:i') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Services --}}
            <div>
                <h3 class="font-semibold mb-2">Select Services</h3>
                @foreach ($order->carWash->services as $service)
                    <label class="flex items-center gap-3 mb-2">
                        <input type="checkbox" class="service-checkbox" value="{{ $service->id }}"
                            {{ $order->services->contains($service->id) ? 'checked' : '' }}>
                        {{ $service->name }} ({{ $service->price }} EGP)
                    </label>
                @endforeach
            </div>

            <button type="button" onclick="submitUpdateOrder()"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Update Order
            </button>
        </form>

    </div>

    <script>
        function submitUpdateOrder() {
            const pickupRaw = document.getElementById('pickup_time_input').value;
            if (!pickupRaw) {
                alert('Choose pickup time');
                return;
            }

            const formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('_method', 'PUT'); // Laravel method spoofing
            formData.append('pickup_time', pickupRaw.replace('T', ' '));

            // Services
            let index = 0;
            document.querySelectorAll('.service-checkbox:checked').forEach(cb => {
                formData.append(`services[${index}][id]`, cb.value);
                index++;
            });

            if (index === 0) {
                alert('Select at least one service');
                return;
            }

            fetch("{{ route('client.order.updateMyOrder', $order->id) }}", {
                    method: 'POST', // Laravel expects POST with _method=PUT
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Redirect لصفحة الأوردرات
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                })
                .catch(() => alert('Something went wrong'));
        }
    </script>
@endsection
