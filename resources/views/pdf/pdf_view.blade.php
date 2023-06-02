<!-- resources/views/export_order.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Export Order PDF</title>
    <style>
        /* // Your CSS styles here */
    </style>
</head>
<body>
    <h1>Export Order {{ $user->id }}</h1>
    <p>Staff ID: {{ $user->staff_id }}</p>
    <p>Total Quantity: {{ $user->total_quantity }}</p>
    <h2>Order Details</h2>
    {{-- @foreach ($exportOrderDetails as $detail)
        <p>Product ID: {{ $detail->product_id }}</p>
        <p>Quantity: {{ $detail->quantity }}</p>
        <p>Price: {{ $detail->price }}</p>
    @endforeach --}}
</body>
</html>
