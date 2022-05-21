
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
   



<div class="card card-profile shadow mt--300">
    <div class="px-4">
      <div class="mt-5">
        <h3><?php echo e(__('Checkout')); ?><span class="font-weight-light"></span></h3>
      </div>
      <div  class="border-top">
        <!-- Price overview -->
        <div id="totalPrices" v-cloak>
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span v-if="totalPrice==0"><?php echo e(__('Cart is empty')); ?>!</span>


                              
                                <?php 

                                  $custom_tip = $restorant['custom_tip'];
                                  $tips = $restorant['tips'];
                                  $vat = $restorant['vat'];
                                  
                                  $tips_array1 = explode(",",$tips); 
                                  $tips_array = array_filter($tips_array1);?>

                                    <?php if(count($tips_array)>1): ?>
                                    <span><strong><?php echo e(__('Leave a Tip!')); ?></strong></span><br>
                                    
                                    <?php $__currentLoopData = $tips_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tips): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <!--  <div class="tips-radio mb-3">
                                        <input name="tips" class="tips-input" id="tips"  type="radio" value="<?php echo e($tips); ?>">
                                        <label class="tips-label"><?php echo e($tips); ?>%</label>
                                      </div> --> 
                                      <!-- <input type="text" name="tipsa" class="tips-input" id="tipsa"> -->

                                      <input type="button" name="tips" class="tips-input" id="tips" value="<?php echo e($tips); ?> %">
                                      
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <!-- <br><input type="text" class="input-text" value=""><br> -->
                                    <?php if($custom_tip==1): ?>
                                      <br><label class="Custom-Tip"><strong>Custom Tip</strong></label>
                                      <br><input type="number" name="tips" class="tips-input1" pattern="\d{3}" id="tips" min="0" max="999" maxlength="3" oninput="validity.valid||(value='');" step=".01">$<br>  
                                      <input type="hidden" name="custom_tip" id="custom_tip" value="">
                                    <?php endif; ?>
                            
                                    <br>
                           

                            <span v-if="totalPrice"><strong><?php echo e(__('Subtotal')); ?>:</strong></span>
                            <span v-if="totalPrice" class="ammount_sub"><strong>{{ totalPriceFormat}}</strong></span>
                            <br>
                            <span class="tax_label"><strong><?php echo e(__('Tax')); ?></strong></span>
                            <span class="tax_ammount"><strong></strong></span>
                            <input type="hidden" name="tax_hidden" id="tax_hidden" value="<?php echo e($restorant->vat); ?>">

                            <?php if(config('app.isft')||config('settings.is_whatsapp_ordering_mode')|| in_array("poscloud", config('global.modules',[])) || in_array("deliveryqr", config('global.modules',[])) ): ?>
                                <span v-if="totalPrice&&deliveryPrice>0"><br /><strong><?php echo e(__('Delivery')); ?>:</strong></span>
                                <span v-if="totalPrice&&deliveryPrice>0" class="ammount"><strong>{{ deliveryPriceFormated }}</strong></span><br />
                            <?php endif; ?>
                            <br /> 

                             

                            <div v-if="deduct"> 
                                <span v-if="deduct"><?php echo e(__('Applied coupon discount')); ?>:</span>
                                <span v-if="deduct" class="ammount">{{ deductFormat }}</span>
                                <br />  
                                <br />  
                            </div>
                           

                        <!-- <span>{{totalPriceFormat}} </span> -->
                            <span v-if="totalPrice"><strong><?php echo e(__('Total')); ?>:</strong></span>
                            <span v-if="totalPrice" class="ammount1"><strong>{{ withDeliveryFormat }}

                            </strong></span>
                            <input v-if="totalPrice" type="hidden" id="tootalPricewithDeliveryRaw" :value="withDelivery" />
                            <br><br>

                            <span><strong><?php echo e(__('Tip Amount:')); ?></strong></span>
                            <span class="tip_amt"><strong></strong></span>
                            <br>
                            <span><strong><?php echo e(__('Grand Total:')); ?></strong></span>
                            <span class="grand_amt"><strong></strong></span>
                            <br>
                           



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End price overview -->

        <?php if(in_array("coupons", config('global.modules',[]))): ?>
            <!-- Coupons -->
            <?php echo $__env->make('cart.coupons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- End coupons -->
        <?php endif; ?>


        <!-- Payment  Methods -->
        <div class="cards">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <!-- Errors on Stripe -->
                        <?php if(session('error')): ?>
                            <div role="alert" class="alert alert-danger"><?php echo e(session('error')); ?></div>
                        <?php endif; ?>
                        <input type="hidden" name="checkout_subtotal_field" id="checkout_subtotal_field" class="form-control" placeholder="81234 56789">
                        <span>In order to send you a receipt please enter your phone number and email address</span><br><br>
                        <span><strong><?php echo e(__('Email')); ?>:</strong></span>
                        <input type="email" class="form-control input_sec <?php $__errorArgs = ['checkout_customer_email_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="checkout_customer_email_field" id="checkout_customer_email_field">
                        <?php $__errorArgs = ['checkout_customer_email_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="" id="local_phone">
                        <span><strong><?php echo e(__('Phone')); ?>:</strong></span>

                        <!-- <input type="text" name="checkout_phone_field" id="checkout_phone_field" class="form-control" placeholder="81234 56789"> -->


                        <!-- <div class="form-group">
                            <input type="text" name="checkout_phone_field" id="checkout_phone_field"  class="form-control input_sec <?php $__errorArgs = ['checkout_phone_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__( 'Your phone here' )); ?> ..." required></input>
                            <?php $__errorArgs = ['checkout_phone_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div> -->
                        <!-- <div class="form-group<?php echo e($errors->has('phone') ? ' has-danger' : ''); ?>">
                            <input type="text" name="phone" id="phone" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" placeholder="<?php echo e(__( 'Your phone here' )); ?> ..." required></input>
                            <?php if($errors->has('phone')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($errors->first('phone')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div> -->
                        <div class="form-group">
                            <input type="text" name="phone_field" id="phone_field"  class="form-control input_sec <?php $__errorArgs = ['phone_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="" placeholder="<?php echo e(__( 'Your phone here' )); ?> ..."  required></input>
                            <?php $__errorArgs = ['phone_field'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback" role="alert">
                            
                            <strong><?php echo e($message); ?></strong></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php if(!config('settings.is_whatsapp_ordering_mode')): ?>
                        <!-- COD -->
                        <?php if(!config('settings.hide_cod')): ?>
                            <div class="custom-control custom-radio mb-3">
                                <input name="paymentType" class="custom-control-input" id="cashOnDelivery" type="radio" value="cod" <?php echo e(config('settings.default_payment')=="cod"?"checked":""); ?>>
                                <label class="custom-control-label" for="cashOnDelivery"><span class="delTime"><?php echo e(config('app.isqrsaas')?__('Cash / Card Terminal'): __('Cash on delivery')); ?></span> <span class="picTime"><?php echo e(__('Cash on pickup')); ?></span></label>
                            </div>


                        <?php endif; ?>

                        <?php if($enablePayments): ?>

                            <!-- STIPE CART -->
                            <?php if(config('settings.stripe_key')&&config('settings.enable_stripe')): ?>
                                <div class="custom-control custom-radio mb-3">
                                    <input name="paymentType" class="custom-control-input" id="paymentStripe" type="radio" value="stripe" <?php echo e(config('settings.default_payment')=="stripe"?"checked":""); ?>>
                                    <label class="custom-control-label" for="paymentStripe"><?php echo e(__('Pay with card')); ?></label>
                                </div>
                           
                            <?php endif; ?>

                            <!-- Extra Payments ( Via module ) -->
                            <?php $__currentLoopData = $extraPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extraPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make($extraPayment.'::selector', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- END Payment -->

        <!-- <div class="text-left pl-4"> -->
        <div class="text-center">
           <div class="custom-control custom-checkbox mb-3 mobile-checkbox">
                <input class="custom-control-input" id="special_offers" type="checkbox" value='1' checked>
              
                <label class="custom-control-label special_offers" for="special_offers">
                   I agree to be contacted for offers, special deals, and other marketing communcation
                    
                </label>
            </div>
        </div><br />
        <div class="text-center">
            <div class="custom-control custom-checkbox mb-3">
                <input class="custom-control-input" id="privacypolicy" type="checkbox"  value='0'>
               
                <label class="custom-control-label" for="privacypolicy">
                    &nbsp;&nbsp;<?php echo e(__('I agree to the')); ?>

                    <a href="<?php echo e(config('settings.link_to_ts')); ?>" target="_blank" style="text-decoration: underline;"><?php echo e(__('Terms of Service')); ?></a> <?php echo e(__('and')); ?>

                    <a href="<?php echo e(config('settings.link_to_pr')); ?>" target="_blank" style="text-decoration: underline;"><?php echo e(__('Privacy Policy')); ?></a>.
                </label>
            </div>
        </div><br />

        <!-- Payment Actions -->
        <?php if(!config('settings.social_mode')): ?>

            <!-- COD -->
            <?php echo $__env->make('cart.payments.cod', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Extra Payments ( Via module ) -->
            <?php $__currentLoopData = $extraPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extraPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make($extraPayment.'::button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </form>

            <!-- Stripe -->
            <?php echo $__env->make('cart.payments.stripe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            

        <?php elseif(config('settings.is_whatsapp_ordering_mode')): ?>
            <?php echo $__env->make('cart.payments.whatsapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(config('settings.is_facebook_ordering_mode')): ?>
            <?php echo $__env->make('cart.payments.facebook', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <!-- END Payment Actions -->

        <br/>
        

      </div>
      <br />
      <br />
    </div>
  </div>

  <?php if(config('settings.is_demo') && config('settings.enable_stripe')): ?>
    <?php echo $__env->make('cart.democards', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>

  <style>
    input[type="button"] {
        width: 60px;
        padding: 10px;
        border: 2px solid #000000;
        background: white;
        margin: 15px 15px 10px 0px;
    }
    input.tips-input1 {
        border: 2px solid #000000;
        margin-top: 5px;
        width: 100px;
        padding: 10px;
        margin-bottom: 15px;
    }
    label.Custom-Tip {
    margin-top: 20px;
}
    .highlight {
        background: #7082E7 !important;
        color: white;
        font-weight: 600;
    }

   /* .custom-control-label:after, .custom-control-label:before {
        left: -1.75rem;
        border-radius: 3px;
    }*/
    input#special_offers {
    width: 80px;
    height: 20px;
    margin-top: 10px;
}
.offer_checkbox_div {
    display: flex;
}
label.custom-control-label.communcation:before {
    left: 1.25rem;
    border-radius: 3px;
}
label.custom-control-label.communcation {
    padding-left: 55px;
}
/*[type="checkbox"]:not(:checked) + label:before {
    top: 0px;
    width: 19px;
    height: 19px;
    border: 1px solid #c82b2b;
}

[type="checkbox"]:not(:checked) + label:after {
    top: 0px;
    width: 19px;
    height: 19px;
    border: 1px solid red;
    z-index: 0;
}*/

label.custom-control-label.special_offers::before {
    left: 23px;
}
label.custom-control-label.special_offers {
    padding-left: 56px;
}
label.custom-control-label.special_offers::after {
    left: 23px;
}
label.custom-control-label.communcation .custom-checkbox .custom-control-input:checked~.custom-control-label::after {
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e);
}

input#tips {
    border-radius: 5px;
    border: 3px solid #7082e7;
}

@media  only screen and (max-width: 600px) {
    label.custom-control-label.special_offers::before {
    left: 0px !important;
}
    label.custom-control-label.special_offers::after {
    left: 0px !important;
}

.custom-control.custom-checkbox.mb-3.mobile-checkbox {
    padding: 0 !important;
}
label.custom-control-label.special_offers {
    text-align: left !important;
} 
 
}

  </style>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->

 <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js"></script> -->
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script> 
<script>
/*  jQuery(document).ready(function(){
    
      jQuery('#tips_input1').hide();
      $('input:radio[name="tips"]').change(function(){
    
      if(jQuery('.tips-input1').is(":checked")){
        jQuery('#tips_input1').show();
      }
      else{
        jQuery('#tips_input1').hide();
      }
    });
  });*/
/*function check_assigna(){      
    var id = $this.attr("id");   
   alert(id);
    if($(a).prop("checked") == true{   
        $('.paymentbutton').attr("disabled", false);
    }   
    else      
    {  
        $('.paymentbutton').attr("disabled", true);
    }  
} */



$("#phone_field").inputmask({"mask":"(999) 999-9999"});
  /*$("#checkout_phone_field").intlTelInput({
    });*/
</script><?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/cart/payment.blade.php ENDPATH**/ ?>