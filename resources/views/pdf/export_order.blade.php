<html>
<body>
    <h1>Export Order #{{ $exportOrder->id }}</h1>
    <p>Staff ID: {{ $exportOrder->staff_id }}</p>
    <p>Total Quantity: {{ $exportOrder->total_quantity }}</p>

    <h2>Details</h2>
    @foreach ($exportOrder->export_orders_details as $detail)
        <p>Product ID: {{ $detail->product_id }}</p>
        <p>Quantity: {{ $detail->quantity }}</p>
        <p>Price: {{ $detail->price }}</p>
    @endforeach
</body>
</html>
