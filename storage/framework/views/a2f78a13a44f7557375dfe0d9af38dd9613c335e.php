<html>
<body>
    <h1>Export Order #<?php echo e($exportOrder->id); ?></h1>
    <p>Staff ID: <?php echo e($exportOrder->staff_id); ?></p>
    <p>Total Quantity: <?php echo e($exportOrder->total_quantity); ?></p>

    <h2>Details</h2>
    <?php $__currentLoopData = $exportOrder->export_orders_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p>Product ID: <?php echo e($detail->product_id); ?></p>
        <p>Quantity: <?php echo e($detail->quantity); ?></p>
        <p>Price: <?php echo e($detail->price); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\git_desktop\Q.Dung datn\da5_dung\resources\views/pdf/export_order.blade.php ENDPATH**/ ?>