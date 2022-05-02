

<html>
<head>
    <title>email</title>
</head><body>
    <?php 
        $currency=config('settings.cashier_currency');
        $convert=config('settings.do_convertion');
    ?>
    <div class="card bg-secondary shadow" style="position: relative; flex-direction: column; min-width: 0; word-wrap:break-word;background-color:#f1f1f1; background-clip: border-box; border: 0.0625rem solid rgba(0,0,0,.05);border-radius: 0.25rem; box-shadow: 0 15px 35px rgba(50,50,93,.1),0 5px 15px rgba(0,0,0,.07)!important;">
                    <div class="card-header bg-white border-0" style="padding: 1.25rem 1.5rem background: #ffffff;">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0" style="background: #ffffff; margin: 0 !important; padding: 20px; font-size: 20px; font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;"><?php echo e(__('Order')." #".$orderid); ?></h3>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 1.5rem; !important;">
    <div class="timeline timeline-one-side" id="status-history" data-timeline-content="axis" data-timeline-axis-style="dashed">
            <div class="timeline-block">
            <span class="timeline-step badge-success">
                <i class="ni ni-bell-55"></i>
            </span>
            <div class="timeline-content">
                <div style="display:flex !important; align-items:center !important; justify-content: space-between !important;width: 500px;padding: 20px 20px 0px 1.5rem;">
                    <div>
                        <span class="text-muted text-sm font-weight-bold" style="color: #8898aa!important; font-size: .875rem; font-weight: 600!important;">Just created</span>
                    </div>
                   <div class="text-right" style="color: #8898aa;  font-size: .875rem;     font-weight: 600!important; margin-left: 10rem;">
                        <small class="text-muted"><i class="fas fa-clock mr-1"></i><?php echo e($created_at); ?></small>
                    </div>
                </div>
                <h6 class="text-sm mt-1 mb-0" style="margin: 0;font-size: .875rem;font-weight: 400; line-height: 1.5; color: #32325d; padding-left: 1.5rem;">Status from: <?php echo e($username); ?> </h6>
            </div>
        </div>
        </div>
</div>                    <div class="card-body">
    <h6 class="heading-small text-muted mb-4" style="color: #8898aa!important; font-weight: 600!important; font-size: .875rem; padding: 1.5rem; margin: 5px !important;">Restaurant information</h6>
          <div class="pl-lg-4" style="padding-left: 1.5rem!important;">
         <h3 style="font-family: inherit; font-weight: 400;line-height: 1.5;color: #32325d;padding: 0 !important; font-size: 25px;padding-left: 20px !important;margin: 0 !important;"><?php echo e($restorent_name); ?></h3>
         <h4 style="font-family: inherit; font-weight: 400;line-height: 1.5;color: #32325d;padding: 0 !important; font-size: 25px;padding-left: 20px !important;margin: 0 !important;"><?php echo e($restorent_address); ?></h4>
         <h4 style="font-family: inherit; font-weight: 400;line-height: 1.5;color: #32325d;padding: 0 !important; font-size: 25px;padding-left: 20px !important;margin: 0 !important;"><?php echo e($restorent_phone); ?></h4>
         <h4 style="font-family: inherit; font-weight: 400;line-height: 1.5;color: #32325d;padding: 0 !important; font-size: 25px;padding-left: 20px !important;margin: 0 !important;"><?php echo e($username); ?>, <?php echo e($useremail); ?></h4>
         
     </div>
     <hr class="my-4" style="margin: 20px;"/>
 
                           <h6 class="heading-small text-muted mb-4" style="color: #8898aa!important; padding: 1.5rem; font-size: 16px; margin: 0;font-weight: 500; padding-bottom: 0 !important;">Table Information</h6>
             <div class="pl-lg-4">
                 
                     <h3 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;padding: 1.5rem 1.5rem 0 50px !important;font-size: 25px;margin: 0 !important;">Table: <?php echo e($tablename); ?></h3>
                                              <h4 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d; padding: 0 0 0 50px !important; font-size: 25px;margin: 0 !important;">Area: <?php echo e($restoarea_name); ?></h4>
                                      
                 
             </div>
             <hr class="my-4" style="margin: 20px;"/>
                   
         
 
     
     <h6 class="heading-small text-muted mb-4" style="padding: 1.5rem 1.5rem 0 1.5rem;font-family: inherit; font-weight: 400;line-height: 1.5;color: #8898aa!important; font-size: 16px;margin: 0 !important;">Order</h6>
    
          <ul id="order-items">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                      <li style="margin-left: 0 !important; list-style: none;"><h4 style="margin-bottom: 0.5rem;font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d; padding: 0 !important; font-size: 20px; margin: 0 !important;"><?php echo e($item->quantity); ?> X <?php echo e($item->name); ?>  -  <?php echo money($item->price, $currency,true); ?>  =  ( <?php echo money($item->quantity * $item->price , $currency,true); ?> )
             
               
                <span class="small">-- VAT <?php echo e($vat); ?>%:  ( <?php echo money(round($vat,2), $currency,true); ?> )</span>
                                                  <span>Tips: <?php echo e($tip); ?>%</span>
                                                  <p>Item Comment: <?php echo e($item['attributes']['item_comment']); ?></p>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
             </h4>
                  
                                  
             </li>
                         
              </ul>
                 
        <h4 style="margin-bottom: 0.5rem;font-family: inherit; font-weight: 400;line-height: 1.5;color: #32325d; font-size: 1.5rem; margin: 0; padding-left: 20px;">Comment:  <?php echo e($comment); ?></h4>
               <br>
          <h5 style="font-family: inherit; font-weight: 400;line-height: 1.5; color: #32325d;font-size: 20px; padding-left: 20px;margin: 0;">Tips: <?php echo money($tips, $currency,true); ?></h5>
     <h5 style="font-family: inherit; font-weight: 400;line-height: 1.5; color: #32325d;font-size: 20px; padding-left: 20px;margin: 0;">NET: <?php echo money((round($net_cal,2)), $currency,true); ?></h5>
     
     <h5 style="font-family: inherit; font-weight: 400;line-height: 1.5; color: #32325d;font-size: 20px; padding-left: 20px;margin: 0;">VAT: <?php echo money((round($vat_cal,2)), $currency,true); ?></h5>
     <h4 style="font-family: inherit; font-weight: 400;line-height: 1.5; color: #32325d;font-size: 20px; padding-left: 20px;margin: 0;">Sub Total: <?php echo money((round($subtotal,2)), $currency,true); ?> </h4>
               <hr style="margin: 20px;"/>
     <h3 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;font-size: 22px;padding-left: 20px;margin: 0;">TOTAL: <?php echo money(round($delivery_price+$subtotal+$discount+$vat_cal,2) , $currency,true); ?></h3>
     <h3 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;font-size: 22px;padding-left: 20px;margin: 0;">GRAND TOTAL: <?php echo money(round($delivery_price+$subtotal+$discount+$tips+$vat_cal,2) , $currency,true); ?></h3>
     <hr style="margin: 20px;"/>
     <h4 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;font-size: 1.5rem;padding-left: 20px;margin: 0;">Payment method: <?php echo e(__(ucfirst($payment_method))); ?></h4>
     <h4 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;font-size: 1.5rem;padding-left: 20px;margin: 0;">Payment status: <?php echo e(__(ucfirst($payment_status))); ?></h4>
          <hr style="margin: 20px;"/>
              <h4 style="font-family: inherit;font-weight: 400;line-height: 1.5;color: #32325d;font-size: 1.5rem;padding-left: 20px;margin: 0; margin-bottom: 25px;">Dine method: <?php echo e(__(ucfirst($deliverymethod))); ?></h4>
              
     
     
 
 
 </div>                </div>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/email/email.blade.php ENDPATH**/ ?>