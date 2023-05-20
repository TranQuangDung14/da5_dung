<!DOCTYPE html>
<html>

<head>
    <title>Thông báo: Cập nhật trạng thái đơn hàng</title>
</head>

<body>
    <h1>Thông báo: Cập nhật trạng thái đơn hàng</h1>
    <p>Xin chào: {{ $order->receiver_name }}!</p>
    <p>Trạng thái của đơn hàng:"<span style="color: #FF9900">{{ $order->code_order }}  </span> "đã được cập nhật thành: <span style="background-color: yellow"> {{ $statusText }}</span></p>
    <p>Danh sách đơn hàng:</p>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm &emsp;</th>
                <th>Số lượng  &emsp;</th>
                <th>Giá &emsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $item)
                <tr>
                    <td>{{ $item->product->name }} &emsp;</td>
                    <td>{{ $item->quantity }} &emsp;</td>
                    <td>{{ $item->price }} &emsp;</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng, thanks all!</p>
</body>

</html>
