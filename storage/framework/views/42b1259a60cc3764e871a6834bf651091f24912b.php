<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('users.partials.header', ['title' => ""], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   

    <div class="container-fluid mt--7"> 
        
        <div class="col-xl-8 offset-xl-2">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-end flex-nowrap">
                        
                        <div class="col-sm-8 align-items-start">
                            <a  href="<?php echo e($backUrl); ?>" type="button" class="btn btn-primary btn-lg left text-white">
                                <span class="btn-inner--icon"><i class="fa fa-chevron-left"></i></span>
                                <span class="btn-inner--text"><?php echo e(__('Go Back')); ?></span>
                            </a>
                        </div>
                        <div class="col-sm-4" style=" display: flex; justify-content: flex-end">
                            <a  href="<?php echo e(url()->current()); ?>" type="button" class="btn btn-primary btn-lg align-items-right text-white">
                                <span class="btn-inner--icon"><i class="fa fa-refresh"></i></span>
                                <span class="btn-inner--text"><?php echo e(__('Refresh')); ?></span>
                            </a>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <br />
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <div class="col-xl-8 offset-xl-2">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0"><?php echo e(__('Order')." #".$order->id); ?></h3>
                        </div>
                    </div>
                    <?php echo $__env->make('orders.partials.orderstatus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('orders.partials.orderinfo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <br />
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', ['title' => __('Orders')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/orders/guestorders.blade.php ENDPATH**/ ?>