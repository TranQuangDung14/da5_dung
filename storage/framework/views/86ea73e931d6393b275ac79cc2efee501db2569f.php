<!DOCTYPE html>
<html>

<head>
    <title>Thông báo: Cập nhật trạng thái đơn hàng</title>
</head>

<body>
    <h1>Thông báo: Cập nhật trạng thái đơn hàng</h1>
    <p>Xin chào: <?php echo e($order->receiver_name); ?>!</p>
    <p>Trạng thái của đơn hàng:"<span style="color: #FF9900"><?php echo e($order->code_order); ?>  </span> "đã được cập nhật thành: <span style="background-color: yellow"> <?php echo e($statusText); ?></span></p>
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
            <?php $__currentLoopData = $orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product->name); ?> &emsp;</td>
                    <td><?php echo e($item->quantity); ?> &emsp;</td>
                    <td><?php echo e($item->price); ?> &emsp;</td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ hỗ trợ khách hàng, thanks all!</p>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\DATN\da5_dung\resources\views/emails/order_status_update.blade.php ENDPATH**/ ?>