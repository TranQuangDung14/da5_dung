<!DOCTYPE html>
<html>

<head>
    <title>Sample Email</title>
</head>

<body>
    <h1>Sample Email</h1>
    <p>Xin chào: {{ $emailData['name'] }},</p>
    <p>Xin chân thành cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Chúng tôi xin xác nhận rằng đơn hàng của bạn đã
        được nhận và xử lý thành công</p>
    <p>{{ $emailData['message'] }}</p>
    <p>Chúng tôi sẽ tiến hành xử lý đơn hàng của bạn và sẽ thông báo cho bạn khi đơn hàng đã được gửi đi. Nếu bạn có bất
        kỳ câu hỏi hoặc yêu cầu đặc biệt, vui lòng liên hệ với chúng tôi qua địa chỉ email hoặc số điện thoại được cung
        cấp bên dưới.</p>

    <p> Một lần nữa, chúng tôi xin chân thành cảm ơn sự ủng hộ của bạn. Chúng tôi luôn sẵn lòng phục vụ bạn và hy vọng
        rằng bạn sẽ hài lòng với trải nghiệm mua sắm tại cửa hàng của chúng tôi. </p>
    <p>Trân trọng,</p>
    <p>Đội ngũ cửa hàng</p>
</body>

</html>
