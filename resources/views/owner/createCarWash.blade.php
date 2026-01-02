@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center">Create Your Car Wash</h1>

        @if (session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif
        <div class="form-container">
            <form id="carwashForm" action="{{ route('carwash.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium mb-1">Name:</label>
                    <input type="text" name="name" placeholder="Car Wash Name" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div>
                    <label class="block font-medium mb-1">Address:</label>
                    <input type="text" name="address" placeholder="Address" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">
                </div>

                <div>
                    <label class="block font-medium mb-1">Location (Drag marker or click map):</label>
                    <div id="map" class="w-full h-96 mb-2 rounded border border-gray-300"></div>
                    <div class="flex gap-4">
                        <input type="text" id="latDisplay" placeholder="Latitude" readonly
                            class="w-1/2 border border-gray-300 rounded px-3 py-2 bg-gray-100">
                        <input type="text" id="lngDisplay" placeholder="Longitude" readonly
                            class="w-1/2 border border-gray-300 rounded px-3 py-2 bg-gray-100">
                    </div>
                </div>

                {{-- Hidden inputs --}}
                <input type="hidden" name="lat" id="lat" required>
                <input type="hidden" name="lng" id="lng" required>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                    Create Car Wash
                </button>
            </form>
        </div>
    </div>

    {{-- Google Maps JS --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAGYL4uUp8nldrWidm7MHLFutJ0QVKlZM&callback=initMap" async
        defer></script>
    <script>
        function initMap() {
            const initialPosition = {
                lat: 30.0444,
                lng: 31.2357
            }; // مركز مبدئي على مصر

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: initialPosition
            });

            const marker = new google.maps.Marker({
                position: initialPosition,
                map: map,
                draggable: true
            });

            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');
            const latDisplay = document.getElementById('latDisplay');
            const lngDisplay = document.getElementById('lngDisplay');

            function updatePosition(pos) {
                latInput.value = pos.lat();
                lngInput.value = pos.lng();
                latDisplay.value = pos.lat().toFixed(6);
                lngDisplay.value = pos.lng().toFixed(6);
            }

            // قيم مبدئية
            updatePosition(new google.maps.LatLng(initialPosition.lat, initialPosition.lng));

            // تحديث عند سحب Marker
            marker.addListener('dragend', function() {
                updatePosition(marker.getPosition());
            });

            // تحديث عند النقر على الخريطة
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                updatePosition(event.latLng);
            });

            // Form validation بسيط قبل الإرسال
            document.getElementById('carwashForm').addEventListener('submit', function(e) {
                if (!latInput.value || !lngInput.value) {
                    e.preventDefault();
                    alert('Please select a location on the map.');
                }
            });
        }
    </script>
@endsection
