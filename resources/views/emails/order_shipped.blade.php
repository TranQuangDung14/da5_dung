<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông báo đơn hàng đã được xuất kho</title>
</head>
<body>
    <h1>Thông báo: Đơn hàng đã được xuất kho</h1>
    <p>Xin chào: {{ $order->receiver_name }},</p>
    <p>Mã đơn hàng {{ $order->code_order }} đã được xuất kho thành công.</p>
    <p>Thời gian nhận hàng dự tính: {{ date('d/m/Y', strtotime($order->delivery_date)) }}</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng</p>
</body>

</html>
