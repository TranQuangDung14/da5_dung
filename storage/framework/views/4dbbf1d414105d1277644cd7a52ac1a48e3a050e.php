<!DOCTYPE html>
<html>
<head>
    <title>Sản phẩm không đủ hàng</title>
</head>
<body>
    <h1>Thông báo: Sản phẩm không đủ hàng</h1>
    <p>Xin chào: <?php echo e($order->receiver_name); ?>,</p>
    <p>Sản phẩm "<?php echo e($orderDetail->product->name); ?>" không đủ hàng để đáp ứng yêu cầu trong đơn hàng của bạn.</p>
    <p>Xin lỗi vì sự bất tiện này. Chúng tôi sẽ liên hệ với bạn để cung cấp các tùy chọn khác hoặc thay đổi đơn hàng.</p>
    <p>Xin cảm ơn và chúc bạn một ngày tốt lành!</p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\git_desktop\da5_dung\resources\views/emails/order_out_of_stock.blade.php ENDPATH**/ ?>