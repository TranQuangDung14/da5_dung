<!DOCTYPE html>
<html>
<head>
    <title>Sản phẩm không đủ hàng</title>
</head>
<body>
    <h1>Thông báo: Sản phẩm không đủ hàng</h1>
    <p>Xin chào: {{ $order->receiver_name }},</p>
    <p>Sản phẩm "{{ $orderDetail->product->name }}" không đủ hàng để đáp ứng yêu cầu trong đơn hàng của bạn.</p>
    <p>Xin lỗi vì sự bất tiện này. Chúng tôi sẽ liên hệ với bạn để cung cấp các tùy chọn khác hoặc thay đổi đơn hàng.</p>
    <p>Xin cảm ơn và chúc bạn một ngày tốt lành!</p>
</body>
</html>
