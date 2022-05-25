
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
   



<div class="card card-profile shadow mt--300">
    <div class="px-4">
      <div class="mt-5">
        <h3>{{ __('Checkout') }}<span class="font-weight-light"></span></h3>
      </div>
      <div  class="border-top">
        <!-- Price overview -->
        <div id="totalPrices" v-cloak>
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span v-if="totalPrice==0">{{ __('Cart is empty') }}!</span>


                              
                                <?php 

                                  $custom_tip = $restorant['custom_tip'];
                                  $tips = $restorant['tips'];
                                  $vat = $restorant['vat'];
                                  
                                  $tips_array1 = explode(",",$tips); 
                                  $tips_array = array_filter($tips_array1);?>

                                    @if(count($tips_array)>1)
                                    <span><strong>{{ __('Leave a Tip!') }}</strong></span><br>
                                    
                                    @foreach($tips_array as $tips)
                                   <!--  <div class="tips-radio mb-3">
                                        <input name="tips" class="tips-input" id="tips"  type="radio" value="{{$tips}}">
                                        <label class="tips-label">{{ $tips }}%</label>
                                      </div> --> 
                                      <!-- <input type="text" name="tipsa" class="tips-input" id="tipsa"> -->

                                      <input type="button" name="tips" class="tips-input" id="tips" value="{{ $tips }} %">
                                      
                                    @endforeach
                                    @endif
                                    <!-- <br><input type="text" class="input-text" value=""><br> -->
                                    @if($custom_tip==1)
                                      <br><label class="Custom-Tip"><strong>Custom Tip</strong></label>
                                      <br><input type="number" name="tips" class="tips-input1" pattern="\d{3}" id="tips" min="0" max="999" maxlength="3" oninput="validity.valid||(value='');" step=".01">$<br>  
                                      <input type="hidden" name="custom_tip" id="custom_tip" value="">
                                    @endif
                            
                                    <br>
                           

                            <span v-if="totalPrice"><strong>{{ __('Subtotal') }}:</strong></span>
                            <span v-if="totalPrice" class="ammount_sub"><strong>@{{ totalPriceFormat}}</strong></span>
                            <br>
                            <span class="tax_label"><strong>{{ __('Tax') }}</strong></span>
                            <span class="tax_ammount"><strong></strong></span>
                            <input type="hidden" name="tax_hidden" id="tax_hidden" value="{{$restorant->vat}}">

                            @if(config('app.isft')||config('settings.is_whatsapp_ordering_mode')|| in_array("poscloud", config('global.modules',[])) || in_array("deliveryqr", config('global.modules',[])) )
                                <span v-if="totalPrice&&deliveryPrice>0"><br /><strong>{{ __('Delivery') }}:</strong></span>
                                <span v-if="totalPrice&&deliveryPrice>0" class="ammount"><strong>@{{ deliveryPriceFormated }}</strong></span><br />
                            @endif
                            <br /> 

                             

                            <div v-if="deduct"> 
                                <span v-if="deduct">{{ __('Applied coupon discount') }}:</span>
                                <span v-if="deduct" class="ammount">@{{ deductFormat }}</span>
                                <br />  
                                <br />  
                            </div>
                           

                        <!-- <span>@{{totalPriceFormat}} </span> -->
                            <span v-if="totalPrice"><strong>{{ __('Total') }}:</strong></span>
                            <span v-if="totalPrice" class="ammount1"><strong>@{{ withDeliveryFormat }}

                            </strong></span>
                            <input v-if="totalPrice" type="hidden" id="tootalPricewithDeliveryRaw" :value="withDelivery" />
                            <br><br>

                            <span><strong>{{ __('Tip Amount:') }}</strong></span>
                            <span class="tip_amt"><strong></strong></span>
                            <br>
                            <span><strong>{{ __('Grand Total:') }}</strong></span>
                            <span class="grand_amt"><strong></strong></span>
                            <br>
                           



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End price overview -->

        @if(in_array("coupons", config('global.modules',[])))
            <!-- Coupons -->
            @include('cart.coupons')
            <!-- End coupons -->
        @endif


        <!-- Payment  Methods -->
        <div class="cards">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <!-- Errors on Stripe -->
                        @if (session('error'))
                            <div role="alert" class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <input type="hidden" name="checkout_subtotal_field" id="checkout_subtotal_field" class="form-control" placeholder="81234 56789">
                        <span>In order to send you a receipt please enter your phone number and email address</span><br><br>
                        <span><strong>{{ __('Email') }}:</strong></span>
                        <input type="email" class="form-control input_sec @error('checkout_customer_email_field') is-invalid @enderror" name="checkout_customer_email_field" id="checkout_customer_email_field">
                        @error('checkout_customer_email_field')<span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong></span>@enderror
                        <div class="" id="local_phone">
                        <span><strong>{{ __('Phone') }}:</strong></span>

                        <!-- <input type="text" name="checkout_phone_field" id="checkout_phone_field" class="form-control" placeholder="81234 56789"> -->


                        <!-- <div class="form-group">
                            <input type="text" name="checkout_phone_field" id="checkout_phone_field"  class="form-control input_sec @error('checkout_phone_field') is-invalid @enderror" placeholder="{{ __( 'Your phone here' ) }} ..." required></input>
                            @error('checkout_phone_field')<span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong></span>@enderror
                        </div> -->
                        <!-- <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                            <input type="text" name="phone" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __( 'Your phone here' ) }} ..." required></input>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div> -->
                        <div class="form-group">
                            <input type="text" name="phone_field" id="phone_field"  class="form-control input_sec @error('phone_field') is-invalid @enderror" value="" placeholder="{{ __( 'Your phone here' ) }} ..."  required></input>
                            @error('phone_field')<span class="invalid-feedback" role="alert">
                            
                            <strong>{{$message}}</strong></span>@enderror
                        </div>
                        @if(!config('settings.is_whatsapp_ordering_mode'))
                        <!-- COD -->
                        @if (!config('settings.hide_cod'))
                            <div class="custom-control custom-radio mb-3">
                                <input name="paymentType" class="custom-control-input" id="cashOnDelivery" type="radio" value="cod" {{ config('settings.default_payment')=="cod"?"checked":""}}>
                                <label class="custom-control-label" for="cashOnDelivery"><span class="delTime">{{ config('app.isqrsaas')?__('Cash / Card Terminal'): __('Cash on delivery') }}</span> <span class="picTime">{{ __('Cash on pickup') }}</span></label>
                            </div>


                        @endif

                        @if($enablePayments)

                            <!-- STIPE CART -->
                            @if (config('settings.stripe_key')&&config('settings.enable_stripe'))
                                <div class="custom-control custom-radio mb-3">
                                    <input name="paymentType" class="custom-control-input" id="paymentStripe" type="radio" value="stripe" {{ config('settings.default_payment')=="stripe"?"checked":""}}>
                                    <label class="custom-control-label" for="paymentStripe">{{ __('Pay with card') }}</label>
                                </div>
                           
                            @endif

                            <!-- Extra Payments ( Via module ) -->
                            @foreach ($extraPayments as $extraPayment)
                                @include($extraPayment.'::selector')
                            @endforeach


                        @endif

                        @endif
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
                    &nbsp;&nbsp;{{__('I agree to the')}}
                    <a href="{{config('settings.link_to_ts')}}" target="_blank" style="text-decoration: underline;">{{__('Terms of Service')}}</a> {{__('and')}}
                    <a href="{{config('settings.link_to_pr')}}" target="_blank" style="text-decoration: underline;">{{__('Privacy Policy')}}</a>.
                </label>
            </div>
        </div><br />

        <!-- Payment Actions -->
        @if(!config('settings.social_mode'))

            <!-- COD -->
            @include('cart.payments.cod')

            <!-- Extra Payments ( Via module ) -->
            @foreach ($extraPayments as $extraPayment)
                @include($extraPayment.'::button')
            @endforeach

            </form>

            <!-- Stripe -->
            @include('cart.payments.stripe')

            

        @elseif(config('settings.is_whatsapp_ordering_mode'))
            @include('cart.payments.whatsapp')
        @elseif(config('settings.is_facebook_ordering_mode'))
            @include('cart.payments.facebook')
        @endif
        <!-- END Payment Actions -->

        <br/>
        

      </div>
      <br />
      <br />
    </div>
  </div>

  @if(config('settings.is_demo') && config('settings.enable_stripe'))
    @include('cart.democards')
  @endif

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

@media only screen and (max-width: 600px) {
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



$(document).on('blur','#checkout_customer_email_field',function(){
    
    var checkout_customer_email_field=$('#checkout_customer_email_field').val();
    var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
    if(checkout_customer_email_field.length == 0){
        $('#checkout_customer_email_field').next(".red").remove();
        $('#checkout_customer_email_field').after('<div class="red" style="color:red">Email Field is Required</div>');
        $('.paymentbutton').attr("disabled", true);
        return false;
    }
    else if(!pattern.test(checkout_customer_email_field))
    {
       $('#checkout_customer_email_field').next(".red").remove();
       $('#checkout_customer_email_field').after('<div class="red" style="color:red">The email field must be a valid email address.</div>');
       $('.paymentbutton').attr("disabled", true);
       return false;
    }
    else {
        $('#checkout_customer_email_field').next(".red").remove();
        $('.paymentbutton').attr("disabled", false);
        return true;
    }

    
    



});
$(document).on('blur','#phone_field',function(){
    
    var phone_field=$('#phone_field').val();
   
    var pattern = /(\d{0,3})(\d{0,3})(\d{0,4})/

    var phoneno = parseInt(phone_field.replace(/[^0-9.]/g, ""));
    phoneno = phoneno.toString().length;
  

    if(phone_field.length == 0){
        $('#phone_field').next(".red").remove();
        
       $('#phone_field').after('<div class="red" style="color:red">Phone is Required</div>');
       $('.paymentbutton').attr("disabled", true);
        return false;
    }
   // else if(phone_field.length. < 14 ){

    else if(phoneno < 10){
        
       $('#phone_field').next(".red").remove();
        
       $('#phone_field').after('<div class="red" style="color:red">The phone field format is invalid.</div>');
        
        return false;
    }

    else {
        $('#phone_field').next(".red").remove();
        $('.paymentbutton').attr("disabled", false);
        return true;
    }
   

});

</script>