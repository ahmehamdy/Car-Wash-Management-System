<h1>New Order Received</h1>
<p>You have a new order from {{ $order->user->name }}.</p>
<p>Pickup Time: {{ $order->pickup_time }}</p>
<p>Total Price: {{ $order->total_price }}</p>

<ul>
@foreach($order->services as $service)
    <li>{{ $service->name }} x {{ $service->pivot->qty }} - {{ $service->pivot->price }}</li>
@endforeach
</ul>
