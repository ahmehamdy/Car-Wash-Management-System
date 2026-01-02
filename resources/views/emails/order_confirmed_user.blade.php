<h1>Your Order is Confirmed</h1>
<p>Your order at {{ $order->carWash->name }} has been confirmed.</p>
<p>Pickup Time: {{ $order->pickup_time }}</p>
<p>Total Price: {{ $order->total_price }}</p>

<ul>
@foreach($order->services as $service)
    <li>{{ $service->name }} x {{ $service->pivot->qty }} - {{ $service->pivot->price }}</li>
@endforeach
</ul>
