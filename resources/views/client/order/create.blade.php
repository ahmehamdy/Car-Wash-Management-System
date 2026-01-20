@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">

        <h1 class="text-3xl font-bold mb-6 text-center">
            Place Order – {{ $carWash->name }}
        </h1>

        <form id="orderForm" class="bg-white shadow rounded p-6 space-y-6">
            @csrf

            {{-- Pickup Time --}}
            <div>
                <label class="block font-semibold mb-1">Pickup Time</label>
                <input type="datetime-local" id="pickup_time_input" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Services --}}
            <div>
                <h3 class="font-semibold mb-2">Select Services</h3>
                @foreach ($carWash->services as $service)
                    <label class="flex items-center gap-3 mb-2">
                        <input type="checkbox" class="service-checkbox" value="{{ $service->id }}">
                        {{ $service->name }} ({{ $service->price }} EGP)
                    </label>
                @endforeach
            </div>

            <button type="button" onclick="submitOrder()"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Place Order
            </button>
        </form>

    </div>

    <script>
        let isSubmitting = false;

        function submitOrder() {
            if (isSubmitting) return; // منع الضغط المتكرر
            isSubmitting = true;

            const pickupRaw = document.getElementById('pickup_time_input').value;
            if (!pickupRaw) {
                alert('Choose pickup time');
                isSubmitting = false;
                return;
            }

            const formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('pickup_time', pickupRaw.replace('T', ' '));

            let index = 0;
            document.querySelectorAll('.service-checkbox:checked').forEach(cb => {
                formData.append(`services[${index}][id]`, cb.value);
                index++;
            });

            if (index === 0) {
                alert('Select at least one service');
                isSubmitting = false;
                return;
            }

            fetch("{{ route('client.order.store', $carWash->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // بعد نجاح الأوردر → نروح لصفحة أوردراته
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Something went wrong');
                        isSubmitting = false;
                    }
                })
                .catch(() => {
                    alert('Something went wrong');
                    isSubmitting = false;
                });
        }
    </script>
@endsection
