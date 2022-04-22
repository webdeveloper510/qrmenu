 <!-- CSS Files -->
 <?php if(in_array(config('app.locale'),['ar','he','fa','ur'])): ?>
    <link href="<?php echo e(asset('css')); ?>/rtl.css" rel="stylesheet" />
 <?php endif; ?>

 <?php echo $__env->make('layouts.common', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/layouts/rtl.blade.php ENDPATH**/ ?>