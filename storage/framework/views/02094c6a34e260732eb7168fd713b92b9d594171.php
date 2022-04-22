<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="card shadow border-0 mt-8">
            <div class="card-body text-center">
                <div class="justify-content-center text-center">
                    <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_y2hxPc.json"  background="transparent"  speed="1"  style=" height: 200px;"    autoplay></lottie-player>
                </div>
                <h2 class="display-2"><?php echo e(__("You're all set!")); ?></h2>
                <h1 class="mb-4">
                    <span class="badge badge-primary"><?php echo e(__('Order')." #".$order->id); ?></span>
                </h1>
                <div class="d-flex justify-content-center">
                    <div class="col-8">
                        <h5 class="mt-0 mb-5 heading-small text-muted">
                            <?php echo e(__("Your order is created. You will be notified for further information.")); ?>

                        </h5>
                        <h5 class="mt-0 mb-5 heading-small text-muted">
                            <?php echo e(__("check your email for a receipt of this order.")); ?>

                        </h5>
                        <div class="font-weight-300 mb-5">
                            <?php echo e(__("Thanks for your purchase")); ?>, 
                        <span class="h3"><?php echo e($order->restorant->name); ?></span></div>
                        <?php if(config('settings.wildcard_domain_ready')): ?>
                            <a href="<?php echo e($order->restorant->getLinkAttribute()); ?>" class="btn btn-outline-primary btn-sm"><?php echo e(__('Go back to restaurant')); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('vendor',$order->restorant->subdomain)); ?>" class="btn btn-outline-primary btn-sm"><?php echo e(__('Go back to restaurant')); ?></a>
                        <?php endif; ?>

                        <!-- WHATS APP Buttton -->
                        <?php if($showWhatsApp): ?>
                            <a target="_blank" href="?order=<?php echo e($_GET['order']); ?>&whatsapp=yes"  class="btn btn-lg btn-icon btn btn-success mt-4 paymentbutton">
                                <span style="color:white" class="btn-inner--icon lg"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                <span style="color:white" class="btn-inner--text"><?php echo e(__('Send order on WhatsApp')); ?></span>
                            </a>
                        <?php endif; ?>
                        <!-- End WhattsApp Button -->

                        <!-- Whats App  Redirect -->
                       <?php if(isset($whatsappurl)): ?>
                        <script type="text/javascript">

                                var redirectDone=false;
                                if(!redirectDone){
                                    redirectDone=true;

                                    var redirectWindow = window.open('<?php echo e($whatsappurl); ?>', '_blank');
                                    redirectWindow.location;
                                }
                            </script>
                       <?php endif; ?>
                            
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.app', ['title' => ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/orders/success.blade.php ENDPATH**/ ?>